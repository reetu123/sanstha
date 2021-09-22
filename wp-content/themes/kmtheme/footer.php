<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="wrap">
		<?php
		get_template_part( 'template-parts/footer/footer', 'widgets' );

		if ( has_nav_menu( 'social' ) ) : ?>
			<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'social',
					'menu_class'     => 'social-links-menu',
					'depth'          => 1,
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>' . twentyseventeen_get_svg( array( 'icon' => 'chain' ) ),
				) );
				?>
			</nav><!-- .social-navigation -->
		<?php endif;


		?>
	</div><!-- .wrap -->
</footer><!-- #colophon -->

<script>
			/*jQuery(document).on('click','#myBtn',function($){
				alert("clicked");
				jQuery('#myModal').modal('show');

				var user_service = jQuery(".user_service_id").val();
				var subscriber_id = jQuery(".subscriber_id").val();
				// alert(tasker_id);
				// alert(subscriber_id);
				jQuery.ajax({

					type: 'post',
					data: {
						action: 'km_add_tasker_contact',
						user_service_id: user_service,
						subscriber_id: subscriber_id
					},
					success: function (res) {
						if (res != '') {
							jQuery(".status_res").text(res);
						}
					}
				});
			});
			*/
			jQuery(document).on('click','.pmpro_btn-select',function(){
				<?php $user_id = get_current_user_id();
				if($user_id){
					$user_meta=get_userdata($user_id); ?>
					var user_role = "<?php echo $user_meta->roles[0]; ?>";
					if(user_role != 'subscriber'){
						var loc = window.location.href+'../';
						// window.location.replace(loc);
						window.location.href = loc;
					}
				<?php } ?>
				
			});
		</script>
		<script>
			jQuery('.slideshow1').slick({
  dots: true,
  infinite: true,
  speed: 300,
  slidesToShow: 1,
  slidesToScroll:1,
  arrows:true,
  autoplay: true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
		</script>
		<?php 	get_template_part( 'template-parts/footer/site', 'info' ); ?>
	</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
