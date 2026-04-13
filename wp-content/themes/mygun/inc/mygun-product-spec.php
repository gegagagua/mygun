<?php
/**
 * Product specs: taxonomies, meta fields, admin meta box, shop query helpers.
 *
 * @package mygun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/mygun-manufacturer-country.php';

/**
 * Spec taxonomies (slug => admin label).
 *
 * @return array<string, string>
 */
function mygun_product_spec_taxonomy_definitions() {
	return array(
		'mygun_charging'       => 'დატენვის მექანიზმი (Charging)',
		'mygun_caliber'        => 'კალიბრი (Caliber)',
		'mygun_firearm_type'   => 'ცეცხლსასროლი იარაღის სახეობა (Firearm type)',
		'mygun_stock'          => 'კონდახი (Stock)',
		'mygun_double_barrel'  => 'ორლულიანი (Double-barrel)',
		'mygun_location'       => 'მდებარეობა (Location)',
		'mygun_installment'    => 'განვადებით (Installment)',
		'mygun_item_state'     => 'ნივთის მდგომარეობა (Condition)',
		'mygun_seller'         => 'გამყიდველის ტიპი (Seller type)',
		'mygun_store'          => 'მაღაზიები (Stores)',
		'mygun_ad_type'        => 'განცხადების ტიპი (Ad type)',
		'mygun_body'           => 'კორპუსი (Body)',
	);
}

/**
 * @return array<string, array{name_ka:string,name_en:string}>
 */
function mygun_product_spec_default_terms() {
	return array(
		'mygun_charging' => array(
			array( 'slug' => 'automatic', 'name_ka' => 'ავტომატური', 'name_en' => 'Automatic' ),
			array( 'slug' => 'semi-auto', 'name_ka' => 'ნახევრად-ავტომატური', 'name_en' => 'Semi-automatic' ),
			array( 'slug' => 'manual', 'name_ka' => 'მექანიკური', 'name_en' => 'Manual' ),
		),
		'mygun_caliber' => array(
			array( 'slug' => '12-ga', 'name_ka' => '12 GA', 'name_en' => '12 GA' ),
			array( 'slug' => '16-ga', 'name_ka' => '16 GA', 'name_en' => '16 GA' ),
			array( 'slug' => '20-ga', 'name_ka' => '20 GA', 'name_en' => '20 GA' ),
			array( 'slug' => '28-ga', 'name_ka' => '28 GA', 'name_en' => '28 GA' ),
			array( 'slug' => '32-ga', 'name_ka' => '32 GA', 'name_en' => '32 GA' ),
			array( 'slug' => '9x18-mm', 'name_ka' => '9x18 mm', 'name_en' => '9x18 mm' ),
			array( 'slug' => '9x19-mm', 'name_ka' => '9x19 mm', 'name_en' => '9x19 mm' ),
			array( 'slug' => '40-sw', 'name_ka' => '40 S&W', 'name_en' => '40 S&W' ),
			array( 'slug' => '44-rem', 'name_ka' => '44 REM', 'name_en' => '44 REM' ),
			array( 'slug' => '45-acp', 'name_ka' => '45 ACP', 'name_en' => '45 ACP' ),
			array( 'slug' => '45-colt', 'name_ka' => '45 Colt', 'name_en' => '45 Colt' ),
			array( 'slug' => '22lr', 'name_ka' => '22LR', 'name_en' => '22LR' ),
			array( 'slug' => '223-rem', 'name_ka' => '223 REM', 'name_en' => '223 REM' ),
			array( 'slug' => '5-56x45-mm', 'name_ka' => '5.56x45 mm', 'name_en' => '5.56x45 mm' ),
			array( 'slug' => '5-45x39-mm', 'name_ka' => '5.45x39 mm', 'name_en' => '5.45x39 mm' ),
			array( 'slug' => '7-62x39-mm', 'name_ka' => '7.62x39 mm', 'name_en' => '7.62x39 mm' ),
			array( 'slug' => '7-62x45-mm', 'name_ka' => '7.62x45 mm', 'name_en' => '7.62x45 mm' ),
			array( 'slug' => '7-62x51-mm', 'name_ka' => '7.62x51 mm', 'name_en' => '7.62x51 mm' ),
			array( 'slug' => '7-62x54-mm', 'name_ka' => '7.62x54 mm', 'name_en' => '7.62x54 mm' ),
			array( 'slug' => '300-win-mag', 'name_ka' => '300 Win Mag', 'name_en' => '300 Win Mag' ),
			array( 'slug' => '308-winchester', 'name_ka' => '308 Winchester', 'name_en' => '308 Winchester' ),
			array( 'slug' => 'caliber-other', 'name_ka' => 'სხვა', 'name_en' => 'Other' ),
		),
		'mygun_firearm_type' => array(
			array( 'slug' => 'pistol-revolver', 'name_ka' => 'პისტოლეტი - რევოლვერი', 'name_en' => 'Pistol / Revolver' ),
			array( 'slug' => 'rifled', 'name_ka' => 'ხრახნულიანი', 'name_en' => 'Rifled' ),
			array( 'slug' => 'smoothbore', 'name_ka' => 'გლუვლულიანი', 'name_en' => 'Smoothbore' ),
			array( 'slug' => 'shotgun-pellet', 'name_ka' => 'საფანტის იარაღი', 'name_en' => 'Shotgun / Pellet' ),
		),
		'mygun_double_barrel' => array(
			array( 'slug' => 'yes', 'name_ka' => 'დიახ', 'name_en' => 'Yes' ),
			array( 'slug' => 'no', 'name_ka' => 'არა', 'name_en' => 'No' ),
		),
		'mygun_installment' => array(
			array( 'slug' => 'yes', 'name_ka' => 'დიახ', 'name_en' => 'Yes' ),
			array( 'slug' => 'no', 'name_ka' => 'არა', 'name_en' => 'No' ),
		),
		'mygun_item_state' => array(
			array( 'slug' => 'used', 'name_ka' => 'მეორადი', 'name_en' => 'Used' ),
			array( 'slug' => 'new', 'name_ka' => 'ახალი', 'name_en' => 'New' ),
			array( 'slug' => 'like-new', 'name_ka' => 'ახალივით', 'name_en' => 'Like new' ),
			array( 'slug' => 'parts', 'name_ka' => 'ნაწილებად', 'name_en' => 'For parts' ),
			array( 'slug' => 'outlet', 'name_ka' => 'Outlet', 'name_en' => 'Outlet' ),
		),
		'mygun_seller' => array(
			array( 'slug' => 'private', 'name_ka' => 'კერძო', 'name_en' => 'Private' ),
			array( 'slug' => 'store', 'name_ka' => 'მაღაზია', 'name_en' => 'Store' ),
		),
		'mygun_body' => array(
			array( 'slug' => 'plastic', 'name_ka' => 'პლასტიკი', 'name_en' => 'Plastic' ),
			array( 'slug' => 'metal', 'name_ka' => 'მეტალი', 'name_en' => 'Metal' ),
			array( 'slug' => 'wood', 'name_ka' => 'ხე', 'name_en' => 'Wood' ),
		),
		'mygun_location' => array(
			array( 'slug' => 'tbilisi', 'name_ka' => 'თბილისი', 'name_en' => 'Tbilisi' ),
			array( 'slug' => 'rustavi', 'name_ka' => 'რუსთავი', 'name_en' => 'Rustavi' ),
			array( 'slug' => 'kutaisi', 'name_ka' => 'ქუთაისი', 'name_en' => 'Kutaisi' ),
			array( 'slug' => 'batumi', 'name_ka' => 'ბათუმი', 'name_en' => 'Batumi' ),
			array( 'slug' => 'poti', 'name_ka' => 'ფოთი', 'name_en' => 'Poti' ),
			array( 'slug' => 'abasha', 'name_ka' => 'აბაშა', 'name_en' => 'Abasha' ),
			array( 'slug' => 'adigeni', 'name_ka' => 'ადიგენი', 'name_en' => 'Adigeni' ),
			array( 'slug' => 'ambrolauri', 'name_ka' => 'ამბროლაური', 'name_en' => 'Ambrolauri' ),
		),
	);
}

