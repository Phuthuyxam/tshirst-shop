<?php


class Woocomerce_extension
{

    public function __construct(){
        add_action( 'pre_get_posts', [$this,'addFilterProduct'] );
        add_action( 'rest_api_init', [$this , 'registerApi']);
    }

    public function loader() {
//        $this->custom_pre_get_posts_query($q);
    }

    public function addFilterProduct($query) {
        if ( ! $query->is_main_query() ) return;
        if ( ! $query->is_post_type_archive() && !$query->is_tax() ) return;
        if( !isset($_GET) || empty($_GET) ) return;
        if ( ! is_admin() && ( is_shop() || is_tax() ) ) {

            // filter category
            if(isset($_GET['product_cat']) && !empty($_GET['product_cat'])) {
                $taxQuery = $this->productCatFilter($query, $_GET['product_cat'], 'product_cat');
                $query->set('tax_query', $taxQuery);
            }

            // filter product_type
            if(isset($_GET['product_type']) && !empty($_GET['product_type'])) {
                $taxQuery = $this->productCatFilter($query, $_GET['product_type'], 'ptx_product_type');
                $query->set('tax_query', $taxQuery);
            }

            // filter color
            if(isset( $_GET['color']) && !empty($_GET['color']) ) {
                $colorQuery = $this->productAttrFilter($query, $_GET['color']);
                $query->set('tax_query', $colorQuery);
            }

            // search
            if(isset($_GET['key']) && !empty($_GET['key'])) {
                $query->set('s', $_GET['key']);
            }

            return;
        }
    }

    // query product

    public function productCatFilter($query , $productCat, $key) {
        $taxQuery = $query->get('tax_query');
        $taxQuery[] = [
            'taxonomy' => $key,
            'field'    => 'slug',
            'terms'    => array( $productCat)
        ];
        return $taxQuery;
    }

    // query attr
    public function productAttrFilter($query , $productColor) {
        $taxQuery = $query->get('tax_query');
        $taxQuery[] = [
            'taxonomy' => 'pa_color',
            'field'    => 'slug',
            'terms'    => array($productColor)
        ];
        return $taxQuery;
    }

