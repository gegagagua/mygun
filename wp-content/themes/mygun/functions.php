<?php
/**
 * mygun functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mygun
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
function mygun_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on mygun, use a find and replace
		* to change 'mygun' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'mygun', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'mygun' ),
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

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'mygun_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

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
add_action( 'after_setup_theme', 'mygun_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mygun_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mygun_content_width', 640 );
}
add_action( 'after_setup_theme', 'mygun_content_width', 0 );

/**
 * Permalink for the page using the Shop template (templates/tpl-shop.php).
 * Respects Polylang translation for the current language when available.
 *
 * @return string
 */
function mygun_get_shop_page_url() {
	$pages = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'templates/tpl-shop.php',
			'number'     => 1,
		)
	);
	if ( empty( $pages ) ) {
		return home_url( '/shop/' );
	}
	$page_id = (int) $pages[0]->ID;
	if ( function_exists( 'pll_get_post' ) && function_exists( 'pll_current_language' ) ) {
		$translated = pll_get_post( $page_id, pll_current_language() );
		if ( $translated ) {
			$page_id = (int) $translated;
		}
	}
	$permalink = get_permalink( $page_id );
	return $permalink ? $permalink : home_url( '/shop/' );
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mygun_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'mygun' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'mygun' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'mygun_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mygun_scripts() {
	wp_enqueue_style( 'mygun-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'mygun-style', 'rtl', 'replace' );

	// Modern typography (Latin + Cyrillic via Oswald/Manrope, Georgian via Noto Sans Georgian).
	wp_enqueue_style(
		'mygun-fonts',
		'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&family=Noto+Sans+Georgian:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Dark-tactical design system — loaded last so it layers over the legacy CSS.
	wp_enqueue_style( 'mygun-modern', get_template_directory_uri() . '/assets/css/mygun-modern.css', array( 'mygun-style' ), _S_VERSION );

	wp_enqueue_script( 'mygun-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mygun_scripts' );

/**
 * Custom fallback for desktop menu when no WP menu is assigned.
 */
function mygun_fallback_menu() {
	echo '<ul class="mamnu">';
	wp_list_pages( array(
		'title_li' => '',
		'depth'    => 2,
	));
	echo '</ul>';
}

/**
 * Get current Polylang language slug.
 */
function mygun_get_lang() {
	return function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
}

/**
 * Pick a string for a given language code (used in AJAX handlers where the
 * language arrives via POST). Falls back ru→en→ka, en→ka, ka→en.
 */
function mygun_lang_pick( $lang, $en, $ka, $ru = '' ) {
	if ( 'en' === $lang ) { return '' !== $en ? $en : $ka; }
	if ( 'ru' === $lang ) { return '' !== $ru ? $ru : ( '' !== $en ? $en : $ka ); }
	return '' !== $ka ? $ka : $en;
}


/**
 * Output localized data for front-end scripts (loaded directly in footer.php).
 */
function mygun_auth_inline_data() {
	?>
	<script>
		var mygun_auth = <?php echo json_encode( array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'lang'     => mygun_get_lang(),
		)); ?>;
	</script>
	<?php
}
add_action( 'wp_footer', 'mygun_auth_inline_data', 5 );

/**
 * AJAX Login Handler
 */
function mygun_ajax_login() {
	$lang = isset( $_POST['lang'] ) ? sanitize_text_field( $_POST['lang'] ) : 'ka';

	// Verify nonce
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mygun_login_nonce' ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Security check failed.', 'უსაფრთხოების შემოწმება ვერ მოხერხდა.', 'Проверка безопасности не пройдена.' ) ) );
	}

	$username = sanitize_text_field( $_POST['username'] );
	$password = $_POST['password'];
	$remember = isset( $_POST['remember'] ) && $_POST['remember'] == 1;

	if ( empty( $username ) || empty( $password ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Please fill in all fields.', 'გთხოვთ შეავსოთ ყველა ველი.', 'Пожалуйста, заполните все поля.' ) ) );
	}

	$creds = array(
		'user_login'    => $username,
		'user_password' => $password,
		'remember'      => $remember,
	);

	$user = wp_signon( $creds, false );

	if ( is_wp_error( $user ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Invalid username or password.', 'არასწორი მომხმარებლის სახელი ან პაროლი.', 'Неверное имя пользователя или пароль.' ) ) );
	}

	wp_send_json_success( array( 'message' => mygun_lang_pick( $lang, 'Successfully logged in!', 'წარმატებით შეხვედით სისტემაში!', 'Вы успешно вошли в систему!' ) ) );
}
add_action( 'wp_ajax_nopriv_mygun_login', 'mygun_ajax_login' );
add_action( 'wp_ajax_mygun_login', 'mygun_ajax_login' );

/**
 * AJAX Register Handler
 */
function mygun_ajax_register() {
	$lang = isset( $_POST['lang'] ) ? sanitize_text_field( $_POST['lang'] ) : 'ka';

	// Verify nonce
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mygun_register_nonce' ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Security check failed.', 'უსაფრთხოების შემოწმება ვერ მოხერხდა.', 'Проверка безопасности не пройдена.' ) ) );
	}

	$username = sanitize_user( $_POST['username'] );
	$email    = sanitize_email( $_POST['email'] );
	$password = $_POST['password'];

	// Validate
	if ( empty( $username ) || empty( $email ) || empty( $password ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Please fill in all fields.', 'გთხოვთ შეავსოთ ყველა ველი.', 'Пожалуйста, заполните все поля.' ) ) );
	}

	if ( strlen( $username ) < 3 ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Username must be at least 3 characters.', 'მომხმარებლის სახელი უნდა შეიცავდეს მინიმუმ 3 სიმბოლოს.', 'Имя пользователя должно содержать минимум 3 символа.' ) ) );
	}

	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Please enter a valid email address.', 'გთხოვთ შეიყვანოთ სწორი ელფოსტის მისამართი.', 'Пожалуйста, введите корректный адрес эл. почты.' ) ) );
	}

	if ( strlen( $password ) < 6 ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Password must be at least 6 characters.', 'პაროლი უნდა შეიცავდეს მინიმუმ 6 სიმბოლოს.', 'Пароль должен содержать минимум 6 символов.' ) ) );
	}

	if ( username_exists( $username ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'This username is already taken.', 'ეს მომხმარებლის სახელი უკვე დაკავებულია.', 'Это имя пользователя уже занято.' ) ) );
	}

	if ( email_exists( $email ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'This email is already registered.', 'ეს ელფოსტა უკვე რეგისტრირებულია.', 'Этот email уже зарегистрирован.' ) ) );
	}

	$user_id = wp_create_user( $username, $password, $email );

	if ( is_wp_error( $user_id ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Registration failed. Please try again later.', 'რეგისტრაცია ვერ მოხერხდა. სცადეთ მოგვიანებით.', 'Регистрация не удалась. Повторите попытку позже.' ) ) );
	}

	// Auto-login after registration
	wp_set_current_user( $user_id );
	wp_set_auth_cookie( $user_id );

	wp_send_json_success( array( 'message' => mygun_lang_pick( $lang, 'Registration completed successfully!', 'რეგისტრაცია წარმატებით დასრულდა!', 'Регистрация успешно завершена!' ) ) );
}
add_action( 'wp_ajax_nopriv_mygun_register', 'mygun_ajax_register' );
add_action( 'wp_ajax_mygun_register', 'mygun_ajax_register' );