/**
 * Taxonomies edited via select in admin / shop (excludes legacy unused slugs).
 *
 * @return array<string, string>
 */
function mygun_product_spec_taxonomies_for_editor() {
	$defs = mygun_product_spec_taxonomy_definitions();
	unset( $defs['mygun_stock'], $defs['mygun_store'], $defs['mygun_ad_type'] );
	return $defs;
}

/**
 * Register taxonomies attached to product CPT.
 */
function mygun_register_product_spec_taxonomies() {
	if ( ! post_type_exists( 'product' ) ) {
		return;
	}
	$hidden_ui = array( 'mygun_stock', 'mygun_store', 'mygun_ad_type' );

	foreach ( mygun_product_spec_taxonomy_definitions() as $slug => $label ) {
		$show_ui = ! in_array( $slug, $hidden_ui, true );
		register_taxonomy(
			$slug,
			array( 'product' ),
			array(
				'labels'            => array(
					'name'          => $label,
					'singular_name' => $label,
					'search_items'  => 'Search',
					'all_items'     => 'All',
					'edit_item'     => 'Edit',
					'update_item'   => 'Update',
					'add_new_item'  => 'Add new',
					'new_item_name' => 'New name',
					'menu_name'     => $label,
				),
				'public'            => true,
				'hierarchical'      => false,
				'show_ui'           => $show_ui,
				'show_in_menu'      => $show_ui,
				'show_admin_column' => false,
				'show_in_rest'      => true,
				'meta_box_cb'       => false,
				'rewrite'           => array( 'slug' => str_replace( '_', '-', $slug ) ),
			)
		);
	}
}
add_action( 'init', 'mygun_register_product_spec_taxonomies', 11 );

/**
 * Seed default terms once.
 */
