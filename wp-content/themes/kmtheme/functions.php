<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if (version_compare($GLOBALS['wp_version'], '4.7-alpha', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
    return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup()
{
    /*
     * Make theme available for translation.
     * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
     * If you're building a theme based on Twenty Seventeen, use a find and replace
     * to change 'twentyseventeen' to the name of your theme in all the template files.
     */
    load_theme_textdomain('twentyseventeen');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    add_image_size('twentyseventeen-featured-image', 2000, 1200, true);

    add_image_size('twentyseventeen-thumbnail-avatar', 100, 100, true);

    // Set the default content width.
    $GLOBALS['content_width'] = 525;

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus(array(
        'top' => __('Top Menu', 'twentyseventeen'),
        'social' => __('Social Links Menu', 'twentyseventeen'),
    ));

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    /*
     * Enable support for Post Formats.
     *
     * See: https://codex.wordpress.org/Post_Formats
     */
    add_theme_support('post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
    ));

    // Add theme support for Custom Logo.
    add_theme_support('custom-logo', array(
        'width' => 240,
        'height' => 61,
        'flex-width' => true,
        'flex-height' => true,
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, and column width.
      */
    add_editor_style(array('assets/css/editor-style.css', twentyseventeen_fonts_url()));

    // Define and register starter content to showcase the theme on new sites.
    $starter_content = array(
        'widgets' => array(
            // Place three core-defined widgets in the sidebar area.
            'sidebar-1' => array(
                'text_business_info',
                'search',
                'text_about',
            ),

            // Add the core-defined business info widget to the footer 1 area.
            'sidebar-2' => array(
                'text_business_info',
            ),

            // Put two core-defined widgets in the footer 2 area.
            'sidebar-3' => array(
                'text_about',
                'search',
            ),
        ),

        // Specify the core-defined pages to create and add custom thumbnails to some of them.
        'posts' => array(
            'home',
            'about' => array(
                'thumbnail' => '{{image-sandwich}}',
            ),
            'contact' => array(
                'thumbnail' => '{{image-espresso}}',
            ),
            'blog' => array(
                'thumbnail' => '{{image-coffee}}',
            ),
            'homepage-section' => array(
                'thumbnail' => '{{image-espresso}}',
            ),
        ),

        // Create the custom image attachments used as post thumbnails for pages.
        'attachments' => array(
            'image-espresso' => array(
                'post_title' => _x('Espresso', 'Theme starter content', 'twentyseventeen'),
                'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
            ),
            'image-sandwich' => array(
                'post_title' => _x('Sandwich', 'Theme starter content', 'twentyseventeen'),
                'file' => 'assets/images/sandwich.jpg',
            ),
            'image-coffee' => array(
                'post_title' => _x('Coffee', 'Theme starter content', 'twentyseventeen'),
                'file' => 'assets/images/coffee.jpg',
            ),
        ),

        // Default to a static front page and assign the front and posts pages.
        'options' => array(
            'show_on_front' => 'page',
            'page_on_front' => '{{home}}',
            'page_for_posts' => '{{blog}}',
        ),

        // Set the front page section theme mods to the IDs of the core-registered pages.
        'theme_mods' => array(
            'panel_1' => '{{homepage-section}}',
            'panel_2' => '{{about}}',
            'panel_3' => '{{blog}}',
            'panel_4' => '{{contact}}',
        ),

        // Set up nav menus for each of the two areas registered in the theme.
        'nav_menus' => array(
            // Assign a menu to the "top" location.
            'top' => array(
                'name' => __('Top Menu', 'twentyseventeen'),
                'items' => array(
                    'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
                    'page_about',
                    'page_blog',
                    'page_contact',
                ),
            ),

            // Assign a menu to the "social" location.
            'social' => array(
                'name' => __('Social Links Menu', 'twentyseventeen'),
                'items' => array(
                    'link_yelp',
                    'link_facebook',
                    'link_twitter',
                    'link_instagram',
                    'link_email',
                ),
            ),
        ),
    );

    /**
     * Filters Twenty Seventeen array of starter content.
     *
     * @since Twenty Seventeen 1.1
     *
     * @param array $starter_content Array of starter content.
     */
    $starter_content = apply_filters('twentyseventeen_starter_content', $starter_content);

    add_theme_support('starter-content', $starter_content);
}

add_action('after_setup_theme', 'twentyseventeen_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width()
{

    $content_width = $GLOBALS['content_width'];

    // Get layout.
    $page_layout = get_theme_mod('page_layout');

    // Check if layout is one column.
    if ('one-column' === $page_layout) {
        if (twentyseventeen_is_frontpage()) {
            $content_width = 644;
        } elseif (is_page()) {
            $content_width = 740;
        }
    }

    // Check if is single post and there is no sidebar.
    if (is_single() && !is_active_sidebar('sidebar-1')) {
        $content_width = 740;
    }

    /**
     * Filter Twenty Seventeen content width of the theme.
     *
     * @since Twenty Seventeen 1.0
     *
     * @param int $content_width Content width in pixels.
     */
    $GLOBALS['content_width'] = apply_filters('twentyseventeen_content_width', $content_width);
}

add_action('template_redirect', 'twentyseventeen_content_width', 0);

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url()
{
    $fonts_url = '';

    /*
     * Translators: If there are characters in your language that are not
     * supported by Libre Franklin, translate this to 'off'. Do not translate
     * into your own language.
     */
    $libre_franklin = _x('on', 'Libre Franklin font: on or off', 'twentyseventeen');

    if ('off' !== $libre_franklin) {
        $font_families = array();

        $font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

        $query_args = array(
            'family' => urlencode(implode('|', $font_families)),
            'subset' => urlencode('latin,latin-ext'),
        );

        $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    }

    return esc_url_raw($fonts_url);
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints($urls, $relation_type)
{
    if (wp_style_is('twentyseventeen-fonts', 'queue') && 'preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }

    return $urls;
}

add_filter('wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more($link)
{
    if (is_admin()) {
        return $link;
    }

    $link = sprintf('<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
        esc_url(get_permalink(get_the_ID())),
        /* translators: %s: Name of current post */
        sprintf(__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen'), get_the_title(get_the_ID()))
    );
    return ' &hellip; ' . $link;
}

add_filter('excerpt_more', 'twentyseventeen_excerpt_more');

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection()
{
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

add_action('wp_head', 'twentyseventeen_javascript_detection', 0);

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", get_bloginfo('pingback_url'));
    }
}

add_action('wp_head', 'twentyseventeen_pingback_header');

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap()
{
    if ('custom' !== get_theme_mod('colorscheme') && !is_customize_preview()) {
        return;
    }

    require_once(get_parent_theme_file_path('/inc/color-patterns.php'));
    $hue = absint(get_theme_mod('colorscheme_hue', 250));
    ?>
    <style type="text/css" id="custom-theme-colors" <?php if (is_customize_preview()) {
        echo 'data-hue="' . $hue . '"';
    } ?>>
    <?php echo twentyseventeen_custom_colors_css(); ?>
</style>
<?php }

add_action('wp_head', 'twentyseventeen_colors_css_wrap');

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts()
{
    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style('twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null);

    // Theme stylesheet.
    wp_enqueue_style('twentyseventeen-style', get_stylesheet_uri());

    // Load the dark colorscheme.
    if ('dark' === get_theme_mod('colorscheme', 'light') || is_customize_preview()) {
        wp_enqueue_style('twentyseventeen-colors-dark', get_theme_file_uri('/assets/css/colors-dark.css'), array('twentyseventeen-style'), '1.0');
    }

    // Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
    if (is_customize_preview()) {
        wp_enqueue_style('twentyseventeen-ie9', get_theme_file_uri('/assets/css/ie9.css'), array('twentyseventeen-style'), '1.0');
        wp_style_add_data('twentyseventeen-ie9', 'conditional', 'IE 9');
    }

    // Load the Internet Explorer 8 specific stylesheet.
    wp_enqueue_style('twentyseventeen-ie8', get_theme_file_uri('/assets/css/ie8.css'), array('twentyseventeen-style'), '1.0');
    wp_style_add_data('twentyseventeen-ie8', 'conditional', 'lt IE 9');

    // Load the html5 shiv.
    wp_enqueue_script('html5', get_theme_file_uri('/assets/js/html5.js'), array(), '3.7.3');
    wp_script_add_data('html5', 'conditional', 'lt IE 9');

    wp_enqueue_script('twentyseventeen-skip-link-focus-fix', get_theme_file_uri('/assets/js/skip-link-focus-fix.js'), array(), '1.0', true);

    $twentyseventeen_l10n = array(
        'quote' => twentyseventeen_get_svg(array('icon' => 'quote-right')),
    );

    if (has_nav_menu('top')) {
        wp_enqueue_script('twentyseventeen-navigation', get_theme_file_uri('/assets/js/navigation.js'), array('jquery'), '1.0', true);
        $twentyseventeen_l10n['expand'] = __('Expand child menu', 'twentyseventeen');
        $twentyseventeen_l10n['collapse'] = __('Collapse child menu', 'twentyseventeen');
        $twentyseventeen_l10n['icon'] = twentyseventeen_get_svg(array('icon' => 'angle-down', 'fallback' => true));
    }

    wp_enqueue_script('twentyseventeen-global', get_theme_file_uri('/assets/js/global.js'), array('jquery'), '1.0', true);

    wp_enqueue_script('jquery-scrollto', get_theme_file_uri('/assets/js/jquery.scrollTo.js'), array('jquery'), '2.1.2', true);

    wp_localize_script('twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'twentyseventeen_scripts');

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array $size Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr($sizes, $size)
{
    $width = $size[0];

    if (740 <= $width) {
        $sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
    }

    if (is_active_sidebar('sidebar-1') || is_archive() || is_search() || is_home() || is_page()) {
        if (!(is_page() && 'one-column' === get_theme_mod('page_options')) && 767 <= $width) {
            $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
        }
    }

    return $sizes;
}

add_filter('wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2);

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array $attr Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag($html, $header, $attr)
{
    if (isset($attr['sizes'])) {
        $html = str_replace($attr['sizes'], '100vw', $html);
    }
    return $html;
}

add_filter('get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function twentyseventeen_post_thumbnail_sizes_attr($attr, $attachment, $size)
{
    if (is_archive() || is_search() || is_home()) {
        $attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
    } else {
        $attr['sizes'] = '100vw';
    }

    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3);

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template($template)
{
    return is_home() ? '' : $template;
}

add_filter('frontpage_template', 'twentyseventeen_front_page_template');

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Seventeen 1.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function twentyseventeen_widget_tag_cloud_args($args)
{
    $args['largest'] = 1;
    $args['smallest'] = 1;
    $args['unit'] = 'em';
    $args['format'] = 'list';

    return $args;
}

add_filter('widget_tag_cloud_args', 'twentyseventeen_widget_tag_cloud_args');

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path('/inc/custom-header.php');


/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path('/inc/template-tags.php');

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path('/inc/template-functions.php');

/**
 * Customizer additions.
 */
require get_parent_theme_file_path('/inc/customizer.php');

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path('/inc/icon-functions.php');

require get_parent_theme_file_path('/kinex/classes/kmsp-class.php');

require get_parent_theme_file_path('/kinex/classes/kmsp-advertisement-widget.php');

require get_parent_theme_file_path('/kinex/classes/kmsp-menu-walker.php');

require get_parent_theme_file_path('/kinex/inc/functions.php');

require get_parent_theme_file_path('/kinex/admin/km-review-class.php');

require get_parent_theme_file_path('/kinex/admin/km-locations-class.php');

require get_parent_theme_file_path('/kinex/admin/km-member-class.php');


add_action('widgets_init', 'footer_sidebar');
function footer_sidebar()
{
    register_sidebar(array(
        'name' => __('Footer Site Info', 'theme-slug'),
        'id' => 'footer-copyright-sidebar',
        'description' => __('Widgets in this area will be shown on all posts and pages.', 'theme-slug'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => __('Header Right', 'theme-slug'),
        'id' => 'header-right-sidebar',
        'description' => __('Widgets in this area will be shown on all posts and pages.', 'theme-slug'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => __('Instagram Home page', 'theme-slug'),
        'id' => 'instagram-home-page',
        'description' => __('Widgets in this area will be shown on all posts and pages.', 'theme-slug'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => __('Become A Member Sidebar', 'theme-slug'),
        'id' => 'become-a-member',
        'description' => __('Widgets in this area will be shown on all posts and pages.', 'theme-slug'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => __('Become A Tasker Sidebar', 'theme-slug'),
        'id' => 'become-a-tasker',
        'description' => __('Widgets in this area will be shown on all posts and pages.', 'theme-slug'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));

}

add_filter('use_block_editor_for_post', '__return_false', 10);


/*function instagramresults(){
    $json_link="https://api.instagram.com/v1/users/4003666719/media/recent/?";
    $json_link .="access_token=4003666719.3d53a8d.3c544e2df76a494e999ee88daad0fdf4&count=6";
 // $json_link="https://api.instagram.com/v1/users/7156108469/media/recent/?";
 // $json_link .="access_token=7156108469.1677ed0.3f62c3d731804f57873a291c6ff1bd04&count=20";
 $json = file_get_contents($json_link);
 $expire_time= 5*60;
 $cache_file = 'api-instagram.json';
 $api_cache= json_decode(file_get_contents($cache_file), false);
 if (filesize( $cache_file ) == 0 ){
  file_put_contents($cache_file, $json);
  return ($api_cache);
 }else {
  if (time() - filemtime($cache_file) > $expire_time) {
   file_put_contents($cache_file, $json);
   return ($api_cache);
  }else{
   return ($api_cache);
  }
 }
}*/


// add_action( 'template_redirect', 'skip_cart_redirect' );
function skip_cart_redirect()
{
    // Redirect to checkout (when cart is not empty)
    if (!WC()->cart->is_empty() && is_cart()) {
        wp_safe_redirect(wc_get_checkout_url());
        exit();
    } // Redirect to shop if cart is empty
    elseif (WC()->cart->is_empty() && is_cart()) {
        wp_safe_redirect(wc_get_page_permalink('shop'));
        exit();
    }
}


/*start code form login lost passwordword etc */


add_action('init', 'km_login_member');
add_action('init', 'km_reset_password');
add_action('init', 'km_set_password');
add_action('lostpassword_url', 'km_lost_password_url');
add_action('init', 'km_signup_member');

/*     * *
     *
     * @param $url
     * @return string
     *  Describe lost passoword url
     */

function km_lost_password_url($url)
{
    return site_url() . "/lost-password";
}

/**
 *  Login On Site
 */


function km_login_member()
{
    // echo "<pre>";print_r($_POST);
    // if(isset($_POST['km-login-submit'])){
    //  echo "isset";
    // }else{
    //  echo "not isset";
    // }

    // if( wp_verify_nonce($_POST['km_login_nonce'], 'km-login-nonce')){
    //  echo "verified";
    // } die;
    // echo "=";
    if (isset($_POST['km-login-submit']) && wp_verify_nonce($_POST['km_login_nonce'], 'km-login-nonce')) {
        // echo "submitted";
        $user = '';
        // this returns the user ID and other info from the user name
        $user = get_user_by('login', $_POST['log']);
        if (!$user) {
            $user = get_user_by('email', $_POST['log']);

        }
        // echo "<pre>"; print_r($user); die;
        if (!$user) {

            km_errors()->add('empty_username', __('Invalid username or email address'));

        } else if (!isset($_POST['pwd']) || $_POST['pwd'] == '') {
            // if no password was entered
            km_errors()->add('empty_password', __('Please enter a password'));
        } else if (!wp_check_password($_POST['pwd'], $user->data->user_pass, $user->data->ID)) {
            // if the password is incorrect for the specified user
            km_errors()->add('empty_password', __('Incorrect password'));
        } else if (is_a($user, 'WP_User') && 2 == $user->data->user_status) {
            $signup = BP_Signup::get(array('user_login' => sanitize_user($user->data->user_login)));

            // No signup or more than one, something is wrong. Let's bail.
            if (!empty($signup['signups'][0]) || $signup['total'] <= 1) {


                $signup_id = $signup['signups'][0]->signup_id;

                $resend_url_params = array(
                    'action' => 'bp-resend-activation',
                    'id' => $signup_id,
                );

                $resend_url = wp_nonce_url(
                    add_query_arg($resend_url_params, wp_login_url()), 'bp-resend-activation'
                );
            }

            $resend_string = '<br /><br />' . sprintf(__('If you have not received an email yet, <a href="%s">click here to resend it</a>.', 'buddypress'), esc_url($resend_url));

            km_errors()->add('bp_account_not_activated', __('Your account has not been activated. Check your email for the activation link.', 'buddypress') . $resend_string);
        }


        // retrieve all error messages
        $errors = km_errors()->get_error_messages();


        // only log the user in if there are no errors
        if (empty($errors)) {

            wp_set_auth_cookie($user->ID, true);
            wp_set_current_user($user->ID, $_POST['log']);

            update_user_meta($user->ID, 'km_is_login', true);
            do_action('wp_login', $_POST['log'], $user);

            if (isset($_REQUEST['redirect_to']) && !empty($_REQUEST['redirect_to'])) {

                wp_redirect($_POST['redirect_to']);
                die();
            } else {

                wp_safe_redirect(site_url('/'));
                die();
            }
        }
    }
    // else{
    //     echo "not in";
    // }
}


function km_delete_login_meta()
{
    delete_user_meta(bp_loggedin_user_id(), 'km_is_login');
}

/*     * *
 *  Forget Password
 *
 */

function km_set_password()
{
    if (isset($_POST['km-set-password']) && wp_verify_nonce($_POST['km_set_password'], 'km-set-password')) {
        $userkey = check_password_reset_key($_POST['key'], $_POST['log']);
        if (!is_wp_error($userkey)) {

            // this returns the user ID and other info from the user name
            $user = get_user_by('login', $_POST['log']);

            if (!$user) {
                // if the user name doesn't exist
                km_errors()->add('empty_username', __('Invalid user for reset password'));
            } else if (!isset($_POST['user_password']) || $_POST['user_password'] == '') {
                // if no password was entered
                km_errors()->add('user_password', __('Please enter a password'));
            } else if (!isset($_POST['user_password']) || $_POST['user_password'] == '') {
                // if no password was entered
                km_errors()->add('confirm_password', __('Please enter a confirm password'));
            } else if ($_POST['user_password'] != $_POST['confirm_password']) {
                // if no password was entered
                km_errors()->add('confirm_password', __('Both password must be same'));
            }


            // retrieve all error messages
            $errors = km_errors()->get_error_messages();


            // only log the user in if there are no errors
            if (empty($errors)) {
                session_start();
                $_SESSION['reset'] = 'success';
                wp_set_password($_POST['user_password'], $user->ID);

                wp_safe_redirect(site_url('login/?reset=success'));
                die;
            }
        } else {
            km_errors()->add('confirm_password', __('Your link has been expired, Please <a href="' . wp_lostpassword_url() . '">Click here</a> to get a new rest password link.'));
        }
    }
}


function km_reset_password()
{
    $user_data = '';
    $login = '';
    if ('POST' !== strtoupper($_SERVER['REQUEST_METHOD'])) {
        return;
    }
    $error = false;
    $ermessage = array();
    if (check_ajax_referer('km-reset-password', false, false)) {
        add_filter('wp_mail_content_type', 'km_content_html');

        if (empty($_POST['email'])) {
            km_errors()->add('invalid_email', __('Please enter a email address.'));
            $error = true;
        } elseif (strpos($_POST['email'], '@')) {
            $user_data = get_user_by('email', trim(wp_unslash($_POST['email'])));
            if (empty($user_data)) {
                $error = true;
                km_errors()->add('invalid_user', __('There is no user registered with that email address.'));
            }
           /* else {
                $login = trim($_POST['email']);
                $user_data = get_user_by('login', $login);
            }*/

        }else{
            $login = trim($_POST['email']);
            $user_data = get_user_by('login', $login);
        }

        if ($error) {
            return;
        }
        if (!$user_data) {
            km_errors()->add('invalid_email', __('invalid user email address.'));
            return;
        } else {
            // echo "into else cond".$_POST['email']; die;
            $user_login = $user_data->user_login;
            $user_email = $user_data->user_email;
            $key = get_password_reset_key($user_data);
            if (is_wp_error($key)) {
                km_errors()->add('invalid_email', __(' Something Went Wrong.'));
                return;
            }

            ob_start();

            set_query_var('user_login', $user_login);
            set_query_var('key', $key);
            get_template_part('template-parts/emails/reset-password');
            $message = ob_get_contents();


            ob_end_clean();


            if (is_multisite()) {
                $blogname = get_network()->site_name;
            } else {
                $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
            }

            /* translators: Password reset email subject. 1: Site name */
            $title = sprintf(__('[%s] Password Reset'), $blogname);


            $title = apply_filters('retrieve_password_title', $title, $user_login, $user_data);


            $message = apply_filters('retrieve_password_message', $message, $key, $user_login, $user_data);



            if ($message && !wp_mail($user_email, wp_specialchars_decode($title), $message)) {
                km_errors()->add('not_sent', __('The email could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.'));
            } else {
                km_errors()->add('success', __('Check your email for the confirmation link'));
            }
            remove_filter('wp_mail_content_type', 'km_content_html');
        }

        // Redefining user_login ensures we return the right case in the email.


    }

}

/* end code for login lost password etc */

/* start show error messages */

function km_show_error_messages()
{
    // echo "here in show error messages";
    if ($codes = km_errors()->get_error_codes()) {
        // echo "in if";
        // echo "<pre>";print_r($codes);
        echo '<div class="pippin_errors">';
        // Loop error codes and display errors
        foreach ($codes as $code) {
            $message = km_errors()->get_error_message($code);
            echo '<span class="' . ($code == 'success' ? 'success' : 'error') . '">' . (($code == 'bp_account_not_activated')
                ? '' : '') .
            $message . '</span><br/>';
        }
        echo '</div>';
    }
    // else{
    //     echo "in else";
    // }
}

function km_show_error_messages_by_code($codex)
{
    $message = km_errors()->get_error_message($codex);

    if (!empty($message)) {

        echo '<div class="pippin_errors custom_error">';
        echo '<span class="' . ($codex == 'success' ? 'success' : 'error') . '">' . $message . '</span>';
        echo '</div>';
    }
}


function km_errors()
{
    //echo "in errors";
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}


function km_random_password($length = 8)
{
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}


add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
function logout_without_confirm($action, $result)
{
    /**
     * Allow logout without confirmation
     */
    if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : 'login';
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
        header("Location: $location");
        die;
    }
}

function km_signup_member()
{
    $errors = array();
    if (isset($_POST['km-signup-submit']) && wp_verify_nonce($_POST['km_signup_nonce'], 'km-signup-nonce')) {
        if (is_user_logged_in()) {
            $userId = $_POST['login_user_id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $user_phone = $_POST['user_phone'];
            // $user_mobile = $_POST['user_mobile'];
            $zip_postal = $_POST['zip_postal'];
            $hear_about = $_POST['hear_about'];
            $other_hear_about = @$_POST['other_hear_about'] ? $_POST['other_hear_about'] : "";

            update_user_meta($userId, 'first_name', $first_name);
            update_user_meta($userId, 'last_name', $last_name);
            update_user_meta($userId, 'user_phone', $user_phone);
            // update_user_meta($userId, 'user_mobile', $user_mobile);
            update_user_meta($userId, 'zip_postal', $zip_postal);
            update_user_meta($userId, 'hear_about', $hear_about);
            update_user_meta($userId, 'other_hear_about', $other_hear_about);
            wp_redirect(home_url('/become-a-member/?status="update"'));
            exit;

        } else {
            $email = $_POST['email'];
            if (email_exists($email)) {
                km_errors()->add('email_exists', __('This email already exists.'));
            }
            $errors = km_errors()->get_error_messages();
            if (empty($errors)) {
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $user_phone = $_POST['user_phone'];
                $user_mobile = $_POST['user_mobile'];
                $zip_postal = $_POST['zip_postal'];
                $hear_about = $_POST['hear_about'];
                $other_hear_about = $_POST['other_hear_about'];
                $password = $_POST['password'];
                // create the user generated default password
                $user_id = wp_create_user($email, $password, $email);
                // Set the nickname
                // update_user_meta($user_id, 'nickname', $email);
                update_user_meta($user_id, 'first_name', $first_name);
                update_user_meta($user_id, 'last_name', $last_name);
                update_user_meta($user_id, 'user_phone', $user_phone);
                // update_user_meta($user_id, 'user_mobile', $user_mobile);
                update_user_meta($user_id, 'hear_about', $hear_about);
                update_user_meta($user_id, 'zip_postal', $zip_postal);
                update_user_meta($user_id, 'other_hear_about', $other_hear_about);

                // wp_update_user(
                //     array(
                //       'ID'          =>    $user_id,
                //       'nickname'    =>    $email,
                //       'first_name'  => $first_name,
                //       'last_name'   => $last_name,
                //       'user_phone' => $user_phone,
                //       'user_mobile' => $user_mobile,
                //       'hear_about' => $hear_about,
                //       'billing_postcode' => $zip_postal
                //   )
                // );
                // Set the role
                $user = new WP_User($user_id);
                $user->set_role('subscriber');
                // Email the user
                wp_mail($email, 'Welcome! ' . $first_name . " " . $last_name, 'Your account has been created successfully.');
                // echo "<p>You have succesfully registered with woofy. Please check your email.</p>";
                wp_redirect(home_url('/create-an-account/?status="success"'));
                exit;
            }
            // else{
            //     foreach($errors as $error){
            //         echo '<p>';
            //         echo "<strong>$error</strong>";
            //         echo '</p>';
            //     }
            // }
                } // end if

            }
        }


        function add_roles_on_plugin_activation()
        {
            add_role('tasker', 'Tasker', array('read' => true, 'level_0' => true));
        }

// add_action('init', 'add_roles_on_plugin_activation');


        /* start add custom field into user meta*/
        /**
 * Add new fields above 'Update' button.
 *
 * @param WP_User $user User object.
 */
        /* function tm_additional_profile_fields( $user ) {

    // $months     = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
    // $default    = array( 'day' => 1, 'month' => 'Jnuary', 'year' => 1950, );
            $hear_about = wp_parse_args( get_the_author_meta('hear_about', $user->ID));
    // get_the_author_meta

            ?>
            <h3>Extra profile information</h3>

            <table class="form-table">
            <tr>
            <th><label for="hear_about">How did you hear about us? </label></th>
            <td>
            <input type="text" name="hear_about" value="">
            </td>
            </tr>
            </table>
            <?php
        }

        add_action( 'show_user_profile', 'tm_additional_profile_fields' ); */

        /* end add custom field into user meta*/


        add_action('show_user_profile', 'oneTarek_extra_user_profile_fields');
        add_action('edit_user_profile', 'oneTarek_extra_user_profile_fields');
        add_action('personal_options_update', 'oneTarek_save_extra_user_profile_fields');
        add_action('edit_user_profile_update', 'oneTarek_save_extra_user_profile_fields');

        function oneTarek_save_extra_user_profile_fields($user_id)
        {
            if (!current_user_can('edit_user', $user_id)) {
                return false;
            }
            update_user_meta($user_id, 'hear_about', $_POST['hear_about']);
            update_user_meta($user_id, 'user_mobile', $_POST['user_mobile']);
            update_user_meta($user_id, 'user_phone', $_POST['user_phone']);
            update_user_meta($user_id, 'about_services', $_POST['about_services']);
        }

#Developed By oneTarek , http://oneTarek.com
        function oneTarek_extra_user_profile_fields($user)
        { ?>
            <h3>Extra Customer Field</h3>

            <table class="form-table">
                <tr>
                    <th><label for="hear_about">How did you hear about us?</label></th>
                    <td>
                        <input type="text" id="hear_about" name="hear_about" size="20"
                        value="<?php echo esc_attr(get_the_author_meta('hear_about', $user->ID)); ?>">
                        <!-- <span class="description">Please enter your Twitter Account User name, eg: oneTarek</span> -->
                    </td>
                </tr>
            </table>
            <h3>Extra Contact Fields </h3>

            <table class="form-table">
                <tr>
                    <th><label for="user_mobile">Mobile Number</label></th>
                    <td>
                        <input type="text" id="user_mobile" name="user_mobile" size="20"
                        value="<?php echo esc_attr(get_the_author_meta('user_mobile', $user->ID)); ?>">
                        <!-- <span class="description">Please enter your Twitter Account User name, eg: oneTarek</span> -->
                    </td>
                </tr>
                <tr>
                    <th><label for="user_phone">Phone Number</label></th>
                    <td>
                        <input type="text" id="user_phone" name="user_phone" size="20"
                        value="<?php echo esc_attr(get_the_author_meta('user_phone', $user->ID)); ?>">
                        <!-- <span class="description">Please enter your Twitter Account User name, eg: oneTarek</span> -->
                    </td>
                </tr>
            </table>

            <h3>Extra Tasker Fields </h3>

            <table>
                <tr>
                    <th><label for="about_services">About My Services</label></th>
                    <td>
                        <textarea id="about_services" name="about_services"
                        size="20"><?php echo esc_attr(get_the_author_meta('about_services', $user->ID)); ?></textarea>
                        <!-- <span class="description">Please enter your Twitter Account User name, eg: oneTarek</span> -->
                    </td>
                </tr>
                <tr>
                    <th><label>Type Of Dog</label></th>
                    <td>
                        <select name="type_of_dog">
                            <option <?php echo esc_attr(get_the_author_meta('type_of_dog', $user->ID)) == 'pit_bull' ? 'selected' : ''; ?>
                            value="pit_bull">Pit Bull
                        </option>
                        <option <?php echo esc_attr(get_the_author_meta('type_of_dog', $user->ID)) == 'american_staffordshire_terrier' ? 'selected' : ''; ?>
                        value="american_staffordshire_terrier">American Staffordshire Terrier
                    </option>
                    <option <?php echo esc_attr(get_the_author_meta('type_of_dog', $user->ID)) == 'german_spaniel' ? 'selected' : ''; ?>
                    value="german_spaniel">German Spaniel
                </option>
                <option <?php echo esc_attr(get_the_author_meta('type_of_dog', $user->ID)) == 'pug' ? 'selected' : ''; ?>
                value="pug">Pug
            </option>
        </select>

    </td>
</tr>
<tr>
    <th><label>Weight Of Dog</label></th>
    <td>
        <input type="text" id="weight_of_dog" name="weight_of_dog" size="25"
        value="<?php echo esc_attr(get_the_author_meta('weight_of_dog', $user->ID)); ?>">
        <select name="weight_into">
            <option <?php echo esc_attr(get_the_author_meta('weight_into', $user->ID)) == 'kg' ? 'selected' : ''; ?>
            value="kg">KG
        </option>
        <option <?php echo esc_attr(get_the_author_meta('weight_into', $user->ID)) == 'lbs' ? 'selected' : ''; ?>
        value="lbs">LBS
    </option>
</select>
</td>
</tr>
<tr>
    <th>Additional Information For Tasker</th>
    <td><textarea
        name="additional_information_for_tasker"><?php echo esc_attr(get_the_author_meta('additional_information_for_tasker', $user->ID)); ?></textarea>
    </td>
</tr>
</table>


<?php }

/* add meta box for feature description  to post and pages  */
add_action('add_meta_boxes', 'meta_box_featured_description');
function meta_box_featured_description()
{
    add_meta_box('featured-description-box-id', 'Featured Image Description', 'meta_box_callback', array('post', 'page'), 'side', 'high');
}

function meta_box_callback($post)
{
    $values = get_post_custom($post->ID);
    $selected = isset($values['meta_box_featured_description']) ? $values['meta_box_featured_description'][0] : '';

    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <label for="meta_box_featured_description"><p>Featured Description</p></label>
        <?php $text = get_post_meta($post->ID, 'meta_box_featured_description', true);
        wp_editor($text, 'meta_box_featured_description'); ?>


    </p>
    <p>Please enter content upto 200 characters .</p>
    <?php
}

add_action('save_post', 'meta_box_featured_description_save');
function meta_box_featured_description_save($post_id)
{
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'my_meta_box_nonce')) return;

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_post')) return;

    // now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchords can only have href attribute
        )
    );

    // Probably a good idea to make sure your data is set

    if (isset($_POST['meta_box_featured_description']))
        update_post_meta($post_id, 'meta_box_featured_description', $_POST['meta_box_featured_description']);

}

function uniqueAssocArray($array, $uniqueKey)
{
    $unique = array();

    foreach ($array as $value) {
        $unique[$value->$uniqueKey] = $value;

    }

    $data = array_values($unique);

    return $data;
}

add_action('wp_footer', 'custom_jquery', 99);
function custom_jquery()
{ ?>
    <script>
        jQuery(document).ready(function () {
            jQuery("#pmpro_level-1").children('div').addClass("pricing-wrap-col one");
            jQuery("#pmpro_level-2").children('div').addClass("pricing-wrap-col two");
            jQuery("#pmpro_level-3").children('div').addClass("pricing-wrap-col three");
        });
    </script>
    <?php
}

/*
    Shortcode to show membership account information
*/
    add_action('init', 'remove_my_shortcodes', 20);
    function remove_my_shortcodes()
    {
        remove_shortcode('pmpro_account');
    }

    add_shortcode('pmpro_advanced_account', 'pmpro_advanced_shortcode_account');
    function pmpro_advanced_shortcode_account($atts, $content = null, $code = "")
    {

        global $wpdb, $pmpro_msg, $pmpro_msgt, $pmpro_levels, $current_user, $levels;

    // $atts    ::= array of attributes
    // $content ::= text within enclosing form of shortcode element
    // $code    ::= the shortcode found, when == callback name
    // examples: [pmpro_account] [pmpro_account sections="membership,profile"/]

        extract(shortcode_atts(array(
            'section' => '',
            'sections' => 'membership,profile,invoices,links'
        ), $atts));

    //did they use 'section' instead of 'sections'?
        if (!empty($section))
            $sections = $section;

    //Extract the user-defined sections for the shortcode
        $sections = array_map('trim', explode(",", $sections));
        ob_start();

    //if a member is logged in, show them some info here (1. past invoices. 2. billing information with button to update.)
        if (pmpro_hasMembershipLevel()) {
            $ssorder = new MemberOrder();
            $ssorder->getLastMemberOrder();
            $mylevels = pmpro_getMembershipLevelsForUser();
        $pmpro_levels = pmpro_getAllLevels(false, true); // just to be sure - include only the ones that allow signups
        $invoices = $wpdb->get_results("SELECT *, UNIX_TIMESTAMP(timestamp) as timestamp FROM $wpdb->pmpro_membership_orders WHERE user_id = '$current_user->ID' AND status NOT IN('review', 'token', 'error') ORDER BY timestamp DESC LIMIT 6");
        ?>
        <div id="pmpro_account">
            <?php if (in_array('membership', $sections) || in_array('memberships', $sections)) { ?>
                <div id="pmpro_account-membership" class="pmpro_box">


                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <thead>
                            <tr>
                                <th><?php _e("Plan name", 'paid-memberships-pro'); ?></th>
                                <th><?php _e("Activate Plan Date", 'paid-memberships-pro'); ?></th>
                                <th><?php _e("Expiry Plan Date", 'paid-memberships-pro'); ?></th>
                                <!-- <th><?php _e("Price", 'paid-memberships-pro'); ?></th> -->
                                <th><?php _e("Price", 'paid-memberships-pro'); ?></th>
                                <th><?php _e("Status", 'paid-memberships-pro'); ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($mylevels as $level) {
                            /*  echo "<pre>";print_r($level);
                            echo date(get_option('date_format'), $level->startdate);*/
                            ?>
                            <tr>
                                <td class="pmpro_account-membership-levelname">
                                    <?php echo $level->name ?>

                                </td>
                                <td>
                                    <?php if ($level->startdate)
                                    $activation_text = date(get_option('date_format'), $level->startdate);
                                    else
                                        $activation_text = "---";


                                    echo $activation_text;

                                    ?>
                                </td>
                                <td class="pmpro_account-membership-expiration">
                                    <?php
                                    if ($level->enddate)
                                        $expiration_text = date(get_option('date_format'), $level->enddate);
                                    else
                                        $expiration_text = "---";

                                    echo apply_filters('pmpro_account_membership_expiration_text', $expiration_text, $level);
                                    ?>
                                </td>

                                <td class="pmpro_account-membership-levelfee">
                                    <p><?php echo pmpro_getLevelCost($level, true, true); ?></p>
                                </td>
                                <td>
                                    <?php
                                    if (($ssorder->status == "success")) {
                                        echo "Active";
                                    } else {
                                        echo "Inactive";
                                    }
                                    ?>

                                </td>
                                <td>
                                    <div class="pmpro_actionlinks">
                                        <?php do_action("pmpro_member_action_links_before"); ?>

                                        <?php if (array_key_exists($level->id, $pmpro_levels) && pmpro_isLevelExpiringSoon($level)) { ?>
                                            <a id="pmpro_actionlink-renew"
                                            href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https") ?>"><?php _e("Renew", 'paid-memberships-pro'); ?></a>
                                        <?php } ?>


                                        <?php if ((isset($ssorder->status) && $ssorder->status == "success") && (isset($ssorder->gateway) && in_array($ssorder->gateway, array("authorizenet", "paypal", "stripe", "braintree", "payflow", "cybersource"))) && pmpro_isLevelRecurring($level)) { ?>
                                            <a id="pmpro_actionlink-update-billing"
                                            href="<?php echo pmpro_url("billing", "", "https") ?>"><?php _e("Update Billing Info", 'paid-memberships-pro'); ?></a>
                                        <?php } ?>

                                        <?php
                                        //To do: Only show CHANGE link if this level is in a group that has upgrade/downgrade rules
                                        if (count($pmpro_levels) > 1 && !defined("PMPRO_DEFAULT_LEVEL")) { ?>
                                            <a id="pmpro_actionlink-change" href="<?php echo site_url('/pricing'); ?>"
                                                id="pmpro_account-change"><?php _e("Change", 'paid-memberships-pro'); ?></a>
                                            <?php } ?>
                                            <a id="pmpro_actionlink-cancel"
                                            href="<?php echo pmpro_url("cancel", "?levelstocancel=" . $level->id) ?>"><?php _e("Cancel", 'paid-memberships-pro'); ?></a>
                                            <?php do_action("pmpro_member_action_links_after"); ?>
                                        </div> <!-- end pmpro_actionlinks -->
                                    </td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php //Todo: If there are multiple levels defined that aren't all in the same group defined as upgrades/downgrades ?>
                        <!--  <div class="pmpro_actionlinks">
                        <a id="pmpro_actionlink-levels" href="<?php echo pmpro_url("levels") ?>"><?php _e("View all Membership Options", 'paid-memberships-pro'); ?></a>
                    </div> -->

                </div> <!-- end pmpro_account-membership -->
            <?php } ?>
        </div> <!-- end pmpro_account -->
        <?php
    }

    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}


function change_password_form()
{ ?>
    <?php echo km_show_error_messages_by_code('success'); ?>
    <form action="" method="post" class="scrooltoForm">
        <div class="form-row">
            <label for="current_password">Old Password <span class="asterisk">*</span></label>
            <input id="current_password" type="password" name="current_password" title="current_password" placeholder=""
            required>
            <?php echo km_show_error_messages_by_code('old_password'); ?>
        </div>
        <div class="form-row">
            <label for="new_password">New password <span class="asterisk">*</span></label>
            <input id="new_password" type="password" name="new_password" title="new_password" placeholder="" required>
            <?php echo km_show_error_messages_by_code('password'); ?>
        </div>
        <div class="form-row">
            <label for="confirm_new_password">Retype password <span class="asterisk">*</span></label>
            <input id="confirm_new_password" type="password" name="confirm_new_password" title="confirm_new_password"
            placeholder="" required>
            <?php echo km_show_error_messages_by_code('confirm_password'); ?>
        </div>
        <div class="form-row">
            <input type="submit" value="submit">
        </div>
    </form>
    <?php $customerrors = km_errors()->get_error_messages(); ?>
    <?php if ($customerrors) : ?>
        <script>
            jQuery(document).ready(function ($) {
                $('html, body').animate({
                    'scrollTop': $(".pippin_errors").position().top - 100
                }, 1000);
            })

        </script>
    <?php endif; ?>
    <?php

}

function change_password()
{
    if (isset($_POST['current_password'])) {
        $_POST = array_map('stripslashes_deep', $_POST);
        $current_password = sanitize_text_field($_POST['current_password']);
        $new_password = sanitize_text_field($_POST['new_password']);
        $confirm_new_password = sanitize_text_field($_POST['confirm_new_password']);
        $user_id = get_current_user_id();
        $errors = array();
        $current_user = get_user_by('id', $user_id);


// Check for errors
        if (empty($current_password) && empty($new_password) && empty($confirm_new_password)) {
            $errors[] = 'All fields are required';
        }
        if ($current_user && wp_check_password($current_password, $current_user->data->user_pass, $current_user->ID)) {
//match
        } else {
            km_errors()->add('old_password', __('Old Password is incorrect.'));
        }
        if (strlen($new_password) < 6) {
            km_errors()->add('password', __('Password is too short, minimum of 6 characters.'));

        }


        if ($new_password != $confirm_new_password) {
            km_errors()->add('confirm_password', __('Password does not match with new password.'));
        }
        $errors = km_errors()->get_error_messages();
        if (empty($errors)) {
            wp_set_password($new_password, $current_user->ID);
            km_errors()->add('success', __('Password successfully changed!'));

        }
    }
}

function cp_form_shortcode()
{
    change_password();
    change_password_form();
}

add_shortcode('changepassword_form', 'cp_form_shortcode');


/* start add profile pic */

function km_get_show_user_avatar($args = '')
{

    $r = wp_parse_args($args, array(
        'item_id' => get_current_user_id(),
        'type' => 'full',
        'is_profile' => false,
        'width' => 300,
        'height' => 'auto',
        'html' => true,
        'class' => 'profile_avatar',
// 'alt' => __('Profile picture', 'buddypress')

    ));
    return apply_filters('km_get_show_user_avatar', km_core_fetch_avatar($r), $r, $args);

}


function km_core_fetch_avatar($args = '')
{

// Set the default variables array and parse it against incoming $args array.
    $params = wp_parse_args($args, array(
        'item_id' => false,
        'object' => 'user',
        'type' => 'full',
        'avatar_dir' => 'profilepics',
        'is_profile' => false,
        'width' => false,
        'height' => false,
        'class' => 'avatar',
        'css_id' => false,
        'alt' => '',
        'email' => false,
        'no_grav' => null,
        'html' => true,
        'title' => '',
        'extra_attr' => '',
        'wrap_type' => 'default',
        'scheme' => null,
// 'rating' => get_option('avatar_rating'),
        'force_default' => false,
    ));

    /* Set item_id **********************************************************/

    if (empty($params['item_id'])) {
        return false;
    }

    /* Set avatar_dir *******************************************************/

    if (empty($params['avatar_dir'])) {
        return false;
    }

// Get a fallback for the 'alt' parameter, create html output.

    $html_alt = ' alt="' . esc_attr($params['alt']) . '"';

// Filter image title and create html string.
    $html_title = '';


// Extra attributes.
    $extra_attr = !empty($args['extra_attr']) ? ' ' . $args['extra_attr'] : '';

// Set CSS ID and create html string.
    $html_css_id = '';


    if (!empty($params['css_id'])) {
        $html_css_id = ' id="' . esc_attr($params['css_id']) . '"';
    }


    $html_width = ' width="' . $params['width'] . '"';


    if ($params['height'] != 'auto') {
        $html_height = ' height="' . $params['height'] . '"';
    }


// Use an alias to leave the param unchanged.
    $avatar_classes = $params['class'];
    if (!is_array($avatar_classes)) {
        $avatar_classes = explode(' ', $avatar_classes);
    }

// Merge classes.
    $avatar_classes = array_merge($avatar_classes, array(
        $params['object'] . '-' . $params['item_id'] . '-avatar',
        'avatar-' . $params['width'],
    ));

// Sanitize each class.
    $avatar_classes = array_map('sanitize_html_class', $avatar_classes);

// Populate the class attribute.
    $html_class = ' class="' . join(' ', $avatar_classes) . ' photo"';

// Set img URL and DIR based on prepopulated constants.
// $base_dir = wp
    $uploaddir = wp_upload_dir();
// echo $base_url; die;

    $avatar_loc = new stdClass();
    $avatar_loc->path = $uploaddir['basedir'];
    $avatar_loc->url = trailingslashit($uploaddir['baseurl']);

    $avatar_loc->dir = trailingslashit($params['avatar_dir']);

    /**
     * Filters the avatar folder directory URL.
     *
     * @since 1.1.0
     *
     * @param string $value Path to the avatar folder URL.
     * @param int $value ID of the avatar item being requested.
     * @param string $value Avatar type being requested.
     * @param string $value Subdirectory where the requested avatar should be found.
     */
    $avatar_folder_url = apply_filters('km_core_avatar_folder_url', ($avatar_loc->url . $avatar_loc->dir . $params['item_id']), $params['item_id'], $params['object'], $params['avatar_dir']);

    /**
     * Filters the avatar folder directory path.
     *
     * @since 1.1.0
     *
     * @param string $value Path to the avatar folder directory.
     * @param int $value ID of the avatar item being requested.
     * @param string $value Avatar type being requested.
     * @param string $value Subdirectory where the requested avatar should be found.
     */
    $avatar_folder_dir = apply_filters('km_core_avatar_folder_dir', ($avatar_loc->path . "/" . $avatar_loc->dir . $params['item_id']), $params['item_id'], $params['object'], $params['avatar_dir']);

    /**
     * Look for uploaded avatar first. Use it if it exists.
     * Set the file names to search for, to select the full size
     * or thumbnail image.
     */
    $avatar_size = '';
    if ($params['type'] == 'small') {
        $avatar_size = '/small/';
    } else if ($params['type'] == 'medium') {
        $avatar_size = '/medium/';
    } else if ($params['type'] == 'large') {
        $avatar_size = '/profile/';
    } else if ($params['type'] == 'thumb') {
        $avatar_size = '/thumbnail/';

    } else {
        $avatar_size = '/';
    }

// Check for directory.
    if (file_exists($avatar_folder_dir)) {
        $main_dir = $avatar_folder_dir . $avatar_size;
        $main_url = $avatar_folder_url . $avatar_size;

// Open directory.
        if (@$av_dir = opendir($main_dir)) {

// Stash files in an array once to check for one that matches.
            $avatar_files = array();
            while (false !== ($avatar_file = readdir($av_dir))) {


                if (is_file($main_dir . $avatar_file)) {
                    $avatar_files[] = $avatar_file;
                }
            }

            if (0 < count($avatar_files)) {

                foreach ($avatar_files as $key => $value) {
                    $avatar_url = $main_url . $avatar_files[$key];
                }
            }

        }


// Close the avatar directory.
        @closedir($av_dir);


// debug($params);

// If we found a locally uploaded avatar.
        if (isset($avatar_url)) {

// Support custom scheme.
            $avatar_url = set_url_scheme($avatar_url, $params['scheme']);

// Return it wrapped in an <img> element.
            if (true === $params['html']) {


                return apply_filters('km_core_fetch_avatar',
                    '
                    <img src="' . $avatar_url . '"' . $html_class . $html_css_id . $html_width . $html_height . $html_alt . $html_title . $extra_attr . ' />',
                    $params,
                    $params['item_id'],
                    $params['avatar_dir'],
                    $html_css_id,
                    $html_width,
                    $html_height,
                    $avatar_folder_url,
                    $avatar_folder_dir
                );


// ...or only the URL
            } else {
                return apply_filters('km_core_fetch_avatar_url', $avatar_url, $params);
            }
        }
    }


    $uploaddir = wp_upload_dir();
// echo $base_url; die;

    $avatar_loc = new stdClass();
    $avatar_loc->path = $uploaddir['basedir'];
    $avatar_loc->url = trailingslashit($uploaddir['baseurl']);

    $avatar_loc->dir = trailingslashit($params['avatar_dir']);

    /**
     * Filters the avatar folder directory URL.
     *
     * @since 1.1.0
     *
     * @param string $value Path to the avatar folder URL.
     * @param int $value ID of the avatar item being requested.
     * @param string $value Avatar type being requested.
     * @param string $value Subdirectory where the requested avatar should be found.
     */
    $avatar_folder_url = apply_filters('km_core_avatar_folder_url', ($avatar_loc->url . $avatar_loc->dir . 'default'), $params['item_id'], $params['object'], $params['avatar_dir']);

    /**
     * Filters the avatar folder directory path.
     *
     * @since 1.1.0
     *
     * @param string $value Path to the avatar folder directory.
     * @param int $value ID of the avatar item being requested.
     * @param string $value Avatar type being requested.
     * @param string $value Subdirectory where the requested avatar should be found.
     */
    $avatar_folder_dir = apply_filters('km_core_avatar_folder_dir', ($avatar_loc->path . "/" . $avatar_loc->dir .
        'default'), $params['item_id'], $params['object'], $params['avatar_dir']);


    $main_dir = $avatar_folder_dir . $avatar_size;
    $main_url = $avatar_folder_url . $avatar_size;

// Open directory.
    if ($av_dir = opendir($main_dir)) {

// Stash files in an array once to check for one that matches.
        $avatar_files = array();
        while (false !== ($avatar_file = readdir($av_dir))) {

// Only add files to the array (skip directories).
            if (is_file($main_dir . $avatar_file)) {
                $avatar_files[] = $avatar_file;
            }
        }


// Check for array.
        if (0 < count($avatar_files)) {

// Check for current avatar.
            foreach ($avatar_files as $key => $value) {
                $avatar_url = $main_url . $avatar_files[$key];
            }
        }


    }

// Close the avatar directory.
    closedir($av_dir);


// debug($params);

// If we found a locally uploaded avatar.
    if (isset($avatar_url)) {
// Support custom scheme.
        $avatar_url = set_url_scheme($avatar_url, $params['scheme']);

// Return it wrapped in an <img> element.
        if (true === $params['html']) {


            return apply_filters('km_core_fetch_avatar',
                '
                <img src="' . $avatar_url . '"' . $html_class . $html_css_id . $html_width . $html_height . $html_alt . $html_title . $extra_attr . ' />',
                $params,
                $params['item_id'],
                $params['avatar_dir'],
                $html_css_id,
                $html_width,
                $html_height,
                $avatar_folder_url,
                $avatar_folder_dir
            );


// ...or only the URL
        } else {
            return apply_filters('km_core_fetch_avatar_url', $avatar_url, $params);
        }
    }


}


/* end add profile pic */
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

function wp_redirect_page()
{
// echo "here"; die;
    $user_id = get_current_user_id();
// echo $user_id;
    $user_meta = get_userdata($user_id);
// echo '<pre>'; print_r($user_meta); die;
    $user_roles = $user_meta->roles;
    echo $user_roles[0];
    die;
    if (is_page('pricing') && $user_roles[0] == 'tasker') {
        exit(wp_redirect(home_url('/')));
    }
    // if()
    //

}

// add_action( 'init', 'wp_redirect_page' );

function add_login_logout_register_menu($items, $args)
{

    if ($args->theme_location != 'top') {
        return $items;
    }
    if (!is_user_logged_in()) {
        $items .= '<li><a href="' . site_url('/become-a-tasker/') . '">' . __('Become a Tasker') . '</a></li>';
    }

    return $items;
}

add_filter('wp_nav_menu_items', 'add_login_logout_register_menu', 199, 2);


function wpb_sender_email($original_email_address)
{
    return 'info@kinexmedia.com';
}

// Function to change sender name
function wpb_sender_name($original_email_from)
{
    return get_bloginfo('name');
}

// Hooking up our functions to WordPress filters 
add_filter('wp_mail_from', 'wpb_sender_email');
add_filter('wp_mail_from_name', 'wpb_sender_name');


add_action('template_redirect', 'km_redirect');
function km_redirect()
{

    if (is_page(196) && !is_user_logged_in()) {
        wp_safe_redirect(site_url('/login'));
        die;
    }
}

/* Plugin Name: First name plus last name as default display name. */
add_action( 'user_register', 'set_display_username_on_register' );

function set_display_username_on_register( $user_id )
{
    $data = get_userdata( $user_id );
    // check if these data are available in your real code!
    wp_update_user( 
        array (
            'ID' => $user_id, 
            'display_name' => "$data->first_name $data->last_name"
        ) 
    );
}

/* First name as default display name. */
add_action( 'profile_update', 'set_display_username_on_update', 10 );

function set_display_username_on_update( $user_id ) {

    $data = get_userdata( $user_id );

    if($data->first_name) {

        remove_action( 'profile_update', 'set_display_name', 10 ); // profile_update is called by wp_update_user, so we need to remove it before call, to avoid infinite recursion
        wp_update_user( 
            array (
                'ID' => $user_id, 
                'display_name' => "$data->first_name $data->last_name"
            ) 
        );
        add_action( 'profile_update', 'set_display_name', 10 );
    }
}



add_filter( 'get_avatar', 'cyb_get_avatar', 10, 5 );
function cyb_get_avatar( $avatar = '', $id_or_email, $size = 96, $default = '', $alt = '' ) {  
  $imgName = km_get_show_user_avatar(array('item_id' => $id_or_email, 'html' => false, 'type' => 'profile'));
  $avatar = "<img alt='$alt' src='".$imgName."' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
  return $avatar;
}




/* start extra  */




add_filter('login_form_middle','my_added_login_field');
function my_added_login_field(){
    //Output your HTML
    $additional_field = '<div class="login-custom-field-wrapper"">
     
        <input type="hidden" tabindex="20" size="20" class="input" id="sanstha_id" name="sanstha_id" value="'.@$_GET['sanstha_id'].'"></label>
    </div>';

    return $additional_field;
}



add_filter('wp_authenticate_user','wp_verify_sanstha',10,2);
function wp_verify_sanstha(){
    // echo "<pre>";print_r($_POST);
    // echo "</pre>";die;
    $sanstha_id = get_user_meta( $user->ID, 'sanstha_id' );
    // echo "<pre>";print_r(get_userdata($user->ID)); echo "</pre>"; die;
    if(!is_admin()){

   
    if ( 1 == (int) $sanstha_id ) {
        wp_redirect(site_url().'/listing/?sansth_id=1');
   }else if(2 == (int) $sanstha_id){
        wp_redirect(site_url().'/listing/?sansth_id=2');
    }else{
            $message = esc_html__( 'User not verified.', 'text-domain');
            return new WP_Error( 'user_not_verified', $message );
    }
}
    return $user;
}

