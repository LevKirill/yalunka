$('.owl-mainSlider').owlCarousel({
    loop:true,
    items:1,
    margin:0,
    nav:false,
    dots:true
});



$('#menu-toggled').click(function() {
    $('.modal-mobile').addClass('show');
});
$('.modal-mobile-bg, .modal-mobile-close').click(function() {
    $('.modal-mobile').removeClass('show');
});
$('.modal-mobile .main-menu li.menu-item-has-children > a').click(function(e) {
    e.preventDefault();
    $(this).parent().toggleClass('active');
});



$('.filter-btn button').click(function() {
    $(this).parent().parent().toggleClass('active');
});

const searchBtn = document.querySelector(".top-header__search");
const searchContainer = document.querySelector(".top-header__search-box");
if (searchBtn) {
    searchBtn.addEventListener('click', (e) => {
        searchContainer.classList.toggle('active');
    });
}


//Добавление выбранных вариаций в кнопки купить на странице товара
jQuery(function($){
    var $form = $('form.variations_form');

    function updateAddToCartButton($btn, baseTitle, price) {
        var selectedAttrs = [];
        $form.find('select[name^="attribute_"]').each(function(){
            var val = $(this).find('option:selected').text();
            if (val && val !== 'Choose an option') selectedAttrs.push(val);
        });
        var fullTitle = baseTitle;
        if (selectedAttrs.length) fullTitle += ' (' + selectedAttrs.join(', ') + ')';
        $btn.attr('data-title', fullTitle);
        $btn.attr('data-price', price);
    }

    if ($form.length) {
        var $btn = $('.product__btns .custom-add-to-cart');
        var baseTitle = $btn.data('base-title') || $btn.attr('data-title');
        if (!$btn.data('base-title')) $btn.data('base-title', baseTitle);

        // При выборе вариации
        $form.on('found_variation', function(event, variation){
            if (!$btn.length) return;
            var price = variation.display_price || variation.price || 0;
            var sku = variation.sku || $btn.data('id');
            $btn.attr('data-id', sku);
            updateAddToCartButton($btn, baseTitle, price);
        });

        // При сбросе вариаций
        $form.on('reset_data', function(){
            if (!$btn.length) return;
            $btn.attr('data-id', $btn.data('original-sku') || $btn.attr('data-id'));
            updateAddToCartButton($btn, baseTitle, $btn.data('original-price') || $btn.attr('data-price'));
        });
    }

    // Для обычных товаров сохраняем исходные значения
    $('.product__btns .custom-add-to-cart').each(function(){
        var $btn = $(this);
        if (!$btn.data('original-price')) $btn.data('original-price', $btn.attr('data-price'));
        if (!$btn.data('original-sku')) $btn.data('original-sku', $btn.attr('data-id'));
    });
});


