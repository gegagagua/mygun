<?php
/* Template Name: Homepage */

get_header();

$home_shop_url = function_exists( 'mygun_get_shop_page_url' ) ? mygun_get_shop_page_url() : home_url( '/shop/' );
$home_news_url = home_url( '/news/' );
$tpl_uri       = get_template_directory_uri();

/* ------------------------------------------------------------------ *
 * Hero slides (3) — content managed in MyGun Content → Hero Slider.
 * ------------------------------------------------------------------ */
$hero_defaults = array(
	1 => array(
		'title'    => mygun_t( 'MC5 Carbine', 'MC5 კარაბინი', 'Карабин MC5' ),
		'subtitle' => mygun_t(
			'Built from a forged upper and lower AR-15 receiver with a standard barrel nut interface and mil-spec controls — made for abuse and high round counts.',
			'შექმნილია გამძლე AR-15 სისტემაზე, სტანდარტული barrel-nut ინტერფეისითა და mil-spec კონტროლებით — გათვლილია ინტენსიურ გამოყენებასა და მაღალ დატვირთვაზე.',
			'Создан на кованой ствольной коробке AR-15 со стандартным интерфейсом и mil-spec управлением — рассчитан на интенсивную эксплуатацию.'
		),
		'align'    => 'text-center',
	),
	2 => array(
		'title'    => mygun_t( 'Precision Optics & Gear', 'ზუსტი ოპტიკა და აღჭურვილობა', 'Точная оптика и снаряжение' ),
		'subtitle' => mygun_t(
			'A curated selection of premium scopes, sights and tactical accessories for every shooter.',
			'შერჩეული პრემიუმ ოპტიკა, სამიზნეები და ტაქტიკური აქსესუარები ყველა მსროლელისთვის.',
			'Отобранная премиальная оптика, прицелы и тактические аксессуары для каждого стрелка.'
		),
		'align'    => 'text-left',
	),
	3 => array(
		'title'    => mygun_t( 'Train Like a Professional', 'ივარჯიშე პროფესიონალივით', 'Тренируйся как профессионал' ),
		'subtitle' => mygun_t(
			'State-of-the-art indoor range and expert instructors for every experience level.',
			'თანამედროვე დახურული სასროლი მოედანი და გამოცდილი ინსტრუქტორები ყველა დონისთვის.',
			'Современный крытый тир и опытные инструкторы для любого уровня подготовки.'
		),
		'align'    => 'text-right',
	),
);

$hero_slides = array();
foreach ( $hero_defaults as $i => $def ) {
	$hero_slides[] = array(
		'image'     => mygun_opt_img( "hero{$i}_image", 'full', $tpl_uri . '/assets/images/sliders/' . $i . '.jpg' ),
		'thumb'     => mygun_opt_img( "hero{$i}_image", 'medium', $tpl_uri . '/assets/images/sliders/sm-' . $i . '.jpg' ),
		'title'     => mygun_opt( "hero{$i}_title", $def['title'] ),
		'subtitle'  => mygun_opt( "hero{$i}_subtitle", $def['subtitle'] ),
		'btn1_text' => mygun_opt( "hero{$i}_btn1_text", mygun_t( 'Shop Now', 'ყიდვა', 'Купить' ) ),
		'btn1_url'  => mygun_opt_raw( "hero{$i}_btn1_url", '' ) ?: $home_shop_url,
		'btn2_text' => mygun_opt( "hero{$i}_btn2_text", mygun_t( 'Read More', 'დაწვრილებით', 'Подробнее' ) ),
		'btn2_url'  => mygun_opt_raw( "hero{$i}_btn2_url", '' ) ?: $home_news_url,
		'align'     => $def['align'],
	);
}
?>