    // public function get
    public function getAllProductTerm($taxonomy) {
        $allProductTerm = get_terms( array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ) );
        return $allProductTerm;
    }

    // load Recommended product
    public function getRecommendedProduct($productId) {
        if(isset($_COOKIE['recommendedProduct'])) {
            $loadProduct = $_COOKIE['recommendedProduct'];
            try {
                $products = json_decode($loadProduct, true);
                if(!in_array($productId, $products)) {
                    if(count($products) == 5) unset($products[4]);
                    $products[] = $productId;
                    setcookie('recommendedProduct', json_encode($products) , time() + (86400 * 15), "/");
                }

            } catch ( \Exception $e ) {

            }

        }else {
            setcookie('recommendedProduct', json_encode([$productId]) , time() + (86400 * 15), "/");
        }
        return $_COOKIE['recommendedProduct'];

//        setcookie('recommendedProduct', null, -1, '/');
    }

    public function renderRecommendedProduct() {
        $productJson = $_COOKIE['recommendedProduct'];
        $recommendProducts = [];
        try {
            $viewedProducts = json_decode($productJson);
            if(isset($viewedProducts) && !empty($viewedProducts)) {
                $terms = [];
                foreach ($viewedProducts as $pro) {
                    $getTerm = get_the_terms($pro , 'product_cat', OBJECT , 'raw');
                    $terms[] = $getTerm[0]->term_id;
                }
                $terms = array_unique($terms);
                $query = new WP_Query(
                    [
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 4,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'term_id',
                                'terms'    => $terms,
                            ),
                        ),
                        'orderby' => 'rand',
                    ]
                );

                if($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $recommendProducts[] = get_the_ID();
                    }
                }
                wp_reset_query();
            }
        } catch ( \Exception $e ) {

        }

        return $recommendProducts;
    }

    // Get Woocommerce variation price based on product ID
    function get_variation_price_by_id($product_id, $variation_id){
        $currency_symbol = get_woocommerce_currency_symbol();
        $product = new WC_Product_Variable($product_id);
        $variations = $product->get_available_variations();
        $var_data = [];
        foreach ($variations as $variation) {
            if($variation['variation_id'] == $variation_id){
                $display_regular_price = $variation['display_regular_price'].'<span class="currency">'. $currency_symbol .'</span>';
                $display_price = $variation['display_price'].'<span class="currency">'. $currency_symbol .'</span>';
            }
        }

        //Check if Regular price is equal with Sale price (Display price)
        if ($display_regular_price == $display_price){
            $display_price = false;
        }

        $priceArray = array(
            'display_regular_price' => $display_regular_price,
            'display_price' => $display_price
        );
        $priceObject = (object)$priceArray;
        return $priceObject;
    }

    public function renderVariationProduct() {
        global $woocommerce, $product, $post;
        $available_variations = [];
        // test if product is variable
        if ($product->is_type( 'variable' ))
        {
            $available_variations = $product->get_available_variations();
        }
        ?>
            <script>
                let data_varidation = jQuery('.variations_form').attr('data-product_variations');
                if(data_varidation){
                    data_varidation = JSON.parse(data_varidation);
                    function isEqual(objA, objB) {
                        var aProps = Object.getOwnPropertyNames(objA);
                        var bProps = Object.getOwnPropertyNames(objB);
                        if (aProps.length != bProps.length) {
                            return false;
                        }

                        for (var i = 0; i < aProps.length; i++) {
                            var propName = aProps[i];
                            if (objA[propName] !== objB[propName]) {
                                return false;
                            }
                        }
                        return true;
                    }
                    function get_varidation(){

                        let obj = function(){
                            obj=new Object();
                            this.add=function(key,value){
                                obj[""+key+""]=value;
                            }
                            this.obj=obj
                        };

                        let object_attr = new obj;
                        jQuery.each( jQuery('.variations ') , function ( index , item ){
                            let current_value = jQuery(this).find('select').val();
                            let attr = jQuery(this).find('select').attr('name');
                            object_attr.add(attr , current_value);
                        });
                        return object_attr.obj;
                    }
                    get_varidation();
                    jQuery('.variations select').change(function (e) {
                        e.preventDefault();
                        let curren_choose = get_varidation();
                        jQuery.each(data_varidation , function(index , item){
                            // console.log(item.attributes , curren_choose);
                            //  check is all attributes
                            let selected = new Array();
                            let index_attr = new Array();
                            jQuery.each( item.attributes , function(index , item){
                                if(item != ""){
                                    selected[index] = item;
                                    index_attr.push( index );
                                }
                            });
                            if( selected.length == 0 ){
                                // if(curren_choose.selected[])
                                if( curren_choose[index_attr[0]] && curren_choose[index_attr[0]] == selected[index_attr[0]] ){
                                    console.log(item);
                                }
                            }else{
                                if( isEqual(item.attributes , curren_choose) ){
                                    console.log(item);
                                }
                            }
                        });
                    });
                }
            </script>
        <?php
    }

    public function registerApi() {
        register_rest_route( 'api/v1', '/get-woocomerce-product', array(
            'methods' => 'GET',
            'callback' => [$this , 'apiGetVariableProduct'],
        ) );

        register_rest_route( 'api/v1', '/ptx-woocomerce-add-to-cart', array(
            'methods' => 'POST',
            'callback' => [$this , 'apiAddToCart'],
        ) );
    }

    public function apiGetVariableProduct( WP_REST_Request $request ) {
        // You can access parameters via direct array access on the object:
        $productId= $request['productId'];
        $color = $request['pa_color'];
        $size = $request['pa_size'];
        $_product = wc_get_product($productId);
        $result = [];
        if($_product && $_product->is_type( 'variable' )) {

            $allVariableProduct = $_product->get_available_variations();

            if(isset($color) && isset($size)){
                foreach ($allVariableProduct as $vProduct) {

                    if( ( isset($vProduct['attributes']['attribute_pa_color']) && $vProduct['attributes']['attribute_pa_color'] == $color && $vProduct['attributes']['attribute_pa_size'] == "" )
                        || ( isset($vProduct['attributes']['attribute_pa_size']) && $vProduct['attributes']['attribute_pa_size'] == $size && $vProduct['attributes']['attribute_pa_color'] == "" )) {
                        $result = $vProduct;
                    }else{
                        if( isset($vProduct['attributes']['attribute_pa_color']) && $vProduct['attributes']['attribute_pa_color'] == $color
                            && isset($vProduct['attributes']['attribute_pa_size']) && $vProduct['attributes']['attribute_pa_size'] == $size ) {
                            $result = $vProduct;
                        }
                    }

                }
            }
            else if (isset($productId)) {

                foreach ($allVariableProduct as $key => $vProduct) {
                    $term = get_term_by('slug', $vProduct['attributes']['attribute_pa_color'] , 'pa_color', OBJECT , 'raw');

                    $colorHex = get_field('color_hex', 'pa_color_'.$term->term_id);
                    $allVariableProduct[$key]['attributes']['color_hex'] = $colorHex;
                    if(isset($vProduct['attributes']['attribute_pa_size']) && $vProduct['attributes']['attribute_pa_size'] == "" ) {
                        $sizes = $_product->get_attribute('pa_size');
                        $allSize = explode("," , str_replace(" ", "", $sizes));
                        $allVariableProduct[$key]['attributes']['all_size'] = $allSize;
                    }

                }

                $result = $allVariableProduct;

            }


        }
        return json_encode($result);
        die();
    }

    public function apiAddToCart() {

        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['pid']));
        $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['qty']);
        $variation_id = absint($_POST['vid']);
        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status = get_post_status($product_id);

        WC()->cart = new WC_Cart();

        
        if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

            do_action('woocommerce_ajax_added_to_cart', $product_id);

            if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }

            WC_AJAX :: get_refreshed_fragments();
        } else {

            $data = array(
                'error' => true,
                'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

            echo wp_send_json($data);
        }

        wp_die();
    }

    public function genDataProductClass( $productId ) {

        $productClass = get_the_terms($productId, 'ptx_product_class');
        $productClass = $productClass[0];
        $productClassData = [$productId];
        $query = new WP_Query(['post_type' => 'product' , 'post_status' => 'publish', 'posts_per_page' => -1, 'post__not_in' => array($productId),'tax_query' => [ ['taxonomy' => 'ptx_product_class' , 'field' => 'term_id' , 'terms' => $productClass->term_id] ] ]);
        if($query->have_posts()) {
            while ($query->have_posts()){
                $query->the_post();
                $productClassData[] = get_the_ID();
            }
        }

        $result = [];
        foreach ( $productClassData as $id) {
            $result[] = ['image' => get_the_post_thumbnail_url($id) , 'id' => $id , 'name' => get_the_title($id) , 'url' => get_the_permalink($id)];
        }

        return json_encode($result);
    }

}
$GLOBALS['wooextension'] = new Woocomerce_extension();