function mygun_maybe_seed_product_spec_terms() {
	if ( get_option( 'mygun_spec_terms_v1' ) ) {
		return;
	}
	foreach ( mygun_product_spec_default_terms() as $taxonomy => $terms ) {
		if ( ! taxonomy_exists( $taxonomy ) ) {
			continue;
		}
		foreach ( $terms as $row ) {
			if ( term_exists( $row['slug'], $taxonomy ) ) {
				continue;
			}
			wp_insert_term(
				$row['name_ka'] . ' / ' . $row['name_en'],
				$taxonomy,
				array( 'slug' => $row['slug'] )
			);
		}
	}
	update_option( 'mygun_spec_terms_v1', 1 );
}
add_action( 'admin_init', 'mygun_maybe_seed_product_spec_terms' );

/**
 * Insert any new caliber terms on sites that already ran mygun_spec_terms_v1.
 */
function mygun_maybe_seed_caliber_extensions() {
	if ( get_option( 'mygun_caliber_extensions_v2' ) ) {
		return;
	}
	$taxonomy = 'mygun_caliber';
	if ( ! taxonomy_exists( $taxonomy ) ) {
		return;
	}
	$all = mygun_product_spec_default_terms();
	if ( empty( $all['mygun_caliber'] ) ) {
		return;
	}
	foreach ( $all['mygun_caliber'] as $row ) {
		if ( term_exists( $row['slug'], $taxonomy ) ) {
			continue;
		}
		wp_insert_term(
			$row['name_ka'] . ' / ' . $row['name_en'],
			$taxonomy,
			array( 'slug' => $row['slug'] )
		);
	}
	update_option( 'mygun_caliber_extensions_v2', 1 );
}
add_action( 'admin_init', 'mygun_maybe_seed_caliber_extensions' );

/**
 * Seed mygun_body terms (plastic / metal / wood).
 */
function mygun_maybe_seed_body_terms() {
	if ( get_option( 'mygun_body_extensions_v1' ) ) {
		return;
	}
	$taxonomy = 'mygun_body';
	if ( ! taxonomy_exists( $taxonomy ) ) {
		return;
	}
	$all = mygun_product_spec_default_terms();
	if ( empty( $all['mygun_body'] ) ) {
		return;
	}
	foreach ( $all['mygun_body'] as $row ) {
		if ( term_exists( $row['slug'], $taxonomy ) ) {
			continue;
		}
		wp_insert_term(
			$row['name_ka'] . ' / ' . $row['name_en'],
			$taxonomy,
			array( 'slug' => $row['slug'] )
		);
	}
	update_option( 'mygun_body_extensions_v1', 1 );
}
add_action( 'admin_init', 'mygun_maybe_seed_body_terms' );

/**
 * Seed mygun_location (Georgian cities / towns).
 */
function mygun_maybe_seed_location_terms() {
	if ( get_option( 'mygun_location_extensions_v1' ) ) {
		return;
	}
	$taxonomy = 'mygun_location';
	if ( ! taxonomy_exists( $taxonomy ) ) {
		return;
	}
	$all = mygun_product_spec_default_terms();
	if ( empty( $all['mygun_location'] ) ) {
		return;
	}
	foreach ( $all['mygun_location'] as $row ) {
		if ( term_exists( $row['slug'], $taxonomy ) ) {
			continue;
		}
		wp_insert_term(
			$row['name_ka'] . ' / ' . $row['name_en'],
			$taxonomy,
			array( 'slug' => $row['slug'] )
		);
	}
	update_option( 'mygun_location_extensions_v1', 1 );
}
add_action( 'admin_init', 'mygun_maybe_seed_location_terms' );

/**
 * @param WP_Term $term
 * @param string  $lang ka|en
 */
function mygun_product_spec_term_label( $term, $lang = 'ka' ) {
	$name = $term->name;
	if ( strpos( $name, ' / ' ) !== false ) {
		$parts = explode( ' / ', $name, 2 );
		return $lang === 'en' ? trim( $parts[1] ) : trim( $parts[0] );
	}
	return $name;
}

/**
 * Public labels for shop filters and single product (KA / EN).
 *
 * @return array<string, array{ka: string, en: string}>
 */
function mygun_product_spec_public_tax_labels() {
	return array(
		'mygun_charging'      => array( 'ka' => 'დატენვის მექანიზმი', 'en' => 'Charging mechanism' ),
		'mygun_caliber'       => array( 'ka' => 'კალიბრი', 'en' => 'Caliber' ),
		'mygun_firearm_type'  => array( 'ka' => 'ცეცხლსასროლი იარაღის სახეობა', 'en' => 'Firearm type' ),
		'mygun_stock'         => array( 'ka' => 'კონდახი', 'en' => 'Stock' ),
		'mygun_double_barrel' => array( 'ka' => 'ორლულიანი', 'en' => 'Double-barrel' ),
		'mygun_location'      => array( 'ka' => 'მდებარეობა', 'en' => 'Location' ),
		'mygun_delivery'      => array( 'ka' => 'მიწოდების ფორმა', 'en' => 'Delivery' ),
		'mygun_installment'   => array( 'ka' => 'განვადებით', 'en' => 'Installment' ),
		'mygun_item_state'    => array( 'ka' => 'ნივთის მდგომარეობა', 'en' => 'Condition' ),
		'mygun_seller'        => array( 'ka' => 'გამყიდველის ტიპი', 'en' => 'Seller type' ),
		'mygun_body'          => array( 'ka' => 'კორპუსი', 'en' => 'Body' ),
	);
}