<!--Slider area start here-->
<section class="slider-area">
    <div class="container-fluid pd-0">
        <div class="row">
            <div class="col-sm-12 pd-0">
                <div class="item-content">
                    <?php foreach ( $hero_slides as $idx => $s ) : ?>
                    <div class="item-slider bg-img" style="background-image:url('<?php echo esc_url( $s['image'] ); ?>');">
                        <div class="slider_section_overlay"></div>
                        <div class="container position-relative">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="contents <?php echo esc_attr( $s['align'] ); ?>">
                                        <h2 class="wow animated fadeInUp" data-wow-duration="1s"><?php echo esc_html( $s['title'] ); ?></h2>
                                        <p class="wow animated fadeInDown" data-wow-duration="1.4s"><?php echo esc_html( $s['subtitle'] ); ?></p>
                                        <div class="buttons wow animated fadeInUp" data-wow-duration="1.8s">
                                            <a href="<?php echo esc_url( $s['btn1_url'] ); ?>" class="btn1"><?php echo esc_html( $s['btn1_text'] ); ?></a>
                                            <a href="<?php echo esc_url( $s['btn2_url'] ); ?>" class="btn2"><?php echo esc_html( $s['btn2_text'] ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-sm-12 pd-0">
                    <div class="item-thumbnail">
                        <?php foreach ( $hero_slides as $idx => $s ) : ?>
                        <a href="#" class="col-sm-4" data-slide-index="<?php echo (int) $idx; ?>">
                            <div class="items">
                                <div class="dbox">
                                    <div class="dleft">
                                        <figure><img src="<?php echo esc_url( $s['thumb'] ); ?>" alt="<?php echo esc_attr( $s['title'] ); ?>"></figure>
                                    </div>
                                    <div class="dright">
                                        <div class="content">
                                            <h3><?php echo esc_html( $s['title'] ); ?></h3>
                                            <p><?php echo esc_html( wp_trim_words( $s['subtitle'], 5, '…' ) ); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Slider area end here-->

<!--Products area start here-->
<section class="products-area section">
    <div class="container">
        <?php
        $home_latest_products = new WP_Query(
            array(
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'posts_per_page'      => 12,
                'orderby'             => 'date',
                'order'               => 'DESC',
                'no_found_rows'       => true,
                'ignore_sticky_posts' => true,
            )
        );
        ?>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="section-heading">
                    <h2><?php echo esc_html( mygun_opt( 'products_heading', mygun_t( 'Our Products', 'ჩვენი პროდუქტები', 'Наши товары' ) ) ); ?></h2>
                    <p><?php echo esc_html( mygun_opt( 'products_subheading', mygun_t( 'All modern weapon enthusiasts can appreciate our broad services and premium support.', 'თანამედროვე იარაღის მოყვარულებისთვის გთავაზობთ ფართო სერვისებსა და ხარისხიან მხარდაჭერას.', 'Ценители современного оружия оценят наш широкий сервис и премиальную поддержку.' ) ) ); ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 pro-ctg">
                <div class="row">
                    <?php
                    $home_product_terms = get_terms( array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                        'number'     => 4,
                        'orderby'    => 'count',
                        'order'      => 'DESC',
                    ) );

                    if ( ! empty( $home_product_terms ) && ! is_wp_error( $home_product_terms ) ) :
                        foreach ( $home_product_terms as $cat_index => $home_term ) :
                            $cat_display_name = $home_term->name;
                            $term_icon_meta = get_term_meta( $home_term->term_id, 'icon', true );
                            if ( empty( $term_icon_meta ) ) { $term_icon_meta = get_term_meta( $home_term->term_id, 'thumbnail_id', true ); }

                            $cat_icon_url = '';
                            if ( is_numeric( $term_icon_meta ) ) {
                                $cat_icon_url = wp_get_attachment_image_url( (int) $term_icon_meta, 'medium' );
                            } elseif ( is_string( $term_icon_meta ) && filter_var( $term_icon_meta, FILTER_VALIDATE_URL ) ) {
                                $cat_icon_url = $term_icon_meta;
                            }
                            if ( empty( $cat_icon_url ) ) {
                                $cat_icon_url = $tpl_uri . '/assets/images/products/' . ( ( $cat_index % 4 ) + 1 ) . '.png';
                            }
                            $cat_link = add_query_arg( array( 'product_cat' => $home_term->slug ), $home_shop_url );
                            $cat_cnt  = function_exists( 'mygun_count_products_in_product_cat' ) ? mygun_count_products_in_product_cat( $home_term->term_id ) : (int) $home_term->count;
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <a href="<?php echo esc_url( $cat_link ); ?>" class="mygun-home-cat-card-link">
                            <div class="catagories-lists">
                                <div class="contents">
                                    <span class="mygun-home-cat-count" aria-label="<?php echo esc_attr( mygun_t( 'Products', 'პროდუქტი', 'товаров' ) ); ?>"><?php echo esc_html( (string) $cat_cnt ); ?></span>
                                    <figure><img src="<?php echo esc_url( $cat_icon_url ); ?>" alt="<?php echo esc_attr( $cat_display_name ); ?>" /></figure>
                                    <h3><?php echo esc_html( $cat_display_name ); ?></h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 pd-0">
                <?php if ( $home_latest_products->have_posts() ) : ?>
                <div class="pro-sliders mygun-home-latest-products">
                    <?php
                    $home_pl_def = $tpl_uri . '/assets/images/products/1.jpg';
                    while ( $home_latest_products->have_posts() ) :
                        $home_latest_products->the_post();
                        $hp_id    = get_the_ID();
                        $hp_title = get_the_title();
                        $hp_link  = get_permalink( $hp_id );

                        $hp_price = get_post_meta( $hp_id, '_price', true );
                        if ( '' === $hp_price || null === $hp_price ) { $hp_price = get_post_meta( $hp_id, '_regular_price', true ); }
                        if ( '' === $hp_price || null === $hp_price ) { $hp_price = get_post_meta( $hp_id, '_product_price', true ); }
                        $hp_price_disp = ( '' !== $hp_price && null !== $hp_price && is_numeric( $hp_price ) )
                            ? number_format_i18n( (float) $hp_price, 0 ) . ' ₾'
                            : mygun_t( 'Price on request', 'ფასი მოთხოვნით', 'Цена по запросу' );

                        $hp_thumb = get_the_post_thumbnail_url( $hp_id, 'product-thumb' );
                        if ( ! $hp_thumb ) { $hp_thumb = $home_pl_def; }
                    ?>
                    <div class="col-sm-12">
                        <div class="products mygun-home-product-card">
                            <a href="<?php echo esc_url( $hp_link ); ?>" class="mygun-home-product-thumb-link">
                                <figure><img src="<?php echo esc_url( $hp_thumb ); ?>" alt="<?php echo esc_attr( $hp_title ); ?>" /></figure>
                            </a>
                            <div class="contents">
                                <h3><a href="<?php echo esc_url( $hp_link ); ?>"><?php echo esc_html( $hp_title ); ?></a></h3>
                                <span><?php echo esc_html( $hp_price_disp ); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
                <?php else : ?>
                    <p class="mygun-home-no-products text-center"><?php echo esc_html( mygun_t( 'No products listed yet.', 'პროდუქტები ჯერ არ არის.', 'Товары пока не добавлены.' ) ); ?></p>
                <?php endif; ?>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="load-btn text-center">
                    <a href="<?php echo esc_url( $home_shop_url ); ?>" class="btn1"><?php echo esc_html( mygun_opt( 'products_btn', mygun_t( 'View All', 'ყველას ნახვა', 'Смотреть все' ) ) ); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Products area end here-->

