<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Yalynka
 */

get_header();
?>

	<main class="page">
    <div class="page__nav"><?php my_breadcrumbs(); ?></div>
    <section class="page__article article">
      <div class="article__container">
        <?php
        if ( has_post_thumbnail() ) :?>
          <div class="article__img-big"><?php the_post_thumbnail();?></div>
        <?php endif; ?>
        <div class="article__content"><?php the_content();?></div>
      </div>
    </section>
    <?php
      if ( is_single() ) {
        set_post_views(get_the_ID());
      }
    ?>
    <section class="page__popular popular">
      <div class="popular__container">
        <h2 class="popular__title">Популярні статті</h2>
        <div class="popular__row">
          <?php
          $cat_id = 1; // ID категории

          $args = array(
                  'cat' => $cat_id,
                  'posts_per_page' => 6,
                  'meta_key' => 'post_views_count',
                  'orderby' => 'meta_value_num',
                  'order' => 'DESC'
          );

          $query = new WP_Query( $args );

          if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
              ?>
              <div class="popular__column">
                <a href="<?php the_permalink(); ?>" class="popular__item">
                  <div class="popular__img">
                    <?php if ( has_post_thumbnail() ) :?>
                      <?php the_post_thumbnail('medium');?>
                    <?php else:?>
                      <img alt="Image" src="<?= get_template_directory_uri() . '/assets/img/placeholder.webp';?>">
                    <?php endif;?>
                  </div>
                  <div class="popular__content">
                    <time datetime="<?php echo get_the_date('c'); ?>" class="popular__date">
                      <?php echo get_the_date('d.m.Y'); ?>
                    </time>
                    <h3 class="popular__subtitle"><?php the_title();?></h3>
                    <?php
                      $excerpt = get_post_field( 'post_excerpt', get_the_ID() );

                      if ( ! empty( $excerpt ) ) {
                        echo '<div class="popular__text">' . wp_kses_post( $excerpt ) . '</div>';
                      }
                    ?>
                    <a href="<?php the_permalink(); ?>" class="popular__button">Читати повністю</a>
                  </div>
                </a>
              </div>
            <?php
            endwhile;
            echo '</div>';
          endif;

          wp_reset_postdata();
          ?>
        </div>
      </div>
    </section>
  </main>

<?php
get_footer();
