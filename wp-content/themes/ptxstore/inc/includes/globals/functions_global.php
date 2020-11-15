<?php
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
add_image_size('post-thumbnails-content' , 513 , 288 , true);
add_image_size('post-thumbnails-big' , 790 , 392 , true);

flush_rewrite_rules();
show_admin_bar(__return_false());

function get_dynamic_sidebar($index = 1)
{
    $sidebar_contents = "";
    ob_start();
    dynamic_sidebar($index);
    $sidebar_contents = ob_get_clean();
    return $sidebar_contents;
}

function pveser_excerpt($number){
    $excerpt = get_the_content();
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $number);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    return $excerpt."...";
}

function pveser_title($number){
    $excerpt = get_the_title();
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $number);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    return $excerpt."...";
}

function pveser_thumbnail($size, $atts = array())
{
    $default=__THEME_HOST."/pveser-framework/assets/images/no-photo.png";
    if (has_post_thumbnail()) the_post_thumbnail($size, $atts);
    else echo '<img src="'.$default.'" alt="'.get_the_title().'"/>';
}

function pveser_comment_facebook($number)
{
    ?>
    <div class="fb-comments" data-width="100%" data-href="<?php the_permalink(); ?>" data-numposts="<?php echo $number; ?>"></div>
    <?php
}

function pveser_related_post($number, $title)
{
    global $post;
    $orig_post = $post;
    $categories = get_the_category($post->ID);
    if ($categories) {
        $category_ids = array();
        foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
        $args=array(
            'category__in' => $category_ids,
            'post__not_in' => array($post->ID),
            'posts_per_page'=> $number, // Number of related posts that will be shown.
            'ignore_sticky_posts'=>1,
            'orderby'=>'date'
        );
        $related_query = new wp_query( $args );
        if( $related_query->have_posts() ) {
            $count=0;
            ?>
            <div class="related-posts">
                <h4 style="margin-bottom: 20px;" class="underline-title text-uppercase"><?php echo $title; ?></h4>
                <div class="wrap-related-post row">
                    <?php

                    while( $related_query->have_posts() )
                    {
                        $count++;
                        $related_query->the_post();
                        ?>
                        <div class="wrap-item-news col-md-6">
                            <div class="media custom-media">
                                <div class="media-left">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php pveser_thumbnail('thumbnail', array('class'=>'media-object', 'width'=>'128', 'height'=>'180')) ?>
                                    </a>
                                </div> <!-- END /. media-left -->
                                <div class="media-body">
                                    <h3 class="media-heading"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                </div> <!-- END /. media-body -->
                            </div>
                        </div> <!-- END /. wrap-item-news -->
                        <?php
                        echo ($count%2==0)?'<div class="clearfix"></div>':FALSE;
                    }
                    ?>
                </div><!--End .row-->
            </div><!--End .related_post-->
            <?php

        }
    }
    $post = $orig_post;
    wp_reset_query();
}

function pveser_wp_is_mobile()
{
    static $is_mobile;

    if ( isset($is_mobile) )
        return $is_mobile;

    if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
        $is_mobile = false;
    } elseif (
        strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false ) {
        $is_mobile = true;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') == false) {
        $is_mobile = true;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
        $is_mobile = false;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}

function custom_login_logo() {
    ?>
    <link href="<?php echo get_template_directory_uri(); ?>/pveser-framework/assets/css/login.css" rel="stylesheet" type="text/css"/>
    <?php
}

add_action('login_head', 'custom_login_logo');

function SearchFilter($query)
{
    if ($query->is_search) {
        $query->set('post_type', array('post','faqs'));
        ///$query->set('post_type', 'faqs');
    }
    return $query;
}
add_filter('pre_get_posts','SearchFilter');

function get_youtube_id($url)
{
    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
    return $my_array_of_vars['v'];
}

//function modify_jquery() {
//    if (!is_admin()) {
//        // comment out the next two lines to load the local copy of jQuery
//        wp_deregister_script('jquery');
//        wp_register_script('jquery', __THEME_HOST.'/assets/js/jquery-1.9.1.js', false, '');
//        wp_enqueue_script('jquery');
//    }
//}
//add_action('init', 'modify_jquery');

add_filter( 'body_class', "custom_body_class");

function custom_body_class( $classes ) {

    if (!in_array("woocommerce", $classes) && !empty($classes))
    {
        return array_merge( $classes, array( 'woocommerce' ) );
    }

    return $classes;

}