/**
 * Register Product Custom Post Type and Taxonomy.
 *
 * When WooCommerce is active it already registers the `product` post type and
 * `product_cat` taxonomy. Re-registering here overwrites WooCommerce's args
 * (capabilities, supports, admin UI) and can break the Products admin screen.
 */
function mygun_register_product_cpt() {
	if ( class_exists( 'WooCommerce' ) ) {
		return;
	}

	register_post_type( 'product', array(
		'labels' => array(
			'name'               => 'Products',
			'singular_name'      => 'Product',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Product',
			'edit_item'          => 'Edit Product',
			'view_item'          => 'View Product',
			'all_items'          => 'All Products',
			'search_items'       => 'Search Products',
			'not_found'          => 'No products found',
			'not_found_in_trash' => 'No products found in Trash',
		),
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'products' ),
		'supports'     => array( 'title', 'editor', 'thumbnail', 'author' ),
		'menu_icon'    => 'dashicons-cart',
		'show_in_rest' => true,
	));

	register_taxonomy( 'product_cat', 'product', array(
		'labels' => array(
			'name'          => 'Product Categories',
			'singular_name' => 'Product Category',
			'search_items'  => 'Search Categories',
			'all_items'     => 'All Categories',
			'parent_item'   => 'Parent Category',
			'edit_item'     => 'Edit Category',
			'add_new_item'  => 'Add New Category',
		),
		'hierarchical' => true,
		'public'       => true,
		'rewrite'      => array( 'slug' => 'product-category' ),
		'show_in_rest' => true,
	));
}
add_action( 'init', 'mygun_register_product_cpt' );

/**
 * Count published products in a product_cat term (matches shop query; includes child categories).
 *
 * @param int  $term_id Term ID.
 * @param bool $include_children Whether to count posts in child terms.
 * @return int
 */
function mygun_count_products_in_product_cat( $term_id, $include_children = true ) {
	static $cache = array();
	$term_id = (int) $term_id;
	if ( $term_id <= 0 ) {
		return 0;
	}
	$key = $term_id . ':' . ( $include_children ? '1' : '0' );
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}
	$q = new WP_Query(
		array(
			'post_type'              => 'product',
			'post_status'            => 'publish',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => false,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'tax_query'              => array(
				array(
					'taxonomy'         => 'product_cat',
					'field'            => 'term_id',
					'terms'            => $term_id,
					'include_children' => $include_children,
				),
			),
		)
	);
	$cache[ $key ] = (int) $q->found_posts;
	wp_reset_postdata();
	return $cache[ $key ];
}

/**
 * Register News Custom Post Type and Taxonomy.
 */
function mygun_register_news_cpt() {
	register_post_type( 'news', array(
		'labels' => array(
			'name'               => 'News',
			'singular_name'      => 'News',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add News',
			'edit_item'          => 'Edit News',
			'view_item'          => 'View News',
			'all_items'          => 'All News',
			'search_items'       => 'Search News',
			'not_found'          => 'No news found',
			'not_found_in_trash' => 'No news found in Trash',
		),
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'news' ),
		'supports'     => array( 'title', 'editor', 'thumbnail', 'author', 'excerpt' ),
		'menu_icon'    => 'dashicons-megaphone',
		'show_in_rest' => true,
	));

	register_taxonomy( 'news_cat', 'news', array(
		'labels' => array(
			'name'          => 'News Categories',
			'singular_name' => 'News Category',
			'search_items'  => 'Search Categories',
			'all_items'     => 'All Categories',
			'parent_item'   => 'Parent Category',
			'edit_item'     => 'Edit Category',
			'add_new_item'  => 'Add New Category',
		),
		'hierarchical' => true,
		'public'       => true,
		'rewrite'      => array( 'slug' => 'news-category' ),
		'show_in_rest' => true,
	));
}
add_action( 'init', 'mygun_register_news_cpt' );

/**
 * Register Video Gallery Custom Post Type.
 * Fields: title, featured image, youtube url (meta box).
 */
