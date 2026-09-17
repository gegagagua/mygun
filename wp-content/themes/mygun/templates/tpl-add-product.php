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
				<h2 class="page-title-heading"><?= mygun_t( 'Add Product', 'პროდუქტის დამატება', 'Добавить товар' ); ?></h2>
				<p class="page-title-sub"><?= mygun_t( 'Fill in the details below to list your product', 'შეავსეთ ქვემოთ მოცემული ველები პროდუქტის დასამატებლად', 'Заполните поля ниже, чтобы разместить товар' ); ?></p>
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
								<?= mygun_t( 'Product Name', 'პროდუქტის სახელი', 'Название товара' ); ?> <span class="required">*</span>
							</label>
							<input type="text" class="ap-form-control" id="product_title" name="product_title" required
								placeholder="<?= mygun_t( 'Enter product name', 'შეიყვანეთ პროდუქტის სახელი', 'Введите название товара' ); ?>">
						</div>

						<!-- Two columns: Price + Condition -->
						<div class="row">
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="product_price">
										<i class="fas fa-dollar-sign"></i>
										<?= mygun_t( 'Price', 'ფასი', 'Цена' ); ?> (₾) <span class="required">*</span>
									</label>
									<input type="number" class="ap-form-control" id="product_price" name="product_price" required
										min="0" step="0.01"
										placeholder="<?= mygun_t( 'Enter price', 'შეიყვანეთ ფასი', 'Введите цену' ); ?>">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="product_condition">
										<i class="fas fa-check-circle"></i>
										<?= mygun_t( 'Condition', 'მდგომარეობა', 'Состояние' ); ?>
									</label>
									<select class="ap-form-control" id="product_condition" name="product_condition">
										<option value="new"><?= mygun_t( 'New', 'ახალი', 'Новое' ); ?></option>
										<option value="used"><?= mygun_t( 'Used', 'მეორადი', 'Б/у' ); ?></option>
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
										<?= mygun_t( 'Category', 'კატეგორია', 'Категория' ); ?>
									</label>
									<select class="ap-form-control" id="product_category" name="product_category">
										<option value="0"><?= mygun_t( '-- Select Category --', '-- აირჩიეთ კატეგორია --', '-- Выберите категорию --' ); ?></option>
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
										<?= mygun_t( 'Location', 'მდებარეობა', 'Местоположение' ); ?>
									</label>
									<select class="ap-form-control" id="mygun_location" name="mygun_location">
										<option value=""><?= mygun_t( '— Not set —', '— არ არის არჩეული —', '— Не указано —' ); ?></option>
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
										<?= mygun_t( 'Caliber', 'კალიბრი', 'Калибр' ); ?>
									</label>
									<select class="ap-form-control" id="mygun_caliber" name="mygun_caliber">
										<option value=""><?= mygun_t( '— Not set —', '— არ არის არჩეული —', '— Не указано —' ); ?></option>
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
										<?= mygun_t( 'Firearm type', 'ცეცხლსასროლი იარაღის სახეობა', 'Тип оружия' ); ?>
									</label>
									<select class="ap-form-control" id="mygun_firearm_type" name="mygun_firearm_type">
										<option value=""><?= mygun_t( '— Not set —', '— არ არის არჩეული —', '— Не указано —' ); ?></option>
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
										<?= mygun_t( 'Stock (buttstock)', 'კონდახი', 'Приклад' ); ?>
									</label>
									<select class="ap-form-control" id="mygun_stock_included" name="mygun_stock_included">
										<option value=""><?= mygun_t( '— Not set —', '— არ არის არჩეული —', '— Не указано —' ); ?></option>
										<option value="yes"><?= mygun_t( 'Yes', 'დიახ', 'Да' ); ?></option>
										<option value="no"><?= mygun_t( 'No', 'არა', 'Нет' ); ?></option>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="mygun_body">
										<i class="fas fa-cube"></i>
										<?= mygun_t( 'Body', 'კორპუსი', 'Корпус' ); ?>
									</label>
									<select class="ap-form-control" id="mygun_body" name="mygun_body">
										<option value=""><?= mygun_t( '— Not set —', '— არ არის არჩეული —', '— Не указано —' ); ?></option>
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
										<?= mygun_t( 'Length (mm)', 'სიგრძე (მმ)', 'Длина (мм)' ); ?>
									</label>
									<input type="number" class="ap-form-control" id="mygun_length_mm" name="mygun_length_mm" min="0" step="1"
										placeholder="<?= mygun_t( 'Optional', 'არასავალდებულო', 'Необязательно' ); ?>">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="mygun_weight_g">
										<i class="fas fa-weight-hanging"></i>
										<?= mygun_t( 'Weight (g)', 'წონა (გრ)', 'Вес (г)' ); ?>
									</label>
									<input type="number" class="ap-form-control" id="mygun_weight_g" name="mygun_weight_g" min="0" step="1"
										placeholder="<?= mygun_t( 'Optional', 'არასავალდებულო', 'Необязательно' ); ?>">
								</div>
							</div>
						</div>

						<?php
						$ap_countries = function_exists( 'mygun_manufacturer_country_choices' ) ? mygun_manufacturer_country_choices() : array();
						?>
						<div class="ap-form-group">
							<label for="mygun_manufacturer_country">
								<i class="fas fa-globe"></i>
								<?= mygun_t( 'Country of manufacture', 'მწარმოებელი ქვეყანა', 'Страна производства' ); ?>
							</label>
							<select class="ap-form-control" id="mygun_manufacturer_country" name="mygun_manufacturer_country">
								<option value=""><?= mygun_t( '— Not set —', '— არ არის არჩეული —', '— Не указано —' ); ?></option>
								<?php foreach ( $ap_countries as $cc_slug => $cc_pair ) : ?>
									<option value="<?= esc_attr( $cc_slug ); ?>">
										<?= esc_html( $lang === 'ka' ? $cc_pair['ka'] : $cc_pair['en'] ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>

						<!-- Phone -->
						<div class="ap-form-group">
							<label for="product_phone">
								<i class="fas fa-phone"></i>
								<?= mygun_t( 'Phone Number', 'ტელეფონის ნომერი', 'Номер телефона' ); ?>
							</label>
							<input type="tel" class="ap-form-control" id="product_phone" name="product_phone"
								placeholder="<?= mygun_t( 'Enter phone number', 'შეიყვანეთ ტელეფონის ნომერი', 'Введите номер телефона' ); ?>">
						</div>

						<!-- Description -->
						<div class="ap-form-group">
							<label for="product_description">
								<i class="fas fa-align-left"></i>
								<?= mygun_t( 'Description', 'აღწერა', 'Описание' ); ?> <span class="required">*</span>
							</label>
							<textarea class="ap-form-control" id="product_description" name="product_description" rows="6" required
								placeholder="<?= mygun_t( 'Describe your product in detail...', 'აღწერეთ პროდუქტი დეტალურად...', 'Опишите товар подробно...' ); ?>"></textarea>
						</div>

						<!-- Main Image -->
						<div class="ap-form-group">
							<label>
								<i class="fas fa-camera"></i>
								<?= mygun_t( 'Main Image', 'მთავარი სურათი', 'Главное изображение' ); ?> <span class="required">*</span>
							</label>
							<div class="ap-file-upload" id="mainImageUpload">
								<input type="file" id="product_image" name="product_image" accept="image/*" class="ap-file-input">
								<div class="ap-file-placeholder" id="mainImagePlaceholder">
									<i class="fas fa-cloud-upload-alt"></i>
									<p><?= mygun_t( 'Click or drag to upload main image', 'დააკლიკეთ ან ჩააგდეთ მთავარი სურათი', 'Нажмите или перетащите главное изображение' ); ?></p>
									<span><?= mygun_t( 'JPG, PNG, WEBP (max 5MB)', 'JPG, PNG, WEBP (მაქს. 5MB)', 'JPG, PNG, WEBP (макс. 5MB)' ); ?></span>
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
								<?= mygun_t( 'Gallery Images', 'გალერეის სურათები', 'Изображения галереи' ); ?>
								<small>(<?= mygun_t( 'up to 5 images', 'მაქს. 5 სურათი', 'до 5 изображений' ); ?>)</small>
							</label>
							<div class="ap-file-upload ap-gallery-upload" id="galleryUpload">
								<input type="file" id="product_gallery" name="product_gallery[]" accept="image/*" multiple class="ap-file-input" data-max="5">
								<div class="ap-file-placeholder" id="galleryPlaceholder">
									<i class="fas fa-cloud-upload-alt"></i>
									<p><?= mygun_t( 'Click or drag to upload gallery images', 'დააკლიკეთ ან ჩააგდეთ გალერეის სურათები', 'Нажмите или перетащите изображения галереи' ); ?></p>
									<span><?= mygun_t( 'JPG, PNG, WEBP (max 5MB each)', 'JPG, PNG, WEBP (თითო მაქს. 5MB)', 'JPG, PNG, WEBP (каждое макс. 5MB)' ); ?></span>
								</div>
								<div class="ap-gallery-preview" id="galleryPreview"></div>
							</div>
						</div>

						<!-- Submit -->
						<button type="submit" class="ap-submit-btn" id="addProductSubmit">
							<span class="btn-text"><i class="fas fa-plus-circle"></i> <?= mygun_t( 'Add Product', 'პროდუქტის დამატება', 'Добавить товар' ); ?></span>
							<span class="btn-loader" style="display:none;"><i class="fas fa-spinner fa-spin"></i> <?= mygun_t( 'Adding...', 'ემატება...', 'Добавление...' ); ?></span>
						</button>

					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
