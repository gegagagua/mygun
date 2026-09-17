<?php
/**
 * MyGun Theme Options — a self-contained, data-driven admin content manager.
 *
 * Provides a "MyGun Content" admin screen where every piece of front-end text,
 * image and contact detail is editable in three languages (ka / en / ru).
 *
 * Storage: a single option `mygun_options` holding an associative array.
 *   - Translatable fields:  key => array( 'ka' => '', 'en' => '', 'ru' => '' )
 *   - Plain fields (url/tel/email/image/checkbox): key => scalar
 *
 * Front-end helpers:
 *   mygun_opt( $key )            Localized value for the current language (with fallback).
 *   mygun_opt_img( $key, $size ) Image URL for a stored attachment id.
 *   mygun_opt_raw( $key )        The raw stored value (all languages / scalar).
 *   mygun_t( $en, $ka, $ru )     Inline 3-language string (ru falls back to en).
 *
 * @package mygun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ------------------------------------------------------------------ *
 * Language helpers
 * ------------------------------------------------------------------ */

/**
 * The languages this theme manages content for.
 *
 * @return array slug => native label
 */
function mygun_lang_list() {
	return array(
		'ka' => 'ქართული',
		'en' => 'English',
		'ru' => 'Русский',
	);
}

/**
 * Current front-end language slug (Polylang aware). Falls back to Georgian.
 */
function mygun_current_lang() {
	$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : '';
	if ( ! $lang || ! array_key_exists( $lang, mygun_lang_list() ) ) {
		$lang = 'ka';
	}
	return $lang;
}

/**
 * Inline three-language string. Georgian is the source of truth; Russian falls
 * back to English, English falls back to Georgian, so nothing ever renders empty.
 *
 * @param string      $en English text.
 * @param string      $ka Georgian text.
 * @param string|null $ru Russian text (optional).
 * @return string
 */
function mygun_t( $en, $ka, $ru = null ) {
	switch ( mygun_current_lang() ) {
		case 'en':
			return $en !== '' ? $en : $ka;
		case 'ru':
			if ( $ru !== null && $ru !== '' ) {
				return $ru;
			}
			return $en !== '' ? $en : $ka;
		case 'ka':
		default:
			return $ka !== '' ? $ka : $en;
	}
}

/* ------------------------------------------------------------------ *
 * Option access
 * ------------------------------------------------------------------ */

/**
 * The full stored options array (cached per request).
 */
function mygun_options_all() {
	static $cache = null;
	if ( null === $cache ) {
		$cache = get_option( 'mygun_options', array() );
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}
	}
	return $cache;
}

/**
 * Raw stored value for a key (array for translatable fields, scalar otherwise).
 *
 * @param string $key
 * @param mixed  $default
 * @return mixed
 */
function mygun_opt_raw( $key, $default = '' ) {
	$all = mygun_options_all();
	return array_key_exists( $key, $all ) ? $all[ $key ] : $default;
}

/**
 * Localized text value for a translatable field, with graceful fallback.
 *
 * @param string      $key
 * @param string      $default Returned when the field is entirely empty.
 * @param string|null $lang    Force a language, otherwise the current one.
 * @return string
 */
function mygun_opt( $key, $default = '', $lang = null ) {
	$val = mygun_opt_raw( $key, null );
	if ( null === $val ) {
		return $default;
	}
	if ( is_array( $val ) ) {
		$lang  = $lang ? $lang : mygun_current_lang();
		$order = array( $lang, 'ka', 'en', 'ru' );
		foreach ( $order as $l ) {
			if ( isset( $val[ $l ] ) && '' !== trim( (string) $val[ $l ] ) ) {
				return $val[ $l ];
			}
		}
		return $default;
	}
	return '' !== trim( (string) $val ) ? $val : $default;
}

/**
 * Image URL for a stored attachment id (or a fallback URL).
 *
 * @param string $key
 * @param string $size
 * @param string $fallback Absolute URL used when nothing is set.
 * @return string
 */
