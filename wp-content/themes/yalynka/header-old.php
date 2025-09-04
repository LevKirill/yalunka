<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <style>
      /* Верхний блок: логотип слева, контакты и соцсети справа */
      .header-top {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 10px 0;
      }

      /* Контакты и соцсети справа */
      .header-top-right {
          display: flex;
          align-items: center;
          gap: 20px;
          white-space: nowrap; /* предотвращаем перенос текста */
      }

      /* Бордер между топом и боттом */
      .header-bottom {
          border-top: 1px solid #fff;
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 15px 0;
      }

      .header-search {
          flex: 0 0 auto !important; /* фиксированная ширина для поиска */
      }

      @media (max-width: 1199px) {
          .header-search {
              display: none !important; /* скрыть поиск на экранах меньше 1200px */
          }
      }

  </style>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
  <div class="container header-top">
    <div class="header-top-left">
      <?php the_custom_logo(); ?>
    </div>
    <div class="header-top-right d-flex align-items-center">
      <div class="header-social">
        <a href="#" class="social-icon facebook" target="_blank"></a>
        <a href="#" class="social-icon instagram" target="_blank"></a>
        <a href="#" class="social-icon telegram" target="_blank"></a>
      </div>
      <div class="header-phone"><a href="tel:+380970457447">+380970457447</a></div>
    </div>
  </div>

  <div class="container header-bottom d-flex justify-content-between align-items-center">
    <?php
      wp_nav_menu(array(
              'theme_location' => 'menu-1',
              'container'      => 'nav',
              'container_class'=> 'menu__body',
              'menu_class'     => 'menu__list',
              'walker'         => new Header_Nav_Walker(),
              'fallback_cb'    => false,
      ));
    ?>
    <div class="header-search d-none d-lg-block"><?php get_search_form(); ?></div>
    <div class="header-account d-none d-lg-block">
      <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">
        <?php _e('My Account', 'yalynka'); ?>
      </a>
    </div>
    <div class="header-cart">
      <a class="cart-customlocation" href="<?php echo wc_get_cart_url(); ?>">
        <span><?php echo sprintf(_n('%d', '%d', WC()->cart->get_cart_contents_count()), WC()->cart->get_cart_contents_count()); ?></span>
      </a>
    </div>
    <div class="header-toggle d-lg-none">
      <button id="menu-toggled"></button>
    </div>
  </div>
  </div>
</header>
<script>

</script>