function mygun_register_video_cpt() {
	register_post_type( 'video_gallery', array(
		'labels' => array(
			'name'               => 'Video Gallery',
			'singular_name'      => 'Video',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Video',
			'edit_item'          => 'Edit Video',
			'view_item'          => 'View Video',
			'all_items'          => 'All Videos',
			'search_items'       => 'Search Videos',
			'not_found'          => 'No videos found',
			'not_found_in_trash' => 'No videos found in Trash',
		),
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'videos' ),
		'supports'     => array( 'title', 'thumbnail' ),
		'menu_icon'    => 'dashicons-video-alt3',
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'mygun_register_video_cpt' );

/**
 * Video Gallery meta box: YouTube URL field.
 */
function mygun_add_video_meta_box() {
	add_meta_box(
		'mygun_video_youtube_url',
		'YouTube URL',
		'mygun_render_video_meta_box',
		'video_gallery',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'mygun_add_video_meta_box' );

/**
 * Render YouTube URL field for video post type.
 */
function mygun_render_video_meta_box( $post ) {
	wp_nonce_field( 'mygun_save_video_youtube_url', 'mygun_video_youtube_nonce' );
	$youtube_url = get_post_meta( $post->ID, '_youtube_url', true );
	?>
	<p>
		<label for="mygun_youtube_url"><strong><?php echo esc_html__( 'YouTube URL', 'mygun' ); ?></strong></label>
	</p>
	<input
		type="url"
		id="mygun_youtube_url"
		name="mygun_youtube_url"
		value="<?php echo esc_attr( $youtube_url ); ?>"
		placeholder="https://www.youtube.com/watch?v=..."
		style="width:100%;"
	/>
	<?php
}

/**
 * Save YouTube URL for video post type.
 */
function mygun_save_video_meta_box( $post_id ) {
	if ( ! isset( $_POST['mygun_video_youtube_nonce'] ) || ! wp_verify_nonce( $_POST['mygun_video_youtube_nonce'], 'mygun_save_video_youtube_url' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( isset( $_POST['post_type'] ) && 'video_gallery' !== $_POST['post_type'] ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$youtube_url = isset( $_POST['mygun_youtube_url'] ) ? esc_url_raw( wp_unslash( $_POST['mygun_youtube_url'] ) ) : '';

	if ( '' !== $youtube_url ) {
		update_post_meta( $post_id, '_youtube_url', $youtube_url );
	} else {
		delete_post_meta( $post_id, '_youtube_url' );
	}
}
add_action( 'save_post', 'mygun_save_video_meta_box' );

add_image_size( 'news-thumb', 600, 400, true );
add_image_size( 'news-single', 1200, 500, true );

/**
 * Add product image sizes.
 */
add_image_size( 'product-thumb', 600, 600, true );
add_image_size( 'product-gallery', 800, 800, true );

/**
 * AJAX Add Product Handler.
 */
function mygun_ajax_add_product() {
	$lang = isset( $_POST['lang'] ) ? sanitize_text_field( $_POST['lang'] ) : 'ka';

	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'You must be logged in.', 'ავტორიზაცია აუცილებელია.', 'Необходимо войти в систему.' ) ) );
	}

	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mygun_add_product_nonce' ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Security check failed.', 'უსაფრთხოების შემოწმება ვერ მოხერხდა.', 'Проверка безопасности не пройдена.' ) ) );
	}

	$title       = sanitize_text_field( $_POST['product_title'] );
	$description = wp_kses_post( $_POST['product_description'] );
	$price       = sanitize_text_field( $_POST['product_price'] );
	$category    = isset( $_POST['product_category'] ) ? intval( $_POST['product_category'] ) : 0;
	$phone       = sanitize_text_field( $_POST['product_phone'] ?? '' );
	$condition   = sanitize_text_field( $_POST['product_condition'] ?? 'new' );

	// Validate
	if ( empty( $title ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Please enter a product name.', 'გთხოვთ შეიყვანოთ პროდუქტის სახელი.', 'Пожалуйста, введите название товара.' ) ) );
	}
	if ( empty( $price ) || ! is_numeric( $price ) || floatval( $price ) < 0 ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Please enter a valid price.', 'გთხოვთ შეიყვანოთ სწორი ფასი.', 'Пожалуйста, введите корректную цену.' ) ) );
	}
	if ( empty( $description ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Please enter a description.', 'გთხოვთ შეიყვანოთ აღწერა.', 'Пожалуйста, введите описание.' ) ) );
	}

	// Create product post
	$post_data = array(
		'post_title'   => $title,
		'post_content' => $description,
		'post_status'  => 'publish',
		'post_type'    => 'product',
		'post_author'  => get_current_user_id(),
	);

	$post_id = wp_insert_post( $post_data );

	if ( is_wp_error( $post_id ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Failed to add product. Please try again.', 'პროდუქტის დამატება ვერ მოხერხდა. სცადეთ თავიდან.', 'Не удалось добавить товар. Попробуйте снова.' ) ) );
	}

	// Save meta fields
	update_post_meta( $post_id, '_product_price', floatval( $price ) );
	update_post_meta( $post_id, '_product_phone', $phone );
	update_post_meta( $post_id, '_product_condition', $condition );

	// Set category
	if ( $category > 0 ) {
		wp_set_object_terms( $post_id, $category, 'product_cat' );
	}

	$location_label = '';
	$loc_slug       = isset( $_POST['mygun_location'] ) ? sanitize_title( wp_unslash( $_POST['mygun_location'] ) ) : '';
	if ( $loc_slug && taxonomy_exists( 'mygun_location' ) && term_exists( $loc_slug, 'mygun_location' ) ) {
		wp_set_object_terms( $post_id, array( $loc_slug ), 'mygun_location', false );
		$t = get_term_by( 'slug', $loc_slug, 'mygun_location' );
		if ( $t && ! is_wp_error( $t ) ) {
			$location_label = function_exists( 'mygun_product_spec_term_label' ) ? mygun_product_spec_term_label( $t, $lang === 'en' ? 'en' : 'ka' ) : $t->name;
		}
	} elseif ( ! empty( $_POST['product_location'] ) ) {
		$location_label = sanitize_text_field( wp_unslash( $_POST['product_location'] ) );
	}
	update_post_meta( $post_id, '_product_location', $location_label );

	$caliber_slug = isset( $_POST['mygun_caliber'] ) ? sanitize_title( wp_unslash( $_POST['mygun_caliber'] ) ) : '';
	if ( $caliber_slug && taxonomy_exists( 'mygun_caliber' ) && term_exists( $caliber_slug, 'mygun_caliber' ) ) {
		wp_set_object_terms( $post_id, array( $caliber_slug ), 'mygun_caliber', false );
	}

	$firearm_slug = isset( $_POST['mygun_firearm_type'] ) ? sanitize_title( wp_unslash( $_POST['mygun_firearm_type'] ) ) : '';
	if ( $firearm_slug && taxonomy_exists( 'mygun_firearm_type' ) && term_exists( $firearm_slug, 'mygun_firearm_type' ) ) {
		wp_set_object_terms( $post_id, array( $firearm_slug ), 'mygun_firearm_type', false );
	}

	$stock_inc = isset( $_POST['mygun_stock_included'] ) ? sanitize_text_field( wp_unslash( $_POST['mygun_stock_included'] ) ) : '';
	if ( in_array( $stock_inc, array( '', 'yes', 'no' ), true ) ) {
		update_post_meta( $post_id, '_mygun_stock_included', $stock_inc );
	}

	$body_slug = isset( $_POST['mygun_body'] ) ? sanitize_title( wp_unslash( $_POST['mygun_body'] ) ) : '';
	if ( $body_slug && taxonomy_exists( 'mygun_body' ) && term_exists( $body_slug, 'mygun_body' ) ) {
		wp_set_object_terms( $post_id, array( $body_slug ), 'mygun_body', false );
	}

	$len_mm = isset( $_POST['mygun_length_mm'] ) ? sanitize_text_field( wp_unslash( $_POST['mygun_length_mm'] ) ) : '';
	$len_mm = $len_mm === '' ? '' : max( 0, (int) $len_mm );
	update_post_meta( $post_id, '_mygun_length_mm', $len_mm );

	$w_g = isset( $_POST['mygun_weight_g'] ) ? sanitize_text_field( wp_unslash( $_POST['mygun_weight_g'] ) ) : '';
	$w_g = $w_g === '' ? '' : max( 0, (int) $w_g );
	update_post_meta( $post_id, '_mygun_weight_g', $w_g );

	$mfc = isset( $_POST['mygun_manufacturer_country'] ) ? strtolower( sanitize_text_field( wp_unslash( $_POST['mygun_manufacturer_country'] ) ) ) : '';
	if ( $mfc !== '' && function_exists( 'mygun_manufacturer_country_is_valid_slug' ) && mygun_manufacturer_country_is_valid_slug( $mfc ) ) {
		update_post_meta( $post_id, '_mygun_manufacturer_country', $mfc );
	}

	// Handle featured image
	if ( ! empty( $_FILES['product_image'] ) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$attachment_id = media_handle_upload( 'product_image', $post_id );
		if ( ! is_wp_error( $attachment_id ) ) {
			set_post_thumbnail( $post_id, $attachment_id );
		}
	}

	// Handle gallery images
	if ( ! empty( $_FILES['product_gallery'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$gallery_ids = array();
		$files       = $_FILES['product_gallery'];

		if ( is_array( $files['name'] ) ) {
			for ( $i = 0; $i < count( $files['name'] ); $i++ ) {
				if ( $files['error'][ $i ] !== UPLOAD_ERR_OK ) continue;

				$_FILES['product_gallery_single'] = array(
					'name'     => $files['name'][ $i ],
					'type'     => $files['type'][ $i ],
					'tmp_name' => $files['tmp_name'][ $i ],
					'error'    => $files['error'][ $i ],
					'size'     => $files['size'][ $i ],
				);

				$gal_id = media_handle_upload( 'product_gallery_single', $post_id );
				if ( ! is_wp_error( $gal_id ) ) {
					$gallery_ids[] = $gal_id;
				}
			}
		}

		if ( ! empty( $gallery_ids ) ) {
			update_post_meta( $post_id, '_product_gallery', implode( ',', $gallery_ids ) );
		}
	}

	wp_send_json_success( array(
		'message' => mygun_lang_pick( $lang, 'Product added successfully! It will be visible after approval.', 'პროდუქტი წარმატებით დაემატა! ის ხილული გახდება დამტკიცების შემდეგ.', 'Товар успешно добавлен! Он появится после проверки.' ),
	));
}
add_action( 'wp_ajax_mygun_add_product', 'mygun_ajax_add_product' );

/**
 * AJAX Update Profile Handler.
 */
function mygun_ajax_update_profile() {
	$lang = isset( $_POST['lang'] ) ? sanitize_text_field( $_POST['lang'] ) : 'ka';

	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'You must be logged in.', 'ავტორიზაცია აუცილებელია.', 'Необходимо войти в систему.' ) ) );
	}

	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mygun_update_profile_nonce' ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Security check failed.', 'უსაფრთხოების შემოწმება ვერ მოხერხდა.', 'Проверка безопасности не пройдена.' ) ) );
	}

	$user_id      = get_current_user_id();
	$display_name = sanitize_text_field( $_POST['display_name'] );
	$phone        = sanitize_text_field( $_POST['phone'] ?? '' );
	$bio          = sanitize_textarea_field( $_POST['bio'] ?? '' );

	if ( empty( $display_name ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Please enter a display name.', 'გთხოვთ შეიყვანოთ სახელი.', 'Пожалуйста, введите отображаемое имя.' ) ) );
	}

	$result = wp_update_user( array(
		'ID'           => $user_id,
		'display_name' => $display_name,
		'description'  => $bio,
	));

	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Failed to update profile.', 'პროფილის განახლება ვერ მოხერხდა.', 'Не удалось обновить профиль.' ) ) );
	}

	update_user_meta( $user_id, '_user_phone', $phone );

	wp_send_json_success( array( 'message' => mygun_lang_pick( $lang, 'Profile updated successfully!', 'პროფილი წარმატებით განახლდა!', 'Профиль успешно обновлён!' ) ) );
}
add_action( 'wp_ajax_mygun_update_profile', 'mygun_ajax_update_profile' );