function mygun_opt_img( $key, $size = 'large', $fallback = '' ) {
	$val = mygun_opt_raw( $key, '' );
	if ( is_numeric( $val ) && (int) $val > 0 ) {
		$url = wp_get_attachment_image_url( (int) $val, $size );
		if ( $url ) {
			return $url;
		}
	} elseif ( is_string( $val ) && filter_var( $val, FILTER_VALIDATE_URL ) ) {
		return $val;
	}
	return $fallback;
}

/* ------------------------------------------------------------------ *
 * Schema — the single source of truth for every editable field
 * ------------------------------------------------------------------ */

/**
 * Field schema grouped into admin tabs.
 *
 * Field types: text, textarea, url, email, tel, image, checkbox, html.
 * `i18n => true` renders one input per language and stores an array.
 *
 * @return array
 */
function mygun_options_schema() {
	$schema = array(

		'general' => array(
			'label'  => __( 'General & Contact', 'mygun' ),
			'icon'   => 'dashicons-admin-generic',
			'fields' => array(
				array( 'key' => 'site_logo', 'label' => 'Logo', 'type' => 'image' ),
				array( 'key' => 'site_logo_light', 'label' => 'Logo (footer / light)', 'type' => 'image' ),
				array( 'key' => 'contact_phone', 'label' => 'Phone', 'type' => 'tel' ),
				array( 'key' => 'contact_phone2', 'label' => 'Phone (secondary)', 'type' => 'tel' ),
				array( 'key' => 'contact_email', 'label' => 'Email', 'type' => 'email' ),
				array( 'key' => 'contact_address', 'label' => 'Address', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'contact_hours', 'label' => 'Working hours', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'social_facebook', 'label' => 'Facebook URL', 'type' => 'url' ),
				array( 'key' => 'social_youtube', 'label' => 'YouTube URL', 'type' => 'url' ),
				array( 'key' => 'social_instagram', 'label' => 'Instagram URL', 'type' => 'url' ),
				array( 'key' => 'social_tiktok', 'label' => 'TikTok URL', 'type' => 'url' ),
				array( 'key' => 'social_linkedin', 'label' => 'LinkedIn URL', 'type' => 'url' ),
			),
		),

		'hero' => array(
			'label'  => __( 'Homepage — Hero Slider', 'mygun' ),
			'icon'   => 'dashicons-images-alt2',
			'fields' => mygun_hero_slide_fields(),
		),

		'home_products' => array(
			'label'  => __( 'Homepage — Products', 'mygun' ),
			'icon'   => 'dashicons-cart',
			'fields' => array(
				array( 'key' => 'products_heading', 'label' => 'Section heading', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'products_subheading', 'label' => 'Section subheading', 'type' => 'textarea', 'i18n' => true ),
				array( 'key' => 'products_btn', 'label' => 'Button text', 'type' => 'text', 'i18n' => true ),
			),
		),

		'home_about' => array(
			'label'  => __( 'Homepage — Who We Are', 'mygun' ),
			'icon'   => 'dashicons-groups',
			'fields' => array(
				array( 'key' => 'about_heading', 'label' => 'Heading', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'about_text1', 'label' => 'Intro paragraph', 'type' => 'textarea', 'i18n' => true ),
				array( 'key' => 'about_quote', 'label' => 'Highlighted quote', 'type' => 'textarea', 'i18n' => true ),
				array( 'key' => 'about_text2', 'label' => 'Closing paragraph', 'type' => 'textarea', 'i18n' => true ),
				array( 'key' => 'about_btn1_text', 'label' => 'Button 1 text', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'about_btn1_url', 'label' => 'Button 1 URL', 'type' => 'url' ),
				array( 'key' => 'about_btn2_text', 'label' => 'Button 2 text', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'about_btn2_url', 'label' => 'Button 2 URL', 'type' => 'url' ),
				array( 'key' => 'about_s1_title', 'label' => 'Service 1 title', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'about_s1_url', 'label' => 'Service 1 URL', 'type' => 'url' ),
				array( 'key' => 'about_s1_icon', 'label' => 'Service 1 icon', 'type' => 'image' ),
				array( 'key' => 'about_s2_title', 'label' => 'Service 2 title', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'about_s2_url', 'label' => 'Service 2 URL', 'type' => 'url' ),
				array( 'key' => 'about_s2_icon', 'label' => 'Service 2 icon', 'type' => 'image' ),
				array( 'key' => 'about_s3_title', 'label' => 'Service 3 title', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'about_s3_url', 'label' => 'Service 3 URL', 'type' => 'url' ),
				array( 'key' => 'about_s3_icon', 'label' => 'Service 3 icon', 'type' => 'image' ),
			),
		),

		'home_gallery' => array(
			'label'  => __( 'Homepage — Gallery', 'mygun' ),
			'icon'   => 'dashicons-format-gallery',
			'fields' => array_merge(
				array(
					array( 'key' => 'gallery_heading', 'label' => 'Heading', 'type' => 'text', 'i18n' => true ),
					array( 'key' => 'gallery_subheading', 'label' => 'Subheading', 'type' => 'textarea', 'i18n' => true ),
				),
				mygun_gallery_item_fields()
			),
		),

		'home_training' => array(
			'label'  => __( 'Homepage — Training', 'mygun' ),
			'icon'   => 'dashicons-awards',
			'fields' => array(
				array( 'key' => 'training_enabled', 'label' => 'Enable training form (uncheck = "Coming soon")', 'type' => 'checkbox' ),
				array( 'key' => 'training_badge', 'label' => '"Coming soon" badge text', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'training_heading', 'label' => 'Heading', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'training_text1', 'label' => 'Intro paragraph', 'type' => 'textarea', 'i18n' => true ),
				array( 'key' => 'training_phone', 'label' => 'Phone (displayed big)', 'type' => 'tel' ),
				array( 'key' => 'training_text2', 'label' => 'Second paragraph', 'type' => 'textarea', 'i18n' => true ),
				array( 'key' => 'training_f1', 'label' => 'Feature 1', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'training_f2', 'label' => 'Feature 2', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'training_f3', 'label' => 'Feature 3', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'training_f4', 'label' => 'Feature 4', 'type' => 'text', 'i18n' => true ),
			),
		),

		'home_news' => array(
			'label'  => __( 'Homepage — News', 'mygun' ),
			'icon'   => 'dashicons-megaphone',
			'fields' => array(
				array( 'key' => 'news_heading', 'label' => 'Heading', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'news_subheading', 'label' => 'Subheading', 'type' => 'textarea', 'i18n' => true ),
			),
		),

		'home_subscribe' => array(
			'label'  => __( 'Homepage — Subscribe', 'mygun' ),
			'icon'   => 'dashicons-email-alt',
			'fields' => array(
				array( 'key' => 'subscribe_heading', 'label' => 'Heading', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'subscribe_text', 'label' => 'Text', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'subscribe_btn', 'label' => 'Button text', 'type' => 'text', 'i18n' => true ),
			),
		),

		'footer' => array(
			'label'  => __( 'Footer', 'mygun' ),
			'icon'   => 'dashicons-align-wide',
			'fields' => array(
				array( 'key' => 'footer_about', 'label' => 'About text', 'type' => 'textarea', 'i18n' => true ),
				array( 'key' => 'footer_shop_heading', 'label' => 'Shop column heading', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'footer_shop_text', 'label' => 'Shop column text', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'footer_col2_heading', 'label' => 'Links column heading', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'footer_copyright', 'label' => 'Copyright (use %year% for the year)', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'footer_link1_text', 'label' => 'Bottom link 1 text', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'footer_link1_url', 'label' => 'Bottom link 1 URL', 'type' => 'url' ),
				array( 'key' => 'footer_link2_text', 'label' => 'Bottom link 2 text', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'footer_link2_url', 'label' => 'Bottom link 2 URL', 'type' => 'url' ),
			),
		),

		'contact' => array(
			'label'  => __( 'Contact Page', 'mygun' ),
			'icon'   => 'dashicons-phone',
			'fields' => array(
				array( 'key' => 'contactp_heading', 'label' => 'Page heading', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'contactp_subheading', 'label' => 'Page subheading', 'type' => 'textarea', 'i18n' => true ),
				array( 'key' => 'contactp_form_heading', 'label' => 'Form heading', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'contactp_info_heading', 'label' => 'Info block heading', 'type' => 'text', 'i18n' => true ),
				array( 'key' => 'contactp_map', 'label' => 'Google Maps embed (iframe)', 'type' => 'html' ),
			),
		),
	);

	/**
	 * Allow other code to extend the schema.
	 */
	return apply_filters( 'mygun_options_schema', $schema );
}