/**
 * Slug(s) from GET for a taxonomy filter (scalar select or legacy array).
 *
 * @return array<int, string>
 */
function mygun_product_spec_tax_slugs_from_request( $taxonomy ) {
	if ( empty( $_GET[ $taxonomy ] ) ) {
		return array();
	}
	if ( is_array( $_GET[ $taxonomy ] ) ) {
		$slugs = array_map( 'sanitize_title', wp_unslash( $_GET[ $taxonomy ] ) );
		return array_values( array_filter( $slugs ) );
	}
	$one = sanitize_title( wp_unslash( $_GET[ $taxonomy ] ) );
	return $one ? array( $one ) : array();
}

/**
 * Output specification table on single product (only non-empty values).
 *
 * @param int    $post_id Post ID.
 * @param string $lang    ka|en
 */
function mygun_render_product_specifications( $post_id, $lang = 'ka' ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return;
	}

	$rows   = array();
	$labels = mygun_product_spec_public_tax_labels();
	$lk     = $lang === 'en' ? 'en' : 'ka';

	$optics = get_post_meta( $post_id, '_mygun_optics', true );
	if ( 'yes' === $optics || 'no' === $optics ) {
		$rows[] = array(
			'label' => 'en' === $lang ? 'Optics' : 'ოპტიკა',
			'value' => 'yes' === $optics ? ( 'en' === $lang ? 'Yes' : 'დიახ' ) : ( 'en' === $lang ? 'No' : 'არა' ),
		);
	}

	$stock_inc = get_post_meta( $post_id, '_mygun_stock_included', true );
	if ( 'yes' === $stock_inc || 'no' === $stock_inc ) {
		$rows[] = array(
			'label' => 'en' === $lang ? 'Stock' : 'კონდახი',
			'value' => 'yes' === $stock_inc ? ( 'en' === $lang ? 'Yes' : 'დიახ' ) : ( 'en' === $lang ? 'No' : 'არა' ),
		);
	}

	$mag = get_post_meta( $post_id, '_mygun_mag_capacity', true );
	if ( $mag !== '' && $mag !== null && is_numeric( $mag ) ) {
		$rows[] = array(
			'label' => 'en' === $lang ? 'Magazine capacity' : 'მჭიდის ტევადობა',
			'value' => (string) (int) $mag,
		);
	}

	$len = get_post_meta( $post_id, '_mygun_length_mm', true );
	if ( $len !== '' && $len !== null && is_numeric( $len ) ) {
		$rows[] = array(
			'label' => 'en' === $lang ? 'Length (mm)' : 'სიგრძე',
			'value' => (string) (int) $len,
		);
	}

	$weight = get_post_meta( $post_id, '_mygun_weight_g', true );
	if ( $weight !== '' && $weight !== null && is_numeric( $weight ) ) {
		$rows[] = array(
			'label' => 'en' === $lang ? 'Weight (g)' : 'წონა',
			'value' => (string) (int) $weight,
		);
	}

	$mfc_country = get_post_meta( $post_id, '_mygun_manufacturer_country', true );
	if ( $mfc_country !== '' && $mfc_country !== null ) {
		$mfc_label = function_exists( 'mygun_manufacturer_country_label' ) ? mygun_manufacturer_country_label( (string) $mfc_country, $lang ) : '';
		if ( $mfc_label !== '' ) {
			$rows[] = array(
				'label' => 'en' === $lang ? 'Country of manufacture' : 'მწარმოებელი ქვეყანა',
				'value' => $mfc_label,
			);
		}
	}

	foreach ( mygun_product_spec_taxonomies_for_editor() as $tax => $admin_lbl ) {
		$terms = get_the_terms( $post_id, $tax );
		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			continue;
		}
		$parts = array();
		foreach ( $terms as $term ) {
			$parts[] = mygun_product_spec_term_label( $term, $lang );
		}
		$parts = array_filter( $parts );
		if ( empty( $parts ) ) {
			continue;
		}
		$lab = isset( $labels[ $tax ] ) ? $labels[ $tax ][ $lk ] : $admin_lbl;
		$rows[] = array(
			'label' => $lab,
			'value' => implode( ', ', $parts ),
		);
	}

	if ( empty( $rows ) ) {
		return;
	}

	$heading = 'en' === $lang ? 'Specifications' : 'მახასიათებლები';
	echo '<div class="product-single-specs">';
	echo '<h2 class="product-single-specs-title">' . esc_html( $heading ) . '</h2>';
	echo '<dl class="product-single-specs-list">';
	foreach ( $rows as $row ) {
		echo '<div class="product-single-specs-row">';
		echo '<dt>' . esc_html( $row['label'] ) . '</dt>';
		echo '<dd>' . esc_html( $row['value'] ) . '</dd>';
		echo '</div>';
	}
	echo '</dl></div>';
}