<!--About area start here-->
<section class="about-area section">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="section-heading2">
                    <h2><?php echo esc_html( mygun_opt( 'about_heading', mygun_t( 'Who We Are', 'ვინ ვართ ჩვენ', 'Кто мы' ) ) ); ?></h2>
                </div>
                <div class="about-contents">
                    <p><?php echo esc_html( mygun_opt( 'about_text1', mygun_t( 'With state-of-the-art indoor training facilities and a full-service custom shop, we can accommodate most requests.', 'თანამედროვე დახურული სასწავლო ინფრასტრუქტურითა და სრულფასოვანი სერვისით, ჩვენ ვაკმაყოფილებთ თქვენს უმეტეს მოთხოვნას.', 'Благодаря современному крытому тренировочному центру и полному сервису мы можем удовлетворить большинство запросов.' ) ) ); ?></p>
                    <blockquote><?php echo esc_html( mygun_opt( 'about_quote', mygun_t( 'This platform modernizes the purchasing process and gives customers a faster, easier experience.', 'ეს პლატფორმა შესყიდვის პროცესს ამარტივებს და მომხმარებელს აძლევს უფრო სწრაფ და მოსახერხებელ გამოცდილებას.', 'Эта платформа упрощает процесс покупки и делает опыт клиента быстрее и удобнее.' ) ) ); ?></blockquote>
                    <p><?php echo esc_html( mygun_opt( 'about_text2', mygun_t( 'Our experienced team provides broad services and practical support for modern weapon enthusiasts.', 'ჩვენი გამოცდილი გუნდი თანამედროვე იარაღის მოყვარულებს სთავაზობს ფართო სერვისებსა და პრაქტიკულ მხარდაჭერას.', 'Наша опытная команда предоставляет широкий сервис и практическую поддержку ценителям современного оружия.' ) ) ); ?></p>
                    <div class="buttons">
                        <a href="<?php echo esc_url( mygun_opt_raw( 'about_btn1_url', '' ) ?: $home_news_url ); ?>" class="btn1"><?php echo esc_html( mygun_opt( 'about_btn1_text', mygun_t( 'Read More', 'დაწვრილებით', 'Подробнее' ) ) ); ?></a>
                        <a href="<?php echo esc_url( mygun_opt_raw( 'about_btn2_url', '' ) ?: $home_shop_url ); ?>" class="btn2"><?php echo esc_html( mygun_opt( 'about_btn2_text', mygun_t( 'Shop', 'მაღაზია', 'Магазин' ) ) ); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12">
                <div class="about-cata">
                    <?php
                    $about_services = array(
                        1 => array( 'title' => mygun_t( 'Hunting', 'ნადირობა', 'Охота' ),          'icon' => $tpl_uri . '/assets/images/icons/01.png' ),
                        2 => array( 'title' => mygun_t( 'Training', 'ვარჯიში', 'Тренировки' ),      'icon' => $tpl_uri . '/assets/images/icons/02.png' ),
                        3 => array( 'title' => mygun_t( 'Shooting Range', 'სასროლი მოედანი', 'Тир' ), 'icon' => $tpl_uri . '/assets/images/icons/03.png' ),
                    );
                    foreach ( $about_services as $si => $sv ) :
                        $s_title = mygun_opt( "about_s{$si}_title", $sv['title'] );
                        $s_url   = mygun_opt_raw( "about_s{$si}_url", '' ) ?: '#';
                        $s_icon  = mygun_opt_img( "about_s{$si}_icon", 'medium', $sv['icon'] );
                    ?>
                    <div class="cata-list">
                        <div class="dbox">
                            <div class="dleft">
                                <div class="content">
                                    <h4><?php echo esc_html( $s_title ); ?></h4>
                                    <a href="<?php echo esc_url( $s_url ); ?>" class="btn3"><?php echo esc_html( mygun_t( 'Read More', 'დაწვრილებით', 'Подробнее' ) ); ?> <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="dright">
                                <div class="cate-ico"><img src="<?php echo esc_url( $s_icon ); ?>" alt="<?php echo esc_attr( $s_title ); ?>" /></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--About area end here-->