/**
 * Build repeated hero-slide fields (3 slides).
 */
function mygun_hero_slide_fields() {
	$fields = array();
	for ( $i = 1; $i <= 3; $i++ ) {
		$fields[] = array( 'key' => "hero{$i}_sep", 'label' => "— Slide {$i} —", 'type' => 'sep' );
		$fields[] = array( 'key' => "hero{$i}_image", 'label' => "Slide {$i} background", 'type' => 'image' );
		$fields[] = array( 'key' => "hero{$i}_title", 'label' => "Slide {$i} title", 'type' => 'text', 'i18n' => true );
		$fields[] = array( 'key' => "hero{$i}_subtitle", 'label' => "Slide {$i} subtitle", 'type' => 'textarea', 'i18n' => true );
		$fields[] = array( 'key' => "hero{$i}_btn1_text", 'label' => "Slide {$i} button 1 text", 'type' => 'text', 'i18n' => true );
		$fields[] = array( 'key' => "hero{$i}_btn1_url", 'label' => "Slide {$i} button 1 URL", 'type' => 'url' );
		$fields[] = array( 'key' => "hero{$i}_btn2_text", 'label' => "Slide {$i} button 2 text", 'type' => 'text', 'i18n' => true );
		$fields[] = array( 'key' => "hero{$i}_btn2_url", 'label' => "Slide {$i} button 2 URL", 'type' => 'url' );
	}
	return $fields;
}