/**
 * AJAX Change Password Handler.
 */
function mygun_ajax_change_password() {
	$lang = isset( $_POST['lang'] ) ? sanitize_text_field( $_POST['lang'] ) : 'ka';

	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'You must be logged in.', 'ავტორიზაცია აუცილებელია.', 'Необходимо войти в систему.' ) ) );
	}

	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mygun_change_password_nonce' ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Security check failed.', 'უსაფრთხოების შემოწმება ვერ მოხერხდა.', 'Проверка безопасности не пройдена.' ) ) );
	}

	$user         = wp_get_current_user();
	$current_pass = $_POST['current_password'];
	$new_pass     = $_POST['new_password'];

	if ( empty( $current_pass ) || empty( $new_pass ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Please fill in all fields.', 'გთხოვთ შეავსოთ ყველა ველი.', 'Пожалуйста, заполните все поля.' ) ) );
	}

	if ( ! wp_check_password( $current_pass, $user->user_pass, $user->ID ) ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'Current password is incorrect.', 'მიმდინარე პაროლი არასწორია.', 'Текущий пароль неверен.' ) ) );
	}

	if ( strlen( $new_pass ) < 6 ) {
		wp_send_json_error( array( 'message' => mygun_lang_pick( $lang, 'New password must be at least 6 characters.', 'ახალი პაროლი უნდა შეიცავდეს მინიმუმ 6 სიმბოლოს.', 'Новый пароль должен содержать минимум 6 символов.' ) ) );
	}

	wp_set_password( $new_pass, $user->ID );

	// Re-authenticate to keep user logged in
	wp_set_current_user( $user->ID );
	wp_set_auth_cookie( $user->ID );

	wp_send_json_success( array( 'message' => mygun_lang_pick( $lang, 'Password changed successfully!', 'პაროლი წარმატებით შეიცვალა!', 'Пароль успешно изменён!' ) ) );
}
add_action( 'wp_ajax_mygun_change_password', 'mygun_ajax_change_password' );