/**
 * Admin meta box.
 */
function mygun_product_spec_add_meta_box() {
	add_meta_box(
		'mygun_product_spec',
		'Product specifications / პროდუქტის მახასიათებლები',
		'mygun_product_spec_render_meta_box',
		'product',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'mygun_product_spec_add_meta_box' );

/**
 * @param WP_Post $post
 */
function mygun_product_spec_render_meta_box( $post ) {
	wp_nonce_field( 'mygun_product_spec_save', 'mygun_product_spec_nonce' );

	$optics    = get_post_meta( $post->ID, '_mygun_optics', true );
	$stock_inc = get_post_meta( $post->ID, '_mygun_stock_included', true );
	$mag       = get_post_meta( $post->ID, '_mygun_mag_capacity', true );
	$len       = get_post_meta( $post->ID, '_mygun_length_mm', true );
	$weight    = get_post_meta( $post->ID, '_mygun_weight_g', true );
	$mfc_sel   = get_post_meta( $post->ID, '_mygun_manufacturer_country', true );

	echo '<p><label for="mygun_optics_sel"><strong>ოპტიკა (Optics)</strong></label></p>';
	echo '<select id="mygun_optics_sel" name="mygun_optics" class="widefat">';
	echo '<option value=""' . selected( $optics, '', false ) . '>— / All</option>';
	echo '<option value="yes"' . selected( $optics, 'yes', false ) . '>დიახ / Yes</option>';
	echo '<option value="no"' . selected( $optics, 'no', false ) . '>არა / No</option>';
	echo '</select>';

	echo '<p><label for="mygun_stock_included_sel"><strong>კონდახი (Stock — yes/no)</strong></label></p>';
	echo '<select id="mygun_stock_included_sel" name="mygun_stock_included" class="widefat">';
	echo '<option value=""' . selected( $stock_inc, '', false ) . '>— / All</option>';
	echo '<option value="yes"' . selected( $stock_inc, 'yes', false ) . '>დიახ / Yes</option>';
	echo '<option value="no"' . selected( $stock_inc, 'no', false ) . '>არა / No</option>';
	echo '</select>';

	echo '<p><strong>მჭიდის ტევადობა (Magazine capacity)</strong></p>';
	echo '<input type="number" step="1" name="mygun_mag_capacity" value="' . esc_attr( $mag ) . '" class="small-text" />';

	echo '<p><strong>სიგრძე (მმ) / Length (mm)</strong></p>';
	echo '<input type="number" step="1" name="mygun_length_mm" value="' . esc_attr( $len ) . '" class="small-text" />';

	echo '<p><strong>წონა (გრ) / Weight (g)</strong></p>';
	echo '<input type="number" step="1" name="mygun_weight_g" value="' . esc_attr( $weight ) . '" class="small-text" />';

	echo '<p><label for="mygun_manufacturer_country"><strong>მწარმოებელი ქვეყანა (Country of manufacture)</strong></label></p>';
	echo '<select id="mygun_manufacturer_country" name="mygun_manufacturer_country" class="widefat">';
	echo '<option value="">' . esc_html( '— / არ არის არჩეული / Not set' ) . '</option>';
	if ( function_exists( 'mygun_manufacturer_country_choices' ) ) {
		foreach ( mygun_manufacturer_country_choices() as $slug => $pair ) {
			echo '<option value="' . esc_attr( $slug ) . '"' . selected( strtolower( (string) $mfc_sel ), $slug, false ) . '>' . esc_html( $pair['ka'] . ' / ' . $pair['en'] ) . '</option>';
		}
	}
	echo '</select>';

	foreach ( mygun_product_spec_taxonomies_for_editor() as $tax => $label ) {
		$terms = get_terms( array( 'taxonomy' => $tax, 'hide_empty' => false ) );
		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			echo '<p><strong>' . esc_html( $label ) . '</strong> — <em>no terms yet (add under Products or via Quick Edit URL).</em></p>';
			continue;
		}
		$selected = wp_get_post_terms( $post->ID, $tax, array( 'fields' => 'slugs' ) );
		if ( is_wp_error( $selected ) ) {
			$selected = array();
		}
		$current = ! empty( $selected ) ? $selected[0] : '';
		echo '<p><label for="mygun-tax-sel-' . esc_attr( $tax ) . '"><strong>' . esc_html( $label ) . '</strong></label></p>';
		echo '<select id="mygun-tax-sel-' . esc_attr( $tax ) . '" name="' . esc_attr( $tax ) . '" class="widefat">';
		echo '<option value="">— / ' . esc_html( 'არ არის არჩეული / Not set' ) . '</option>';
		foreach ( $terms as $term ) {
			echo '<option value="' . esc_attr( $term->slug ) . '"' . selected( $current, $term->slug, false ) . '>' . esc_html( $term->name ) . '</option>';
		}
		echo '</select>';
	}
}

