<?php
//add_filter('pre_get_posts','get_custom_post_type');
function get_custom_post_type($query) {
    if ($query->is_main_query() && is_tax())
        $query->set ('post_type', array ('post','products', 'faqs'));
    return $query;
}

/*
2 Dashboard
4 Separator
5 Posts
10 Media
15 Links
20 Pages
25 Comments
59 Separator
60 Appearance
65 Plugins
70 Users
75 Tools
80 Settings
99 Separator.
 * */
function create_custom_post_type_products()
{
    $label = array(
        'name' => 'Sản phẩm',
        'singular_name' => 'Sản phẩm',
        'menu_name'           => 'Sản phẩm',
        'all_items'           => 'Tất cả Sản phẩm',
        'view_item'           => 'Xem Sản phẩm',
        'add_new_item'        => 'Thêm Sản phẩm',
        'add_new'             => 'Thêm Sản phẩm mới',
        'edit_item'           => 'Sửa Sản phẩm',
        'update_item'         => 'Cập nhật Sản phẩm',
        'search_items'        => 'Tìm kiếm Sản phẩm',
        'not_found'           => 'Không tìm thấy',
        'not_found_in_trash'  => 'Không tìm thấy trong thùng rác',
    );


    $args = array(
        'labels' => $label,
        'description' => '',
        'supports' => array(
            'title',
            'thumbnail'
        ), //Các tính năng được hỗ trợ trong post type
        'taxonomies' => array('product_cat'), //Các taxonomy được phép sử dụng để phân loại nội dung
        'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
        'public' => true, //Kích hoạt post type
        'show_ui' => true, //Hiển thị khung quản trị như Post/Page
        'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
        'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
        'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
        'menu_position' => 5, //Thứ tự vị trí hiển thị trong menu (tay trái)
        'menu_icon' => 'dashicons-info', //Đường dẫn tới icon sẽ hiển thị
        'can_export' => true, //Có thể export nội dung bằng Tools -> Export
        'has_archive' => true, //Cho phép lưu trữ (month, date, year)
        'exclude_from_search' => true, //Loại bỏ khỏi kết quả tìm kiếm
        'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
        'capability_type' => 'post',
        'rewrite' => array('slug'=>'san-pham')
    );

    register_post_type('products', $args); //Tạo post type với slug tên là sanpham và các tham số trong biến $args ở trên

}
//add_action('init', 'create_custom_post_type_products');

?>