//Купить в 1 клик
document.addEventListener("DOMContentLoaded", () => {
    const orderPopup = document.querySelector(".order-popup");
    const orderItemsContainer = document.querySelector(".order-items");
    const orderTotalEl = document.querySelector(".order-total__sum");
    const orderCloseBtn = document.querySelector(".order-popup__close");
    const orderConfirmBtn = document.querySelector(".order-confirm");

    function renderOrderPopup(products) {
        orderItemsContainer.innerHTML = "";
        let total = 0;
        products.forEach((item) => {
            total += item.price * item.quantity;
            const div = document.createElement("div");
            div.classList.add("order-item");
            div.style.cssText = `
        display:flex;
        align-items:center;
        margin-bottom:10px;
      `;
            div.innerHTML = `
        <img src="${item.image}" alt="${item.title}" style="width:50px;height:50px;object-fit:cover;margin-right:10px;border-radius:5px;">
        <span style="flex:1;">${item.title} × ${item.quantity}</span>
        <strong>${item.price * item.quantity}&nbsp;₴</strong>
      `;
            orderItemsContainer.appendChild(div);
        });
        orderTotalEl.innerHTML = `${total}&nbsp;₴`;
    }

    if (orderCloseBtn) {
        orderCloseBtn.addEventListener("click", () => {
            orderPopup.classList.remove("open");
        });
    }

    window.addEventListener("click", (e) => {
        if (e.target === orderPopup) {
            orderPopup.classList.remove("open");
        }
    });

    document.querySelectorAll(".buy-click").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const productContainer = btn.closest(".product");
            if (!productContainer) return;

            // Название товара
            const titleEl = productContainer.querySelector("h1.product_title.entry-title");
            let title = titleEl ? titleEl.textContent.trim() : "Товар";

            // Выбранные вариации
            const variationLis = productContainer.querySelectorAll(".variations li.xt_woovs-selected");
            if (variationLis.length) {
                const variations = Array.from(variationLis)
                  .map(li => li.getAttribute("title")?.trim())
                  .filter(v => v)
                  .join(", ");
                if (variations) title += ` (${variations})`;
            }

            // Цена
            const priceEl = productContainer.querySelector(".product__price span, .woocommerce-Price-amount");
            let price = priceEl ? parseFloat(priceEl.textContent.replace(/\s/g, "")) : 0;

            // Изображение
            const imageEl = productContainer.querySelector(".product__main img, .woocommerce-product-gallery__image img");
            let image = imageEl ? imageEl.src : "";

            const quickCart = [{
                id: "quick_" + Date.now(),
                title,
                price,
                quantity: 1,
                image
            }];

            renderOrderPopup(quickCart);
            orderPopup.classList.add("open");
        });
    });

    /*if (orderConfirmBtn) {
        orderConfirmBtn.addEventListener("click", (e) => {
            e.preventDefault();
            const orderForm = document.querySelector(".order-form");
            const inputs = orderForm.querySelectorAll("input[required], select[required]");
            let isValid = true;
            inputs.forEach((input) => (input.style.border = ""));
            inputs.forEach((input) => {
                if (!input.value.trim()) {
                    input.style.border = "1px solid #f44336";
                    isValid = false;
                }
            });
            if (!isValid) {
                alert("Будь ласка, заповніть усі обов'язкові поля!");
                return;
            }
            alert("Дякуємо! Ваше замовлення прийнято.");
            orderPopup.classList.remove("open");
            orderForm.reset();
        });
    }*/
});


