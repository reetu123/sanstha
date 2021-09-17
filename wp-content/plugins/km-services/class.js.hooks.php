<?php
class hooks
{
    public function __construct()
    {
        $this->add_action('wp_enqueue_scripts', array($this, 'km_inlclude_script_frontend'));
        $this->add_action('admin_enqueue_scripts', array($this, 'km_inlclude_script_backend'));
    }

    public function km_inlclude_script_frontend()
    {
        wp_enqueue_script('moment-min-js', plugin_dir_url(__FILE__) . 'assets/js/moment.min.js', array('jquery'));
        
        

        if (is_page ('my-profile') || is_page ('tasker-signup') || is_page('search-tasker') || is_page('become-a-tasker') || is_page('listing')){
            
            wp_enqueue_script('google-api-key', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCc75Q9kXqU-DXijJUzbBwMYYtdXCfFAH8&libraries=places,drawing&callback=initSearchAutocomplete', array('jquery')); 

            wp_enqueue_script('custom-locations-js', plugin_dir_url(__FILE__) . 'assets/js/custom-locations.js', array('jquery'));
        }
        wp_enqueue_script('slick-min-js', plugin_dir_url(__FILE__) . 'assets/js/slick.min.js', array('jquery'));

        wp_enqueue_script('jquery-fancybox-min-js', plugin_dir_url(__FILE__) . 'assets/js/jquery.fancybox.min.js', array('jquery'));
        wp_enqueue_script('jquery-isotope-js', plugin_dir_url(__FILE__) . 'assets/js/isotope.pkgd.js', array('jquery'));

        wp_enqueue_script('ajax-script', plugin_dir_url(__FILE__) . 'assets/js/frontend-custom.js', array('jquery'));
        wp_enqueue_script('jquery-star-rating-svg-js', plugin_dir_url(__FILE__) . 'assets/js/jquery.star-rating-svg.js');
        wp_enqueue_script('jquery-mask-min-js', plugin_dir_url(__FILE__) . 'assets/js/jquery.mask.min.js');

        wp_enqueue_script('jquery-validate-js', plugin_dir_url(__FILE__) . '/assets/js/jquery.validate.min.js', array('jquery'));


         // wp_enqueue_script('bootstrap-min-js', plugin_dir_url(__FILE__) . 'assets/js/bootstrap.min.js');

        wp_localize_script('ajax-script', 'kmpl', array('ajaxUrl' => admin_url('admin-ajax.php')));

    }

    public function km_inlclude_script_backend()
    {
        wp_enqueue_script('jquery-validate-min-js', plugin_dir_url(__FILE__) . '/assets/js/jquery.validate.min.js', array('jquery'));
        wp_enqueue_script('backend-custom-js', plugin_dir_url(__FILE__) . '/assets/js/backend-custom.js', array('jquery'));
    }

    function add_action($name, $callback)
    {
        add_action($name, $callback);
    }
}
new hooks();