/**
 * @param int     $post_id
 * @param WP_Post $post
 */
function mygun_product_spec_save( $post_id, $post ) {
	if ( ! isset( $_POST['mygun_product_spec_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mygun_product_spec_nonce'] ) ), 'mygun_product_spec_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( 'product' !== $post->post_type ) {
		return;
	}

	$optics = isset( $_POST['mygun_optics'] ) ? sanitize_text_field( wp_unslash( $_POST['mygun_optics'] ) ) : '';
	if ( ! in_array( $optics, array( '', 'yes', 'no' ), true ) ) {
		$optics = '';
	}
	update_post_meta( $post_id, '_mygun_optics', $optics );

	$stock_inc = isset( $_POST['mygun_stock_included'] ) ? sanitize_text_field( wp_unslash( $_POST['mygun_stock_included'] ) ) : '';
	if ( ! in_array( $stock_inc, array( '', 'yes', 'no' ), true ) ) {
		$stock_inc = '';
	}
	update_post_meta( $post_id, '_mygun_stock_included', $stock_inc );

	$mag = isset( $_POST['mygun_mag_capacity'] ) ? sanitize_text_field( wp_unslash( $_POST['mygun_mag_capacity'] ) ) : '';
	$mag = $mag === '' ? '' : max( 0, (int) $mag );
	update_post_meta( $post_id, '_mygun_mag_capacity', $mag );

	$len = isset( $_POST['mygun_length_mm'] ) ? sanitize_text_field( wp_unslash( $_POST['mygun_length_mm'] ) ) : '';
	$len = $len === '' ? '' : max( 0, (int) $len );
	update_post_meta( $post_id, '_mygun_length_mm', $len );

	$w = isset( $_POST['mygun_weight_g'] ) ? sanitize_text_field( wp_unslash( $_POST['mygun_weight_g'] ) ) : '';
	$w = $w === '' ? '' : max( 0, (int) $w );
	update_post_meta( $post_id, '_mygun_weight_g', $w );

	$mfc = isset( $_POST['mygun_manufacturer_country'] ) ? strtolower( sanitize_text_field( wp_unslash( $_POST['mygun_manufacturer_country'] ) ) ) : '';
	if ( $mfc !== '' && function_exists( 'mygun_manufacturer_country_is_valid_slug' ) && mygun_manufacturer_country_is_valid_slug( $mfc ) ) {
		update_post_meta( $post_id, '_mygun_manufacturer_country', $mfc );
	} else {
		delete_post_meta( $post_id, '_mygun_manufacturer_country' );
	}

	foreach ( array_keys( mygun_product_spec_taxonomies_for_editor() ) as $tax ) {
		$slugs = array();
		if ( isset( $_POST[ $tax ] ) && ! is_array( $_POST[ $tax ] ) ) {
			$one = sanitize_title( wp_unslash( $_POST[ $tax ] ) );
			if ( $one !== '' ) {
				$slugs = array( $one );
			}
		} elseif ( isset( $_POST[ $tax ] ) && is_array( $_POST[ $tax ] ) ) {
			$slugs = array_map( 'sanitize_title', wp_unslash( $_POST[ $tax ] ) );
			$slugs = array_filter( $slugs );
		}
		wp_set_object_terms( $post_id, $slugs, $tax, false );
	}
}
add_action( 'save_post_product', 'mygun_product_spec_save', 10, 2 );

/**
 * Build associative array of active shop filter GET params (for pagination links).
 *
 * @return array<string, string|array<int, string>>
 */
function mygun_shop_collect_filter_query_args() {
	$out = array();
	if ( isset( $_GET['product_cat'] ) && $_GET['product_cat'] !== '' ) {
		$out['product_cat'] = sanitize_title( wp_unslash( $_GET['product_cat'] ) );
	}
	if ( isset( $_GET['mygun_optics'] ) && $_GET['mygun_optics'] !== '' ) {
		$o = sanitize_text_field( wp_unslash( $_GET['mygun_optics'] ) );
		if ( in_array( $o, array( 'yes', 'no' ), true ) ) {
			$out['mygun_optics'] = $o;
		}
	}
	if ( isset( $_GET['mygun_stock_included'] ) && $_GET['mygun_stock_included'] !== '' ) {
		$s = sanitize_text_field( wp_unslash( $_GET['mygun_stock_included'] ) );
		if ( in_array( $s, array( 'yes', 'no' ), true ) ) {
			$out['mygun_stock_included'] = $s;
		}
	}
	$numeric = array( 'mygun_mag_min', 'mygun_mag_max', 'mygun_len_min', 'mygun_len_max', 'mygun_w_min', 'mygun_w_max', 'mygun_price_min', 'mygun_price_max' );
	foreach ( $numeric as $key ) {
		if ( isset( $_GET[ $key ] ) && $_GET[ $key ] !== '' ) {
			$out[ $key ] = sanitize_text_field( wp_unslash( $_GET[ $key ] ) );
		}
	}
	foreach ( array_keys( mygun_product_spec_taxonomies_for_editor() ) as $tax ) {
		$slugs = mygun_product_spec_tax_slugs_from_request( $tax );
		if ( $slugs ) {
			$out[ $tax ] = count( $slugs ) === 1 ? $slugs[0] : $slugs;
		}
	}
	if ( isset( $_GET['shop_order'] ) && $_GET['shop_order'] !== '' ) {
		$so = sanitize_key( wp_unslash( $_GET['shop_order'] ) );
		if ( in_array( $so, array( 'newest', 'price_asc', 'price_desc' ), true ) ) {
			$out['shop_order'] = $so;
		}
	}
	return $out;
}