<!--Gallery area start here-->
<section class="gallery-area section2 section position-relative">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="section-heading">
                    <h2><?php echo esc_html( mygun_opt( 'gallery_heading', mygun_t( 'Video Gallery', 'ვიდეო გალერეა', 'Видеогалерея' ) ) ); ?></h2>
                    <p><?php echo esc_html( mygun_opt( 'gallery_subheading', mygun_t( 'Watch our latest weapon showcases and video highlights.', 'ნახეთ ჩვენი უახლესი იარაღის მიმოხილვები და ვიდეო გამორჩეულები.', 'Смотрите наши последние обзоры оружия и видео.' ) ) ); ?></p>
                </div>
            </div>
        </div>
        <div class="gallery row">
            <?php
            $gallery_defaults = array( 1, 5, 2, 3, 4 );
            $gallery_cols     = array( 'col-md-6', 'col-md-6', 'col-md-4', 'col-md-4', 'col-md-4' );
            foreach ( $gallery_defaults as $gi_index => $gnum ) :
                $i        = $gi_index + 1;
                $g_img    = mygun_opt_img( "gallery{$i}_image", 'large', $tpl_uri . '/assets/images/gallery/' . $gnum . '.jpg' );
                $g_full   = mygun_opt_img( "gallery{$i}_image", 'full', $tpl_uri . '/assets/images/gallery/' . $gnum . '.jpg' );
                $g_title  = mygun_opt( "gallery{$i}_title", mygun_t( 'Range Session', 'სასროლი სესია', 'Стрельбы' ) );
                $g_desc   = mygun_opt( "gallery{$i}_desc", mygun_t( 'Modern weapon enthusiasts enjoy our broad services.', 'თანამედროვე იარაღის მოყვარულებისთვის გვაქვს ფართო სერვისები.', 'Ценители современного оружия пользуются нашим широким сервисом.' ) );
                $g_col    = isset( $gallery_cols[ $gi_index ] ) ? $gallery_cols[ $gi_index ] : 'col-md-4';
            ?>
            <div class="<?php echo esc_attr( $g_col ); ?> col-sm-6 col-xs-12">
                <div class="gimg">
                    <figure>
                        <a href="<?php echo esc_url( $g_full ); ?>">
                            <img src="<?php echo esc_url( $g_img ); ?>" alt="<?php echo esc_attr( $g_title ); ?>" />
                            <div class="con-pop"><span><i class="fas fa-search"></i></span></div>
                        </a>
                        <div class="content">
                            <h3><?php echo esc_html( $g_title ); ?></h3>
                            <p><?php echo esc_html( $g_desc ); ?></p>
                        </div>
                    </figure>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!--Gallery area end here-->

