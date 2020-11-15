<?php
class Posts_Thumbnail extends WP_Widget {

    function __construct() {
        parent::__construct(
            'posts_thumbnail_widget',
            'Pveser Post Thumbnails',
            array( 'description'  =>  'Widget hiển thị bài viết có thumbnail' )
        );
    }

    function form( $instance ) {
        wp_enqueue_style( 'posts-widget-style', get_template_directory_uri()."/pveser-framework/assets/css/widgets.css");
        $default = array(
            'title' => 'Bài viết mới',
            'post_number' => 5,
            "orderby"=>"date",
            "order"=>"DESC",
            "category_id"=>array()
        );
        $walker = new Walker_Category_Checklist_Widget(
            $this->get_field_name( 'category_id' ),
            $this->get_field_id( 'category_id' )
        );
        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        $post_number = esc_attr($instance['post_number']);
        $orderby = esc_attr($instance['orderby']);
        $order = esc_attr($instance['order']);

        if ($orderby=="date") $selected_date="selected";
        else
        {
            $selected_date="";
        }
        if ($orderby=="title") $selected_title="selected";
        else
        {
            $selected_title="";
        }
        if ($order=="ASC") $selected_asc="selected";
        else
        {
            $selected_asc="";
        }
        if ($order=="DESC") $selected_desc="selected";
        else
        {
            $selected_desc="";
        }

        echo '<p>Nhập tiêu đề: <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';

        echo '<p>Số lượng bài viết hiển thị: <input type="number" class="widefat" name="'.$this->get_field_name('post_number').'" value="'.$post_number.'" placeholder="'.$post_number.'" /></p>';

        echo '<p>Chuyên mục:<p>';
        echo '<ul class="list-checkbox">';
        wp_category_checklist( 0, 0, $instance['category_id'], FALSE, $walker, FALSE );
        echo '</ul>';

        echo '<p>Order By: <select class="widefat" name="'.$this->get_field_name('orderby').'">
            <option value="date" '.$selected_date.'>Date</option>
            <option value="title" '.$selected_title.'>Title</option>
        </select></p>';
        echo '<p>Order: <select class="widefat" name="'.$this->get_field_name('order').'">
            <option value="ASC" '.$selected_asc.'>ASC</option>
            <option value="DESC" '.$selected_desc.'>DESC</option>
        </select></p>';
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['post_number'] = strip_tags($new_instance['post_number']);
        $instance['category_id'] = $new_instance['category_id'];
        $instance['orderby'] = strip_tags($new_instance['orderby']);
        $instance['order'] = strip_tags($new_instance['order']);
        return $instance;
    }

    function widget( $args, $instance ) {
        extract($args);
        //$title = apply_filters( 'widget_title', $instance['title'] );
        $post_number = $instance['post_number'];

        if (count($instance['category_id'])>0)
        {
            $category_id=implode(",", $instance['category_id']);
        }
        else
        {
            $category_id="";
        }

        $orderby=$instance['orderby'];
        $order=$instance['order'];
        //echo $before_widget;
        //echo $before_title.$title.$after_title;
        $post_query=new WP_Query(array(
            "post_type"=>"post",
            "posts_per_page"=>$post_number,
            "cat"=>$category_id,
            "orderby"=>$orderby,
            "order"=>$order
        ));
        if ($post_query->have_posts()):
            ?>
            <div class="bg-dark" style="margin-bottom: 15px;">
                <div class="wrap-content-sidebar bg-white">

                    <div class="head-article-sidebar">
                        <h3><?php echo $instance['title'] ?></h3
                    </div> <!-- END /.head-article-sidebar -->
                    <hr>

                    <div class="contennt-article-sidebar">
                        <?php
                            while ($post_query->have_posts()):
                                $post_query->the_post();
                                if ($post_query->current_post<=2):
                        ?>
                        <div class="media custom-media">
                            <div class="media-left">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <?php pveser_thumbnail('thumbnail', array('class'=>'media-object')); ?>
                                </a>
                            </div> <!-- END /. media-left -->
                            <div class="media-body">
                                <h3 class="media-heading"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                            </div> <!-- END /. media-body -->
                        </div> <!-- END /.media .custom-media -->
                            <?php else: ?>

                        <h3 class="h5"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                        <hr/>

                        <?php endif; endwhile; wp_reset_query(); ?>

                    </div> <!-- END /.contennt-article-sidebar -->

                </div> <!-- END /.wrap-content-sidebar -->
            </div> <!-- END /.bg-dark -->
           </div>
            <?php
        else:
            ?>
            <?php
        endif;
        //echo $after_widget;
    }

}

add_action( 'widgets_init', 'create_posts_thumbnail_widget' );
function create_posts_thumbnail_widget() {
    register_widget('Posts_Thumbnail');
}
?>