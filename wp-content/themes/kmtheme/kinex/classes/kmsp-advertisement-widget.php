<?php

// Creating the widget
class KMSP_Advertisement extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'KMSP_Advertisement',
            __('Advertisement', 'kmtheme'),
            array('description' => __('widget based on show advertise', 'kmtheme'),)
        );
    }


    public function widget($args, $instance)
    {
       
        echo $args['before_widget'];


        echo $args['after_widget'];
    }


    public function form($instance)
    {

    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

add_filter('dynamic_sidebar_params', 'my_dynamic_sidebar_params');

function my_dynamic_sidebar_params( $params ) {

    // get widget vars
    $widget_name = $params[0]['widget_name'];
    $widget_id = $params[0]['widget_id'];



    // bail early if this widget is not a Text widget
    if( $widget_name != 'Advertisement' ) {

        return $params;

    }



    // add image to after_widget
    $image = get_field('image', 'widget_' . $widget_id);

    if( $image ) {

        $params[0]['after_widget'] = '<a href="'.get_field('link', 'widget_' . $widget_id).'"><img src="' . $image['url'] . '"></a>' . $params[0]['after_widget'];
    }


    // return
    return $params;

}