<?php


class Woocomerce_extension
{

    public function __construct(){
        add_action( 'pre_get_posts', [$this,'addFilterProduct'] );
        add_action( 'rest_api_init', [$this , 'registerApi']);
        add_action('wp_ajax_woocommerce_ajax_add_to_cart', [$this , 'woocommerce_ajax_add_to_cartfunc']);
        add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', [$this, 'woocommerce_ajax_add_to_cartfunc']);
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
                foreach ($allVariableProduct as $key => $vProduct) {

                    if( ( isset($vProduct['attributes']['attribute_pa_color']) && $vProduct['attributes']['attribute_pa_color'] == $color && $vProduct['attributes']['attribute_pa_size'] == "" )
                        || ( isset($vProduct['attributes']['attribute_pa_size']) && $vProduct['attributes']['attribute_pa_size'] == $size && $vProduct['attributes']['attribute_pa_color'] == "" )) {
                        $sizes = $_product->get_attribute('pa_size');
                        $allSize = explode("," , str_replace(" ", "", $sizes));
                        $colors = $_product->get_attribute('pa_color');
                        $colors = explode("," , str_replace(" ", "", $colors));
                        $vProduct['attributes']['all_size'] = $allSize;
                        $vProduct['attributes']['all_color'] = $colors;
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

    public function woocommerce_ajax_add_to_cartfunc() {
        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['pid']));
        $quantity = empty($_POST['qty']) ? 1 : wc_stock_amount($_POST['qty']);
        $variation_id = absint($_POST['vid']);
        $color = $_POST['color'];
        $size = $_POST['size'];
        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status = get_post_status($product_id);

        $arrAttr = [
                'attribute_pa_size' => $size,
                'attribute_pa_color' => $color
        ];
        if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $arrAttr , null) && 'publish' === $product_status) {

            do_action('woocommerce_ajax_added_to_cart', $product_id);

            if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }

            $addCartData = $this->renderUpsellProduct($product_id);

            if($addCartData) {
                $addCartData = $this->minifier($addCartData);
            }
            $cart = '<b>Cart subtotal</b>('. WC()->cart->get_cart_contents_count() .' items ) :<b>'. wc_price( WC()->cart->total ) .'</b>';
            $data = array(
                'error' => false,
                'product_upsell' => $addCartData,
                'cart_info' => $cart
            );
            echo wp_send_json($data);
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