/**
 * URL for "All products" in the shop sidebar: current path without any shop filters or sort.
 *
 * @return string
 */
function mygun_shop_all_products_url() {
	$keys = array(
		'product_cat',
		'shop_order',
		'paged',
		'page',
		'mygun_optics',
		'mygun_stock_included',
		'mygun_mag_min',
		'mygun_mag_max',
		'mygun_len_min',
		'mygun_len_max',
		'mygun_w_min',
		'mygun_w_max',
		'mygun_price_min',
		'mygun_price_max',
	);
	foreach ( array_keys( mygun_product_spec_taxonomies_for_editor() ) as $tax ) {
		$keys[] = $tax;
	}
	return remove_query_arg( array_unique( $keys ) );
}

/**
 * @param array<string, mixed> $tax_query
 * @return array<int, array<string, mixed>>
 */
function mygun_product_spec_flatten_tax_clauses( $tax_query ) {
	if ( empty( $tax_query ) || ! is_array( $tax_query ) ) {
		return array();
	}
	$out = array();
	if ( isset( $tax_query['relation'] ) ) {
		foreach ( $tax_query as $key => $clause ) {
			if ( 'relation' === $key || ! is_array( $clause ) ) {
				continue;
			}
			if ( isset( $clause['taxonomy'] ) ) {
				$out[] = $clause;
			}
		}
		return $out;
	}
	foreach ( $tax_query as $clause ) {
		if ( is_array( $clause ) && isset( $clause['taxonomy'] ) ) {
			$out[] = $clause;
		}
	}
	return $out;
}

/**
 * Merge shop WP_Query args with filters from $_GET.
 *
 * @param array<string, mixed> $shop_query_args
 * @return array<string, mixed>
 */
