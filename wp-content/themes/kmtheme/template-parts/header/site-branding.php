<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>

<div class="head-wrapper">
  <div class="wrap">
    <div class="site-branding">
      <?php the_custom_logo(); ?>
      <div class="site-branding-text">
        <?php if (is_front_page()) : ?>
          <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
            rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php else : ?>
              <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
               rel="home"><?php bloginfo('name'); ?></a></p>
           <?php endif; ?>

           <?php
           $description = get_bloginfo('description', 'display');

           if ($description || is_customize_preview()) :
              ?>
              <p class="site-description"><?php echo $description; ?></p>
          <?php endif; ?>
      </div><!-- .site-branding-text -->

      <?php if ((twentyseventeen_is_frontpage() || (is_home() && is_front_page())) && !has_nav_menu('top')) : ?>
      <a href="#content"
      class="menu-scroll-down"><?php echo twentyseventeen_get_svg(array('icon' => 'arrow-right')); ?><span
      class="screen-reader-text"><?php _e('Scroll down to content', 'twentyseventeen'); ?></span></a>
  <?php endif; ?>


</div><!-- .site-branding -->

<div class="head-right-wrap">
   <?php   if ( is_user_logged_in() ) {
    $url = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $classPassword = ($url == 'change-password') ? 'active' :'';
    $classReviews = ($url == 'my-reviews') ? 'active' :'';
// echo $url;
    $user_id = get_current_user_id();
        // $img_url = get_user_meta($user_id,'author_profile_picture',true);
    $img_name =   km_get_show_user_avatar(array('item_id'=>$user_id,'html'=>false,'type'=>'thumb'));

    if($img_name){
      $img = '<img src="'.$img_name .'">';
  }else{
      $img ='<i class="fas fa-user-circle"></i>';
  }
  $user = wp_get_current_user();
  if ( in_array( 'tasker', (array) $user->roles ) ) {
    $class = ($url == 'my-profile') ? 'active' :'';
      $li = '<li class="'.$class.'"><a class="settings-i" href="'.site_url().'/my-profile/">My Profile</a></li>';
  }else{
    $class = ($url == 'edit-profile') ? 'active' :'';
      $li='<li class="'.$class.'"><a class="settings-i" href="'.site_url().'/edit-profile/">My Profile</a></li>';
  }
  // if ( !in_array( 'tasker', (array) $user->roles ) ) {

  //     $class = ($url == 'membership-account') ? 'active' :'';
  //     $liPlan = '<li class="'.$class.'"><a class="plan-i" href="'.site_url().'/membership-account/">My Plan</a></li>';
  //     $classContact = ($url == 'tasker-contact') ? 'active' :'';
  //     $liTaskerContact = '<li class="'.$classContact.'"><a class="tasker-i" href="'.site_url().'/tasker-contact/"></a></li>';
  // }else{
  //     $liPlan = $liTaskerContact ='';
  // }

  echo '<div class="my_Account_nav"><a href="javascript:void(0);" class="button toggler"><i class="fas fa-user-circle"></i> <span>My Account</span> <i class="far fa-angle-down"></i></a>
  <ul class="my_Account_subnav toggle_wrap">

  <li class="wooffy-title">'.$img." ".ucwords(get_user_meta($user_id,'first_name',true)).'</li>'.$li.'
  <li class="'.$classPassword.'"><a class="pw-i" href="'.site_url().'/change-password/">Change Password</a></li>'.$liPlan.$liTaskerContact;
  // echo '<li class="'.$classReviews.'"><a class="reviews-i" href="'.site_url().'/my-reviews/">My Reviews</a></li>';
  echo '<li><a class="log-i" href="'.site_url().'/wp-login.php?action=logout">Sign Out</a></li>
  </ul>
  </div>';

} else {
    echo '<a href="'.site_url().'/login" class="button button-primary login"><i class="fas fa-user"></i> <span>Sign In</span></a>';
    echo '<a href="'.site_url().'/become-a-member" class="button signup"><i class="fas fa-user-plus"></i> <span>Become a Member</span></a>';
}


?>
<?php //dynamic_sidebar('[header-right-sidebar]'); ?>
<div class="head-right desktop">
    <div class="lang-tr">
      <?php if ( function_exists( 'qtranxf_generateLanguageSelectCode' ) )
      qtranxf_generateLanguageSelectCode(array('type'=>'dropdown'));
      ?>
  </div>
  <div class="social-icons show-desktop-7">
     <?php if(function_exists('get_field')) : ?>
      <?php if (get_field('social_icons', 'option')): ?>

        <ul>

          <?php while (has_sub_field('social_icons', 'option')): ?>

            <?php if (get_sub_field('image') && get_sub_field('url')): ?>
            <li>
              <a href="<?php the_sub_field('url') ?>" title="<?php get_sub_field('title') ?>"><img
                alt="<?php get_sub_field('title') ?>"
                src="<?php the_sub_field('image') ?>"></a>
            </li>
        <?php endif; ?>

    <?php endwhile; ?>

</ul>


<?php endif; ?>
<?php endif ?>

</div>
<?php if(function_exists('get_field')) : ?>
    <?php if (get_field('show_accessibilit_icon', 'option')): ?>
      <div class="accss-top show-desktop-7"><a href="<?php echo get_field('accessibility_link', 'option') ?>" target="_blank"
        class="icon-accessibility"></a></div>
    <?php endif; ?>
<?php endif ?>

</div>
<div class="wsmobileheader clearfix">
    <a id="wsnavtoggle" class="animated-arrow"><span></span></a>
</div>
</div>

<div class="header-search-form">
  <span class="toggle-button icon-search-toggle icon-toggle" data-toggleid="search-toggle-wrapper"></span>
  <div class="search-toggle-wrapper" id="search-toggle-wrapper">
    <?php
   //  echo get_search_form();
    ?>
   <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
</div>
</div>

<nav id="site-navigation" class="wsmenu clearfix">
  <?php wp_nav_menu(array(

    'theme_location' => 'top',
    'menu_id' => 'top-menu',
    'menu_class' => 'mobile-sub wsmenu-list',
    'container' => 'span',
    'walker' => new CSS_Menu_Maker_Walker()
)); ?>
</nav>
</div><!-- .wrap -->
</div><!-- .head-wrapper -->
