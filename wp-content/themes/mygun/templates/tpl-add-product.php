<?php
/* Template Name: Add Product */

// Redirect if not logged in
if ( ! is_user_logged_in() ) {
	wp_redirect( home_url() );
	exit;
}

get_header();

$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';

// Get product categories
$categories = get_terms( array(
	'taxonomy'   => 'product_cat',
	'hide_empty' => false,
) );
$ap_locations = get_terms( array(
	'taxonomy'   => 'mygun_location',
	'hide_empty' => false,
	'orderby'    => 'name',
	'order'      => 'ASC',
) );
?>

<!-- Page Title area -->
<section class="page-title-area" style="background:#111; padding:160px 0 40px;">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h2 class="page-title-heading"><?= $lang === 'en' ? 'Add Product' : 'პროდუქტის დამატება'; ?></h2>
				<p class="page-title-sub"><?= $lang === 'en' ? 'Fill in the details below to list your product' : 'შეავსეთ ქვემოთ მოცემული ველები პროდუქტის დასამატებლად'; ?></p>
			</div>
		</div>
	</div>
</section>

<!-- Add Product Form area -->
<section class="add-product-area section">
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="add-product-form-wrapper">

					<div class="ap-alert" id="addProductAlert"></div>

					<form id="addProductForm" enctype="multipart/form-data" novalidate>
						<?php wp_nonce_field( 'mygun_add_product_nonce', 'add_product_nonce' ); ?>

						<!-- Product Name -->
						<div class="ap-form-group">
							<label for="product_title">
								<i class="fas fa-tag"></i>
								<?= $lang === 'en' ? 'Product Name' : 'პროდუქტის სახელი'; ?> <span class="required">*</span>
							</label>
							<input type="text" class="ap-form-control" id="product_title" name="product_title" required
								placeholder="<?= $lang === 'en' ? 'Enter product name' : 'შეიყვანეთ პროდუქტის სახელი'; ?>">
						</div>

						<!-- Two columns: Price + Condition -->
						<div class="row">
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="product_price">
										<i class="fas fa-dollar-sign"></i>
										<?= $lang === 'en' ? 'Price' : 'ფასი'; ?> (₾) <span class="required">*</span>
									</label>
									<input type="number" class="ap-form-control" id="product_price" name="product_price" required
										min="0" step="0.01"
										placeholder="<?= $lang === 'en' ? 'Enter price' : 'შეიყვანეთ ფასი'; ?>">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="product_condition">
										<i class="fas fa-check-circle"></i>
										<?= $lang === 'en' ? 'Condition' : 'მდგომარეობა'; ?>
									</label>
									<select class="ap-form-control" id="product_condition" name="product_condition">
										<option value="new"><?= $lang === 'en' ? 'New' : 'ახალი'; ?></option>
										<option value="used"><?= $lang === 'en' ? 'Used' : 'მეორადი'; ?></option>
									</select>
								</div>
							</div>
						</div>

						<!-- Two columns: Category + Location -->
						<div class="row">
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="product_category">
										<i class="fas fa-folder"></i>
										<?= $lang === 'en' ? 'Category' : 'კატეგორია'; ?>
									</label>
									<select class="ap-form-control" id="product_category" name="product_category">
										<option value="0"><?= $lang === 'en' ? '-- Select Category --' : '-- აირჩიეთ კატეგორია --'; ?></option>
										<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
											<?php foreach ( $categories as $cat ) : ?>
												<option value="<?= esc_attr( $cat->term_id ); ?>"><?= esc_html( $cat->name ); ?></option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="mygun_location">
										<i class="fas fa-map-marker-alt"></i>
										<?= $lang === 'en' ? 'Location' : 'მდებარეობა'; ?>
									</label>
									<select class="ap-form-control" id="mygun_location" name="mygun_location">
										<option value=""><?= $lang === 'en' ? '— Not set —' : '— არ არის არჩეული —'; ?></option>
										<?php if ( ! empty( $ap_locations ) && ! is_wp_error( $ap_locations ) ) : ?>
											<?php foreach ( $ap_locations as $ap_loc ) : ?>
												<option value="<?= esc_attr( $ap_loc->slug ); ?>">
													<?= esc_html( function_exists( 'mygun_product_spec_term_label' ) ? mygun_product_spec_term_label( $ap_loc, $lang ) : $ap_loc->name ); ?>
												</option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>
						</div>

						<?php
						$ap_calibers = get_terms( array(
							'taxonomy'   => 'mygun_caliber',
							'hide_empty' => false,
							'orderby'    => 'name',
							'order'      => 'ASC',
						) );
						$ap_firearm_types = get_terms( array(
							'taxonomy'   => 'mygun_firearm_type',
							'hide_empty' => false,
							'orderby'    => 'name',
							'order'      => 'ASC',
						) );
						$ap_bodies = get_terms( array(
							'taxonomy'   => 'mygun_body',
							'hide_empty' => false,
							'orderby'    => 'name',
							'order'      => 'ASC',
						) );
						?>
						<div class="row">
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="mygun_caliber">
										<i class="fas fa-bullseye"></i>
										<?= $lang === 'en' ? 'Caliber' : 'კალიბრი'; ?>
									</label>
									<select class="ap-form-control" id="mygun_caliber" name="mygun_caliber">
										<option value=""><?= $lang === 'en' ? '— Not set —' : '— არ არის არჩეული —'; ?></option>
										<?php if ( ! empty( $ap_calibers ) && ! is_wp_error( $ap_calibers ) ) : ?>
											<?php foreach ( $ap_calibers as $ap_term ) : ?>
												<option value="<?= esc_attr( $ap_term->slug ); ?>">
													<?= esc_html( function_exists( 'mygun_product_spec_term_label' ) ? mygun_product_spec_term_label( $ap_term, $lang ) : $ap_term->name ); ?>
												</option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="mygun_firearm_type">
										<i class="fas fa-crosshairs"></i>
										<?= $lang === 'en' ? 'Firearm type' : 'ცეცხლსასროლი იარაღის სახეობა'; ?>
									</label>
									<select class="ap-form-control" id="mygun_firearm_type" name="mygun_firearm_type">
										<option value=""><?= $lang === 'en' ? '— Not set —' : '— არ არის არჩეული —'; ?></option>
										<?php if ( ! empty( $ap_firearm_types ) && ! is_wp_error( $ap_firearm_types ) ) : ?>
											<?php foreach ( $ap_firearm_types as $ap_term ) : ?>
												<option value="<?= esc_attr( $ap_term->slug ); ?>">
													<?= esc_html( function_exists( 'mygun_product_spec_term_label' ) ? mygun_product_spec_term_label( $ap_term, $lang ) : $ap_term->name ); ?>
												</option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="mygun_stock_included">
										<i class="fas fa-grip-lines-vertical"></i>
										<?= $lang === 'en' ? 'Stock (buttstock)' : 'კონდახი'; ?>
									</label>
									<select class="ap-form-control" id="mygun_stock_included" name="mygun_stock_included">
										<option value=""><?= $lang === 'en' ? '— Not set —' : '— არ არის არჩეული —'; ?></option>
										<option value="yes"><?= $lang === 'en' ? 'Yes' : 'დიახ'; ?></option>
										<option value="no"><?= $lang === 'en' ? 'No' : 'არა'; ?></option>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="mygun_body">
										<i class="fas fa-cube"></i>
										<?= $lang === 'en' ? 'Body' : 'კორპუსი'; ?>
									</label>
									<select class="ap-form-control" id="mygun_body" name="mygun_body">
										<option value=""><?= $lang === 'en' ? '— Not set —' : '— არ არის არჩეული —'; ?></option>
										<?php if ( ! empty( $ap_bodies ) && ! is_wp_error( $ap_bodies ) ) : ?>
											<?php foreach ( $ap_bodies as $ap_term ) : ?>
												<option value="<?= esc_attr( $ap_term->slug ); ?>">
													<?= esc_html( function_exists( 'mygun_product_spec_term_label' ) ? mygun_product_spec_term_label( $ap_term, $lang ) : $ap_term->name ); ?>
												</option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="mygun_length_mm">
										<i class="fas fa-ruler-horizontal"></i>
										<?= $lang === 'en' ? 'Length (mm)' : 'სიგრძე (მმ)'; ?>
									</label>
									<input type="number" class="ap-form-control" id="mygun_length_mm" name="mygun_length_mm" min="0" step="1"
										placeholder="<?= $lang === 'en' ? 'Optional' : 'არასავალდებულო'; ?>">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="mygun_weight_g">
										<i class="fas fa-weight-hanging"></i>
										<?= $lang === 'en' ? 'Weight (g)' : 'წონა (გრ)'; ?>
									</label>
									<input type="number" class="ap-form-control" id="mygun_weight_g" name="mygun_weight_g" min="0" step="1"
										placeholder="<?= $lang === 'en' ? 'Optional' : 'არასავალდებულო'; ?>">
								</div>
							</div>
						</div>

						<!-- Phone -->
						<div class="ap-form-group">
							<label for="product_phone">
								<i class="fas fa-phone"></i>
								<?= $lang === 'en' ? 'Phone Number' : 'ტელეფონის ნომერი'; ?>
							</label>
							<input type="tel" class="ap-form-control" id="product_phone" name="product_phone"
								placeholder="<?= $lang === 'en' ? 'Enter phone number' : 'შეიყვანეთ ტელეფონის ნომერი'; ?>">
						</div>

						<!-- Description -->
						<div class="ap-form-group">
							<label for="product_description">
								<i class="fas fa-align-left"></i>
								<?= $lang === 'en' ? 'Description' : 'აღწერა'; ?> <span class="required">*</span>
							</label>
							<textarea class="ap-form-control" id="product_description" name="product_description" rows="6" required
								placeholder="<?= $lang === 'en' ? 'Describe your product in detail...' : 'აღწერეთ პროდუქტი დეტალურად...'; ?>"></textarea>
						</div>

						<!-- Main Image -->
						<div class="ap-form-group">
							<label>
								<i class="fas fa-camera"></i>
								<?= $lang === 'en' ? 'Main Image' : 'მთავარი სურათი'; ?> <span class="required">*</span>
							</label>
							<div class="ap-file-upload" id="mainImageUpload">
								<input type="file" id="product_image" name="product_image" accept="image/*" class="ap-file-input">
								<div class="ap-file-placeholder" id="mainImagePlaceholder">
									<i class="fas fa-cloud-upload-alt"></i>
									<p><?= $lang === 'en' ? 'Click or drag to upload main image' : 'დააკლიკეთ ან ჩააგდეთ მთავარი სურათი'; ?></p>
									<span><?= $lang === 'en' ? 'JPG, PNG, WEBP (max 5MB)' : 'JPG, PNG, WEBP (მაქს. 5MB)'; ?></span>
								</div>
								<div class="ap-file-preview" id="mainImagePreview" style="display:none;">
									<img src="" alt="" id="mainImagePreviewImg">
									<button type="button" class="ap-remove-image" data-target="main"><i class="fas fa-times"></i></button>
								</div>
							</div>
						</div>

						<!-- Gallery Images -->
						<div class="ap-form-group">
							<label>
								<i class="fas fa-images"></i>
								<?= $lang === 'en' ? 'Gallery Images' : 'გალერეის სურათები'; ?>
								<small>(<?= $lang === 'en' ? 'up to 5 images' : 'მაქს. 5 სურათი'; ?>)</small>
							</label>
							<div class="ap-file-upload ap-gallery-upload" id="galleryUpload">
								<input type="file" id="product_gallery" name="product_gallery[]" accept="image/*" multiple class="ap-file-input" data-max="5">
								<div class="ap-file-placeholder" id="galleryPlaceholder">
									<i class="fas fa-cloud-upload-alt"></i>
									<p><?= $lang === 'en' ? 'Click or drag to upload gallery images' : 'დააკლიკეთ ან ჩააგდეთ გალერეის სურათები'; ?></p>
									<span><?= $lang === 'en' ? 'JPG, PNG, WEBP (max 5MB each)' : 'JPG, PNG, WEBP (თითო მაქს. 5MB)'; ?></span>
								</div>
								<div class="ap-gallery-preview" id="galleryPreview"></div>
							</div>
						</div>

						<!-- Submit -->
						<button type="submit" class="ap-submit-btn" id="addProductSubmit">
							<span class="btn-text"><i class="fas fa-plus-circle"></i> <?= $lang === 'en' ? 'Add Product' : 'პროდუქტის დამატება'; ?></span>
							<span class="btn-loader" style="display:none;"><i class="fas fa-spinner fa-spin"></i> <?= $lang === 'en' ? 'Adding...' : 'ემატება...'; ?></span>
						</button>

					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
