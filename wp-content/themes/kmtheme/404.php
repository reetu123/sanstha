<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>


<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<!--<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'twentyseventeen' ); ?></h1>-->
					<div class="error-msg"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/404.jpg" /></div>
				</header><!-- .page-header -->
				<div class="page-content">
					<p><a href="<?php echo site_url(); ?>" class="button"><?php _e('Back to Home') ?></a></p> 
					<?php  /* <p class="or"><strong>OR</strong> Maybe try a search?</p>
					<?php  get_search_form(); */?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