/**
 * Build gallery item fields (5 items).
 */
function mygun_gallery_item_fields() {
	$fields = array();
	for ( $i = 1; $i <= 5; $i++ ) {
		$fields[] = array( 'key' => "gallery{$i}_sep", 'label' => "— Image {$i} —", 'type' => 'sep' );
		$fields[] = array( 'key' => "gallery{$i}_image", 'label' => "Image {$i}", 'type' => 'image' );
		$fields[] = array( 'key' => "gallery{$i}_title", 'label' => "Image {$i} title", 'type' => 'text', 'i18n' => true );
		$fields[] = array( 'key' => "gallery{$i}_desc", 'label' => "Image {$i} description", 'type' => 'text', 'i18n' => true );
	}
	return $fields;
}

/* ------------------------------------------------------------------ *
 * Admin screen
 * ------------------------------------------------------------------ */

add_action( 'admin_menu', 'mygun_options_admin_menu' );
function mygun_options_admin_menu() {
	add_menu_page(
		__( 'MyGun Content', 'mygun' ),
		__( 'MyGun Content', 'mygun' ),
		'manage_options',
		'mygun-content',
		'mygun_options_render_page',
		'dashicons-admin-customizer',
		3
	);
}

add_action( 'admin_enqueue_scripts', 'mygun_options_admin_assets' );
function mygun_options_admin_assets( $hook ) {
	if ( 'toplevel_page_mygun-content' !== $hook ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_style( 'mygun-options-admin', get_template_directory_uri() . '/inc/mygun-options-admin.css', array(), _S_VERSION );
	wp_enqueue_script( 'mygun-options-admin', get_template_directory_uri() . '/inc/mygun-options-admin.js', array( 'jquery' ), _S_VERSION, true );
}

/**
 * Render the tabbed options screen and handle saving.
 */
function mygun_options_render_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$schema      = mygun_options_schema();
	$tab_keys    = array_keys( $schema );
	$active_tab  = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : $tab_keys[0];
	if ( ! isset( $schema[ $active_tab ] ) ) {
		$active_tab = $tab_keys[0];
	}

	// Handle save.
	if ( isset( $_POST['mygun_options_save'] ) ) {
		check_admin_referer( 'mygun_options_save', 'mygun_options_nonce' );
		mygun_options_save( $schema, $active_tab );
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Content saved.', 'mygun' ) . '</p></div>';
	}

	$langs = mygun_lang_list();
	?>
	<div class="wrap mygun-options-wrap">
		<h1><span class="dashicons dashicons-admin-customizer"></span> <?php esc_html_e( 'MyGun Content', 'mygun' ); ?></h1>
		<p class="description"><?php esc_html_e( 'Edit every front-end text, image and contact detail in three languages. Leave a language blank to fall back automatically.', 'mygun' ); ?></p>

		<div class="mygun-options-layout">
			<nav class="mygun-options-tabs">
				<?php foreach ( $schema as $tab_key => $tab ) : ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=mygun-content&tab=' . $tab_key ) ); ?>"
					   class="<?php echo $tab_key === $active_tab ? 'active' : ''; ?>">
						<span class="dashicons <?php echo esc_attr( $tab['icon'] ); ?>"></span>
						<?php echo esc_html( $tab['label'] ); ?>
					</a>
				<?php endforeach; ?>
			</nav>

			<form method="post" class="mygun-options-form">
				<?php wp_nonce_field( 'mygun_options_save', 'mygun_options_nonce' ); ?>
				<input type="hidden" name="mygun_active_tab" value="<?php echo esc_attr( $active_tab ); ?>" />

				<h2><?php echo esc_html( $schema[ $active_tab ]['label'] ); ?></h2>

				<div class="mygun-fields">
					<?php
					foreach ( $schema[ $active_tab ]['fields'] as $field ) {
						mygun_options_render_field( $field, $langs );
					}
					?>
				</div>

				<p class="submit">
					<button type="submit" name="mygun_options_save" value="1" class="button button-primary button-large">
						<?php esc_html_e( 'Save changes', 'mygun' ); ?>
					</button>
				</p>
			</form>
		</div>
	</div>
	<?php
}

