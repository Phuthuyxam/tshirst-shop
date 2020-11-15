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

}
$GLOBALS['wooextension'] = new Woocomerce_extension();