/**
 * AJAX Contact Form Handler.
 */
function mygun_ajax_contact_form() {
	$lang = isset( $_POST['lang'] ) ? sanitize_text_field( $_POST['lang'] ) : mygun_get_lang();

	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mygun_contact_nonce' ) ) {
		wp_send_json_error( array(
			'message' => mygun_lang_pick( $lang, 'Security check failed.', 'უსაფრთხოების შემოწმება ვერ მოხერხდა.', 'Проверка безопасности не пройдена.' ),
		) );
	}

	$full_name = isset( $_POST['full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['full_name'] ) ) : '';
	$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$subject   = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
	$message   = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $full_name || '' === $email || '' === $message ) {
		wp_send_json_error( array(
			'message' => mygun_lang_pick( $lang, 'Please fill in all required fields.', 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი.', 'Пожалуйста, заполните все обязательные поля.' ),
		) );
	}

	if ( ! is_email( $email ) ) {
		wp_send_json_error( array(
			'message' => mygun_lang_pick( $lang, 'Please enter a valid email address.', 'გთხოვთ შეიყვანოთ სწორი ელფოსტის მისამართი.', 'Пожалуйста, введите корректный адрес эл. почты.' ),
		) );
	}

	$to          = 'gegagagua@gmail.com';
	$mail_subject = $subject ? $subject : ( mygun_lang_pick( $lang, 'New contact message from website', 'ახალი კონტაქტის შეტყობინება საიტიდან', 'Новое сообщение с сайта' ) );
	$mail_body    = "Name: {$full_name}\n";
	$mail_body   .= "Email: {$email}\n";
	$mail_body   .= "Subject: {$subject}\n\n";
	$mail_body   .= "Message:\n{$message}\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $full_name . ' <' . $email . '>',
	);

	$sent = wp_mail( $to, $mail_subject, $mail_body, $headers );

	if ( ! $sent ) {
		wp_send_json_error( array(
			'message' => mygun_lang_pick( $lang, 'Failed to send message. Please try again later.', 'შეტყობინების გაგზავნა ვერ მოხერხდა. სცადეთ მოგვიანებით.', 'Не удалось отправить сообщение. Повторите попытку позже.' ),
		) );
	}

	wp_send_json_success( array(
		'message' => mygun_lang_pick( $lang, 'Your message has been sent successfully!', 'თქვენი შეტყობინება წარმატებით გაიგზავნა!', 'Ваше сообщение успешно отправлено!' ),
	) );
}
add_action( 'wp_ajax_nopriv_mygun_contact_form', 'mygun_ajax_contact_form' );
add_action( 'wp_ajax_mygun_contact_form', 'mygun_ajax_contact_form' );

/**
 * Merge WooCommerce "Additional information" into "Description" tab.
 */
function mygun_merge_woo_product_tabs( $tabs ) {
	if ( isset( $tabs['description'] ) ) {
		$tabs['description']['callback'] = 'mygun_render_merged_description_tab';
	}

	if ( isset( $tabs['additional_information'] ) ) {
		unset( $tabs['additional_information'] );
	}

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'mygun_merge_woo_product_tabs', 98 );

/**
 * Render merged WooCommerce tab content.
 */
