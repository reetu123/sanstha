<?php
class css_hooks
{
  public function __construct()
  {
    $this->add_action('wp_enqueue_scripts', array($this, 'km_inlcude_style_frontend'));
    $this->add_action('admin_head', array($this, 'km_inlclude_style_backend'));

  }

  public function km_inlcude_style_frontend()
  {
    wp_enqueue_style('slick-css', plugin_dir_url(__FILE__) . 'assets/css/slick.css');
    wp_enqueue_style('slick-theme-css', plugin_dir_url(__FILE__) . 'assets/css/slick-theme.css');
    wp_enqueue_style('fancybox-min-css', plugin_dir_url(__FILE__) . 'assets/css/jquery.fancybox.min.css');
    wp_enqueue_style('star-rating-svg-css', plugin_dir_url(__FILE__) . 'assets/css/star-rating-svg.css');
      // wp_enqueue_style('demo-css', plugin_dir_url(__FILE__) . 'assets/css/demo.css');
    
      // wp_enqueue_style('bootstrap-min-css', plugin_dir_url(__FILE__) . 'assets/css/bootstrap.min.css');
    
  }

  public function km_inlclude_style_backend()
  {
    wp_enqueue_style('backend-custom-css', plugin_dir_url(__FILE__) . 'assets/css/backend-custom.css');
  }

  function add_action($name, $callback)
  {
    add_action($name, $callback);
  }
}

new css_hooks();