function mygun_shop_apply_filters_to_query( $shop_query_args ) {
	$tax_blocks = mygun_product_spec_flatten_tax_clauses( isset( $shop_query_args['tax_query'] ) ? $shop_query_args['tax_query'] : array() );

	foreach ( array_keys( mygun_product_spec_taxonomies_for_editor() ) as $tax ) {
		$slugs = mygun_product_spec_tax_slugs_from_request( $tax );
		if ( ! $slugs ) {
			continue;
		}
		$tax_blocks[] = array(
			'taxonomy' => $tax,
			'field'    => 'slug',
			'terms'    => $slugs,
			'operator' => 'IN',
		);
	}

	if ( ! empty( $tax_blocks ) ) {
		$shop_query_args['tax_query'] = array_merge( array( 'relation' => 'AND' ), $tax_blocks );
	}

	$meta_query = array( 'relation' => 'AND' );

	if ( isset( $_GET['mygun_optics'] ) ) {
		$o = sanitize_text_field( wp_unslash( $_GET['mygun_optics'] ) );
		if ( in_array( $o, array( 'yes', 'no' ), true ) ) {
			$meta_query[] = array(
				'key'   => '_mygun_optics',
				'value' => $o,
				'compare' => '=',
			);
		}
	}

	if ( isset( $_GET['mygun_stock_included'] ) ) {
		$s = sanitize_text_field( wp_unslash( $_GET['mygun_stock_included'] ) );
		if ( in_array( $s, array( 'yes', 'no' ), true ) ) {
			$meta_query[] = array(
				'key'     => '_mygun_stock_included',
				'value'   => $s,
				'compare' => '=',
			);
		}
	}

	$mag_min = isset( $_GET['mygun_mag_min'] ) && $_GET['mygun_mag_min'] !== '' ? (int) $_GET['mygun_mag_min'] : null;
	$mag_max = isset( $_GET['mygun_mag_max'] ) && $_GET['mygun_mag_max'] !== '' ? (int) $_GET['mygun_mag_max'] : null;
	if ( null !== $mag_min ) {
		$meta_query[] = array(
			'key'     => '_mygun_mag_capacity',
			'value'   => $mag_min,
			'compare' => '>=',
			'type'    => 'NUMERIC',
		);
	}
	if ( null !== $mag_max ) {
		$meta_query[] = array(
			'key'     => '_mygun_mag_capacity',
			'value'   => $mag_max,
			'compare' => '<=',
			'type'    => 'NUMERIC',
		);
	}

	$len_min = isset( $_GET['mygun_len_min'] ) && $_GET['mygun_len_min'] !== '' ? (int) $_GET['mygun_len_min'] : null;
	$len_max = isset( $_GET['mygun_len_max'] ) && $_GET['mygun_len_max'] !== '' ? (int) $_GET['mygun_len_max'] : null;
	if ( null !== $len_min ) {
		$meta_query[] = array(
			'key'     => '_mygun_length_mm',
			'value'   => $len_min,
			'compare' => '>=',
			'type'    => 'NUMERIC',
		);
	}
	if ( null !== $len_max ) {
		$meta_query[] = array(
			'key'     => '_mygun_length_mm',
			'value'   => $len_max,
			'compare' => '<=',
			'type'    => 'NUMERIC',
		);
	}

	$w_min = isset( $_GET['mygun_w_min'] ) && $_GET['mygun_w_min'] !== '' ? (int) $_GET['mygun_w_min'] : null;
	$w_max = isset( $_GET['mygun_w_max'] ) && $_GET['mygun_w_max'] !== '' ? (int) $_GET['mygun_w_max'] : null;
	if ( null !== $w_min ) {
		$meta_query[] = array(
			'key'     => '_mygun_weight_g',
			'value'   => $w_min,
			'compare' => '>=',
			'type'    => 'NUMERIC',
		);
	}
	if ( null !== $w_max ) {
		$meta_query[] = array(
			'key'     => '_mygun_weight_g',
			'value'   => $w_max,
			'compare' => '<=',
			'type'    => 'NUMERIC',
		);
	}

	$pmin = isset( $_GET['mygun_price_min'] ) && $_GET['mygun_price_min'] !== '' ? floatval( wp_unslash( $_GET['mygun_price_min'] ) ) : null;
	$pmax = isset( $_GET['mygun_price_max'] ) && $_GET['mygun_price_max'] !== '' ? floatval( wp_unslash( $_GET['mygun_price_max'] ) ) : null;
	if ( null !== $pmin || null !== $pmax ) {
		$lo = null !== $pmin ? $pmin : 0;
		$hi = null !== $pmax ? $pmax : 999999999;
		$meta_query[] = array(
			'relation' => 'OR',
			array(
				'key'     => '_price',
				'value'   => array( $lo, $hi ),
				'compare' => 'BETWEEN',
				'type'    => 'DECIMAL',
			),
			array(
				'key'     => '_product_price',
				'value'   => array( $lo, $hi ),
				'compare' => 'BETWEEN',
				'type'    => 'DECIMAL',
			),
		);
	}

	if ( count( $meta_query ) > 1 ) {
		$shop_query_args['meta_query'] = $meta_query;
	}

	$shop_order = 'newest';
	if ( isset( $_GET['shop_order'] ) && $_GET['shop_order'] !== '' ) {
		$so = sanitize_key( wp_unslash( $_GET['shop_order'] ) );
		if ( in_array( $so, array( 'newest', 'price_asc', 'price_desc' ), true ) ) {
			$shop_order = $so;
		}
	}
	if ( 'price_asc' === $shop_order || 'price_desc' === $shop_order ) {
		$shop_query_args['mygun_shop_price_order'] = 'price_asc' === $shop_order ? 'ASC' : 'DESC';
		unset( $shop_query_args['meta_key'] );
		$shop_query_args['orderby'] = 'date';
		$shop_query_args['order']   = 'DESC';
	} else {
		unset( $shop_query_args['mygun_shop_price_order'], $shop_query_args['meta_key'] );
		$shop_query_args['orderby'] = 'date';
		$shop_query_args['order']   = 'DESC';
	}

	return $shop_query_args;
}

/**
 * Sort shop products by numeric price from WooCommerce (_price / _regular_price) or theme (_product_price).
 *
 * @param array<string, string> $clauses Query clauses.
 * @param WP_Query               $query  Query object.
 * @return array<string, string>
 */
function mygun_shop_posts_clauses_price_order( $clauses, $query ) {
	if ( ! $query instanceof WP_Query ) {
		return $clauses;
	}
	$order = $query->get( 'mygun_shop_price_order' );
	if ( ! $order ) {
		return $clauses;
	}
	$dir = strtoupper( (string) $order ) === 'ASC' ? 'ASC' : 'DESC';

	global $wpdb;
	$alias = 'mygun_psort';
	if ( ! empty( $clauses['join'] ) && strpos( $clauses['join'], $alias ) !== false ) {
		return $clauses;
	}

	$coalesce_null = 'ASC' === $dir ? '999999999' : '-1';

	$clauses['join'] .= " LEFT JOIN (
		SELECT post_id, MAX( CAST( meta_value AS DECIMAL(14,4) ) ) AS sort_price
		FROM {$wpdb->postmeta}
		WHERE meta_key IN ( '_price', '_regular_price', '_product_price' )
			AND meta_value != ''
		GROUP BY post_id
	) {$alias} ON ( {$wpdb->posts}.ID = {$alias}.post_id )";

	$clauses['orderby'] = "COALESCE( {$alias}.sort_price, {$coalesce_null} ) {$dir}, {$wpdb->posts}.post_date DESC";

	return $clauses;
}
add_filter( 'posts_clauses', 'mygun_shop_posts_clauses_price_order', 25, 2 );