<!--Training area Start here-->
<?php
$training_enabled = mygun_opt_raw( 'training_enabled', '0' ) === '1';
$training_phone   = mygun_opt_raw( 'training_phone', '+995 555 555 555' );
?>
<section class="training-area section af">
    <div class="container">
        <?php if ( ! $training_enabled ) : ?>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <p class="mygun-training-soon-banner" role="status"><?php echo esc_html( mygun_opt( 'training_badge', mygun_t( 'Coming soon', 'მალე იქნება', 'Скоро' ) ) ); ?></p>
            </div>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="training-forms">
                    <form action="#" method="post" onsubmit="return false;">
                        <fieldset <?php echo $training_enabled ? '' : 'disabled'; ?> class="<?php echo $training_enabled ? '' : 'mygun-training-form-disabled'; ?>" aria-disabled="<?php echo $training_enabled ? 'false' : 'true'; ?>">
                        <fieldset><input type="text" placeholder="<?php echo esc_attr( mygun_t( 'Full Name', 'სრული სახელი', 'Полное имя' ) ); ?>"></fieldset>
                        <fieldset><input type="email" placeholder="<?php echo esc_attr( mygun_t( 'Email Address', 'ელფოსტის მისამართი', 'Адрес эл. почты' ) ); ?>"></fieldset>
                        <fieldset><input type="text" placeholder="<?php echo esc_attr( mygun_t( 'Phone No.', 'ტელეფონის ნომერი', 'Номер телефона' ) ); ?>"></fieldset>
                        <fieldset>
                            <select>
                                <option><?php echo esc_html( mygun_t( 'Weapon / Plans', 'იარაღი / გეგმები', 'Оружие / планы' ) ); ?></option>
                                <option><?php echo esc_html( mygun_t( 'Basic Training Plan', 'საბაზისო სასწავლო გეგმა', 'Базовый план' ) ); ?></option>
                                <option><?php echo esc_html( mygun_t( 'Advanced Training Plan', 'გაფართოებული სასწავლო გეგმა', 'Продвинутый план' ) ); ?></option>
                                <option><?php echo esc_html( mygun_t( 'Premium Shooting Plan', 'პრემიუმ სასროლო გეგმა', 'Премиум план' ) ); ?></option>
                            </select>
                        </fieldset>
                        <fieldset class="arrows">
                            <div class="row">
                                <div class="col-md-5 col-sm-6 pd-0">
                                    <select>
                                        <option><?php echo esc_html( mygun_t( 'Gender', 'სქესი', 'Пол' ) ); ?></option>
                                        <option><?php echo esc_html( mygun_t( 'Male', 'კაცი', 'Мужской' ) ); ?></option>
                                        <option><?php echo esc_html( mygun_t( 'Female', 'ქალი', 'Женский' ) ); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-7 col-sm-6 pd-r0">
                                    <input type="number" placeholder="<?php echo esc_attr( mygun_t( 'Age', 'ასაკი', 'Возраст' ) ); ?>">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset><textarea placeholder="<?php echo esc_attr( mygun_t( 'Message', 'შეტყობინება', 'Сообщение' ) ); ?>"></textarea></fieldset>
                        <button type="submit" class="btn1"><?php echo esc_html( mygun_t( 'Send Now', 'გაგზავნა', 'Отправить' ) ); ?></button>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="training-con pd-t60">
                    <h2><?php echo esc_html( mygun_opt( 'training_heading', mygun_t( 'Weapon Trainings', 'იარაღის ვარჯიშები', 'Оружейные тренировки' ) ) ); ?></h2>
                    <p><?php echo esc_html( mygun_opt( 'training_text1', mygun_t( 'With state-of-the-art indoor training facilities and full-service custom shop, we can accommodate most requests.', 'თანამედროვე ინფრასტრუქტურითა და სრულფასოვანი სერვისით, ჩვენ ვაკმაყოფილებთ თქვენს მოთხოვნებს.', 'С современным крытым тренировочным центром и полным сервисом мы удовлетворим большинство запросов.' ) ) ); ?></p>
                    <h1>P. <?php echo esc_html( $training_phone ); ?></h1>
                    <p><?php echo esc_html( mygun_opt( 'training_text2', mygun_t( 'Our team provides practical guidance, safe training methods, and personalized support for all experience levels.', 'ჩვენი გუნდი გთავაზობთ პრაქტიკულ გზამკვლევს, უსაფრთხო ვარჯიშის მეთოდებსა და ინდივიდუალურ მხარდაჭერას ყველა დონეზე.', 'Наша команда обеспечивает практическое руководство, безопасные методы тренировок и индивидуальную поддержку для всех уровней.' ) ) ); ?></p>
                    <ul>
                        <li><i class="fas fa-long-arrow-alt-right"></i><?php echo esc_html( mygun_opt( 'training_f1', mygun_t( 'Handgun Training Full Pack', 'პისტოლეტის სრული სასწავლო პაკეტი', 'Полный курс по пистолету' ) ) ); ?></li>
                        <li><i class="fas fa-long-arrow-alt-right"></i><?php echo esc_html( mygun_opt( 'training_f2', mygun_t( 'Machine Gun CS5 Full Pack', 'ავტომატის CS5 სრული პაკეტი', 'Полный курс CS5' ) ) ); ?></li>
                        <li><i class="fas fa-long-arrow-alt-right"></i><?php echo esc_html( mygun_opt( 'training_f3', mygun_t( 'Custom Shooting Range Training', 'ინდივიდუალური სასროლო მოედნის ვარჯიში', 'Индивидуальные занятия в тире' ) ) ); ?></li>
                        <li><i class="fas fa-long-arrow-alt-right"></i><?php echo esc_html( mygun_opt( 'training_f4', mygun_t( 'Hunting and Tactical Shooting Programs', 'ნადირობისა და ტაქტიკური სროლის პროგრამები', 'Программы охоты и тактической стрельбы' ) ) ); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Training area End here-->

