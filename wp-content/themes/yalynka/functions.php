<?php
/**
 * Yalynka functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Yalynka
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function yalynka_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Yalynka, use a find and replace
		* to change 'yalynka' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'yalynka', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'yalynka' ),
			'menu-2' => esc_html__( 'Language', 'yalynka' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'woocommerce' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'yalynka_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function yalynka_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'yalynka_content_width', 640 );
}
add_action( 'after_setup_theme', 'yalynka_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function yalynka_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'yalynka' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'yalynka' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'yalynka_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function yalynka_scripts() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-3.6.0.min.js', false, null);
	wp_enqueue_script('jquery');

  wp_enqueue_style( 'yalynka-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'yalynka-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '5.1.3' );
	wp_enqueue_style( 'yalynka-owlcss', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), '2.3.4' );
	wp_enqueue_style( 'yalynka-app', get_template_directory_uri() . '/css/app.css', array(), '2.3.4' );

	wp_enqueue_script( 'yalynka-bundle', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array(), '5.1.3', true );
	wp_enqueue_script( 'yalynka-owljs', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), '2.3.4', true );
//  wp_enqueue_script( 'yalynka-appJS', get_template_directory_uri() . '/js/app.js', array(), _S_VERSION, true );
  wp_enqueue_script( 'yalynka-custom', get_template_directory_uri() . '/js/custom.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'yalynka_scripts' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';



add_filter( 'woocommerce_add_to_cart_fragments', 'header_add_to_cart_fragment', 30, 1 );
function header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    ob_start();
    ?>
    <a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>"><span><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></span></a>
    <?php
    $fragments['a.cart-customlocation'] = ob_get_clean();

    return $fragments;
}




function roofart_get_rating_html( $product, $rating = null ) {
    if (get_option('woocommerce_enable_review_rating') == 'no')
        return '';
    if ( ! is_numeric( $rating ) ) {
        $rating = $product->get_average_rating();
    }
    $rating_html  = '<div class="star-rating" title="' . $rating . '">';
    $rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"><strong class="rating">' . $rating . '</strong> ' . __( 'out of 5', 'woocommerce' ) . '</span>';
    $rating_html .= '</div>';
    return $rating_html;
}




function pageHeaderImage($img) {
	if($img) $html = '<div class="page-header-img"><img src="'.$img.'" alt="" /></div>';
	elseif(get_field('page_header_image', 'options')['url']) $html = '<div class="page-header-img"><img src="'.get_field('page_header_image', 'options')['url'].'" alt="" /></div>';
	else $html = '<div class="page-header-img"></div>';
	return $html;
}




// Отделяем категории от товаров
function tutsplus_product_subcategories( $args = array() ) {
	$parentid = get_queried_object_id();
	$args = array(
		'parent' => $parentid
	);
	$terms = get_terms( 'product_cat', $args );
	if ( $terms ) {
		echo '<ul class="product-cats">';
		foreach ( $terms as $term ) {
			echo '<li class="category-item"><div class="category-item-inner">';
			echo '<a href="' . esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">';
			echo '<h3>'.$term->name.'</h3>';
			echo '<div class="category-item-image">'; woocommerce_subcategory_thumbnail( $term ); echo '</div>';
			echo '</a></div></li>';
		}
		echo '</ul>';
	}
}
add_action( 'woocommerce_before_shop_loop', 'tutsplus_product_subcategories', 50 );

// Подключение стилей и скриптов
function my_theme_enqueue_assets() {
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/index.min.css', [], '1.0', 'all');
    wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/index.min.js', [], '1.0', true);
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_assets');

function register_hero_section_cpt() {
    $labels = array(
        'name' => 'Головна секція',
        'singular_name' => 'Головна секція',
        'add_new' => 'Додати секцію',
        'add_new_item' => 'Додати нову секцію',
        'edit_item' => 'Редагувати секцію',
        'new_item' => 'Нова секція',
        'view_item' => 'Переглянути секцію',
        'search_items' => 'Пошук секцій',
        'not_found' => 'Не знайдено',
        'not_found_in_trash' => 'Не знайдено у кошику',
        'menu_name' => 'Hero Секція'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-format-image',
        'supports' => array('title'),
        'has_archive' => false,
        'show_in_rest' => true,
    );

    register_post_type('hero_section', $args);
}
add_action('init', 'register_hero_section_cpt');

function register_teaser_slide_cpt() {
    $labels = array(
        'name' => 'Teaser Слайди',
        'singular_name' => 'Teaser Слайд',
        'add_new' => 'Додати слайд',
        'add_new_item' => 'Додати новий слайд',
        'edit_item' => 'Редагувати слайд',
        'new_item' => 'Новий слайд',
        'view_item' => 'Переглянути слайд',
        'search_items' => 'Пошук слайдів',
        'not_found' => 'Не знайдено',
        'not_found_in_trash' => 'Не знайдено у кошику',
        'menu_name' => 'Teaser Слайди'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array('title'),
        'has_archive' => false,
        'show_in_rest' => true,
    );

    register_post_type('teaser_slide', $args);
}
add_action('init', 'register_teaser_slide_cpt');

function register_catalog_item_cpt() {
    $labels = array(
        'name' => 'Catalog Items',
        'singular_name' => 'Catalog Item',
        'add_new' => 'Додати картку',
        'add_new_item' => 'Додати нову картку',
        'edit_item' => 'Редагувати картку',
        'new_item' => 'Нова картка',
        'view_item' => 'Переглянути картку',
        'search_items' => 'Пошук карток',
        'not_found' => 'Не знайдено',
        'not_found_in_trash' => 'Не знайдено у кошику',
        'menu_name' => 'Каталог'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-products',
        'supports' => array('title'),
        'has_archive' => false,
        'show_in_rest' => true,
    );

    register_post_type('catalog_item', $args);
}
add_action('init', 'register_catalog_item_cpt');

function register_discount_item_cpt() {
    $labels = array(
        'name' => 'Акційні товари',
        'singular_name' => 'Акційний товар',
        'add_new' => 'Додати товар',
        'add_new_item' => 'Додати новий товар',
        'edit_item' => 'Редагувати товар',
        'new_item' => 'Новий товар',
        'view_item' => 'Переглянути товар',
        'search_items' => 'Пошук товарів',
        'not_found' => 'Не знайдено',
        'not_found_in_trash' => 'Не знайдено у кошику',
        'menu_name' => 'Акції'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-tag',
        'supports' => array('title'),
        'has_archive' => false,
        'show_in_rest' => true,
    );

    register_post_type('discount_item', $args);
}
add_action('init', 'register_discount_item_cpt');

function register_gallery_item_cpt() {
    $labels = array(
        'name' => 'Фотогалерея',
        'singular_name' => 'Фото',
        'add_new' => 'Додати фото',
        'add_new_item' => 'Додати нове фото',
        'edit_item' => 'Редагувати фото',
        'new_item' => 'Нове фото',
        'view_item' => 'Переглянути фото',
        'search_items' => 'Пошук фото',
        'not_found' => 'Не знайдено',
        'not_found_in_trash' => 'Не знайдено у кошику',
        'menu_name' => 'Галерея'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-format-image',
        'supports' => array('title'),
        'has_archive' => false,
        'show_in_rest' => true,
    );

    register_post_type('gallery_item', $args);
}
add_action('init', 'register_gallery_item_cpt');

function register_video_item_cpt() {
    $labels = array(
        'name' => 'Відео',
        'singular_name' => 'Відео',
        'add_new' => 'Додати відео',
        'add_new_item' => 'Додати нове відео',
        'edit_item' => 'Редагувати відео',
        'new_item' => 'Нове відео',
        'view_item' => 'Переглянути відео',
        'search_items' => 'Пошук відео',
        'not_found' => 'Не знайдено',
        'not_found_in_trash' => 'Не знайдено у кошику',
        'menu_name' => 'Відео'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-video-alt3',
        'supports' => array('title'),
        'has_archive' => false,
        'show_in_rest' => true,
    );

    register_post_type('video_item', $args);
}
add_action('init', 'register_video_item_cpt');

/**
 * Отправка заказа по email и/или Telegram
 */
require get_template_directory() . '/inc/email-functions.php';