/**
 * Render a single field row.
 */
function mygun_options_render_field( $field, $langs ) {
	$key   = $field['key'];
	$type  = $field['type'];
	$label = $field['label'];

	if ( 'sep' === $type ) {
		echo '<h3 class="mygun-field-sep">' . esc_html( $label ) . '</h3>';
		return;
	}

	echo '<div class="mygun-field mygun-field-' . esc_attr( $type ) . '">';
	echo '<label class="mygun-field-label">' . esc_html( $label ) . '</label>';
	echo '<div class="mygun-field-control">';

	$val = mygun_opt_raw( $key, empty( $field['i18n'] ) ? '' : array() );

	if ( ! empty( $field['i18n'] ) ) {
		echo '<div class="mygun-i18n">';
		foreach ( $langs as $slug => $native ) {
			$v = is_array( $val ) && isset( $val[ $slug ] ) ? $val[ $slug ] : '';
			echo '<div class="mygun-i18n-row">';
			echo '<span class="mygun-lang-badge lang-' . esc_attr( $slug ) . '">' . esc_html( strtoupper( $slug ) ) . '</span>';
			$name = 'mygun_field[' . esc_attr( $key ) . '][' . esc_attr( $slug ) . ']';
			if ( 'textarea' === $type ) {
				echo '<textarea name="' . $name . '" rows="2" class="large-text">' . esc_textarea( $v ) . '</textarea>';
			} else {
				echo '<input type="text" name="' . $name . '" value="' . esc_attr( $v ) . '" class="large-text" />';
			}
			echo '</div>';
		}
		echo '</div>';
	} else {
		$name = 'mygun_field[' . esc_attr( $key ) . ']';
		switch ( $type ) {
			case 'image':
				$img_url = '';
				if ( is_numeric( $val ) && (int) $val > 0 ) {
					$img_url = wp_get_attachment_image_url( (int) $val, 'medium' );
				}
				echo '<div class="mygun-image-field">';
				echo '<div class="mygun-image-preview">' . ( $img_url ? '<img src="' . esc_url( $img_url ) . '" />' : '' ) . '</div>';
				echo '<input type="hidden" name="' . $name . '" value="' . esc_attr( $val ) . '" class="mygun-image-id" />';
				echo '<button type="button" class="button mygun-image-select">' . esc_html__( 'Choose image', 'mygun' ) . '</button> ';
				echo '<button type="button" class="button mygun-image-remove"' . ( $img_url ? '' : ' style="display:none;"' ) . '>' . esc_html__( 'Remove', 'mygun' ) . '</button>';
				echo '</div>';
				break;
			case 'textarea':
			case 'html':
				echo '<textarea name="' . $name . '" rows="4" class="large-text code">' . esc_textarea( is_scalar( $val ) ? $val : '' ) . '</textarea>';
				break;
			case 'checkbox':
				echo '<label class="mygun-check"><input type="checkbox" name="' . $name . '" value="1" ' . checked( '1', $val, false ) . ' /> ' . esc_html__( 'Enabled', 'mygun' ) . '</label>';
				break;
			case 'url':
			case 'email':
			case 'tel':
			default:
				$input_type = in_array( $type, array( 'url', 'email', 'tel' ), true ) ? $type : 'text';
				echo '<input type="' . esc_attr( $input_type ) . '" name="' . $name . '" value="' . esc_attr( is_scalar( $val ) ? $val : '' ) . '" class="large-text" />';
				break;
		}
	}

	echo '</div></div>';
}

