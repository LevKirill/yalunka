<?php
/**
 * The template for displaying category archive pages
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Yalynka
 */

get_header();
$current_cat = get_queried_object();
?>
  <main class="page">
    <div class="page__nav"><?php my_breadcrumbs(); ?></div>
    <section class="page__blog blog">
      <div class="blog__container">
        <div class="blog__layout">
          <!-- Сайдбар -->
          <aside class="blog__sidebar">
            <h3 class="blog__sidebar-title">Категорії</h3>
            <?php
              // Определяем родительскую категорию
              if ( $current_cat->parent != 0 ) {
                // Если мы в подкатегории — берём её родителя
                $parent_id = $current_cat->parent;
              } else {
                // Если мы в родительской категории
                $parent_id = $current_cat->term_id;
              }

              // Получаем все подкатегории родительской категории
              $subcategories = get_categories( array(
                      'parent'     => $parent_id,
                      'hide_empty' => false,
                      'orderby'    => 'name',
                      'order'      => 'DESC', // обратный порядок (Z → A)
              ) );

              if ( $subcategories ) {
                echo '<ul class="blog__categories-list">';
                foreach ( $subcategories as $cat ) {
                  // Добавляем класс для текущей категории
                  $class = ( $current_cat->term_id == $cat->term_id ) ? ' class="current-cat"' : '';
                  echo '<li' . $class . '><a href="' . get_category_link( $cat->term_id ) . '">' . $cat->name . '</a></li>';
                }
                echo '</ul>';
              }
            ?>
          </aside>
          <!-- Основной контент -->
          <?php
          $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

          if ( have_posts() ) : ?>
            <div class="blog__content-wrap">
              <div class="blog__row">
                <?php while ( have_posts() ) : the_post(); ?>
                  <div class="blog__column">
                    <a href="<?php the_permalink(); ?>" class="blog__item">
                      <div class="blog__img">
                        <picture>
                          <?php
                          $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
                          $thumbnail_src = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
                          if ( $thumbnail_src ) : ?>
                            <source media="(max-width: 600px)" srcset="<?php echo esc_url( $thumbnail_src[0] ); ?>" type="image/webp">
                            <img alt="<?php the_title_attribute(); ?>" src="<?php echo esc_url( $thumbnail_src[0] ); ?>">
                          <?php else: ?>
                            <img alt="Image" src="/wp-content/uploads/placeholder.webp">
                          <?php endif; ?>
                        </picture>
                      </div>
                      <div class="blog__content">
                        <div class="blog__date"><?php echo get_the_date('d.m.Y'); ?></div>
                        <h3 class="blog__subtitle"><?php the_title(); ?></h3>
                        <div class="blog__text">
                          <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                        </div>
                        <span class="blog__button">Читати повністю</span>
                      </div>
                    </a>
                  </div>
                <?php endwhile; ?>
              </div>

              <!-- Пагинация -->
              <div class="blog__pagination">
                <?php
                global $wp_query;
                echo paginate_links( array(
                        'total'     => $wp_query->max_num_pages,
                        'current'   => max( 1, $paged ),
                        'mid_size'  => 1,
                        'prev_text' => '«',
                        'next_text' => '»',
                        'format'    => ( get_option('permalink_structure') ? 'page/%#%/' : '?paged=%#%' ),
                        'type'      => 'list', // для обёртки <ul> ... </ul>
                ) );
                ?>
              </div>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </section>
    <!-- Популярные статьи -->
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