// === Додавання товарiв в LocalStorage и обробник для форми CF7 з JSON ===
jQuery(function($){
    // === Обновление счётчика корзины ===
    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        $('.header__count').text(cart.reduce((sum, item) => sum + item.quantity, 0));
    }

    // === Обновление кнопки оформления ===
    function updateCheckoutBtn() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        $('.cart-checkout').prop('disabled', cart.length === 0).toggleClass('disabled', cart.length === 0);
    }

    // === Рендер корзины ===
    function renderCart() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const $cartItems = $('.cart-items');
        $cartItems.empty();
        let total = 0;

        if(cart.length === 0){
            $cartItems.append('<p>Кошик порожній</p>');
        } else {
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                $cartItems.append(`
                    <div class="cart-item">
                        <img src="${item.image}" alt="${item.title}" class="cart-item__img">
                        <div class="cart-item__info">
                            <span class="cart-item__title">${item.title}</span>
                            <span class="cart-item__quantity">× ${item.quantity}</span>
                            <span class="cart-item__price">${item.price}&nbsp;₴ / шт</span>
                        </div>
                        <strong class="cart-item__total">${itemTotal}&nbsp;₴</strong>
                        <button class="remove-item" data-id="${item.id}">✖</button>
                    </div>
                `);
            });
        }

        $('.cart-total').text(`Всього: ${total} ₴`);
        $('.order-total__sum').text(`${total} ₴`);
        updateCartCount();
        updateCheckoutBtn();
    }

    // === Рендер popup заказа ===
    function renderOrderPopup(cartArray){
        const $orderItems = $('.order-items');
        $orderItems.empty();
        let total = 0;

        cartArray.forEach(item => {
            const itemTotal = item.price * (item.quantity || 1);
            total += itemTotal;

            $orderItems.append(`
                <div class="order-item" style="display: flex; align-items: center; margin-bottom: 10px;">
                    <img src="${item.image || ''}" alt="${item.title}" style="width:50px;height:50px;object-fit:cover;margin-right:10px;border-radius:5px;">
                    <span style="flex:1;">${item.title} × ${item.quantity || 1}</span>
                    <strong>${itemTotal} ₴</strong>
                </div>
            `);
        });

        $('.order-total__sum').text(`${total} ₴`);
        const cartField = $('input[name="cart"]');
        if(cartField.length) cartField.val(JSON.stringify(cartArray));
        $('.order-popup').addClass('open');
    }

    // === Добавление товара в корзину ===
    // === Добавление товара в корзину ===
    $('.product__btns').on('click', '.custom-add-to-cart', function(){
        const $btn = $(this);
        const productId = $btn.attr('data-id');
        const variationId = $btn.attr('data-variation-id') || ''; // уникальный id вариации
        const uniqueId = productId + '_' + variationId; // уникальный ключ
        const title = $btn.attr('data-title');
        const price = parseFloat($btn.attr('data-price')) || 0;
        const image = $btn.closest('.product').find('img').attr('src') || 'assets/img/placeholder.png';

        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const existingItem = cart.find(item => item.id === uniqueId);

        if(existingItem){
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: uniqueId,
                productId: productId,
                variationId: variationId,
                title: title,
                price: price,
                image: image,
                quantity: 1
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();

        // === Анимация кнопки ===
        const originalText = $btn.text();
        $btn.text('Додано в кошик');
        setTimeout(() => {
            $btn.text(originalText);
        }, 1500);
    });

    // === Удаление из корзины ===
    $('.cart-popup').on('click', '.remove-item', function(){
        const productId = $(this).data('id');
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart = cart.filter(item => item.id != productId);
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
    });

    // === Открытие корзины ===
    $('.cart-btn').on('click', function(e){
        e.preventDefault();
        $('.cart-popup').addClass('active');
        renderCart();
    });

    $('.cart-popup').on('click', '.cart-popup__close', function(){
        $('.cart-popup').removeClass('active');
    });

    $(document).on('click', function(e){
        if($(e.target).closest('.cart-popup__content, .cart-btn, .remove-item').length === 0)
            $('.cart-popup').removeClass('active');
    });

    // === Кнопка "Оформити замовлення" ===
    $(document).on('click', '.cart-checkout', function(e){
        e.preventDefault();
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        if(cart.length === 0) return;
        const $orderPopup = $('.order-popup');
        $orderPopup.data('quick-order', false); // обычный заказ
        renderOrderPopup(cart);
    });

    // === Кнопка "Купить в 1 клік" ===
    $(document).on('click', '.buy-click', function(e){
        e.preventDefault();
        const $btn = $(this);
        const $product = $btn.closest('.product');

        const item = {
            id: $product.find('.custom-add-to-cart').data('id'),
            title: $product.find('.custom-add-to-cart').data('title'),
            price: parseFloat($product.find('.custom-add-to-cart').data('price')) || 0,
            image: $product.find('img').attr('src') || '',
            quantity: 1
        };

        const $orderPopup = $('.order-popup');
        $orderPopup.data('quick-order', true); // 1 клик
        renderOrderPopup([item]);
    });

    // === Заполнение скрытого поля при отправке CF7 ===
    document.addEventListener('wpcf7beforesubmit', function(event){
        const $form = $(event.target);
        const $cartField = $form.find('input[name="cart"]');
        if($cartField.length){
            const cartItems = [];
            $('.order-items .order-item').each(function(){
                const $item = $(this);
                const title = $item.find('span').text() || '';
                const price = parseFloat($item.find('strong').text().replace(/[^\d.]/g,'')) || 0;
                const quantityMatch = $item.find('span').text().match(/× (\d+)/);
                const quantity = quantityMatch ? parseInt(quantityMatch[1]) : 1;
                cartItems.push({ title, price, quantity });
            });
            $cartField.val(JSON.stringify(cartItems));
        }
    });

    // === Очистка корзины после отправки CF7 ===
    document.addEventListener('wpcf7mailsent', function(event){
        const $form = $(event.target);
        const $orderPopup = $('.order-popup');
        if($form.closest('.order-popup').length > 0){
            const isQuickOrder = $orderPopup.data('quick-order');
            if(!isQuickOrder){ // очищаем только обычный заказ
                localStorage.removeItem('cart');
                $('.cart-items, .order-items').empty().append('<p>Кошик порожній</p>');
                $('.cart-total, .order-total__sum').text('0 ₴');
                $('.header__count').text('0');
            }
            $orderPopup.removeClass('open');
            alert('Дякуємо! Ваше замовлення прийнято.');
        }
    });

    // === Инициализация ===
    renderCart();
});

