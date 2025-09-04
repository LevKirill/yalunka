<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Yalynka
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function yalynka_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'yalynka_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function yalynka_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'yalynka_pingback_header' );

//Вывод статей в отдельном шаблоне
add_filter('template_include', function($template) {
  if ( is_single() && has_category('blog') ) {
    $new_template = locate_template(['single-blog.php']);
    if ( $new_template ) return $new_template;
  }
  return $template;
});


//My Breadcrumbs
function build_category_chain( $cat_id, $make_current_span = true ) {
  $parts = array();
  $ancestors = get_ancestors( $cat_id, 'category' );

  if ( $ancestors ) {
    $ancestors = array_reverse( $ancestors );
    foreach ( $ancestors as $anc_id ) {
      $term = get_category( $anc_id );
      if ( $term && ! is_wp_error( $term ) ) {
        $parts[] = '<a href="' . get_category_link( $anc_id ) . '" class="page__prev">' . $term->name . '</a>';
      }
    }
  }

  $current = get_category( $cat_id );
  if ( $current && ! is_wp_error( $current ) ) {
    if ( $make_current_span ) {
      $parts[] = '<span class="page__current">' . $current->name . '</span>';
    } else {
      $parts[] = '<a href="' . get_category_link( $cat_id ) . '" class="page__prev">' . $current->name . '</a>';
    }
  }

  return implode( ' / ', $parts );
}

function my_breadcrumbs() {
  if ( is_home() ) {
    return;
  }

  echo '<nav class="page__container">';
  echo '<a href="' . home_url('/') . '" class="page__prev">Головна</a>';
  $sep = ' / ';

  if ( is_category() ) {
    $current_cat = get_queried_object();
    if ( $current_cat && ! is_wp_error( $current_cat ) ) {
      echo $sep . build_category_chain( $current_cat->term_id, true );
    }

  } elseif ( is_single() ) {
    $cats = get_the_category();
    if ( $cats ) {
      // Выбираем самую "глубокую" категорию
      $deepest_cat = $cats[0];
      $max_depth = -1;
      foreach ( $cats as $cat ) {
        $depth = count( get_ancestors( $cat->term_id, 'category' ) );
        if ( $depth > $max_depth ) {
          $max_depth = $depth;
          $deepest_cat = $cat;
        }
      }

      // Для записи категории делаем ссылками (current = false)
      echo $sep . build_category_chain( $deepest_cat->term_id, false );
    }

    echo $sep . '<span class="page__current">' . get_the_title() . '</span>';

  } elseif ( is_page() ) {
    global $post;
    if ( $post->post_parent ) {
      $parent_id = $post->post_parent;
      $breadcrumbs = array();
      while ( $parent_id ) {
        $page = get_post( $parent_id );
        $breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '" class="page__prev">' . get_the_title( $page->ID ) . '</a>';
        $parent_id = $page->post_parent;
      }
      $breadcrumbs = array_reverse( $breadcrumbs );
      echo $sep . implode( $sep, $breadcrumbs ) . $sep;
    }
    echo '<span class="page__current">' . get_the_title() . '</span>';
  }

  echo '</nav>';
}


//Счетчик просмотров статей
// Увеличиваем счетчик просмотров
function set_post_views($postID) {
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);

  if ($count == '') {
    $count = 0;
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key, '0');
  } else {
    $count++;
    update_post_meta($postID, $count_key, $count);
  }
}

// Получаем количество просмотров
function get_post_views($postID) {
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);

  if ($count == '') {
    return "0";
  }
  return $count;
}

//Показывать только категории 1-го порядка в Вигляд->Меню
add_filter( 'get_terms_args', function( $args, $taxonomies ) {
  if ( in_array( 'product_cat', $taxonomies ) && is_admin() ) {
    $args['parent'] = 0; // только корневые категории
  }
  return $args;
}, 10, 2 );


/* ================== Header Walker ================== */
class Header_Nav_Walker extends Walker_Nav_Menu {

  // Определяем наличие дочерних пунктов
  function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
    $element->has_children = !empty( $children_elements[$element->ID] );
    parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<div class=\"menu__sub sub-menu__body\"><ul class=\"sub-menu\">\n";
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul></div>\n";
  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    if ($depth == 0) {
      $li_class = 'menu__item';
      $a_class  = 'menu__link';
    } else {
      $li_class = 'sub-menu__item';
      $a_class  = 'sub-menu__link';
    }