/**
 * Persist submitted fields for the active tab (merged into the full option).
 */
function mygun_options_save( $schema, $active_tab ) {
	$all = get_option( 'mygun_options', array() );
	if ( ! is_array( $all ) ) {
		$all = array();
	}

	$submitted = isset( $_POST['mygun_field'] ) && is_array( $_POST['mygun_field'] ) ? wp_unslash( $_POST['mygun_field'] ) : array();
	$fields    = $schema[ $active_tab ]['fields'];

	foreach ( $fields as $field ) {
		$key  = $field['key'];
		$type = $field['type'];
		if ( 'sep' === $type ) {
			continue;
		}

		if ( ! empty( $field['i18n'] ) ) {
			$out = array();
			$raw = isset( $submitted[ $key ] ) && is_array( $submitted[ $key ] ) ? $submitted[ $key ] : array();
			foreach ( array_keys( mygun_lang_list() ) as $slug ) {
				$v = isset( $raw[ $slug ] ) ? $raw[ $slug ] : '';
				$out[ $slug ] = ( 'textarea' === $type ) ? sanitize_textarea_field( $v ) : sanitize_text_field( $v );
			}
			$all[ $key ] = $out;
			continue;
		}

		$v = isset( $submitted[ $key ] ) ? $submitted[ $key ] : '';
		switch ( $type ) {
			case 'image':
				$all[ $key ] = (int) $v;
				break;
			case 'url':
				$all[ $key ] = esc_url_raw( $v );
				break;
			case 'email':
				$all[ $key ] = sanitize_email( $v );
				break;
			case 'checkbox':
				$all[ $key ] = ( '1' === (string) $v ) ? '1' : '0';
				break;
			case 'html':
				$all[ $key ] = wp_kses( $v, mygun_options_allowed_html() );
				break;
			case 'tel':
			default:
				$all[ $key ] = sanitize_text_field( $v );
				break;
		}
	}

	update_option( 'mygun_options', $all );
}

/**
 * Allowed HTML for embed fields (Google Maps iframe etc.).
 */
function mygun_options_allowed_html() {
	return array(
		'iframe' => array(
			'src'             => true,
			'width'           => true,
			'height'          => true,
			'style'           => true,
			'frameborder'     => true,
			'allow'           => true,
			'allowfullscreen' => true,
			'loading'         => true,
			'referrerpolicy'  => true,
			'title'           => true,
		),
	);
}