<!--Blog area start here-->
<?php
$hp_news_posts = get_posts( array(
    'post_type'      => array( 'news', 'post' ),
    'numberposts'    => 10,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
));

if ( ! empty( $hp_news_posts ) ) :
    $featured    = $hp_news_posts[0];
    $f_cats      = get_the_terms( $featured->ID, 'news_cat' );
    if ( ! $f_cats || is_wp_error( $f_cats ) ) { $f_cats = get_the_terms( $featured->ID, 'category' ); }
    $f_cat_names = ( $f_cats && ! is_wp_error( $f_cats ) ) ? implode( ', ', wp_list_pluck( $f_cats, 'name' ) ) : '';
    $f_thumb     = get_the_post_thumbnail_url( $featured->ID, 'large' );

    $slider_posts = array_slice( $hp_news_posts, 1 );
    if ( empty( $slider_posts ) ) { $slider_posts = $hp_news_posts; }
    while ( count( $slider_posts ) < 3 ) { $slider_posts = array_merge( $slider_posts, $hp_news_posts ); }
    $slider_posts = array_slice( $slider_posts, 0, 7 );

    $read_more = mygun_t( 'Read More', 'სრულად', 'Подробнее' );
?>
<section class="blog-area section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="section-heading">
                    <h2><?php echo esc_html( mygun_opt( 'news_heading', mygun_t( 'Latest News', 'სიახლეები', 'Новости' ) ) ); ?></h2>
                    <p><?php echo esc_html( mygun_opt( 'news_subheading', mygun_t( 'Stay up to date with our latest news and updates.', 'იყავი კურსში უახლესი სიახლეებისა და განახლებების შესახებ.', 'Будьте в курсе наших последних новостей и обновлений.' ) ) ); ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 pd-0">
                <div class="news_left_wrapper"<?php if ( $f_thumb ) : ?> style="background-image:url('<?php echo esc_url( $f_thumb ); ?>');"<?php endif; ?>>
                    <div class="news_left_img_overlay"></div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="news_left_cont position-relative">
                                <?php if ( $f_cat_names ) : ?><p><i><?php echo esc_html( $f_cat_names ); ?></i></p><?php endif; ?>
                                <div class="heart_box"><a href="<?php echo esc_url( get_permalink( $featured->ID ) ); ?>"><i class="fa fa-heart"></i></a></div>
                                <h6><i class="fa fa-calendar-alt"></i><?php echo esc_html( get_the_date( 'd M Y', $featured->ID ) ); ?></h6>
                                <h3><?php echo esc_html( $featured->post_title ); ?></h3>
                                <h5><a href="<?php echo esc_url( get_permalink( $featured->ID ) ); ?>"><?php echo esc_html( $read_more ); ?></a> &nbsp;<i class="fa fa-long-arrow-alt-right"></i></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 pd-0">
                <div class="ln-sliders">
                    <?php foreach ( $slider_posts as $sp ) :
                        $s_cats = get_the_terms( $sp->ID, 'news_cat' );
                        if ( ! $s_cats || is_wp_error( $s_cats ) ) { $s_cats = get_the_terms( $sp->ID, 'category' ); }
                        $s_cat_names = ( $s_cats && ! is_wp_error( $s_cats ) ) ? implode( ', ', wp_list_pluck( $s_cats, 'name' ) ) : '';
                    ?>
                    <div class="col-sm-12">
                        <div class="main_news_right_box">
                            <div class="news_right_box1_wrapper">
                                <div class="news_right_box1">
                                    <?php if ( $s_cat_names ) : ?><p><?php echo esc_html( $s_cat_names ); ?></p><?php endif; ?>
                                    <h3><?php echo esc_html( $sp->post_title ); ?></h3>
                                    <h6><i class="fa fa-calendar-alt"></i><?php echo esc_html( get_the_date( 'd M Y', $sp->ID ) ); ?></h6>
                                    <div class="news_border_bottom"></div>
                                </div>
                            </div>
                            <div class="news_botton_cont">
                                <p><?php echo esc_html( wp_trim_words( $sp->post_excerpt ? $sp->post_excerpt : $sp->post_content, 12, '…' ) ); ?></p>
                                <h5><a href="<?php echo esc_url( get_permalink( $sp->ID ) ); ?>"><?php echo esc_html( $read_more ); ?></a> &nbsp;<i class="fa fa-long-arrow-alt-right"></i></h5>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<!--Blog area end here-->

<!--Subscribe area start here-->
<section class="subscribe-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="subscribe">
                    <span class="ico"><i class="far fa-envelope"></i></span>
                    <div class="conts">
                        <h2><?php echo esc_html( mygun_opt( 'subscribe_heading', mygun_t( 'Get Our Latest News', 'მიიღეთ უახლესი სიახლეები', 'Получайте наши новости' ) ) ); ?></h2>
                        <p><?php echo esc_html( mygun_opt( 'subscribe_text', mygun_t( 'Subscribe to our newsletter now!', 'გამოიწერეთ ჩვენი ნიუსლეთერი ახლავე!', 'Подпишитесь на нашу рассылку!' ) ) ); ?></p>
                    </div>
                    <form>
                        <input type="email" placeholder="<?php echo esc_attr( mygun_t( 'Email Address', 'ელფოსტის მისამართი', 'Адрес эл. почты' ) ); ?>">
                        <button type="submit" class="btn1"><?php echo esc_html( mygun_opt( 'subscribe_btn', mygun_t( 'Subscribe', 'გამოწერა', 'Подписаться' ) ) ); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Subscribe area End here-->

<?php get_footer(); ?>