//add_action('wp_ajax_nopriv_dhemy_ajax_search','dhemy_ajax_search');
//add_action('wp_ajax_dhemy_ajax_search','dhemy_ajax_search');

function dhemy_ajax_search(){

// your taxonomy name
    $tax = 'product_tag';

// get the terms of taxonomy
    $terms = get_terms( $tax, array( 'hide_empty' => false, 'search'=>$_POST['term'], 'number'=>10)
    // do not hide empty terms
);

    if (count($terms)>0)
    {
        foreach( $terms as $term ) {
            echo '<li><a href="'. get_term_link( $term ) .'">'. $term->name .'</a></li>';
        }
    }
    else
    {
        echo '<li>Không tìm thấy kết quả</li>';
    }


    exit;
}

function rel_next_prev(){
    global $paged;

    if ( get_previous_posts_link() ) { ?>
        <link rel="prev" href="<?php echo get_pagenum_link( $paged - 1 ); ?>" /><?php
    }

    if ( get_next_posts_link() ) { ?>
        <link rel="next" href="<?php echo get_pagenum_link( $paged +1 ); ?>" /><?php
    }

}
add_action( 'wp_head', 'rel_next_prev' );


function _remove_script_version( $src ){
    $parts = explode( '?ver', $src );
    return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

function wp_html_compression_finish($html)
{
    return new WP_HTML_Compression($html);
}

function wp_html_compression_start()
{
    ob_start('wp_html_compression_finish');
}
add_action('get_header', 'wp_html_compression_start');

function pveser_option($theme_options, $before='', $after='', $default='')
{
    if (!empty($theme_options))
    {
        $content = $before.$theme_options.$after;
    }
    else
    {
        $content = $default;
    }

    return $content;
}

function pveser_template_part($name)
{
    $path = __THEME_PATH.'/pveser-framework/templates/'.$name.'.php';

    require_once $path;
}

function pveser_menu_bootstrap($location, $level, $container_class='', $container_id='', $menu_class='nav navbar-nav', $menu_id='')
{
    wp_nav_menu( array(
        'theme_location' => $location,
        'depth' => $level,
        'menu_class' => $menu_class,
        'menu_id' => $menu_id,
        'container_class'=>$container_class,
        'container_id'=>$container_id,
        'walker' => new wp_bootstrap_navwalker())
);
}

function pveser_breadcrumbs() {

    // Settings
    $breadcrums_class   = 'breadcrumb';
    $home_title         = '';

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';

    // Get the query & post information
    global $post,$wp_query;

    // Do not display on the homepage
    if ( !is_front_page() ) {

        // Build the breadcrums
        echo '<ul class="' . $breadcrums_class . '">';

        // Home page
        echo '<li><a href="' . get_home_url() . '" title="' . $home_title . '"><span class="fa-stack"><i class="fa fa-square text-muted fa-stack-2x"></i><i class="fa fa-home fa-stack-1x text-white"></i></span> ' . $home_title . '</a></li>';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

            echo '<li class="active"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';

        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';

            }

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="active">' . $custom_tax_name . '</li>';

        } else if ( is_single() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';

            }

            // Get post category info
            $category = get_the_category();

            if(!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                }

            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;

            }

            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';

                // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {

                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';

            } else {

                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';

            }

        } else if ( is_category() ) {

            // Category page
            echo '<li class="item-current item-cat">' . single_cat_title('', false) . '</li>';

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';

            } else {

                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';

            }

        } else if ( is_tag() ) {

            // Tag page

            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '">' . $get_term_name . '</li>';

        } elseif ( is_day() ) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '">' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</li>';

        } else if ( is_month() ) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '">' . get_the_time('M') . ' Archives</li>';

        } else if ( is_year() ) {

            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</li>';

        } else if ( is_author() ) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '">' . 'Author: ' . $userdata->display_name . '</li>';

        } else if ( get_query_var('paged') ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '">Search results for: ' . get_search_query() . '</li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }

        echo '</ul>';

    }

}

