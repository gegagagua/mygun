<?php
/**
 * Import products from tools/excel-accessories-import/products.json (Excel export).
 *
 * Run (from site root, DB online):
 *   wp eval-file wp-content/themes/mygun/tools/run-excel-import.php
 *
 * Idempotent: uses post meta _mygun_excel_import_row matching excel_row.
 *
 * @package mygun
 */

if ( ! function_exists( 'wp_insert_post' ) ) {
	fwrite( STDERR, "Load WordPress first, e.g. wp eval-file ...\n" );
	exit( 1 );
}

$base = __DIR__ . '/excel-accessories-import';
$json_path = $base . '/products.json';

if ( ! is_readable( $json_path ) ) {
	fwrite( STDERR, "Missing {$json_path}\n" );
	exit( 1 );
}

$data = json_decode( file_get_contents( $json_path ), true );
if ( ! is_array( $data ) || empty( $data['products'] ) ) {
	fwrite( STDERR, "Invalid JSON\n" );
	exit( 1 );
}

$cat_cfg = isset( $data['category'] ) ? $data['category'] : array( 'slug' => 'aksesuarebi', 'name' => 'აქსესუარები' );
$slug    = isset( $cat_cfg['slug'] ) ? sanitize_title( $cat_cfg['slug'] ) : 'aksesuarebi';
$name    = isset( $cat_cfg['name'] ) ? $cat_cfg['name'] : 'აქსესუარები';

$term = get_term_by( 'slug', $slug, 'product_cat' );
if ( ! $term ) {
	$term = get_term_by( 'name', $name, 'product_cat' );
}
if ( ! $term ) {
	$ins = wp_insert_term(
		$name,
		'product_cat',
		array(
			'slug' => $slug,
		)
	);
	if ( is_wp_error( $ins ) ) {
		fwrite( STDERR, 'Category error: ' . $ins->get_error_message() . "\n" );
		exit( 1 );
	}
	$term_id = (int) $ins['term_id'];
} else {
	$term_id = (int) $term->term_id;
}

$admin = get_users(
	array(
		'role'    => 'administrator',
		'number'  => 1,
		'orderby' => 'ID',
		'order'   => 'ASC',
	)
);
$author_id = ! empty( $admin ) ? (int) $admin[0]->ID : 1;

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$created = 0;
$skipped = 0;
$failed  = 0;

foreach ( $data['products'] as $row ) {
	$excel_row = isset( $row['excel_row'] ) ? (int) $row['excel_row'] : 0;
	$title     = isset( $row['title'] ) ? sanitize_text_field( $row['title'] ) : '';
	$price     = isset( $row['price'] ) ? floatval( $row['price'] ) : 0;
	$desc      = isset( $row['description'] ) ? wp_kses_post( $row['description'] ) : '';
	$img       = isset( $row['image'] ) ? $row['image'] : '';

	if ( $excel_row <= 0 || '' === $title ) {
		++$failed;
		continue;
	}

	$q = new WP_Query(
		array(
			'post_type'              => 'product',
			'post_status'            => 'any',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'meta_query'             => array(
				array(
					'key'   => '_mygun_excel_import_row',
					'value' => (string) $excel_row,
				),
			),
		)
	);
	if ( $q->have_posts() ) {
		++$skipped;
		wp_reset_postdata();
		continue;
	}
	wp_reset_postdata();

	$post_id = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_content' => $desc,
			'post_status'  => 'publish',
			'post_type'    => 'product',
			'post_author'  => $author_id,
		),
		true
	);

	if ( is_wp_error( $post_id ) || ! $post_id ) {
		++$failed;
		fwrite( STDERR, "Insert failed row {$excel_row}: " . ( is_wp_error( $post_id ) ? $post_id->get_error_message() : 'unknown' ) . "\n" );
		continue;
	}

	update_post_meta( $post_id, '_mygun_excel_import_row', (string) $excel_row );
	update_post_meta( $post_id, '_product_price', $price );
	update_post_meta( $post_id, '_product_condition', 'new' );

	if ( function_exists( 'wc_get_product' ) ) {
		update_post_meta( $post_id, '_regular_price', wc_format_decimal( $price, 2 ) );
		update_post_meta( $post_id, '_price', wc_format_decimal( $price, 2 ) );
		if ( taxonomy_exists( 'product_type' ) ) {
			wp_set_object_terms( $post_id, 'simple', 'product_type', false );
		}
	}

	wp_set_object_terms( $post_id, array( $term_id ), 'product_cat', false );

	if ( $img && is_readable( $base . '/images/' . $img ) ) {
		$file = $base . '/images/' . $img;
		$bits = file_get_contents( $file );
		if ( false !== $bits ) {
			$upload = wp_upload_bits( basename( $img ), null, $bits );
			if ( empty( $upload['error'] ) && ! empty( $upload['file'] ) ) {
				$filetype = wp_check_filetype( $upload['file'], null );
				$attachment = array(
					'post_mime_type' => $filetype['type'] ? $filetype['type'] : 'image/png',
					'post_title'     => sanitize_file_name( pathinfo( $img, PATHINFO_FILENAME ) ),
					'post_content'   => '',
					'post_status'    => 'inherit',
				);
				$attach_id = wp_insert_attachment( $attachment, $upload['file'], $post_id );
				if ( ! is_wp_error( $attach_id ) ) {
					$meta = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
					wp_update_attachment_metadata( $attach_id, $meta );
					set_post_thumbnail( $post_id, $attach_id );
				}
			}
		}
	}

	++$created;
}

echo "Done. Created: {$created}, skipped (already imported): {$skipped}, failed: {$failed}, category term_id: {$term_id}\n";
