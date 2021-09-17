<?php
require_once ABSPATH . "wp-includes/class-wp-widget.php";
add_action('widgets_init', 'km_load_widget');
function km_load_widget()
{
    register_widget('km_widget');
    register_widget('km_instagram_feeds');
}

/* latest posts start */
function km_get_latest_post($args_data)
{
    ob_start();
    $recent_posts_service = new WP_Query($args_data);
    ?>
    <div class="recent-post-container">
        <div class="main-heading border">
            <h3>Latest News</h3>
        </div>
        <?php
        if ($recent_posts_service->have_posts()) {
            while ($recent_posts_service->have_posts()) {
                $post_id = get_the_ID();
                $recent_posts_service->the_post();
                $img_url = get_the_post_thumbnail_url();
                $terms = get_the_terms($recent_posts_service->ID, 'category');
                ?>
                <div class="recent-blog-sidebar">
                    <div class="post-content-header-imagewrap">
                        <a href="<?php echo get_the_permalink(); ?>">
                            <!-- <img src="<?php // echo $img_url; ?>" alt=""/> -->
                            <div class="content-header-bg"
                            style=" background-image: url(<?php echo $img_url; ?>);"></div>
                        </a>
                    </div>
                    <div class="post-content-wrap">
                        <div class="recent-blog-sidebar-title">
                            <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
                        </div>
                        <div class="recent-post-sidebar-date">
                            <span class="author">By : <?php echo get_the_author(); ?></span>
                            <span class="date_recent"><?php echo get_the_date('M. d, Y'); ?></span>
                        </div>
                        <div class="recent-post-sidebar-description">
                            <span class="content">
                                <?php $trimmed_content = wp_trim_words(get_the_content(), 20);
                                echo $trimmed_content; ?>..
                            </span>
                        </div>
                        <div class="recent-post-sidebar-more">
                            <a href="<?php echo get_the_permalink(); ?>">View More</a>
                        </div>
                    </div>
                </div>
                <?php
            } 
            wp_reset_postdata();
        }
        ?>
        <div class="text-center" style="clear: both;">
            <a href="<?php echo site_url('blog') ?>">
                <button class="button view_all">View All</button>
            </a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
class km_widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            // Base ID of your widget
            'km_widget',
            __('Km Recent Post Widget', 'wpb_widget_domain'),
            array('description' => __('Simple widget', 'wpb_widget_domain')
        ));
    }

    /* Creating widget front-end */

    public function widget($args, $instance)
    {
        global $wpdb;
        global $posts;
        $args['before_widget'];
        $args_data = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $instance['number'],
            'order' => 'DESC'
        );
        echo km_get_latest_post($args_data);
    }

    /* Widget Backend */

    public function form($instance)
    {
        $number = esc_attr(@$instance['number']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number Of Posts:'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" class="widefat" type="text"
            name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $number; ?>"/>
        </p>
        <?php
    }

    /* Updating widget replacing old instances with new */

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['number'] = strip_tags($new_instance['number']);
        return $instance;
    }
}





/* km insta gram feeds start */

function km_get_insta_feeds()
{
    ob_start();
    ?>
    <div class="timeline-widget insta-timeline clearfix">
        <div class="title-logo text-center"><h3>FolloW <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/10/LOGO-WOOFY.png"  width="180px" /> on Instagram</h3></div>
        <div class="insta-timeline-body">
            <?php // echo "<pre>"; print_r(instagramresults()); die;
            $i=1;
            ?>
            <?php foreach (instagramresults()->data as $post) {
               if($i <= 4){ ?>
                    <div class="mainimg">
                        <div class="imagebox">
                            <a href="<?php echo $post->link; ?>" target="_blank">
                                <img src="<?php echo $post->images->standard_resolution->url; ?>">
                            </a>
                        </div>
                    </div>
                <?php }
                $i++;
                 } ?>
            </div>
        </div>
        <?php return ob_get_clean();
    }


    class km_instagram_feeds extends WP_Widget
    {

        function __construct()
        {
            parent::__construct(
// Base ID of your widget
                'km_instagram_feeds',
                __('Km Instagram Feeds', 'wpb_widget_domain'),
                array('description' => __('Instagram Feeds', 'wpb_widget_domain')
            )
            );
        }

// Creating widget front-end

        public function widget($args, $instance)
        {
            echo km_get_insta_feeds();

        }
        /* km insta gram feeds end */

    }
    ?>