<?php
function adt_register_sidebars()
{

    register_sidebar(array(
        'id' => 'footer',
        'name' => 'Footer Area',
        'description' => '',
        'before_widget' => '<div class="item-col col-xs-12 col-sm-6 col-md-3 %1$s"><div class="item-footer">',
        'after_widget' => '</div></div>',
        'before_title' => '<div class="footer-widget-seo">',
        'after_title' => '</div>'
    ));

}

add_action( 'widgets_init', 'adt_register_sidebars' );

function mega_menu_init() {
    $location = 'main-menu';
    $css_class = 'mega_menu';
    $locations = get_nav_menu_locations();
    if ( isset( $locations[ $location ] ) ) {
        $menu = get_term( $locations[ $location ], 'nav_menu' );
        if ( $items = wp_get_nav_menu_items( $menu->name ) ) {
            foreach ( $items as $item ) {
                if ( in_array( $css_class, $item->classes ) ) {
                    register_sidebar( array(
                        'id' => 'mega-menu-widget-area-' . $item->ID,
                        'name' => $item->title . ' - Mega Menu',
                        'before_widget'=>'<div class="col-md-3">',
                        'after_widget'=>'</div>',
                        'before_title'=>'<h3>',
                        'after_title'=>'</h3>',
                    ) );
                }
            }
        }
    }
}
add_action( 'widgets_init', 'mega_menu_init' );

$widget_list = array('pveser-post-thumbnail', 'pveser-post-without-thumbnail', 'pveser-subscribe-email');
pveser_install_widgets($widget_list);
?>