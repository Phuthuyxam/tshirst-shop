<?php
class Pveser_Subscribe_Email extends WP_Widget {

    function __construct() {
        parent::__construct(
            'pveser_subscribe_email_widget',
            'Pveser Subscribe Email',
            array( 'description'  =>  'Widget hiển thị form thu nhập email' )
        );
    }

    function form( $instance ) {

        $default = array(
            'title' => 'Đăng ký nhận quà',
            'content' => '',
            'email_desc'=>''
        );

        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        $content = esc_attr($instance['content']);
        $desc = esc_attr($instance['email_desc']);

        echo '<p>Nhập tiêu đề: <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
        echo '<p>Mô tả: <textarea class="widefat" name="'.$this->get_field_name('email_desc').'">'.$desc.'</textarea></p>';
        echo '<p>HTML Form: <textarea class="widefat" name="'.$this->get_field_name('content').'">'.$content.'</textarea></p>';
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['content'] = $new_instance['content'];
        $instance['email_desc'] = $new_instance['email_desc'];
        return $instance;
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = $instance['title'];
        $content = $instance['content'];
        $desc = apply_filters('the_content', $instance['email_desc']);
        ?>
        <section class="panel m-t bg-danger dk">
            <header class="panel-heading dker red-bottom-xs">
                <span class="h5"><?php echo $title; ?></span>
            </header>
            <div class="panel-body">
                <div class="tab-pane active" id="update-newsletter">
                    <?php
                        echo $desc;
                    ?>
                    <?php
                        echo $content;
                    ?>
                </div>
            </div>
        </section>
        <?php
    }

}

add_action( 'widgets_init', 'create_pveser_subscribe_email_widget' );
function create_pveser_subscribe_email_widget() {
    register_widget('Pveser_Subscribe_Email');
}
?>