<?php
//function create_taxonomy_product_cat() {
//
//    $labels = array(
//        'name' => 'Danh mục sản phẩm',
//        'singular' => 'Danh mục sản phẩm',
//        'menu_name' => 'Danh mục sản phẩm'
//    );
//
//
//    $args = array(
//        'labels'                     => $labels,
//        'hierarchical'               => true,
//        'public'                     => true,
//        'show_ui'                    => true,
//        'show_admin_column'          => true,
//        'show_in_nav_menus'          => true,
//        'show_tagcloud'              => true,
//        'rewrite' => array(
//            'slug' => 'danh-muc-san-pham'
//        ),
//    );
//
//    register_taxonomy('product_cat', 'products', $args);
//
//}

// Hook into the 'init' action
//add_action( 'init', 'create_taxonomy_product_cat', 0 );