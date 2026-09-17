<?php
/**
 * Local WordPress bootstrap for admin-side operations run from the CLI
 * (adding Polylang languages, seeding theme options, creating translations).
 *
 * Usage: /Applications/XAMPP/xamppfiles/bin/php mygun-cli.php <task>
 *   info | add-ru | seed-options | create-ru-pages
 *
 * This is a development helper; remove before deploying to production.
 */

define( 'WP_USE_THEMES', false );
$_SERVER['HTTP_HOST']   = 'localhost';
$_SERVER['REQUEST_URI'] = '/mygun/';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '80';

require __DIR__ . '/wp-load.php';

if ( PHP_SAPI !== 'cli' ) {
	wp_die( 'CLI only.' );
}

$task = isset( $argv[1] ) ? $argv[1] : 'info';

/** Build an i18n value array. */
function mg( $ka, $en, $ru ) {
	return array( 'ka' => $ka, 'en' => $en, 'ru' => $ru );
}

switch ( $task ) {

	case 'info':
		echo 'Site: ' . get_bloginfo( 'name' ) . "\n";
		if ( function_exists( 'pll_languages_list' ) ) {
			echo 'Langs: ' . implode( ',', pll_languages_list() ) . "\n";
		}
		break;

	case 'add-ru':
		if ( in_array( 'ru', pll_languages_list(), true ) ) {
			echo "Russian already present.\n";
			break;
		}
		$res = PLL()->model->languages->add( array(
			'name' => 'Русский', 'slug' => 'ru', 'locale' => 'ru_RU', 'rtl' => false, 'term_group' => 2, 'flag' => 'ru',
		) );
		echo is_wp_error( $res ) ? 'ERROR: ' . $res->get_error_message() . "\n" : "Russian added.\n";
		break;

	case 'seed-options':
		$opts = get_option( 'mygun_options', array() );
		if ( ! is_array( $opts ) ) { $opts = array(); }

		$seed = array(
			// General & contact
			'contact_phone'   => '+995 555 12 34 56',
			'contact_phone2'  => '+995 322 22 33 44',
			'contact_email'   => 'info@mygun.ge',
			'contact_address' => mg( 'თბილისი, ვაჟა-ფშაველას გამზ. 71, საქართველო', 'Tbilisi, 71 Vazha-Pshavela Ave, Georgia', 'Тбилиси, пр. Важа-Пшавела 71, Грузия' ),
			'contact_hours'   => mg( 'ორშ–შაბ: 10:00 – 19:00', 'Mon–Sat: 10:00 – 19:00', 'Пн–Сб: 10:00 – 19:00' ),
			'social_facebook' => 'https://facebook.com/',
			'social_youtube'  => 'https://youtube.com/',
			'social_instagram'=> 'https://instagram.com/',

			// Hero slide 1
			'hero1_title'    => mg( 'MC5 კარაბინი', 'MC5 Carbine', 'Карабин MC5' ),
			'hero1_subtitle' => mg( 'შექმნილია გამძლე AR-15 სისტემაზე, სტანდარტული barrel-nut ინტერფეისითა და mil-spec კონტროლებით — გათვლილია ინტენსიურ გამოყენებაზე.', 'Built on a forged AR-15 platform with a standard barrel-nut interface and mil-spec controls — made for abuse and high round counts.', 'Создан на кованой платформе AR-15 со стандартным интерфейсом и mil-spec управлением — рассчитан на интенсивную эксплуатацию.' ),
			'hero1_btn1_text'=> mg( 'ყიდვა', 'Shop Now', 'Купить' ),
			'hero1_btn2_text'=> mg( 'დაწვრილებით', 'Read More', 'Подробнее' ),
			// Hero slide 2
			'hero2_title'    => mg( 'ზუსტი ოპტიკა და აღჭურვილობა', 'Precision Optics & Gear', 'Точная оптика и снаряжение' ),
			'hero2_subtitle' => mg( 'შერჩეული პრემიუმ ოპტიკა, სამიზნეები და ტაქტიკური აქსესუარები ყველა მსროლელისთვის.', 'A curated selection of premium scopes, sights and tactical accessories for every shooter.', 'Отобранная премиальная оптика, прицелы и тактические аксессуары для каждого стрелка.' ),
			'hero2_btn1_text'=> mg( 'ყიდვა', 'Shop Now', 'Купить' ),
			'hero2_btn2_text'=> mg( 'დაწვრილებით', 'Read More', 'Подробнее' ),
			// Hero slide 3
			'hero3_title'    => mg( 'ივარჯიშე პროფესიონალივით', 'Train Like a Professional', 'Тренируйся как профессионал' ),
			'hero3_subtitle' => mg( 'თანამედროვე დახურული სასროლი მოედანი და გამოცდილი ინსტრუქტორები ყველა დონისთვის.', 'State-of-the-art indoor range and expert instructors for every experience level.', 'Современный крытый тир и опытные инструкторы для любого уровня.' ),
			'hero3_btn1_text'=> mg( 'დაჯავშნა', 'Book Now', 'Забронировать' ),
			'hero3_btn2_text'=> mg( 'დაწვრილებით', 'Read More', 'Подробнее' ),

			// Products section
			'products_heading'    => mg( 'ჩვენი პროდუქტები', 'Our Products', 'Наши товары' ),
			'products_subheading' => mg( 'თანამედროვე იარაღის მოყვარულებისთვის გთავაზობთ ფართო სერვისებსა და ხარისხიან მხარდაჭერას.', 'All modern weapon enthusiasts can appreciate our broad services and premium support.', 'Ценители современного оружия оценят наш широкий сервис и премиальную поддержку.' ),
			'products_btn'        => mg( 'ყველას ნახვა', 'View All', 'Смотреть все' ),

			// About
			'about_heading'  => mg( 'ვინ ვართ ჩვენ', 'Who We Are', 'Кто мы' ),
			'about_text1'    => mg( 'თანამედროვე დახურული სასწავლო ინფრასტრუქტურითა და სრულფასოვანი სერვისით, ჩვენ ვაკმაყოფილებთ თქვენს უმეტეს მოთხოვნას.', 'With state-of-the-art indoor training facilities and a full-service custom shop, we can accommodate most requests.', 'Благодаря современному крытому центру и полному сервису мы удовлетворяем большинство запросов.' ),
			'about_quote'    => mg( 'ეს პლატფორმა შესყიდვის პროცესს ამარტივებს და მომხმარებელს აძლევს უფრო სწრაფ და მოსახერხებელ გამოცდილებას.', 'This platform modernizes the purchasing process and gives customers a faster, easier experience.', 'Эта платформа упрощает процесс покупки и делает опыт клиента быстрее и удобнее.' ),
			'about_text2'    => mg( 'ჩვენი გამოცდილი გუნდი თანამედროვე იარაღის მოყვარულებს სთავაზობს ფართო სერვისებსა და პრაქტიკულ მხარდაჭერას.', 'Our experienced team provides broad services and practical support for modern weapon enthusiasts.', 'Наша опытная команда предоставляет широкий сервис и практическую поддержку ценителям современного оружия.' ),
			'about_btn1_text'=> mg( 'დაწვრილებით', 'Read More', 'Подробнее' ),
			'about_btn2_text'=> mg( 'მაღაზია', 'Shop', 'Магазин' ),
			'about_s1_title' => mg( 'ნადირობა', 'Hunting', 'Охота' ),
			'about_s2_title' => mg( 'ვარჯიში', 'Training', 'Тренировки' ),
			'about_s3_title' => mg( 'სასროლი მოედანი', 'Shooting Range', 'Тир' ),

			// Gallery
			'gallery_heading'    => mg( 'ვიდეო გალერეა', 'Video Gallery', 'Видеогалерея' ),
			'gallery_subheading' => mg( 'ნახეთ ჩვენი უახლესი იარაღის მიმოხილვები და ვიდეო გამორჩეულები.', 'Watch our latest weapon showcases and video highlights.', 'Смотрите наши последние обзоры оружия и лучшие видео.' ),
			'gallery1_title' => mg( 'სასროლი სესია', 'Range Session', 'Стрельбы' ),
			'gallery1_desc'  => mg( 'თანამედროვე იარაღის მოყვარულებისთვის გვაქვს ფართო სერვისები.', 'Modern weapon enthusiasts enjoy our broad services.', 'Ценители современного оружия пользуются нашим сервисом.' ),
			'gallery2_title' => mg( 'ტაქტიკური ვარჯიში', 'Tactical Drill', 'Тактическая тренировка' ),
			'gallery2_desc'  => mg( 'პრაქტიკული ვარჯიში გამოცდილ ინსტრუქტორებთან ერთად.', 'Practical training with experienced instructors.', 'Практические занятия с опытными инструкторами.' ),
			'gallery3_title' => mg( 'ოპტიკის ტესტი', 'Optics Test', 'Тест оптики' ),
			'gallery3_desc'  => mg( 'უახლესი ოპტიკის მიმოხილვა და შედარება.', 'Reviews and comparisons of the latest optics.', 'Обзоры и сравнения новейшей оптики.' ),
			'gallery4_title' => mg( 'ნადირობის დღე', 'Hunting Day', 'День охоты' ),
			'gallery4_desc'  => mg( 'აღჭურვილობა და რჩევები ნადირობისთვის.', 'Gear and tips for a successful hunt.', 'Снаряжение и советы для успешной охоты.' ),
			'gallery5_title' => mg( 'ახალი კოლექცია', 'New Collection', 'Новая коллекция' ),
			'gallery5_desc'  => mg( 'გაეცანით ჩვენს უახლეს შემოსვლებს.', 'Explore our latest arrivals.', 'Ознакомьтесь с новыми поступлениями.' ),

			// Training
			'training_enabled' => '0',
			'training_badge'   => mg( 'მალე იქნება', 'Coming soon', 'Скоро' ),
			'training_heading' => mg( 'იარაღის ვარჯიშები', 'Weapon Trainings', 'Оружейные тренировки' ),
			'training_text1'   => mg( 'თანამედროვე ინფრასტრუქტურითა და სრულფასოვანი სერვისით, ჩვენ ვაკმაყოფილებთ თქვენს მოთხოვნებს.', 'With state-of-the-art indoor facilities and a full-service shop, we can accommodate most requests.', 'С современным крытым центром и полным сервисом мы удовлетворим большинство запросов.' ),
			'training_phone'   => '+995 555 12 34 56',
			'training_text2'   => mg( 'ჩვენი გუნდი გთავაზობთ პრაქტიკულ გზამკვლევს, უსაფრთხო ვარჯიშის მეთოდებსა და ინდივიდუალურ მხარდაჭერას ყველა დონეზე.', 'Our team provides practical guidance, safe training methods, and personalized support for all levels.', 'Наша команда обеспечивает практическое руководство, безопасные методы и индивидуальную поддержку.' ),
			'training_f1'      => mg( 'პისტოლეტის სრული სასწავლო პაკეტი', 'Handgun Training Full Pack', 'Полный курс по пистолету' ),
			'training_f2'      => mg( 'ავტომატის CS5 სრული პაკეტი', 'Machine Gun CS5 Full Pack', 'Полный курс CS5' ),
			'training_f3'      => mg( 'ინდივიდუალური სასროლო მოედნის ვარჯიში', 'Custom Shooting Range Training', 'Индивидуальные занятия в тире' ),
			'training_f4'      => mg( 'ნადირობისა და ტაქტიკური სროლის პროგრამები', 'Hunting and Tactical Shooting Programs', 'Программы охоты и тактической стрельбы' ),

			// News
			'news_heading'    => mg( 'სიახლეები', 'Latest News', 'Новости' ),
			'news_subheading' => mg( 'იყავი კურსში უახლესი სიახლეებისა და განახლებების შესახებ.', 'Stay up to date with our latest news and updates.', 'Будьте в курсе наших последних новостей и обновлений.' ),

			// Subscribe
			'subscribe_heading' => mg( 'მიიღეთ უახლესი სიახლეები', 'Get Our Latest News', 'Получайте наши новости' ),
			'subscribe_text'    => mg( 'გამოიწერეთ ჩვენი ნიუსლეთერი ახლავე!', 'Subscribe to our newsletter now!', 'Подпишитесь на нашу рассылку!' ),
			'subscribe_btn'     => mg( 'გამოწერა', 'Subscribe', 'Подписаться' ),

			// Footer
			'footer_about'        => mg( 'თანამედროვე იარაღის მოყვარულებისთვის გვაქვს ფართო სერვისები და გამოცდილი მხარდაჭერის გუნდი.', 'All modern weapon enthusiasts can appreciate our broad services and experienced support team.', 'Все ценители современного оружия оценят наш широкий сервис и опытную команду поддержки.' ),
			'footer_shop_heading' => mg( 'პროდუქტების მაღაზია', 'Product Shop', 'Магазин товаров' ),
			'footer_shop_text'    => mg( 'მეტი პროდუქტისა და შეთავაზებისთვის დააჭირეთ აქ!', 'For more products and offers, click here!', 'Больше товаров и предложений — нажмите здесь!' ),
			'footer_copyright'    => mg( '© %year% MyGun. ყველა უფლება დაცულია.', '© %year% MyGun. All rights reserved.', '© %year% MyGun. Все права защищены.' ),
			'footer_link1_text'   => mg( 'კონფიდენციალურობის პოლიტიკა', 'Privacy Policy', 'Политика конфиденциальности' ),
			'footer_link2_text'   => mg( 'წესები და პირობები', 'Terms & Conditions', 'Условия использования' ),

			// Contact page
			'contactp_heading'      => mg( 'დაგვიკავშირდით', 'Contact Us', 'Свяжитесь с нами' ),
			'contactp_subheading'   => mg( 'დაგვიკავშირდით — ჩვენი გუნდი მზადაა დაგეხმაროთ ნებისმიერ კითხვაზე.', 'Reach out to us — our team is ready to help with any question.', 'Свяжитесь с нами — наша команда готова помочь с любым вопросом.' ),
			'contactp_form_heading' => mg( 'მოგვწერეთ', 'Get in Touch', 'Напишите нам' ),
			'contactp_info_heading' => mg( 'საკონტაქტო ინფორმაცია', 'Contact Information', 'Контактная информация' ),
		);

		foreach ( $seed as $k => $v ) {
			$opts[ $k ] = $v; // seed overwrites so admin reflects current defaults
		}
		update_option( 'mygun_options', $opts );
		echo 'Seeded ' . count( $seed ) . " option keys.\n";
		break;

	case 'create-ru-pages':
		if ( ! function_exists( 'pll_set_post_language' ) ) {
			echo "Polylang not available.\n";
			break;
		}

		// template => [ ru title, ru slug ]
		$targets = array(
			'templates/tpl-homepage.php'    => array( 'Главная', 'glavnaya' ),
			'templates/tpl-contact.php'     => array( 'Контакты', 'kontakty' ),
			'templates/tpl-shop.php'        => array( 'Магазин', 'magazin' ),
			'templates/tpl-add-product.php' => array( 'Добавить товар', 'dobavit-tovar' ),
			'templates/tpl-profile.php'     => array( 'Профиль', 'profil-ru' ),
			'templates/tpl-news.php'        => array( 'Новости', 'novosti' ),
			'templates/tpl-videos.php'      => array( 'Видео', 'video-ru' ),
		);

		foreach ( $targets as $template => $meta ) {
			$pages = get_pages( array(
				'meta_key'    => '_wp_page_template',
				'meta_value'  => $template,
				'number'      => 0,
			) );
			if ( empty( $pages ) ) {
				echo "  [skip] no page for {$template}\n";
				continue;
			}

			// Pick a base page that has a language; prefer en.
			$base = null;
			foreach ( $pages as $p ) {
				$pl = pll_get_post_language( $p->ID );
				if ( 'en' === $pl ) { $base = $p; break; }
				if ( ! $base && $pl ) { $base = $p; }
			}
			if ( ! $base ) { $base = $pages[0]; }

			$translations = pll_get_post_translations( $base->ID );
			if ( ! empty( $translations['ru'] ) && get_post( $translations['ru'] ) ) {
				echo "  [ok] ru exists for {$template} (#{$translations['ru']})\n";
				continue;
			}

			$new_id = wp_insert_post( array(
				'post_title'  => $meta[0],
				'post_name'   => $meta[1],
				'post_status' => 'publish',
				'post_type'   => 'page',
				'post_content'=> $base->post_content,
			) );
			if ( is_wp_error( $new_id ) ) {
				echo "  [err] {$template}: " . $new_id->get_error_message() . "\n";
				continue;
			}
			update_post_meta( $new_id, '_wp_page_template', $template );
			pll_set_post_language( $new_id, 'ru' );

			$translations['ru'] = $new_id;
			pll_save_post_translations( $translations );

			echo "  [new] ru page for {$template} -> #{$new_id}\n";
		}
		echo "Done.\n";
		break;

	case 'create-ru-menu':
		if ( ! function_exists( 'pll_get_post' ) ) {
			echo "Polylang not available.\n";
			break;
		}
		$menu_name = 'Russian menu';
		$menu      = wp_get_nav_menu_object( $menu_name );
		$menu_id   = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( $menu_name );
		if ( is_wp_error( $menu_id ) || ! $menu_id ) {
			echo "Failed to create menu.\n";
			break;
		}

		// Clear existing items to avoid duplicates on re-run.
		foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $it ) {
			wp_delete_post( $it->ID, true );
		}

		// Mirror the English menu (id 2) structure, pointing at RU translations.
		$source_items = wp_get_nav_menu_items( 2 );
		if ( $source_items ) {
			foreach ( $source_items as $si ) {
				$ru_target = ( 'post_type' === $si->type ) ? pll_get_post( (int) $si->object_id, 'ru' ) : 0;
				if ( ! $ru_target ) {
					continue;
				}
				wp_update_nav_menu_item( $menu_id, 0, array(
					'menu-item-title'     => get_the_title( $ru_target ),
					'menu-item-object'    => 'page',
					'menu-item-object-id' => (int) $ru_target,
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				) );
			}
		}

		// Register the menu for the 'ru' language in the Polylang option.
		$pll = get_option( 'polylang' );
		if ( ! isset( $pll['nav_menus']['mygun']['menu-1'] ) || ! is_array( $pll['nav_menus']['mygun']['menu-1'] ) ) {
			$pll['nav_menus']['mygun']['menu-1'] = array();
		}
		$pll['nav_menus']['mygun']['menu-1']['ru'] = $menu_id;
		update_option( 'polylang', $pll );

		echo "Russian menu #{$menu_id} created with " . count( wp_get_nav_menu_items( $menu_id ) ) . " items and assigned to ru.\n";
		break;

	default:
		echo "Unknown task: {$task}\n";
		break;
}
