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
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Security check failed.' : 'უსაფრთხოების შემოწმება ვერ მოხერხდა.' ) );
	}

	$username = sanitize_text_field( $_POST['username'] );
	$password = $_POST['password'];
	$remember = isset( $_POST['remember'] ) && $_POST['remember'] == 1;

	if ( empty( $username ) || empty( $password ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Please fill in all fields.' : 'გთხოვთ შეავსოთ ყველა ველი.' ) );
	}

	$creds = array(
		'user_login'    => $username,
		'user_password' => $password,
		'remember'      => $remember,
	);

	$user = wp_signon( $creds, false );

	if ( is_wp_error( $user ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Invalid username or password.' : 'არასწორი მომხმარებლის სახელი ან პაროლი.' ) );
	}

	wp_send_json_success( array( 'message' => $lang === 'en' ? 'Successfully logged in!' : 'წარმატებით შეხვედით სისტემაში!' ) );
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
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Security check failed.' : 'უსაფრთხოების შემოწმება ვერ მოხერხდა.' ) );
	}

	$username = sanitize_user( $_POST['username'] );
	$email    = sanitize_email( $_POST['email'] );
	$password = $_POST['password'];

	// Validate
	if ( empty( $username ) || empty( $email ) || empty( $password ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Please fill in all fields.' : 'გთხოვთ შეავსოთ ყველა ველი.' ) );
	}

	if ( strlen( $username ) < 3 ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Username must be at least 3 characters.' : 'მომხმარებლის სახელი უნდა შეიცავდეს მინიმუმ 3 სიმბოლოს.' ) );
	}

	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Please enter a valid email address.' : 'გთხოვთ შეიყვანოთ სწორი ელფოსტის მისამართი.' ) );
	}

	if ( strlen( $password ) < 6 ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Password must be at least 6 characters.' : 'პაროლი უნდა შეიცავდეს მინიმუმ 6 სიმბოლოს.' ) );
	}

	if ( username_exists( $username ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'This username is already taken.' : 'ეს მომხმარებლის სახელი უკვე დაკავებულია.' ) );
	}

	if ( email_exists( $email ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'This email is already registered.' : 'ეს ელფოსტა უკვე რეგისტრირებულია.' ) );
	}

	$user_id = wp_create_user( $username, $password, $email );

	if ( is_wp_error( $user_id ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Registration failed. Please try again later.' : 'რეგისტრაცია ვერ მოხერხდა. სცადეთ მოგვიანებით.' ) );
	}

	// Auto-login after registration
	wp_set_current_user( $user_id );
	wp_set_auth_cookie( $user_id );

	wp_send_json_success( array( 'message' => $lang === 'en' ? 'Registration completed successfully!' : 'რეგისტრაცია წარმატებით დასრულდა!' ) );
}
add_action( 'wp_ajax_nopriv_mygun_register', 'mygun_ajax_register' );
add_action( 'wp_ajax_mygun_register', 'mygun_ajax_register' );

/**
 * Register Product Custom Post Type and Taxonomy.
 */
function mygun_register_product_cpt() {
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
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'You must be logged in.' : 'ავტორიზაცია აუცილებელია.' ) );
	}

	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mygun_add_product_nonce' ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Security check failed.' : 'უსაფრთხოების შემოწმება ვერ მოხერხდა.' ) );
	}

	$title       = sanitize_text_field( $_POST['product_title'] );
	$description = wp_kses_post( $_POST['product_description'] );
	$price       = sanitize_text_field( $_POST['product_price'] );
	$category    = isset( $_POST['product_category'] ) ? intval( $_POST['product_category'] ) : 0;
	$phone       = sanitize_text_field( $_POST['product_phone'] ?? '' );
	$condition   = sanitize_text_field( $_POST['product_condition'] ?? 'new' );

	// Validate
	if ( empty( $title ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Please enter a product name.' : 'გთხოვთ შეიყვანოთ პროდუქტის სახელი.' ) );
	}
	if ( empty( $price ) || ! is_numeric( $price ) || floatval( $price ) < 0 ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Please enter a valid price.' : 'გთხოვთ შეიყვანოთ სწორი ფასი.' ) );
	}
	if ( empty( $description ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Please enter a description.' : 'გთხოვთ შეიყვანოთ აღწერა.' ) );
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
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Failed to add product. Please try again.' : 'პროდუქტის დამატება ვერ მოხერხდა. სცადეთ თავიდან.' ) );
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
		'message' => $lang === 'en' ? 'Product added successfully! It will be visible after approval.' : 'პროდუქტი წარმატებით დაემატა! ის ხილული გახდება დამტკიცების შემდეგ.',
	));
}
add_action( 'wp_ajax_mygun_add_product', 'mygun_ajax_add_product' );

/**
 * AJAX Update Profile Handler.
 */