function getDuration($videoID){

    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );

    $apikey = "AIzaSyCNNrA_abLroIglF1586TYRP5GoO_Jd6DY";
    $dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$videoID&key=$apikey", false, stream_context_create($arrContextOptions));
    $VidDuration =json_decode($dur, true);
    foreach ($VidDuration['items'] as $vidTime)
    {
        $VidDuration= $vidTime['contentDetails']['duration'];
    }
    preg_match_all('/(\d+)/',$VidDuration,$parts);
    return $parts[0][0].":".$parts[0][1].":".$parts[0][2]; // Return 1:11:46 (i.e) HH:MM:SS
}

function pveser_install_widgets($name=array()) {
}

// =================== LOGIN ============================//

// Redirect khi đăng nhập
function my_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    global $user;
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if ( in_array( 'administrator', $user->roles ) ) {
        // redirect them to the default place
            return home_url();
        } else {
            return home_url();
        }
    } else {
        return $redirect_to;
    }
}
//add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );
function redirect_login_page() {
    $login_page  = get_page_link(241);;
    $page_viewed = basename($_SERVER['REQUEST_URI']);
    if( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
        wp_redirect($login_page);
        exit;
    }
}
//add_action('init','redirect_login_page');
// Kết thúc Redirect khi đăng nhập

// Kiểm tra lỗi đăng nhập
function login_failed() {
    $login_page  = get_page_link(241);;
    wp_redirect( $login_page . '?login=failed' );
    exit;
}
//add_action( 'wp_login_failed', 'login_failed' );
function verify_username_password( $user, $username, $password ) {
    $login_page  = get_page_link(241);;
    if( $username == "" || $password == "" ) {
        wp_redirect( $login_page . "?login=empty" );
        exit;
    }
}
//add_filter( 'authenticate', 'verify_username_password', 1, 3);



//============== xoa bai ================//
/*
add_action( 'wp_ajax_delete_post', 'delete_post_fuction');
add_action( 'wp_ajax_nopriv_delete_post', 'delete_post_fuction');

function delete_post_fuction(){
    $post_idd = $_POST['value'];
    wp_delete_post( $post_idd, false);
    die();
}


function insert_attachment($file_handler,$post_id,$setthumb='false') {
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    $attach_id = media_handle_upload( $file_handler, $post_id );
    
    if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
    return $attach_id;
}

function create_shortcode_post_featured($args, $content)
{
    ob_start();
    $query = new WP_Query(
        array('post_type' => 'post', 'cat'=>$args['category'], 'order'=>'DESC', 'orderby'=>'date', 'meta_key'=>'featured_post', 'meta_value'=>true, 'posts_per_page'=>$args['limit'])
    );
    if ($query->have_posts())
    {
        echo '<ul>';
        while ($query->have_posts())
        {
            $query->the_post();
            ?>
            <li><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 10, '...' ); ?></a></li>
            <?php
        }
        echo '</ul>';
    }
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}
add_shortcode('post_featured', 'create_shortcode_post_featured');

//Hàm đếm lượt truy cập khi khách vào xem bài viết
function ah_setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function create_shortcode_post_views($args, $content)
{
    ob_start();
    $query = new WP_Query(
        array('post_type' => 'post', 'cat'=>$args['category'], 'order'=>'DESC', 'orderby'=>'meta_value_num', 'meta_key'=>'post_views_count', 'posts_per_page'=>$args['limit'])
    );
    if ($query->have_posts())
    {
        echo '<ul>';
        while ($query->have_posts())
        {
            $query->the_post();
            ?>
            <li><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 10, '...' ); ?></a></li>
            <?php
        }
        echo '</ul>';
    }
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}
add_shortcode('post_views', 'create_shortcode_post_views');



add_action( 'wp_ajax_check_pass', 'check_pass_fuction');
add_action( 'wp_ajax_nopriv_check_pass', 'check_pass_fuction');

function check_pass_fuction(){

    if(isset($_POST['value'])&&!empty($_POST['value'])){
        if(wp_check_password( $_POST['value'], $_POST['user_hash'], $_POST['idd'])){
            echo "true";
        }
        else echo "false";
    }
    die();

}

/*Contributor add media*/
//Allow Contributors to Add Media
/*
if ( current_user_can('contributor') && !current_user_can('upload_files') )
    add_action('admin_init', 'allow_contributor_uploads');
function allow_contributor_uploads() {
    $contributor = get_role('contributor');
    $contributor->add_cap('upload_files');
}
*/
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
    // $cols contains the current number of products per page based on the value stored on Options –> Reading
    // Return the number of products you wanna show per page.
    $cols = 2;
    return $cols;
}
?>