<?php


class Woocomerce_setup
{
    public function __construct(){
        add_action( 'init', [$this,'addTaxonomy'] );
    }

    public function addTaxonomy() {
        $labels = array(
            'name' => 'Loại sản phẩm',
            'singular' => 'Loại sản phẩm',
            'menu_name' => 'Loại sản phẩm'
        );

        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'rewrite' => array(
                'slug' => 'loai-san-pham'
            ),
        );

        register_taxonomy('ptx_product_type', 'product', $args);
    }
}

$ptxWooSetup = new Woocomerce_setup();