function mygun_ajax_update_profile() {
	$lang = isset( $_POST['lang'] ) ? sanitize_text_field( $_POST['lang'] ) : 'ka';

	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'You must be logged in.' : 'ავტორიზაცია აუცილებელია.' ) );
	}

	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mygun_update_profile_nonce' ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Security check failed.' : 'უსაფრთხოების შემოწმება ვერ მოხერხდა.' ) );
	}

	$user_id      = get_current_user_id();
	$display_name = sanitize_text_field( $_POST['display_name'] );
	$phone        = sanitize_text_field( $_POST['phone'] ?? '' );
	$bio          = sanitize_textarea_field( $_POST['bio'] ?? '' );

	if ( empty( $display_name ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Please enter a display name.' : 'გთხოვთ შეიყვანოთ სახელი.' ) );
	}

	$result = wp_update_user( array(
		'ID'           => $user_id,
		'display_name' => $display_name,
		'description'  => $bio,
	));

	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Failed to update profile.' : 'პროფილის განახლება ვერ მოხერხდა.' ) );
	}

	update_user_meta( $user_id, '_user_phone', $phone );

	wp_send_json_success( array( 'message' => $lang === 'en' ? 'Profile updated successfully!' : 'პროფილი წარმატებით განახლდა!' ) );
}
add_action( 'wp_ajax_mygun_update_profile', 'mygun_ajax_update_profile' );

/**
 * AJAX Change Password Handler.
 */
function mygun_ajax_change_password() {
	$lang = isset( $_POST['lang'] ) ? sanitize_text_field( $_POST['lang'] ) : 'ka';

	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'You must be logged in.' : 'ავტორიზაცია აუცილებელია.' ) );
	}

	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mygun_change_password_nonce' ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Security check failed.' : 'უსაფრთხოების შემოწმება ვერ მოხერხდა.' ) );
	}

	$user         = wp_get_current_user();
	$current_pass = $_POST['current_password'];
	$new_pass     = $_POST['new_password'];

	if ( empty( $current_pass ) || empty( $new_pass ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Please fill in all fields.' : 'გთხოვთ შეავსოთ ყველა ველი.' ) );
	}

	if ( ! wp_check_password( $current_pass, $user->user_pass, $user->ID ) ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'Current password is incorrect.' : 'მიმდინარე პაროლი არასწორია.' ) );
	}

	if ( strlen( $new_pass ) < 6 ) {
		wp_send_json_error( array( 'message' => $lang === 'en' ? 'New password must be at least 6 characters.' : 'ახალი პაროლი უნდა შეიცავდეს მინიმუმ 6 სიმბოლოს.' ) );
	}

	wp_set_password( $new_pass, $user->ID );

	// Re-authenticate to keep user logged in
	wp_set_current_user( $user->ID );
	wp_set_auth_cookie( $user->ID );

	wp_send_json_success( array( 'message' => $lang === 'en' ? 'Password changed successfully!' : 'პაროლი წარმატებით შეიცვალა!' ) );
}
add_action( 'wp_ajax_mygun_change_password', 'mygun_ajax_change_password' );

/**
 * AJAX Contact Form Handler.
 */
function mygun_ajax_contact_form() {
	$lang = isset( $_POST['lang'] ) ? sanitize_text_field( $_POST['lang'] ) : mygun_get_lang();

	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mygun_contact_nonce' ) ) {
		wp_send_json_error( array(
			'message' => $lang === 'en' ? 'Security check failed.' : 'უსაფრთხოების შემოწმება ვერ მოხერხდა.',
		) );
	}

	$full_name = isset( $_POST['full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['full_name'] ) ) : '';
	$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$subject   = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
	$message   = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $full_name || '' === $email || '' === $message ) {
		wp_send_json_error( array(
			'message' => $lang === 'en' ? 'Please fill in all required fields.' : 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი.',
		) );
	}

	if ( ! is_email( $email ) ) {
		wp_send_json_error( array(
			'message' => $lang === 'en' ? 'Please enter a valid email address.' : 'გთხოვთ შეიყვანოთ სწორი ელფოსტის მისამართი.',
		) );
	}

	$to          = 'gegagagua@gmail.com';
	$mail_subject = $subject ? $subject : ( $lang === 'en' ? 'New contact message from website' : 'ახალი კონტაქტის შეტყობინება საიტიდან' );
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
			'message' => $lang === 'en' ? 'Failed to send message. Please try again later.' : 'შეტყობინების გაგზავნა ვერ მოხერხდა. სცადეთ მოგვიანებით.',
		) );
	}

	wp_send_json_success( array(
		'message' => $lang === 'en' ? 'Your message has been sent successfully!' : 'თქვენი შეტყობინება წარმატებით გაიგზავნა!',
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
	global $post, $product;

	$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
	$heading = $lang === 'en' ? 'Additional information' : 'დამატებითი ინფორმაცია';

	// Default WooCommerce description output.
	if ( $post instanceof WP_Post ) {
		$description = apply_filters( 'the_content', $post->post_content );
		if ( $description ) {
			echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	// Append product attributes/extra info in the same section.
	if ( $product && method_exists( $product, 'has_attributes' ) && $product->has_attributes() && function_exists( 'wc_display_product_attributes' ) ) {
		echo '<div class="mygun-merged-additional-info" style="margin-top:30px;">';
		echo '<h3 style="margin-bottom:15px;">' . esc_html( $heading ) . '</h3>';
		wc_display_product_attributes( $product );
		echo '</div>';
	}
}

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

