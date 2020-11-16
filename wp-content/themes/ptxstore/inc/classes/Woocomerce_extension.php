<?php


class Woocomerce_extension
{

    public function __construct(){
        add_action( 'pre_get_posts', [$this,'addFilterProduct'] );
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
                        'posts_per_page' => 6,
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

}
$GLOBALS['wooextension'] = new Woocomerce_extension();