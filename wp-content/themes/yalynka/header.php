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
<?php
  $options = get_fields('option');
  $facebook = $options['link_facebook']??'';
  $instagram = $options['link_instagram']??'';
  $telegram = $options['link_telegram']??'';
  $phone = $options['phone_1']??'';
  $linkPhone = preg_replace('/\D+/', '', $phone);
?>

<header data-fls-header="" class="header">
  <div class="header__container">
    <?php
      $home_url = home_url('/');

      $custom_logo_id = get_theme_mod( 'custom_logo' );
      $logo = wp_get_attachment_image( $custom_logo_id, 'full', false, array( 'class' => 'header__logo' ) );

      if ( $logo ) {
        if ( is_front_page() ) {
          echo '<span class="header__logo">' . $logo . '</span>';
        } else {
          echo '<a href="' . esc_url( $home_url ) . '" class="header__logo">' . $logo . '</a>';
        }
      }
    ?>
    <div class="header__nav">
      <div class="header__top top-header">
        <div data-fls-dynamic=".menu__body, 992" class="top-header__social">
          <a href="<?= esc_url($facebook);?>" class="top-header__link" target="_blank">
            <picture>
              <img alt="Facebook" src="<?= get_template_directory_uri() . '/assets/img/social/fb.webp'; ?>">
            </picture>
          </a>
          <a href="<?= esc_url($instagram);?>" class="top-header__link" target="_blank">
            <picture>
              <img alt="Instagram" src="<?= get_template_directory_uri() . '/assets/img/social/inst.webp'; ?>">
            </picture>
          </a>
          <a href="<?= esc_attr('https://t.me/' . $telegram);?>" class="top-header__link" target="_blank">
            <picture>
              <img alt="Telegram" src="<?= get_template_directory_uri() . '/assets/img/social/tg.webp'; ?>">
            </picture>
          </a>
        </div>
        <div data-fls-dynamic=".menu__body, 768" class="top-header__phone">
          <a href="#" class="top-header__call">
            <picture>
              <img alt="Call" src="<?= get_template_directory_uri() . '/assets/img/header/call.webp'; ?>">
            </picture>
          </a>
          <a href="tel:+<?= esc_attr($linkPhone);?>" class="top-header__phone"><?= esc_html($phone);?></a>
        </div>
      </div>
      <div class="header__bottom header-bot">
        <div class="header-bot__nav">
          <div class="header__menu menu">
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
          </div>
        </div>
        <div class="top-header__icons">
          <div data-fls-dynamic=".menu__body, 992" class="top-header__search-box">
            <?php get_search_form(); ?>
            <a href="#" class="top-header__icon top-header__search">
              <img src="<?= get_template_directory_uri() . '/assets/img/header/search.svg';?>" alt="Search">
            </a>
          </div>
          <div class="header-account d-none d-lg-block">
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>"></a>
          </div>
          <a href="#" class="top-header__icon top-header__cart cart-btn">
            <picture>
              <img alt="Cart" src="<?= get_template_directory_uri() . '/assets/img/header/cart.webp';?>">
            </picture>
            <span class="header__count">0</span>
          </a>
          <button type="button" data-fls-menu="" class="menu__icon icon-menu">
            <span></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Попап корзины -->
<div class="cart-popup">
  <div class="cart-popup__content">
    <button class="cart-popup__close">&times;</button>
    <h2>Ваша корзина</h2>
    <div class="cart-items"><!-- Тут будуть товари з JS --></div>
    <div class="cart-footer">
      <span class="cart-total">Всього: 0 ₴</span>
      <button class="cart-checkout">Оформити замовлення</button>
    </div>
  </div>
</div>
<!-- Попап оформлення замовлення -->
<div class="order-popup">
  <div class="order-popup__content">
    <button class="order-popup__close">&times;</button>
    <h2>Оформлення замовлення</h2>

    <!-- Список товарів -->
    <div class="order-items"><!-- JS вставит товары --></div>

    <!-- Підсумок -->
    <div class="order-total">
      Всього до сплати:
      <span class="order-total__sum">0 ₴</span>
    </div>

    <!-- Форма для відправки -->
    <?= do_shortcode('[contact-form-7 id="ccdd54b"]');?>
  </div>
</div>

