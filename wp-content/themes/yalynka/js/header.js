//Перенос блоков в Header для Tablet и Mobile
jQuery(function($) {
  // элементы
  var $social    = $(".header .top-header__social");
  var $search    = $(".header .top-header__search-box");
  var $phone     = $(".header div.top-header__phone");
  var $topHeader = $(".header .header__top.top-header");

  // плейсхолдеры (только если элементы существуют)
  var $socialPlaceholder = $social.length ? $('<div class="social-placeholder" style="display:none"></div>').insertAfter($social) : null;
  var $searchPlaceholder = $search.length ? $('<div class="search-placeholder" style="display:none"></div>').insertAfter($search) : null;
  var $phonePlaceholder  = $phone.length ? $('<div class="phone-placeholder" style="display:none"></div>').insertAfter($phone) : null;
  var $topHeaderPlaceholder = $topHeader.length ? $('<div class="top-header-placeholder" style="display:none"></div>').insertAfter($topHeader) : null;

  function moveBlocks() {
    var width = $(window).width();

    if (width <= 768) {
      // social и search в меню
      if ($social.length && !$social.parent().is(".menu__body")) {
        $social.appendTo(".header nav.menu__body");
      }
      if ($search.length && !$search.parent().is(".menu__body")) {
        $search.appendTo(".header nav.menu__body");
      }

      // phone в самый низ меню
      if ($phone.length && !$phone.parent().is(".menu__body")) {
        $(".header nav.menu__body").append($phone);
      }

      // topHeader удаляем
      if ($topHeader.length && $topHeader.parent().length) {
        $topHeader.detach();
      }

    } else if (width <= 980) {
      // возвращаем phone
      if ($phone.length && $phone.parent().is(".menu__body") && $phonePlaceholder) {
        $phonePlaceholder.after($phone);
      }
      // возвращаем topHeader
      if ($topHeader.length && $topHeaderPlaceholder && !$topHeader.parent().length) {
        $topHeaderPlaceholder.after($topHeader);
      }

      // social и search в меню
      if ($social.length && !$social.parent().is(".menu__body")) {
        $social.appendTo(".header nav.menu__body");
      }
      if ($search.length && !$search.parent().is(".menu__body")) {
        $search.appendTo(".header nav.menu__body");
      }

    } else {
      // >980: всё возвращаем
      if ($social.length && $social.parent().is(".menu__body") && $socialPlaceholder) {
        $socialPlaceholder.after($social);
      }
      if ($search.length && $search.parent().is(".menu__body") && $searchPlaceholder) {
        $searchPlaceholder.after($search);
      }
      if ($phone.length && $phone.parent().is(".menu__body") && $phonePlaceholder) {
        $phonePlaceholder.after($phone);
      }
      if ($topHeader.length && $topHeaderPlaceholder && !$topHeader.parent().length) {
        $topHeaderPlaceholder.after($topHeader);
      }
    }
  }

  // первый запуск
  moveBlocks();
  // снимаем "js-move-init", показываем блоки
  $("body").removeClass("js-move-init");

  // слушаем resize (с debounce)
  var resizeTimer;
  $(window).on("resize", function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(moveBlocks, 80);
  });
});
