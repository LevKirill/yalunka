<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Yalynka
 */

?>

</main>

<footer data-fls-footer="" class="footer">
  <div class="footer__container">
    <div class="footer__info info-footer">
      <a href="#" class="footer__logo">
        <picture>
          <img alt="Logo" src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.webp">
        </picture>
      </a>
      <div class="info-footer__text">
        Виробники якісних та довговічних вуличних гірлянд, 3D освітлення, вітражних та підвісних світлодіодних
        сіток та стовбурових ялинок ексклюзивних розмірів
      </div>
      <div class="info-footer__social">
        <a href="#" class="footer__link">
          <picture>
            <img alt="Facebook" src="<?php echo get_template_directory_uri(); ?>/assets/img/social/fb.webp">
          </picture>
        </a>
        <a href="#" class="footer__link">
          <picture>
            <img alt="Instagram" src="<?php echo get_template_directory_uri(); ?>/assets/img/social/inst.webp">
          </picture>
        </a>
        <a href="#" class="footer__link">
          <picture>
            <img alt="Telegram" src="<?php echo get_template_directory_uri(); ?>/assets/img/social/tg.webp">
          </picture>
        </a>
      </div>
    </div>
    <div class="footer__nav nav-footer">
      <h2 class="footer__title">Інформація</h2>
      <?php
        wp_nav_menu(array(
                'theme_location' => 'menu-1',
                'container'      => 'nav',
                'container_class'=> 'nav-footer__menu menu-footer',
                'menu_class'     => 'menu-footer__list',
                'walker'         => new Footer_Nav_Walker(),
                'fallback_cb'    => false,
        ));
      ?>
      <!--<nav class="nav-footer__menu menu-footer">
        <ul class="menu-footer__list">
          <li class="menu-footer__item">
            <a href="index.php" class="menu-footer__link">Головна</a>
          </li>
          <li class="menu-footer__item menu_parent">
            <a href="https://yalunka.market/catalog/" class="menu-footer__link">Каталог</a>
            <ul class="menu-footer__sub sub-menu">
              <li class="sub-menu__item">
                <a href="https://yalunka.market/product-category/girlyandy/" class="sub-menu__link">Гірлянди</a>
              </li>
              <li class="sub-menu__item">
                <a href="https://yalunka.market/product-category/3d-fontany/" class="sub-menu__link">3D Фонтани</a>
              </li>
              <li class="sub-menu__item">
                <a href="https://yalunka.market/product-category/figury-arky-ta-instalyacziyi/" class="sub-menu__link">Фігури,
                  арки та інсталяції</a>
              </li>
              <li class="sub-menu__item">
                <a href="https://yalunka.market/product-category/igrashky/" class="sub-menu__link">Іграшки</a>
              </li>
              <li class="sub-menu__item">
                <a href="https://yalunka.market/product-category/makivka/" class="sub-menu__link">Маківка</a>
              </li>
              <li class="sub-menu__item">
                <a href="https://yalunka.market/product-category/ogorozha/" class="sub-menu__link">Огорожа</a>
              </li>
              <li class="sub-menu__item">
                <a href="https://yalunka.market/product-category/promyslove-zabezpechennya/" class="sub-menu__link">Промисловe
                  забезпечення</a>
              </li>
              <li class="sub-menu__item">
                <a href="https://yalunka.market/product-category/rgb-kuli/" class="sub-menu__link">RGB Кулі</a>
              </li>
              <li class="sub-menu__item">
                <a href="https://yalunka.market/product-category/gabiony/" class="sub-menu__link">Габіони</a>
              </li>
            </ul>
          </li>
          <li class="menu-footer__item">
            <a href="https://yalunka.market/product-category/akcziyi/" class="menu-footer__link">Акції</a>
          </li>
          <li class="menu-footer__item">
            <a href="index.php" class="menu-footer__link">Фотогалерея</a>
          </li>
          <li class="menu-footer__item">
            <a href="https://yalunka.market/oplata-ta-dostavka/" class="menu-footer__link">Оплата та доставка</a>
          </li>
          <li class="menu-footer__item">
            <a href="https://yalunka.market/dokumenty/" class="menu-footer__link">Документи</a>
          </li>
          <li class="menu-footer__item">
            <a href="https://yalunka.market/kontakty/" class="menu-footer__link">Контакти</a>
          </li>
        </ul>
      </nav>-->
    </div>
    <div class="footer__contact contact-footer">
      <h2 class="footer__title">Контакти</h2>
      <div class="contact-footer__mob">
        <a href="tel:+380970457447" class="contact-footer__tel">0970457447</a>
      </div>
      <div class="contact-footer__email">
        <a href="mailto:svstlosvyata@gmail.com" class="contact-footer__mail">svstlosvyata@gmail.com</a>
      </div>
    </div>
    <div class="footer__adress adress-footer">
      <h2 class="footer__title">Адреса</h2>
      <div class="adress-footer__adress">46001 Тернопіль вул. Грушевського 23</div>
    </div>
  </div>
</footer>
</div>
<?php wp_footer(); ?>

</body>
</html>