<?php
// Template Name: Change Password
if(!is_user_logged_in()){
	wp_redirect(home_url());
}
get_header();
$user_id = get_current_user_id();

/* start user details */
$user = get_userdata($user_id);
// echo "<pre>"; print_r($user);
$user_email = $user->data->user_email;
$phone = @get_user_meta($user_id, 'billing_phone', true) ? get_user_meta($user_id, 'billing_phone', true) : "";
$first_name =  get_user_meta($user_id, 'first_name', true);
$last_name = get_user_meta($user_id, 'last_name', true);
$image = get_user_meta($user_id, 'author_profile_picture', true); ?>




<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="row-spacing">
				<div class="heading_profile text-center">
					<h3><?php the_title(); ?></h3>
					<p><?php echo get_the_content(); ?></p>
				</div>
				<!--<img src="<?php echo $image ?>">
				Name :  <?php echo $first_name." ".$last_name ?>
				Phone : <?php echo $phone ?>
				email : <?php echo $user_email ?>-->
				<div class="form-d">   
					<?php echo do_shortcode('[changepassword_form]'); ?>
				</div>
			</div>
		</main>
	</div>
</div>
<?php
get_footer(); ?>