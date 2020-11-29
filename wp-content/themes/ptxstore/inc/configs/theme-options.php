<?php
    class PVESER_Set_Section_Options{

        public $sections = array();

        public function setSections()
        {
            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'  => 'Thiết Lập Header',
                'desc'   => 'Mọi thiết lập phần Header',
                'icon'   => 'el el-bookmark',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(

                    array(
                        'id'    => 'logo-image',
                        'type'  => 'media',
                        'title' => 'Logo',
                        'desc'  => 'Vui lòng chọn logo cho website',
                        'url'=>true
                    ),

                    array(
                        'id'    => 'favicon',
                        'type'  => 'media',
                        'title' => 'Favicon',
                        'desc'  => 'Vui lòng chọn favicon cho website',
                        'url'=>true
                    )
                )
            );

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'  => 'Thiết Lập Trang Chủ',
                'desc'   => 'Mọi thiết lập phần trang chủ',
                'icon'   => 'el el-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(

                    array(
                        "id"=>"news_cat",
                        "type"=>"select",
                        "title"=>"Chuyên mục tin tức",
                        'multi'    => true,
                        'data'      => 'terms',
                        'args'      => array(
                            'taxonomies'    => 'category',
                            'args'          => array(),
                            'hide_empty'=>false

                        ),
                        'sortable'  => true,
                    )

                )
            );

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'  => 'Thiết lập Footer',
                'desc'   => 'Thiết lập thông tin tại Footer',
                'icon'   => 'el el-bookmark',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(

                    array(
                        "id"=>"footer-copyright",
                        "title"=>"Thông tin bản quyền",
                        "type"=>"editor"
                    ),

                    array(
                        "id"=>"footer-text",
                        "title"=>"Footer Text",
                        "type"=>"editor"
                    ),

                    array(
                        "id"=>"footer-hotline",
                        "title"=>"Footer Hotline",
                        "type"=>"text"
                    ),

                    array(
                        "id"=>"footer-social",
                        "title"=>"Footer Social",
                        "type"=>"section",
                        "indent" => true
                    ),

                    array(
                        "id"=>"facebook",
                        "title"=>"Facebook",
                        "type"=>"text"
                    ),

                    array(
                        "id"=>"instagram",
                        "title"=>"Instagram",
                        "type"=>"text"
                    ),

                    array(
                        "id"=>"youtube",
                        "title"=>"Youtube",
                        "type"=>"text"
                    ),


                )
            );

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'  => 'Header & Footer Code',
                'desc'   => 'Settings Header & Footer Code',
                'icon'   => 'el el-bookmark',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(

                    array(
                        'id'    => 'header-code',
                        'type'  => 'textarea',
                        'title' => 'Header Code',
                        'placeholder'  => 'Header Code...'
                    ),

                    array(
                        'id'    => 'footer-code',
                        'type'  => 'textarea',
                        'title' => 'Footer Code',
                        'placeholder'  => 'Footer Code...'
                    ),

                )
            );

            //thiết lập trang product

            $this->sections[] = array(
                'title'  => 'Thiết lập trang chi tiết sản phẩm',
                'desc'   => 'Mọi thiết lập liên quan tới trang chi tiết sản phẩm',
                'icon'   => 'el el-bookmark',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(

                    array(
                        'id'    => 'tell_product',
                        'type'  => 'text',
                        'title' => 'Thiết lập số điện thoại liên hệ mua hàng',
                       
                    ),

                    

                )
            );


            $this->sections[] = array(
                'title'  => 'Thiết Lập Slideshow',
                'desc'   => 'Mọi thiết lập phần Slideshow',
                'icon'   => 'el el-bookmark',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(

                    array(
                        'id'    => 'slideshow',
                        'type'  => 'slides',
                        'title' => 'Slideshow Trang Chủ'
                    ),

                    array(
                        'id'    => 'slideshow_shop',
                        'type'  => 'slides',
                        'title' => 'Slideshow sản phẩm'
                    ),

                    array(
                        'id'    => 'slideshow_expert',
                        'type'  => 'slides',
                        'title' => 'Slideshow chuyên gia'
                    )
                )
            );

            $this->sections[] = array(
                'title'  => 'Thiết Lập Khuyến mãi',
                'desc'   => 'Mọi thiết lập phần Khuyến mãi',
                'icon'   => 'el el-bookmark',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(

                    array(
                        'id'    => 'product_image_promotion_1',
                        'type'  => 'media',
                        'title' => 'Hình ảnh 1',
                        'url' => true
                    ),

                    array(
                        'id'    => 'product_link_promotion_1',
                        'type'  => 'text',
                        'title' => 'Liên kết 1'
                    ),

                    array(
                        'id'    => 'product_title_promotion_1',
                        'type'  => 'text',
                        'title' => 'Tiêu đề 1'
                    ),

                    array(
                        'id'    => 'product_image_promotion_2',
                        'type'  => 'media',
                        'title' => 'Hình ảnh 2',
                        'url' => true
                    ),

                    array(
                        'id'    => 'product_link_promotion_2',
                        'type'  => 'text',
                        'title' => 'Liên kết 2'
                    ),

                    array(
                        'id'    => 'product_title_promotion_2',
                        'type'  => 'text',
                        'title' => 'Tiêu đề 2'
                    ),
                )
            );

            $this->sections[] = array(
                'title'  => 'Thiết Lập Sidebar',
                'desc'   => 'Mọi thiết lập phần Sidebar',
                'icon'   => 'el el-bookmark',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(

                    array(
                        'title' => 'Thiết lập banner',
                        'type' => 'section',
                        'id' => 'section_sidebar_ads',
                        'indent' => true
                    ),
                    array(
                        'id'    => 'sidebar_ads_image',
                        'type'  => 'media',
                        'title' => 'Ảnh banner',
                        'url' => true
                    ),

                    array(
                        'id'    => 'sidebar_ads_link',
                        'type'  => 'text',
                        'title' => 'Link banner',
                    ),

                    array(
                        'id'    => 'sidebar_ads_desc',
                        'type'  => 'textarea',
                        'title' => 'Mô tả',
                    ),


                )
            );


            $this->sections[] = array(
                'title'  => 'Thiết Lập Trang 404',
                'desc'   => 'Mọi thiết lập trang 404',
                'icon'   => 'el el-bookmark',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(
                    array(
                        'id'    => 'image_404',
                        'type'  => 'media',
                        'title' => 'Ảnh 404',
                        'url' => true
                    ),

                    array(
                        'id'    => 'link_404',
                        'type'  => 'text',
                        'title' => 'Link 404',
                    ),

                )
            );

        }
    };

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> true
	));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme General Settings',
        'menu_title'	=> 'General',
        'parent_slug'	=> 'theme-general-settings',
    ));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Home Settings',
		'menu_title'	=> 'Home',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));

}
?>