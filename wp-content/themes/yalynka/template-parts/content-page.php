<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Yalynka
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('page-wrapper'); ?>>
	<header class="page-header">
		<?php echo pageHeaderImage(get_field('page_header_image')['url']); ?>
		<div class="container">
			<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
			<?php if( function_exists( 'aioseo_breadcrumbs' ) ) aioseo_breadcrumbs(); ?>
		</div>
	</header><!-- .entry-header -->

	<div class="page-content section">
		<div class="container">
			<?php the_content(); ?>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