function mygun_render_merged_description_tab() {
	global $post;

	// Default WooCommerce description output.
	if ( $post instanceof WP_Post ) {
		$description = apply_filters( 'the_content', $post->post_content );
		if ( $description ) {
			echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

/**
 * Theme content options (3-language admin content manager).
 */
require get_template_directory() . '/inc/mygun-theme-options.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/mygun-product-spec.php';
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/* ------------------------------------------------------------------
 * YouTube Videos page support (YouTube Data API v3)
 * ---------------------------------------------------------------- */

/**
 * Return the configured YouTube Data API key.
 * Prefers the MYGUN_YOUTUBE_API_KEY constant (wp-config.php), then the option.
 */
function mygun_youtube_api_key() {
	if ( defined( 'MYGUN_YOUTUBE_API_KEY' ) && MYGUN_YOUTUBE_API_KEY ) {
		return MYGUN_YOUTUBE_API_KEY;
	}
	return trim( (string) get_option( 'mygun_youtube_api_key', '' ) );
}

/**
 * Referer sent with API requests. YouTube Data API keys are often restricted
 * to a specific site (HTTP referrer restriction); server-side calls send no
 * referrer, so we set it explicitly. Falls back to the site URL.
 */
function mygun_youtube_referer() {
	if ( defined( 'MYGUN_YOUTUBE_REFERER' ) && MYGUN_YOUTUBE_REFERER ) {
		$ref = MYGUN_YOUTUBE_REFERER;
	} else {
		$ref = trim( (string) get_option( 'mygun_youtube_referer', '' ) );
	}
	if ( '' === $ref ) {
		$ref = home_url( '/' );
	}
	return apply_filters( 'mygun_youtube_referer', $ref );
}

/**
 * Default request args (incl. Referer header) for YouTube API calls.
 */
function mygun_youtube_request_args() {
	return array(
		'timeout' => 15,
		'headers' => array( 'Referer' => mygun_youtube_referer() ),
	);
}

/**
 * List of YouTube channel handles (or IDs / URLs) to pull videos from.
 */
function mygun_youtube_channels() {
	$stored  = (string) get_option( 'mygun_youtube_handles', '' );
	$handles = array();

	if ( trim( $stored ) !== '' ) {
		foreach ( preg_split( '/\r\n|\r|\n/', $stored ) as $line ) {
			$line = trim( $line );
			if ( $line === '' ) {
				continue;
			}
			// Accept a full channel URL, an @handle, or a bare handle/ID.
			if ( preg_match( '#youtube\.com/(?:@|channel/)?([^/?\s]+)#u', $line, $m ) ) {
				$line = $m[1];
			}
			$handles[] = ltrim( $line, '@' );
		}
	}

	if ( empty( $handles ) ) {
		$handles = array(
			'adventureslifegeo',
			'იარაღისგანხილვაზურაკვანჭახაძე',
			'SSBBMarket',
			'Practical-shooting',
		);
	}

	return apply_filters( 'mygun_youtube_channels', $handles );
}

/**
 * Resolve a channel handle/ID into its uploads playlist + title.
 *
 * @return array|false { id, uploads, title, thumb }
 */
function mygun_youtube_resolve_channel( $handle, $api_key ) {
	$handle = ltrim( $handle, '@' );

	// A raw channel ID: derive the uploads playlist directly (UC... -> UU...).
	if ( preg_match( '/^UC[A-Za-z0-9_-]{22}$/', $handle ) ) {
		return array(
			'id'      => $handle,
			'uploads' => 'UU' . substr( $handle, 2 ),
			'title'   => $handle,
			'thumb'   => '',
		);
	}

	$url  = 'https://www.googleapis.com/youtube/v3/channels?part=contentDetails,snippet'
		. '&forHandle=' . rawurlencode( '@' . $handle )
		. '&key=' . rawurlencode( $api_key );
	$resp = wp_remote_get( $url, mygun_youtube_request_args() );

	if ( is_wp_error( $resp ) ) {
		return false;
	}

	$body = json_decode( wp_remote_retrieve_body( $resp ), true );
	if ( empty( $body['items'][0] ) ) {
		return false;
	}

	$item = $body['items'][0];

	return array(
		'id'      => isset( $item['id'] ) ? $item['id'] : '',
		'uploads' => isset( $item['contentDetails']['relatedPlaylists']['uploads'] ) ? $item['contentDetails']['relatedPlaylists']['uploads'] : '',
		'title'   => isset( $item['snippet']['title'] ) ? $item['snippet']['title'] : $handle,
		'thumb'   => isset( $item['snippet']['thumbnails']['default']['url'] ) ? $item['snippet']['thumbnails']['default']['url'] : '',
	);
}

/**
 * Minimum video length (seconds) to include. Excludes YouTube Shorts and clips
 * shorter than 5 minutes. Filterable.
 */
function mygun_youtube_min_duration() {
	return (int) apply_filters( 'mygun_youtube_min_duration', 300 );
}

/**
 * Convert an ISO-8601 duration (e.g. PT7M40S) to seconds.
 */
function mygun_parse_iso8601_duration( $iso ) {
	$iso = trim( (string) $iso );
	if ( '' === $iso ) {
		return 0;
	}
	try {
		$d = new DateInterval( $iso );
	} catch ( Exception $e ) {
		return 0;
	}
	return ( $d->d * 86400 ) + ( $d->h * 3600 ) + ( $d->i * 60 ) + $d->s;
}

/**
 * Fetch durations (in seconds) for up to 50 video IDs. Returns id => seconds.
 */
function mygun_youtube_fetch_durations( $ids, $api_key ) {
	$out = array();
	$ids = array_slice( array_values( array_unique( array_filter( $ids ) ) ), 0, 50 );
	if ( empty( $ids ) ) {
		return $out;
	}

	$url  = 'https://www.googleapis.com/youtube/v3/videos?part=contentDetails'
		. '&id=' . rawurlencode( implode( ',', $ids ) )
		. '&key=' . rawurlencode( $api_key );
	$resp = wp_remote_get( $url, mygun_youtube_request_args() );
	if ( is_wp_error( $resp ) ) {
		return $out;
	}

	$body = json_decode( wp_remote_retrieve_body( $resp ), true );
	if ( empty( $body['items'] ) ) {
		return $out;
	}

	foreach ( $body['items'] as $it ) {
		$id = isset( $it['id'] ) ? $it['id'] : '';
		if ( $id ) {
			$out[ $id ] = mygun_parse_iso8601_duration( isset( $it['contentDetails']['duration'] ) ? $it['contentDetails']['duration'] : '' );
		}
	}
	return $out;
}

/**
 * Fetch the latest videos from an uploads playlist, excluding Shorts and clips
 * shorter than mygun_youtube_min_duration(). Returns up to $max videos.
 */
function mygun_youtube_fetch_uploads( $uploads, $api_key, $max = 30 ) {
	if ( ! $uploads ) {
		return array();
	}

	$max        = max( 1, min( 50, (int) $max ) );
	$min        = mygun_youtube_min_duration();
	$max_pages  = (int) apply_filters( 'mygun_youtube_max_pages', 4 ); // up to 4 x 50 = 200 uploads scanned.
	$page_token = '';
	$videos     = array();

	// Paginate through uploads, filtering Shorts / sub-min-duration, until we
	// have $max qualifying videos or run out of pages.
	for ( $page = 0; $page < $max_pages; $page++ ) {
		$url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet'
			. '&maxResults=50'
			. '&playlistId=' . rawurlencode( $uploads )
			. ( $page_token ? '&pageToken=' . rawurlencode( $page_token ) : '' )
			. '&key=' . rawurlencode( $api_key );
		$resp = wp_remote_get( $url, mygun_youtube_request_args() );

		if ( is_wp_error( $resp ) ) {
			break;
		}

		$body = json_decode( wp_remote_retrieve_body( $resp ), true );
		if ( empty( $body['items'] ) ) {
			break;
		}

		$raw = array();
		foreach ( $body['items'] as $it ) {
			$sn  = isset( $it['snippet'] ) ? $it['snippet'] : array();
			$vid = isset( $sn['resourceId']['videoId'] ) ? $sn['resourceId']['videoId'] : '';
			if ( ! $vid ) {
				continue;
			}

			// Skip private/deleted placeholders (no thumbnail).
			$thumb = '';
			foreach ( array( 'maxres', 'standard', 'high', 'medium', 'default' ) as $q ) {
				if ( isset( $sn['thumbnails'][ $q ]['url'] ) ) {
					$thumb = $sn['thumbnails'][ $q ]['url'];
					break;
				}
			}
			if ( ! $thumb ) {
				continue;
			}

			$raw[] = array(
				'id'          => $vid,
				'title'       => isset( $sn['title'] ) ? $sn['title'] : '',
				'description' => isset( $sn['description'] ) ? $sn['description'] : '',
				'published'   => isset( $sn['publishedAt'] ) ? $sn['publishedAt'] : '',
				'thumb'       => $thumb,
			);
		}

		if ( $raw ) {
			$durations = mygun_youtube_fetch_durations( wp_list_pluck( $raw, 'id' ), $api_key );
			foreach ( $raw as $v ) {
				$sec = isset( $durations[ $v['id'] ] ) ? $durations[ $v['id'] ] : 0;
				if ( $sec < $min ) {
					continue;
				}
				$v['duration'] = $sec;
				$videos[]      = $v;
				if ( count( $videos ) >= $max ) {
					return $videos;
				}
			}
		}

		$page_token = isset( $body['nextPageToken'] ) ? $body['nextPageToken'] : '';
		if ( ! $page_token ) {
			break;
		}
	}

	return $videos;
}

/**
 * Aggregated, cached list of latest videos across all configured channels.
 * Cached per channel for 6 hours (30 min on empty so hiccups retry sooner).
 */
function mygun_get_youtube_videos( $per_channel = 30 ) {
	$api_key = mygun_youtube_api_key();
	if ( ! $api_key ) {
		return array();
	}

	$per_channel = max( 1, min( 50, (int) $per_channel ) );
	$all         = array();

	foreach ( mygun_youtube_channels() as $handle ) {
		$cache_key = 'mygun_yt_v2_' . md5( $handle . '|' . $per_channel );
		$videos    = get_transient( $cache_key );

		if ( false === $videos ) {
			$videos  = array();
			$channel = mygun_youtube_resolve_channel( $handle, $api_key );

			if ( $channel && $channel['uploads'] ) {
				foreach ( mygun_youtube_fetch_uploads( $channel['uploads'], $api_key, $per_channel ) as $v ) {
					$v['channel_title']  = $channel['title'];
					$v['channel_handle'] = $handle;
					$videos[]            = $v;
				}
			}

			set_transient( $cache_key, $videos, $videos ? 6 * HOUR_IN_SECONDS : 30 * MINUTE_IN_SECONDS );
		}

		$all = array_merge( $all, $videos );
	}

	return $all;
}

/**
 * Delete all cached YouTube video transients.
 */
function mygun_youtube_clear_cache() {
	foreach ( mygun_youtube_channels() as $handle ) {
		for ( $n = 1; $n <= 50; $n++ ) {
			delete_transient( 'mygun_yt_' . md5( $handle . '|' . $n ) );
			delete_transient( 'mygun_yt_v2_' . md5( $handle . '|' . $n ) );
		}
	}
}

/**
 * Extract an 11-char YouTube video ID from a URL (watch / youtu.be / embed / shorts / live).
 */
function mygun_extract_youtube_id( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return '';
	}
	if ( preg_match( '#(?:youtube\.com/(?:watch\?v=|embed/|shorts/|live/|v/)|youtu\.be/)([A-Za-z0-9_-]{11})#', $url, $m ) ) {
		return $m[1];
	}
	if ( preg_match( '/^[A-Za-z0-9_-]{11}$/', $url ) ) {
		return $url;
	}
	return '';
}

/**
 * Render the videos UI (filter + search + grid + inline player).
 * Shared by the video_gallery archive and the Videos page template.
 */
function mygun_render_videos_section() {
	$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
	$t    = function( $en, $ka ) use ( $lang ) {
		return $lang === 'en' ? $en : $ka;
	};

	$videos = function_exists( 'mygun_get_youtube_videos' ) ? mygun_get_youtube_videos( 30 ) : array();

	$channels = array();
	foreach ( $videos as $v ) {
		if ( ! isset( $channels[ $v['channel_handle'] ] ) ) {
			$channels[ $v['channel_handle'] ] = $v['channel_title'];
		}
	}
	$has_api_key = function_exists( 'mygun_youtube_api_key' ) && mygun_youtube_api_key();

	if ( empty( $videos ) ) :
		?>
		<div class="mygun-videos-empty">
			<p><?php echo esc_html( mygun_t( 'No videos available right now.', 'ვიდეოები ამჟამად მიუწვდომელია.', 'Видео пока недоступны.' ) ); ?></p>
			<?php if ( current_user_can( 'manage_options' ) && ! $has_api_key ) : ?>
				<p><em><?php echo esc_html( mygun_t( 'Set the YouTube API key under Settings → YouTube Videos.', 'დააყენეთ YouTube API გასაღები აქ: Settings → YouTube Videos.', 'Задайте ключ YouTube API в разделе Настройки → YouTube Videos.' ) ); ?></em></p>
			<?php endif; ?>
		</div>
		<?php
		return;
	endif;
	?>
	<div class="mygun-videos-controls">
		<div class="mygun-videos-search">
			<input type="text" id="mygunVideoSearch" placeholder="<?php echo esc_attr( mygun_t( 'Search videos...', 'ძებნა ვიდეოებში...', 'Поиск видео...' ) ); ?>" />
		</div>
		<div class="mygun-videos-filters">
			<button type="button" class="mygun-video-filter active" data-channel="all"><?php echo esc_html( mygun_t( 'All', 'ყველა', 'Все' ) ); ?></button>
			<?php foreach ( $channels as $handle => $title ) : ?>
				<button type="button" class="mygun-video-filter" data-channel="<?php echo esc_attr( $handle ); ?>"><?php echo esc_html( $title ); ?></button>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="row mygun-videos-grid" id="mygunVideosGrid">
		<?php
		foreach ( $videos as $v ) :
			$search_blob = strtolower( $v['title'] . ' ' . $v['description'] . ' ' . $v['channel_title'] );
			$date        = $v['published'] ? date_i18n( 'd-M-Y', strtotime( $v['published'] ) ) : '';
			?>
			<div class="col-md-4 col-sm-6 mygun-video-col" data-channel="<?php echo esc_attr( $v['channel_handle'] ); ?>" data-search="<?php echo esc_attr( $search_blob ); ?>">
				<article class="mygun-video-card">
					<div class="mygun-video-thumb" data-video-id="<?php echo esc_attr( $v['id'] ); ?>">
						<img src="<?php echo esc_url( $v['thumb'] ); ?>" alt="<?php echo esc_attr( $v['title'] ); ?>" loading="lazy" />
						<span class="mygun-video-play"><i class="fa fa-play"></i></span>
					</div>
					<div class="mygun-video-body">
						<span class="mygun-video-channel"><?php echo esc_html( $v['channel_title'] ); ?></span>
						<h3 class="mygun-video-title"><?php echo esc_html( $v['title'] ); ?></h3>
						<?php if ( $date ) : ?>
							<span class="mygun-video-date"><i class="fa fa-calendar-alt"></i> <?php echo esc_html( $date ); ?></span>
						<?php endif; ?>
						<?php if ( '' !== trim( (string) $v['description'] ) ) : ?>
							<p class="mygun-video-desc"><?php echo esc_html( wp_trim_words( $v['description'], 24, '...' ) ); ?></p>
						<?php endif; ?>
					</div>
				</article>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="mygun-videos-noresults" style="display:none;"><?php echo esc_html( mygun_t( 'No videos match your search.', 'ვიდეო ვერ მოიძებნა.', 'Видео не найдено.' ) ); ?></div>

	<div class="mygun-video-modal" id="mygunVideoModal" aria-hidden="true">
		<div class="mygun-video-modal-overlay" data-close="1"></div>
		<div class="mygun-video-modal-dialog" role="dialog" aria-modal="true">
			<button type="button" class="mygun-video-modal-close" data-close="1" aria-label="Close">&times;</button>
			<div class="mygun-video-modal-frame" id="mygunVideoModalFrame"></div>
		</div>
	</div>

	<script>
	(function () {
		var grid = document.getElementById('mygunVideosGrid');
		if (!grid) return;

		var search    = document.getElementById('mygunVideoSearch');
		var cards     = Array.prototype.slice.call(grid.querySelectorAll('.mygun-video-col'));
		var filters   = Array.prototype.slice.call(document.querySelectorAll('.mygun-video-filter'));
		var noResults = document.querySelector('.mygun-videos-noresults');
		var activeChannel = 'all';

		function apply() {
			var q = (search ? search.value : '').trim().toLowerCase();
			var visible = 0;
			cards.forEach(function (card) {
				var okChannel = activeChannel === 'all' || card.getAttribute('data-channel') === activeChannel;
				var okSearch  = !q || card.getAttribute('data-search').indexOf(q) !== -1;
				var show = okChannel && okSearch;
				card.style.display = show ? '' : 'none';
				if (show) visible++;
			});
			if (noResults) noResults.style.display = visible ? 'none' : 'block';
		}

		if (search) search.addEventListener('input', apply);

		filters.forEach(function (btn) {
			btn.addEventListener('click', function () {
				filters.forEach(function (b) { b.classList.remove('active'); });
				btn.classList.add('active');
				activeChannel = btn.getAttribute('data-channel');
				apply();
			});
		});

		var modal      = document.getElementById('mygunVideoModal');
		var modalFrame = document.getElementById('mygunVideoModalFrame');

		function openModal(id) {
			if (!modal || !modalFrame || !id) return;
			modalFrame.innerHTML = '<iframe src="https://www.youtube.com/embed/' + id +
				'?autoplay=1&rel=0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
			modal.classList.add('open');
			modal.setAttribute('aria-hidden', 'false');
			document.body.style.overflow = 'hidden';
		}
		function closeModal() {
			if (!modal) return;
			modal.classList.remove('open');
			modal.setAttribute('aria-hidden', 'true');
			modalFrame.innerHTML = '';
			document.body.style.overflow = '';
		}

		grid.addEventListener('click', function (e) {
			var thumb = e.target.closest ? e.target.closest('.mygun-video-thumb') : null;
			if (!thumb) return;
			openModal(thumb.getAttribute('data-video-id'));
		});

		if (modal) {
			modal.addEventListener('click', function (e) {
				if (e.target.getAttribute && e.target.getAttribute('data-close')) closeModal();
			});
		}
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' || e.keyCode === 27) closeModal();
		});
	})();
	</script>
	<?php
}

