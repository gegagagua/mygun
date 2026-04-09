<?php
/**
 * Single Product template.
 *
 * @package mygun
 */

get_header();

$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
$t    = function( $en, $ka ) use ( $lang ) {
	return $lang === 'en' ? $en : $ka;
};
?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php
	$product_id       = get_the_ID();
	$product_price = get_post_meta( $product_id, '_price', true );
	if ( '' === $product_price || null === $product_price ) {
		$product_price = get_post_meta( $product_id, '_regular_price', true );
	}
	if ( '' === $product_price || null === $product_price ) {
		$product_price = get_post_meta( $product_id, '_product_price', true );
	}
	$product_phone    = get_post_meta( $product_id, '_product_phone', true );
	$product_location = get_post_meta( $product_id, '_product_location', true );
	$product_condition = get_post_meta( $product_id, '_product_condition', true );
	$product_terms    = get_the_terms( $product_id, 'product_cat' );
	$product_cats     = ( $product_terms && ! is_wp_error( $product_terms ) ) ? implode( ', ', wp_list_pluck( $product_terms, 'name' ) ) : '';
	$gallery_raw    = get_post_meta( $product_id, '_product_gallery', true );
	$gallery_ids    = array_filter( array_map( 'absint', explode( ',', (string) $gallery_raw ) ) );
	$featured_image = has_post_thumbnail( $product_id ) ? get_the_post_thumbnail_url( $product_id, 'full' ) : '';
	$gallery_images = array();

	if ( ! empty( $gallery_ids ) ) {
		foreach ( $gallery_ids as $gallery_id ) {
			$gallery_full = wp_get_attachment_image_url( $gallery_id, 'full' );
			if ( $gallery_full ) {
				$gallery_images[] = $gallery_full;
			}
		}
	}

	$gallery_images = array_values( array_unique( $gallery_images ) );

	if ( empty( $featured_image ) ) {
		$featured_image = ! empty( $gallery_images ) ? $gallery_images[0] : get_template_directory_uri() . '/assets/images/products/1.jpg';
	}

	if ( empty( $gallery_images ) ) {
		$gallery_images[] = $featured_image;
	}

	$gallery_slides = array();
	if ( ! empty( $gallery_ids ) ) {
		foreach ( $gallery_ids as $gid ) {
			$full = wp_get_attachment_image_url( $gid, 'full' );
			if ( ! $full ) {
				continue;
			}
			$disp = wp_get_attachment_image_url( $gid, 'product-gallery' );
			if ( ! $disp ) {
				$disp = $full;
			}
			$cap  = wp_get_attachment_caption( $gid );
			$gallery_slides[] = array(
				'full' => $full,
				'disp' => $disp,
				'alt'  => $cap ? $cap : get_the_title(),
			);
		}
	}
	if ( empty( $gallery_slides ) ) {
		$gallery_slides[] = array(
			'full' => $featured_image,
			'disp' => $featured_image,
			'alt'  => get_the_title(),
		);
	}

	ob_start();
	if ( function_exists( 'mygun_render_product_specifications' ) ) {
		mygun_render_product_specifications( $product_id, $lang );
	}
	$mygun_specs_html = trim( (string) ob_get_clean() );
	?>

	<section class="product-single-area section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="product-single-content">
						<h1 class="product-single-title"><?php the_title(); ?></h1>

						<?php if ( '' !== $product_price && null !== $product_price ) : ?>
							<div class="product-single-price"><?= esc_html( $product_price ); ?> ₾</div>
						<?php endif; ?>

						<?php if ( $product_cats ) : ?>
							<div class="product-single-category">
								<strong><?= esc_html( $t( 'Category', 'კატეგორია' ) ); ?>:</strong>
								<span><?= esc_html( $product_cats ); ?></span>
							</div>
						<?php endif; ?>

						<div class="product-single-meta">
							<?php if ( $product_condition ) : ?>
								<span>
									<i class="fas fa-check-circle"></i>
									<?= esc_html( $product_condition === 'new' ? $t( 'New', 'ახალი' ) : $t( 'Used', 'მეორადი' ) ); ?>
								</span>
							<?php endif; ?>
							<?php if ( $product_location ) : ?>
								<span><i class="fas fa-map-marker-alt"></i> <?= esc_html( $product_location ); ?></span>
							<?php endif; ?>
							<?php if ( $product_phone ) : ?>
								<span><i class="fas fa-phone-alt"></i> <?= esc_html( $product_phone ); ?></span>
							<?php endif; ?>
						</div>

						<div class="row product-single-media-specs-row">
							<div class="<?= $mygun_specs_html ? 'col-lg-6 col-md-12' : 'col-xs-12'; ?> product-single-media-col">
								<div class="product-single-media product-single-media-gallery">
									<?php if ( count( $gallery_slides ) > 1 ) : ?>
										<div class="product-single-slider owl-carousel">
											<?php foreach ( $gallery_slides as $slide ) : ?>
												<div class="product-single-slide">
													<a class="product-single-lightbox" href="<?= esc_url( $slide['full'] ); ?>" title="<?= esc_attr( $slide['alt'] ); ?>">
														<img src="<?= esc_url( $slide['disp'] ); ?>" alt="<?= esc_attr( $slide['alt'] ); ?>">
													</a>
												</div>
											<?php endforeach; ?>
										</div>
									<?php else : ?>
										<?php $one = $gallery_slides[0]; ?>
										<div class="product-single-main-image">
											<a class="product-single-lightbox" href="<?= esc_url( $one['full'] ); ?>" title="<?= esc_attr( $one['alt'] ); ?>">
												<img src="<?= esc_url( $one['disp'] ); ?>" alt="<?= esc_attr( $one['alt'] ); ?>">
											</a>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<?php if ( $mygun_specs_html ) : ?>
								<div class="col-lg-6 col-md-12 product-single-specs-col">
									<?php echo wp_kses_post( $mygun_specs_html ); ?>
								</div>
							<?php endif; ?>
						</div>

						<div class="product-single-description">
							<?php the_content(); ?>
						</div>

						<div class="product-single-actions">
							<?php if ( $product_phone ) : ?>
								<a href="tel:<?= esc_attr( preg_replace( '/[^0-9+]/', '', $product_phone ) ); ?>" class="btn2"><?= esc_html( $t( 'Call Seller', 'დარეკვა' ) ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

			<?php
			$related_args = array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => 3,
				'post__not_in'   => array( $product_id ),
			);

			if ( $product_terms && ! is_wp_error( $product_terms ) ) {
				$related_args['tax_query'] = array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => wp_list_pluck( $product_terms, 'term_id' ),
					),
				);
			}

			$related_products = new WP_Query( $related_args );
			if ( $related_products->have_posts() ) :
			?>
				<div class="row">
					<div class="col-sm-12">
						<div class="section-heading">
							<h2><?= esc_html( $t( 'Related Products', 'მსგავსი პროდუქტები' ) ); ?></h2>
						</div>
					</div>
					<?php while ( $related_products->have_posts() ) : $related_products->the_post(); ?>
						<div class="col-md-4 col-sm-6">
							<div class="products product-related-card">
								<figure>
									<a href="<?php the_permalink(); ?>">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'product-thumb', array( 'alt' => get_the_title() ) ); ?>
										<?php else : ?>
											<img src="<?= esc_url( get_template_directory_uri() . '/assets/images/products/1.jpg' ); ?>" alt="<?php the_title_attribute(); ?>">
										<?php endif; ?>
									</a>
								</figure>
								<div class="contents">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<?php
									$rel_price = get_post_meta( get_the_ID(), '_price', true );
									if ( '' === $rel_price || null === $rel_price ) {
										$rel_price = get_post_meta( get_the_ID(), '_regular_price', true );
									}
									if ( '' === $rel_price || null === $rel_price ) {
										$rel_price = get_post_meta( get_the_ID(), '_product_price', true );
									}
									?>
									<span><?= $rel_price !== '' ? esc_html( $rel_price ) . ' ₾' : esc_html( $t( 'Price on request', 'ფასი მოთხოვნით' ) ); ?></span>
									<a href="<?php the_permalink(); ?>" class="btn4"><?= esc_html( $t( 'View Product', 'პროდუქტის ნახვა' ) ); ?></a>
								</div>
							</div>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

<?php endwhile; ?>

<?php get_footer(); ?>
