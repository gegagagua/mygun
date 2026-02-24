<?php
/* Template Name: Profile */

if ( ! is_user_logged_in() ) {
	wp_redirect( home_url() );
	exit;
}

get_header();

$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
$user = wp_get_current_user();

$phone = get_user_meta( $user->ID, '_user_phone', true );
$bio   = get_user_meta( $user->ID, 'description', true );

// Get user's products
$user_products = get_posts( array(
	'post_type'   => 'product',
	'author'      => $user->ID,
	'post_status' => array( 'publish', 'pending', 'draft' ),
	'numberposts' => -1,
) );
?>

<!-- Page Title area -->
<section class="page-title-area" style="background:#111; padding:60px 0 40px;">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h2 class="page-title-heading"><?= $lang === 'en' ? 'My Profile' : 'ჩემი პროფილი'; ?></h2>
				<p class="page-title-sub"><?= $lang === 'en' ? 'Manage your account settings and products' : 'მართეთ თქვენი ანგარიშის პარამეტრები და პროდუქტები'; ?></p>
			</div>
		</div>
	</div>
</section>

<!-- Profile area -->
<section class="add-product-area section">
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2">

				<!-- Profile Info Card -->
				<div class="add-product-form-wrapper profile-card">
					<div class="profile-header">
						<div class="profile-avatar">
							<?php echo get_avatar( $user->ID, 100 ); ?>
						</div>
						<div class="profile-meta">
							<h3 class="profile-name"><?php echo esc_html( $user->display_name ); ?></h3>
							<p class="profile-email"><i class="fas fa-envelope"></i> <?php echo esc_html( $user->user_email ); ?></p>
							<p class="profile-date"><i class="fas fa-calendar-alt"></i> <?= $lang === 'en' ? 'Member since' : 'წევრი'; ?>: <?php echo date_i18n( 'd.m.Y', strtotime( $user->user_registered ) ); ?></p>
						</div>
					</div>
				</div>

				<!-- Edit Profile Form -->
				<div class="add-product-form-wrapper" style="margin-top:30px;">
					<h3 class="profile-section-title"><i class="fas fa-user-edit"></i> <?= $lang === 'en' ? 'Edit Profile' : 'პროფილის რედაქტირება'; ?></h3>

					<div class="ap-alert" id="profileAlert"></div>

					<form id="profileForm" novalidate>
						<?php wp_nonce_field( 'mygun_update_profile_nonce', 'profile_nonce' ); ?>

						<div class="row">
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="profile_display_name">
										<i class="fas fa-user"></i>
										<?= $lang === 'en' ? 'Display Name' : 'სახელი'; ?> <span class="required">*</span>
									</label>
									<input type="text" class="ap-form-control" id="profile_display_name" name="display_name"
										value="<?= esc_attr( $user->display_name ); ?>"
										placeholder="<?= $lang === 'en' ? 'Your display name' : 'თქვენი სახელი'; ?>">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="profile_email">
										<i class="fas fa-envelope"></i>
										<?= $lang === 'en' ? 'Email' : 'ელფოსტა'; ?>
									</label>
									<input type="email" class="ap-form-control" id="profile_email" name="email"
										value="<?= esc_attr( $user->user_email ); ?>" disabled
										style="opacity:0.6; cursor:not-allowed;">
									<small style="color:#666; font-size:12px;"><?= $lang === 'en' ? 'Contact admin to change email' : 'ელფოსტის შესაცვლელად მიმართეთ ადმინს'; ?></small>
								</div>
							</div>
						</div>

						<div class="ap-form-group">
							<label for="profile_phone">
								<i class="fas fa-phone"></i>
								<?= $lang === 'en' ? 'Phone Number' : 'ტელეფონის ნომერი'; ?>
							</label>
							<input type="tel" class="ap-form-control" id="profile_phone" name="phone"
								value="<?= esc_attr( $phone ); ?>"
								placeholder="<?= $lang === 'en' ? 'Enter phone number' : 'შეიყვანეთ ტელეფონის ნომერი'; ?>">
						</div>

						<div class="ap-form-group">
							<label for="profile_bio">
								<i class="fas fa-align-left"></i>
								<?= $lang === 'en' ? 'About Me' : 'ჩემს შესახებ'; ?>
							</label>
							<textarea class="ap-form-control" id="profile_bio" name="bio" rows="4"
								placeholder="<?= $lang === 'en' ? 'Tell something about yourself...' : 'მოგვიყევით თქვენს შესახებ...'; ?>"><?= esc_textarea( $bio ); ?></textarea>
						</div>

						<button type="submit" class="ap-submit-btn" id="profileSubmit">
							<span class="btn-text"><i class="fas fa-save"></i> <?= $lang === 'en' ? 'Save Changes' : 'ცვლილებების შენახვა'; ?></span>
							<span class="btn-loader" style="display:none;"><i class="fas fa-spinner fa-spin"></i> <?= $lang === 'en' ? 'Saving...' : 'ინახება...'; ?></span>
						</button>
					</form>
				</div>

				<!-- Change Password -->
				<div class="add-product-form-wrapper" style="margin-top:30px;">
					<h3 class="profile-section-title"><i class="fas fa-lock"></i> <?= $lang === 'en' ? 'Change Password' : 'პაროლის შეცვლა'; ?></h3>

					<div class="ap-alert" id="passwordAlert"></div>

					<form id="passwordForm" novalidate>
						<?php wp_nonce_field( 'mygun_change_password_nonce', 'password_nonce' ); ?>

						<div class="ap-form-group">
							<label for="current_password">
								<i class="fas fa-key"></i>
								<?= $lang === 'en' ? 'Current Password' : 'მიმდინარე პაროლი'; ?> <span class="required">*</span>
							</label>
							<div class="password-field">
								<input type="password" class="ap-form-control" id="current_password" name="current_password"
									placeholder="<?= $lang === 'en' ? 'Enter current password' : 'შეიყვანეთ მიმდინარე პაროლი'; ?>">
								<button type="button" class="toggle-password" data-target="#current_password">
									<i class="fas fa-eye"></i>
								</button>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="new_password">
										<i class="fas fa-lock"></i>
										<?= $lang === 'en' ? 'New Password' : 'ახალი პაროლი'; ?> <span class="required">*</span>
									</label>
									<div class="password-field">
										<input type="password" class="ap-form-control" id="new_password" name="new_password"
											placeholder="<?= $lang === 'en' ? 'Enter new password' : 'შეიყვანეთ ახალი პაროლი'; ?>">
										<button type="button" class="toggle-password" data-target="#new_password">
											<i class="fas fa-eye"></i>
										</button>
									</div>
									<div class="password-strength" id="newPasswordStrength"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="ap-form-group">
									<label for="confirm_new_password">
										<i class="fas fa-lock"></i>
										<?= $lang === 'en' ? 'Confirm Password' : 'გაიმეორეთ პაროლი'; ?> <span class="required">*</span>
									</label>
									<div class="password-field">
										<input type="password" class="ap-form-control" id="confirm_new_password" name="confirm_new_password"
											placeholder="<?= $lang === 'en' ? 'Confirm new password' : 'გაიმეორეთ ახალი პაროლი'; ?>">
										<button type="button" class="toggle-password" data-target="#confirm_new_password">
											<i class="fas fa-eye"></i>
										</button>
									</div>
								</div>
							</div>
						</div>

						<button type="submit" class="ap-submit-btn" id="passwordSubmit">
							<span class="btn-text"><i class="fas fa-key"></i> <?= $lang === 'en' ? 'Change Password' : 'პაროლის შეცვლა'; ?></span>
							<span class="btn-loader" style="display:none;"><i class="fas fa-spinner fa-spin"></i> <?= $lang === 'en' ? 'Changing...' : 'იცვლება...'; ?></span>
						</button>
					</form>
				</div>

				<!-- My Products -->
				<div class="add-product-form-wrapper" style="margin-top:30px;">
					<h3 class="profile-section-title"><i class="fas fa-box-open"></i> <?= $lang === 'en' ? 'My Products' : 'ჩემი პროდუქტები'; ?>
						<span class="product-count">(<?= count( $user_products ); ?>)</span>
					</h3>

					<?php if ( ! empty( $user_products ) ) : ?>
						<div class="my-products-list">
							<?php foreach ( $user_products as $product ) :
								$price     = get_post_meta( $product->ID, '_product_price', true );
								$condition = get_post_meta( $product->ID, '_product_condition', true );
								$thumb     = get_the_post_thumbnail_url( $product->ID, 'product-thumb' );
								$status    = $product->post_status;
							?>
								<div class="my-product-item">
									<div class="my-product-thumb">
										<?php if ( $thumb ) : ?>
											<img src="<?= esc_url( $thumb ); ?>" alt="<?= esc_attr( $product->post_title ); ?>">
										<?php else : ?>
											<div class="no-thumb"><i class="fas fa-image"></i></div>
										<?php endif; ?>
									</div>
									<div class="my-product-info">
										<h4 class="my-product-title">
											<?php if ( $status === 'publish' ) : ?>
												<a href="<?= get_permalink( $product->ID ); ?>"><?= esc_html( $product->post_title ); ?></a>
											<?php else : ?>
												<?= esc_html( $product->post_title ); ?>
											<?php endif; ?>
										</h4>
										<div class="my-product-meta">
											<?php if ( $price ) : ?>
												<span class="my-product-price"><?= esc_html( $price ); ?> ₾</span>
											<?php endif; ?>
											<span class="my-product-status status-<?= esc_attr( $status ); ?>">
												<?php
												if ( $status === 'publish' ) {
													echo $lang === 'en' ? 'Published' : 'გამოქვეყნებული';
												} elseif ( $status === 'pending' ) {
													echo $lang === 'en' ? 'Pending' : 'მოლოდინში';
												} else {
													echo $lang === 'en' ? 'Draft' : 'დრაფტი';
												}
												?>
											</span>
											<?php if ( $condition ) : ?>
												<span class="my-product-condition">
													<?php
													if ( $condition === 'new' ) {
														echo $lang === 'en' ? 'New' : 'ახალი';
													} else {
														echo $lang === 'en' ? 'Used' : 'მეორადი';
													}
													?>
												</span>
											<?php endif; ?>
										</div>
									</div>
									<div class="my-product-actions">
										<?php if ( $status === 'publish' ) : ?>
											<a href="<?= get_permalink( $product->ID ); ?>" class="my-product-action-btn" title="<?= $lang === 'en' ? 'View' : 'ნახვა'; ?>"><i class="fas fa-eye"></i></a>
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php else : ?>
						<div class="no-products-msg">
							<i class="fas fa-box-open"></i>
							<p><?= $lang === 'en' ? 'You have not added any products yet.' : 'თქვენ ჯერ არ დაგიმატებიათ პროდუქტი.'; ?></p>
							<?php
							$add_product_page = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'templates/tpl-add-product.php', 'number' => 1 ) );
							$add_product_url  = ! empty( $add_product_page ) ? get_permalink( $add_product_page[0]->ID ) : '#';
							?>
							<a href="<?= esc_url( $add_product_url ); ?>" class="ap-submit-btn" style="display:inline-block; width:auto; padding:12px 30px; text-decoration:none;">
								<i class="fas fa-plus-circle"></i> <?= $lang === 'en' ? 'Add Product' : 'პროდუქტის დამატება'; ?>
							</a>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
