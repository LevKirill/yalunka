<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Yalynka
 */

get_header();
?>

	<div class="page-wrapper">

		<section class="error-404 not-found">
			<header class="page-header">
				<?php echo pageHeaderImage(get_field('page_header_image')['url']); ?>
				<div class="container">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'yalynka' ); ?></h1>
					<?php if( function_exists( 'aioseo_breadcrumbs' ) ) aioseo_breadcrumbs(); ?>
				</div>
			</header><!-- .page-header -->

			<div class="page-content section">
				<div class="container">
					<p class="error-404-number">404</p>
				</div>
			</div>
		</section><!-- .error-404 -->

	</div>

<?php
get_footer();