    public function getRelateProduct() {
        global $post;
        $cats = wp_get_post_terms( $post->ID, "product_cat" );
        foreach ( $cats as $cat ) {
            $cats_array[] .= $cat->term_id;
        }
        $tags = wp_get_post_terms( $post->ID, "product_tag" );
        foreach ( $tags as $tag ) {
            $tags_array[] .= $tag->term_id;
        }
        $related_posts = new WP_Query(
            array(
                'orderby' => 'rand',
                'posts_per_page' => 6,
                'post_type' => 'product',
                'post__not_in' => array($post->ID),
                'tax_query' => array(

                    'relation' => 'OR',
                    array(
                            'taxonomy' => 'product_cat',
                            'field' => 'id',
                            'terms' => $cats_array
                    ),

                    array(
                        'taxonomy' => 'product_tag',
                        'field' => 'id',
                        'terms' => $tags_array
                    )
                )
            )
        );

        return $related_posts;
    }
    private function minifier($code) {
        $search = array(

            // Remove whitespaces after tags
            '/\>[^\S ]+/s',

            // Remove whitespaces before tags
            '/[^\S ]+\</s',

            // Remove multiple whitespace sequences
            '/(\s)+/s',

            // Removes comments
            '/<!--(.|\s)*?-->/'
        );
        $replace = array('>', '<', '\\1');
        $code = preg_replace($search, $replace, $code);
        return $code;
    }
    public function renderUpsellProduct($productId) {
        $productClass = get_the_terms($productId, 'ptx_product_class');
        $productClass = $productClass[0];
        $productClassData =  [];
        $query = new WP_Query(['post_type' => 'product' , 'post_status' => 'publish', 'posts_per_page' => -1, 'post__not_in' => array($productId),'tax_query' => [ ['taxonomy' => 'ptx_product_class' , 'field' => 'term_id' , 'terms' => $productClass->term_id] ] ]);
        if($query->have_posts()) {
              while ($query->have_posts()){
                     $query->the_post();
                  $productClassData[] = get_the_ID();
            }
        }
        if(empty($productClassData)) return false;
        $productUpsell = $productClassData[0];
        $product = wc_get_product( $productUpsell );
        $product_attributes = $product->get_attributes();
        $class = get_the_terms($product->get_id(), 'ptx_product_class')[0];
        $firstVariation = false;
        if($product->product_type=='variable') {
            $variations = $product->get_available_variations();

            if(isset($variations) && !empty($variations)){
                $firstVariation = $variations[0]['attributes'];
                $firstVariation['variation_id'] = $variations[0]['variation_id'];
                $firstVariation['price_display'] = $variations[0]['price_html'];
            }

        }
        ob_start("minifier");
        ?>
            <hr>
            <strong style="">You May Also Like</strong>
            <hr>
            <div class="product-wrapper add-cart-upsell">
                <div class="row row-mobile">
                    <div class="col-xl-7 col-lg-7 col-12 col-mobile">
                        <div class="product-image" id="upsell-product-img">
                            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $firstVariation['variation_id'] ), 'single-post-thumbnail' );?>
                            <img src="<?php  echo $image[0]; ?>" alt="product image">
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-12 col-mobile">
                        <div class="product-detail">
                            <div class="product-title">
                                <span class="fs-md title"><?php echo $product->get_name() ?></span>
                                <span class="fs-md type"><?php echo $class->name ?></span>
                            </div>
                            <div class="product-price">
                                <span class="price fs-xl fw-bold" id="upsell-product-price">
                                    <?php echo ($firstVariation) ? $firstVariation['price_display'] : $product->get_price_html(); ?>
                                </span>


                                <?php
                                if(isset($product_attributes['pa_size']) && !empty($product_attributes['pa_size'])):
                                    $sizeAttr = $product_attributes['pa_size']->get_data();

                                    ?>
                                    <div class="product-size-select" id="upsell-product-size">
                                        <div class="product-size-title">
                                            <span class="fw-bold label">Size: </span>
                                            <span class="fw-bold placeholder">Select a Size</span>
                                            <span class="size"></span>
                                        </div>
                                        <ul>
                                            <?php
                                            if($firstVariation['attribute_pa_size'] == "") {
                                                $firstTerm = get_term_by('id' , $sizeAttr['options'][0], $sizeAttr['name'], OBJECT, 'raw');
                                                $activeItem = $firstTerm->slug;
                                            }else{
                                                $activeItem = $firstVariation["attribute_pa_size"];
                                            }
                                            foreach ($sizeAttr['options'] as $size):
                                                $term = get_term_by('id' , $size, $sizeAttr['name'], OBJECT, 'raw');
                                                ?>
                                                <li class="fw-bold <?php echo ( $activeItem == $term->slug ) ? 'active' : false ?>" data-size="<?php echo $term->slug ?>"><?php echo $term->name ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <?php
                                if(isset($product_attributes['pa_color']) && !empty($product_attributes['pa_color'])):
                                    $colorAttr = $product_attributes['pa_color']->get_data();
                                    $termFirst = get_term_by('id' , $colorAttr['options'][0] , $colorAttr['name'], OBJECT, 'raw');
                                    ?>
                                    <div class="product-color-select" id="upsell-product-color">
                                        <div class="product-color-title">
                                            <span class="fw-bold label">Color: </span>
                                            <span class="color"><?php echo $termFirst->name ?></span>
                                        </div>
                                        <ul>
                                            <?php
                                            if($firstVariation['attribute_pa_color'] == "") {
                                                $activeItemColor = $termFirst->slug;
                                            }else{
                                                $activeItemColor = $firstVariation["attribute_pa_color"];
                                            }
                                            foreach ($colorAttr['options'] as $key => $color):
                                                $term = get_term_by('id' , $color, $colorAttr['name'], OBJECT, 'raw');
                                                $bgColor = get_field('color_hex', 'pa_color_'.$term->term_id);
                                                ?>
                                                <li class="fw-bold <?php if($term->slug == $activeItemColor) echo 'active' ?>" data-name="<?php echo $term->name ?>" data-color="<?php echo $term->slug ?>">
                                                    <div class="color-circle">
                                                        <div class="circle" style="background-color: <?php echo $bgColor ?>;"></div>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>

                                <?php endif; ?>

                            <div class="product-quantity-list" id="upsell-product-qty">
                                <div class="product-quantity-title">
                                    <span class="fw-bold label">Qty: </span>
                                    <span class="quantity">1</span>
                                </div>
                                <div class="product-quantity-select">
                                    <button class="btn minus disabled"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                    <span class="quantity" id="upsell-quantity">1</span>
                                    <button class="btn plus"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="product-add-to-cart">
                                <?php
                                    if(isset($product_attributes['pa_size']) && !empty($product_attributes['pa_size'])) {
                                        $sizeAttr = $product_attributes['pa_size']->get_data();
                                        if ($firstVariation['attribute_pa_size'] == "") {
                                            $firstTerm = get_term_by('id', $sizeAttr['options'][0], $sizeAttr['name'], OBJECT, 'raw');
                                            $activeItem = $firstTerm->slug;
                                        } else {
                                            $activeItem = $firstVariation["attribute_pa_size"];
                                        }
                                        ?>
                                        <input type="hidden" id="upsell-single-size" value="<?php echo $activeItem ?>">
                                        <?php
                                    }
                                    if(isset($product_attributes['pa_color']) && !empty($product_attributes['pa_color'])) {
                                        $colorAttr = $product_attributes['pa_color']->get_data();
                                        $termFirst = get_term_by('id' , $colorAttr['options'][0] , $colorAttr['name'], OBJECT, 'raw');
                                        if($firstVariation['attribute_pa_color'] == "") {
                                            $firstTerm = get_term_by('id' , $colorAttr['options'][0], $colorAttr['name'], OBJECT, 'raw');
                                            $activeItemColor = $firstTerm->slug;
                                        }else{
                                            $activeItemColor = $firstVariation["attribute_pa_color"];
                                        }
                                        ?>
                                        <input type="hidden" id="upsell-single-color" value="<?php echo $activeItemColor ?>">
                                        <?php
                                    }
                                ?>
                                <input type="hidden" id="upsell-single-variation" value="<?php echo $firstVariation['variation_id'] ?>">
                                <input type="hidden" id="upsell-single-productid" value="<?php echo $productUpsell ?>">
                                <input type="hidden" id="upsell-single-quantity" value="1">
                                <input type="hidden" id="cart-url" value="<?php echo wc_get_cart_url() ?>">
                                <button class="btn btn-add-card fw-bold" data-product='<?php echo json_encode($product->get_available_variations()) ?>' id="upsell-single-add-cart">Add to cart</button>
                            </div>
                            <div class="view-detail">
                                <a href="<?php echo get_permalink($productUpsell) ?>">View full product details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        $content = ob_get_contents();
        ob_get_clean();
        return $content;
    }

}
$GLOBALS['wooextension'] = new Woocomerce_extension();