    if ( !empty($item->has_children) ) {
      $li_class .= ' menu_parent';
    }

    $output .= $indent . '<li class="' . $li_class . '">';
    $attributes  = !empty( $item->url ) ? ' href="' . esc_url( $item->url ) . '"' : '';
    $title = apply_filters( 'the_title', $item->title, $item->ID );
    $output .= '<a'. $attributes .' class="'. $a_class .'">'. $title .'</a>';
  }

  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= "</li>\n";
  }
}

/* ================== Footer Walker ================== */
class Footer_Nav_Walker extends Walker_Nav_Menu {

  function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
    $element->has_children = !empty( $children_elements[$element->ID] );
    parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"menu-footer__sub sub-menu\">\n";
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul>\n";
  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    if ($depth == 0) {
      $li_class = 'menu-footer__item';
      $a_class  = 'menu-footer__link';
    } else {
      $li_class = 'sub-menu__item';
      $a_class  = 'sub-menu__link';
    }

    if ( !empty($item->has_children) ) {
      $li_class .= ' menu_parent';
    }

    $output .= $indent . '<li class="' . $li_class . '">';
    $attributes  = !empty( $item->url ) ? ' href="' . esc_url( $item->url ) . '"' : '';
    $title = apply_filters( 'the_title', $item->title, $item->ID );
    $output .= '<a'. $attributes .' class="'. $a_class .'">'. $title .'</a>';
  }

  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= "</li>\n";
  }
}


//Custom Search
add_filter('get_search_form', function($form) {
  // Убираем класс у тега form
  $form = preg_replace('/<form([^>]*)class="[^"]*"([^>]*)>/', '<form$1$2>', $form);

  // Добавляем класс к input[type="search"]
  $form = preg_replace('/(<input[^>]*type="search"[^>]*)>/', '$1 class="top-header__input">', $form);

  return $form;
});

//Добавить класс к цене в вариативном товаре в категории товаров
add_filter('woocommerce_get_price_html', function($price, $product) {
  if (is_product_category() || is_shop()) {
    if ($product->is_type('variable')) {
      // Добавляем span с классом
      $price = '<span class="variable-price">' . $price . '</span>';
    }
  }
  return $price;
}, 10, 2);

//Изменить кнопку "Купити" с добавить в корзину на ссылку на товар
add_filter( 'woocommerce_loop_add_to_cart_link', function( $html, $product ) {
  $url = get_permalink( $product->get_id() );
  $text = $product->is_type('variable') ? 'Вибрати варіант' : 'Купити';

  $class = 'button product_type_' . $product->get_type();

  $html = '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $class ) . '">' . esc_html( $text ) . '</a>';

  return $html;
}, 10, 2 );

//Удалить кнопку купить со страницы товара и заменить кастомными кнопками
add_action( 'woocommerce_single_product_summary', function() {
  global $product;

  // Для вариативных товаров убираем стандартную кнопку внутри формы
  if ( $product->is_type('variable') ) {
    remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );

    add_action( 'woocommerce_single_variation', function() use ( $product ) {
      ?>
      <div class="product__btns">
        <button
                type="button"
                data-id="<?php echo esc_attr( $product->get_id() ); ?>"
                data-title="<?php echo esc_attr( $product->get_name() ); ?>"
                class="button custom-add-to-cart">
          Додати в кошик
        </button>
        <button type="button" class="buy-click">Замовити в один клік</button>
      </div>
      <?php
    }, 20 );

  } else {
    // Для простых товаров просто заменяем кнопку
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

    add_action( 'woocommerce_single_product_summary', function() use ( $product ) {
      ?>
      <div class="product__btns">
        <button
                type="button"
                data-id="<?php echo esc_attr( $product->get_id() ); ?>"
                data-title="<?php echo esc_attr( $product->get_name() ); ?>"
                data-price="<?php echo esc_attr( $product->get_price() ); ?>"
                data-image="<?php echo get_the_post_thumbnail_url( $product->get_id(), 'full' ) ?: 'assets/img/placeholder.png'; ?>"
                class="button custom-add-to-cart">
          Додати в кошик
        </button>
        <button type="button" class="buy-click">Замовити в один клік</button>
      </div>
      <?php
    }, 30 );
  }
}, 1 );
