<?php
/**
 * Displays header media
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<?php
if (is_active_sidebar('sidebar-top')) { ?>
	<div class="widget-column topbar-msgbar">

		<div id="top-sidebar-add" class="wrap">
			<?php dynamic_sidebar('sidebar-top'); ?>
		</div>
		<span class="hideshow-button icon-top-toggle" data-toggleid="top-sidebar-add"></span>
	</div>
<?php }
?>
<div class="custom-header">

		<div class="custom-header-media">
			<?php the_custom_header_markup(); ?>
		</div>

	<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>

</div><!-- .custom-header -->