/**
 * Settings page: Settings -> YouTube Videos.
 */
add_action( 'admin_menu', 'mygun_youtube_admin_menu' );
function mygun_youtube_admin_menu() {
	add_options_page( 'YouTube Videos', 'YouTube Videos', 'manage_options', 'mygun-youtube', 'mygun_youtube_settings_page' );
}

add_action( 'admin_init', 'mygun_youtube_register_settings' );
function mygun_youtube_register_settings() {
	register_setting( 'mygun_youtube_group', 'mygun_youtube_api_key', array( 'sanitize_callback' => 'sanitize_text_field' ) );
	register_setting( 'mygun_youtube_group', 'mygun_youtube_referer', array( 'sanitize_callback' => 'esc_url_raw' ) );
	register_setting( 'mygun_youtube_group', 'mygun_youtube_handles', array( 'sanitize_callback' => 'sanitize_textarea_field' ) );
}

function mygun_youtube_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['mygun_yt_clear_cache'] ) && check_admin_referer( 'mygun_yt_clear_cache' ) ) {
		mygun_youtube_clear_cache();
		echo '<div class="notice notice-success is-dismissible"><p>YouTube video cache cleared.</p></div>';
	}

	$key_from_constant = defined( 'MYGUN_YOUTUBE_API_KEY' ) && MYGUN_YOUTUBE_API_KEY;
	?>
	<div class="wrap">
		<h1>YouTube Videos</h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'mygun_youtube_group' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="mygun_youtube_api_key">API Key</label></th>
					<td>
						<?php if ( $key_from_constant ) : ?>
							<p><em>Defined via the <code>MYGUN_YOUTUBE_API_KEY</code> constant in wp-config.php.</em></p>
						<?php else : ?>
							<input name="mygun_youtube_api_key" id="mygun_youtube_api_key" type="text" class="regular-text" value="<?php echo esc_attr( get_option( 'mygun_youtube_api_key', '' ) ); ?>" autocomplete="off" />
							<p class="description">YouTube Data API v3 key from Google Cloud Console.</p>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="mygun_youtube_referer">Allowed Referer</label></th>
					<td>
						<input name="mygun_youtube_referer" id="mygun_youtube_referer" type="text" class="regular-text" value="<?php echo esc_attr( get_option( 'mygun_youtube_referer', '' ) ); ?>" placeholder="<?php echo esc_attr( home_url( '/' ) ); ?>" />
						<p class="description">Only needed if your API key has an HTTP referrer restriction (e.g. <code>https://mygun.ge/</code>). Sent as the Referer header so server-side calls pass the restriction. Leave empty to use the site URL.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="mygun_youtube_handles">Channels</label></th>
					<td>
						<textarea name="mygun_youtube_handles" id="mygun_youtube_handles" rows="6" class="large-text code" placeholder="adventureslifegeo&#10;SSBBMarket"><?php echo esc_textarea( get_option( 'mygun_youtube_handles', '' ) ); ?></textarea>
						<p class="description">One channel per line — accepts <code>@handle</code>, bare handle, channel ID, or full channel URL. Leave empty to use the four defaults.</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
		<hr />
		<form method="post">
			<?php wp_nonce_field( 'mygun_yt_clear_cache' ); ?>
			<input type="submit" name="mygun_yt_clear_cache" class="button" value="Clear cached videos" />
			<p class="description">Videos are cached for 6 hours per channel. Clear to pull fresh data now.</p>
		</form>
	</div>
	<?php
}

