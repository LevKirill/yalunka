<?php
/**
 * The main template file
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
?>

	<main id="primary" class="site-main">

			<?php get_header(); ?>
		<div class="wrapper">
			<main class="page">
<section class="page__hero hero">
    <div class="hero__container">
        <div class="hero__content">
            <h1 class="hero__title"><?php the_field('hero_title', $hero_id); ?></h1>
            <h2 class="hero__subtitle"><?php the_field('hero_subtitle', $hero_id); ?></h2>
            <div class="hero__text"><?php the_field('hero_text', $hero_id); ?></div>
            <a href="<?php the_field('hero_button_link', $hero_id); ?>" class="hero__button">
                Переглянути каталог
                <picture>
                    <img alt="Image" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr.webp">
                </picture>
            </a>
        </div>
        <div class="hero__img">
            <?php $img = get_field('hero_main_image', $hero_id); ?>
            <?php if($img): ?>
            <img alt="Main" src="<?php echo esc_url($img['url']); ?>">
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

				<section class="page__teaser teaser">
    <div class="teaser__container">
        <div data-fls-slider="" class="teaser__slider swiper">
            <div class="teaser__wrapper swiper-wrapper">
                <?php
                $slides = get_posts([
                    'post_type' => 'teaser_slide',
                    'numberposts' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ]);

                if($slides):
                    foreach($slides as $slide):
                        $img = get_field('teaser_image', $slide->ID);
                        if($img):
                ?>
                <div class="teaser__slide swiper-slide">
                    <img alt="Image" src="<?php echo esc_url($img['url']); ?>">
                </div>
                <?php
                        endif;
                    endforeach;
                endif;
                ?>
            </div>

            <div class="teaser__nav">
                <button type="button" class="teaser-swiper-button-prev">
                    <picture>
                        <img alt="Назад" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
                    </picture>
                </button>
                <button type="button" class="teaser-swiper-button-next">
                    <picture>
                        <img alt="Вперед" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
                    </picture>
                </button>
            </div>
        </div>

        <div class="teaser__info">
            <div class="teaser__item">
                <h2 class="teaser__title">850+</h2>
                <h3 class="teaser__subtitle">Проєктів</h3>
            </div>
            <div class="teaser__item">
                <h2 class="teaser__title">950+</h2>
                <h3 class="teaser__subtitle">Інсталяцій</h3>
            </div>
            <div class="teaser__item">
                <h2 class="teaser__title">565+</h2>
                <h3 class="teaser__subtitle">Клієнтів</h3>
            </div>
            <div class="teaser__item">
                <h2 class="teaser__title">250+</h2>
                <h3 class="teaser__subtitle">Об'єктів</h3>
            </div>
        </div>
    </div>
</section>

				<section class="page__catalog catalog">
    <div class="catalog__container">
        <h2 class="catalog__title">Каталог товарів</h2>
        <div class="catalog__text">
            Ми «Світло Свято Друзів - виробники якісних та довговічних вуличних гірлянд, 3D освітлення, вітражних та
            підвісних світлодіодних сіток та стовбурових ялинок ексклюзивних розмірів.
        </div>
        <div data-fls-slider="" class="catalog__slider swiper">
            <div class="catalog__wrapper swiper-wrapper">
                <?php
                $items = get_posts([
                    'post_type' => 'catalog_item',
                    'numberposts' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ]);

                if($items):
                    foreach($items as $item):
                        $img = get_field('catalog_image', $item->ID);
                        $label = get_field('catalog_label', $item->ID);
                        if($img):
                ?>
                <div class="catalog__slide swiper-slide">
                    <picture>
                        <img alt="Image" src="<?php echo esc_url($img['url']); ?>">
                    </picture>
                    <div class="catalog__label"><?php echo esc_html($label); ?></div>
                </div>
                <?php
                        endif;
                    endforeach;
                endif;
                ?>
            </div>

            <div class="catalog__nav">
                <button type="button" class="catalog-swiper-button-prev">
                    <picture>
                        <img alt="Назад" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
                    </picture>
                </button>
                <button type="button" class="catalog-swiper-button-next">
                    <picture>
                        <img alt="Вперед" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
                    </picture>
                </button>
            </div>
        </div>
    </div>
</section>

				<section class="page__discount discount">
    <div class="discount__container">
        <h2 class="discount__title">Акційні товари</h2>
        <h3 class="discount__label">Спеціальні пропозиції</h3>
        <div data-fls-slider="" class="discount__slider swiper">
            <div class="discount__wrapper swiper-wrapper">
                <?php
                $items = get_posts([
                    'post_type' => 'discount_item',
                    'numberposts' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ]);

                if($items):
                    foreach($items as $item):
                        $img = get_field('discount_image', $item->ID);
                        $label = get_field('discount_label', $item->ID);
                        $name = get_field('discount_name', $item->ID);
                        $price = get_field('discount_price', $item->ID);
                        $link = get_field('discount_link', $item->ID);
                        if($img):
                ?>
                <div class="discount__slide swiper-slide">
                    <div class="discount__action"><?php echo esc_html($label); ?></div>
                    <div class="discount__img">
                        <img alt="<?php echo esc_attr($name); ?>" src="<?php echo esc_url($img['url']); ?>">
                    </div>
                    <div class="discount__info">
                        <?php echo esc_html($name); ?>
                        <div class="discount__nav">
                            <div class="discount__cost">
                                <span><?php echo esc_html($price); ?></span> грн
                            </div>
                            <a href="<?php echo esc_url($link); ?>" class="discount__go">
                                <picture>
                                    <img alt="До товару" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
                                </picture>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                        endif;
                    endforeach;
                endif;
                ?>
            </div>

            <div class="discount__btns">
                <button type="button" class="discount-swiper-button-prev">
                    <picture>
                        <img alt="Назад" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
                    </picture>
                </button>
                <button type="button" class="discount-swiper-button-next">
                    <picture>
                        <img alt="Вперед" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
                    </picture>
                </button>
            </div>
        </div>
    </div>
</section>

				<section class="page__about about">
					<div class="about__container">
						<h2 class="about__title">Про нас</h2>
						<h3 class="about__subtitle">Індивідуальний підхід до кожного проєкту</h3>
						<div class="about__wrapper">
							<div class="about__img">
								<picture>
									<img alt="Image" src="<?php echo get_template_directory_uri(); ?>/assets/img/about/about.webp">
								</picture>
							</div>
							<div class="about__content">
								<div class="about__text">
									Ми «Світло свята друзів- виробники якісних та довговічних вуличних гірлянд, 3D освітлення,
                        віражних та підвісних світлодіодних сіток та стовбурових ялинок ексклюзивних розмірів. З радістю
                        зробимо помітним Ваш бізнес (готель, ресторан, торговий павільйон) облаштуємо ковзанку чи
                        встановимо та освітимо найкращу ялинку. Індивідуальний підхід, робота під ключ за погодженим
                        проектом.
								</div>
								<div class="about__row">
									<div class="about__item item-about">
										<div class="item-about__img">
											<picture>
												<img alt="Image" src="<?php echo get_template_directory_uri(); ?>/assets/img/about/01.webp">
											</picture>
										</div>
										<h4 class="item-about__title">Не горять</h4>
									</div>
									<div class="about__item item-about">
										<div class="item-about__img">
											<picture>
												<img alt="Image" src="<?php echo get_template_directory_uri(); ?>/assets/img/about/02.webp">
											</picture>
										</div>
										<h4 class="item-about__title">Легкі в установці</h4>
									</div>
									<div class="about__item item-about">
										<div class="item-about__img">
											<picture>
												<img alt="Image" src="<?php echo get_template_directory_uri(); ?>/assets/img/about/03.webp">
											</picture>
										</div>
										<h4 class="item-about__title">Екологічно чисті</h4>
									</div>
									<div class="about__item item-about">
										<div class="item-about__img">
											<picture>
												<img alt="Image" src="<?php echo get_template_directory_uri(); ?>/assets/img/about/04.webp">
											</picture>
										</div>
										<h4 class="item-about__title">Точність розмірів</h4>
									</div>
									<div class="about__item item-about">
										<div class="item-about__img">
											<picture>
												<img alt="Image" src="<?php echo get_template_directory_uri(); ?>/assets/img/about/05.webp">
											</picture>
										</div>
										<h4 class="item-about__title">Довговічність</h4>
									</div>
									<div class="about__item item-about">
										<div class="item-about__img">
											<picture>
												<img alt="Image" src="<?php echo get_template_directory_uri(); ?>/assets/img/about/06.webp">
											</picture>
										</div>
										<h4 class="item-about__title">Міцність конструкції</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<section class="page__gal gal">
    <div class="gal__container">
        <h2 class="gal__title">ФОТОГАЛЕРЕЯ НАШИХ РОБІТ</h2>
        <h3 class="gal__subitlte">Індивідуальний підхід до кожного проєкту</h3>

        <div data-fls-slider="" class="gal__slider swiper">
            <div class="gal__wrapper swiper-wrapper">
                <?php
                $photos = get_posts([
                    'post_type' => 'gal_item',
                    'numberposts' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ]);

                if($photos):
                    foreach($photos as $photo):
                        $img = get_field('gal_image', $photo->ID);
                        if($img):
                ?>
                <div class="gal__slide swiper-slide">
                    <picture>
                        <img alt="<?php echo esc_attr($photo->post_title); ?>" src="<?php echo esc_url($img['url']); ?>">
                    </picture>
                </div>
                <?php
                        endif;
                    endforeach;
                endif;
                ?>
            </div>

            <div class="gal__nav">
                <button type="button" class="gal-swiper-button-prev">
                    <picture>
                        <img alt="Назад" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
                    </picture>
                </button>
                <button type="button" class="gal-swiper-button-next">
                    <picture>
                        <img alt="Вперед" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
                    </picture>
                </button>
            </div>
        </div>
    </div>
</section>

				<section class="page__video video">
    <div class="video__container">
        <h2 class="video__title">НАШІ ВІДЕО</h2>
        <h3 class="video__subtitle">Індивідуальний підхід до кожного проєкту</h3>

        <div data-fls-slider="" class="video__slider swiper">
            <div class="video__wrapper swiper-wrapper">
                <?php
                $videos = get_posts([
                    'post_type' => 'video_item',
                    'numberposts' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ]);

                if($videos):
                    foreach($videos as $video):
                        $embed = get_field('video_embed', $video->ID);
                        if($embed):
                ?>
                <div class="video__slide swiper-slide">
                    <?php echo $embed; ?>
                </div>
                <?php
                        endif;
                    endforeach;
                endif;
                ?>
            </div>

            <div class="video__nav">
                <button type="button" class="video-swiper-button-prev">
                    <picture>
                        <img alt="Назад" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
                    </picture>
                </button>
                <button type="button" class="video-swiper-button-next">
                    <picture>
                        <img alt="Вперед" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
                    </picture>
                </button>
            </div>
        </div>
    </div>
</section>

				<section class="page__partners partners">
					<div class="partners__container">
						<h2 class="partners__title">Наші партнери</h2>
						<h3 class="partners__subtitle">
							Роки нашої роботи подарували Нам чудових партнерів! Будемо раді співпраці із Вами!
						</h3>
						<div data-fls-slider="" class="partners__slider swiper">
							<div class="partners__wrapper swiper-wrapper">
								<div class="partners__slide swiper-slide">
									<picture>
										<img alt="Нова пошта" src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/01.webp">
									</picture>
								</div>
								<div class="partners__slide swiper-slide">
									<picture>
										<img alt="Епіцентр" src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/02.webp">
									</picture>
								</div>
								<div class="partners__slide swiper-slide">
									<picture>
										<img alt="Королівський смак" src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/03.webp">
									</picture>
								</div>
								<div class="partners__slide swiper-slide">
									<picture>
										<img alt="Сільпо" src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/04.webp">
									</picture>
								</div>
								<div class="partners__slide swiper-slide">
									<picture>
										<source media="(max-width: 600px)" srcset="<?php echo get_template_directory_uri(); ?>/assets/img/partners/05-600.webp" type="image/webp">
										<img alt="Фішер" src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/05.webp">
									</picture>
								</div>
								<div class="partners__slide swiper-slide">
									<picture>
										<img alt="Метінвест" src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/06.webp">
									</picture>
								</div>
								<div class="partners__slide swiper-slide">
									<picture>
										<img alt="Нова пошта" src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/01.webp">
									</picture>
								</div>
								<div class="partners__slide swiper-slide">
									<picture>
										<img alt="Епіцентр" src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/02.webp">
									</picture>
								</div>
								<div class="partners__slide swiper-slide">
									<picture>
										<img alt="Королівський смак" src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/03.webp">
									</picture>
								</div>
								<div class="partners__slide swiper-slide">
									<picture>
										<img alt="Сільпо" src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/04.webp">
									</picture>
								</div>
								<div class="partners__slide swiper-slide">
									<picture>
										<source media="(max-width: 600px)" srcset="<?php echo get_template_directory_uri(); ?>/assets/img/partners/05-600.webp" type="image/webp">
										<img alt="Фішер" src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/05.webp">
									</picture>
								</div>
								<div class="partners__slide swiper-slide">
									<picture>
										<img alt="Метінвест" src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/06.webp">
									</picture>
								</div>
							</div>
							<div class="partners__nav">
								<button type="button" class="partners-swiper-button-prev">
									<picture>
										<img alt="Назад" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
									</picture>
								</button>
								<button type="button" class="partners-swiper-button-next">
									<picture>
										<img alt="Вперед" src="<?php echo get_template_directory_uri(); ?>/assets/img/arr_slider.webp">
									</picture>
								</button>
							</div>
						</div>
					</div>
				</section>
			</main>
			<script>
				document.addEventListener("DOMContentLoaded", function () {
    // Находим все iframe с YouTube
    const iframes = document.querySelectorAll('iframe[src*="youtube.com"]');

    iframes.forEach(iframe => {
        const src = iframe.getAttribute("src");
        const videoIdMatch = src.match(/\/embed\/([a-zA-Z0-9_-]+)/);

        if (!videoIdMatch) return;
        const videoId = videoIdMatch[1];

        // Создаем обертку
        const wrapper = document.createElement("div");
        wrapper.classList.add("youtube-lazy");
        wrapper.style.position = "relative";
        wrapper.style.width = iframe.width || "560px";
        wrapper.style.height = iframe.height || "315px";
        wrapper.style.cursor = "pointer";

        // Превью
        const thumbnail = document.createElement("img");
        thumbnail.src = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
        thumbnail.style.width = "100%";
        thumbnail.style.height = "100%";
        thumbnail.style.objectFit = "cover";
        wrapper.appendChild(thumbnail);

        // Кнопка Play
        const playButton = document.createElement("div");
        playButton.style.width = "80px";
        playButton.style.height = "80px";
        playButton.style.background = "url('https://i.imgur.com/TxzC70f.png') no-repeat center center";
        playButton.style.backgroundSize = "contain";
        playButton.style.position = "absolute";
        playButton.style.top = "50%";
        playButton.style.left = "50%";
        playButton.style.transform = "translate(-50%, -50%)";
        wrapper.appendChild(playButton);

        // Клик заменяет на iframe
        wrapper.addEventListener("click", function () {
            const newIframe = document.createElement("iframe");
            newIframe.setAttribute("src", `${src}?autoplay=1`);
            newIframe.setAttribute("frameborder", "0");
            newIframe.setAttribute("allowfullscreen", "1");
            newIframe.setAttribute("allow", "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture");
            wrapper.replaceWith(newIframe);
        });

        // Заменяем оригинальный iframe на ленивую обертку
        iframe.replaceWith(wrapper);
    });
});

			</script>
<?php get_footer(); ?>
			

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
