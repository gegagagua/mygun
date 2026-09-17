<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mygun
 */

?>
<?php
$footer_shop_url = mygun_get_shop_page_url();
$footer_logo     = mygun_opt_img( 'site_logo_light', 'full', mygun_opt_img( 'site_logo', 'full', get_template_directory_uri() . '/assets/images/logo/logo.png' ) );

// Social links (only rendered when a URL is set in MyGun Content → General).
$footer_socials = array(
	'social_facebook'  => 'fab fa-facebook-f',
	'social_youtube'   => 'fab fa-youtube',
	'social_instagram' => 'fab fa-instagram',
	'social_tiktok'    => 'fab fa-tiktok',
	'social_linkedin'  => 'fab fa-linkedin-in',
);

// Latest products with a thumbnail for the footer shop teaser.
$footer_products = get_posts( array(
	'post_type'      => 'product',
	'post_status'    => 'publish',
	'numberposts'    => 3,
	'meta_key'       => '_thumbnail_id',
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

$footer_copy = mygun_opt( 'footer_copyright', mygun_t( 'Copyright', 'საავტორო უფლება', 'Все права защищены' ) . ' © %year% MyGun' );
$footer_copy = str_replace( '%year%', gmdate( 'Y' ), $footer_copy );

$footer_bottom_links = array(
	array( 'text' => mygun_opt( 'footer_link1_text', mygun_t( 'Privacy Policy', 'კონფიდენციალურობის პოლიტიკა', 'Политика конфиденциальности' ) ), 'url' => mygun_opt_raw( 'footer_link1_url', '#' ) ),
	array( 'text' => mygun_opt( 'footer_link2_text', mygun_t( 'Terms & Conditions', 'წესები და პირობები', 'Условия использования' ) ), 'url' => mygun_opt_raw( 'footer_link2_url', '#' ) ),
);
?>

<!--Footer area start here-->
<footer class="jarallax">
	<div class="footer-top section">
		<div class="container">
			<div class="row">
				<div class="col-md-5 col-sm-6">
					<div class="foo-about">
						<figure><img src="<?php echo esc_url( $footer_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></figure>
						<div class="contents">
							<p><?php echo esc_html( mygun_opt( 'footer_about', mygun_t( 'All modern weapon enthusiasts can appreciate our broad services and experienced support team.', 'თანამედროვე იარაღის მოყვარულებისთვის გვაქვს ფართო სერვისები და გამოცდილი მხარდაჭერის გუნდი.', 'Все ценители современного оружия оценят наш широкий сервис и опытную команду поддержки.' ) ) ); ?></p>
							<a href="<?php echo esc_url( $footer_shop_url ); ?>" class="btn3"><?php echo esc_html( mygun_t( 'Read More', 'დაწვრილებით', 'Подробнее' ) ); ?> <i class="fas fa-arrow-right"></i></a>
						</div>
						<ul class="foo-social">
							<?php
							foreach ( $footer_socials as $opt_key => $icon ) :
								$url = mygun_opt_raw( $opt_key, '' );
								if ( ! $url ) {
									continue;
								}
								?>
								<li><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><i class="<?php echo esc_attr( $icon ); ?>"></i></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
				</div>
				<div class="col-md-4 col-sm-6">
					<h2><a href="<?php echo esc_url( $footer_shop_url ); ?>"><?php echo esc_html( mygun_opt( 'footer_shop_heading', mygun_t( 'Product Shop', 'პროდუქტების მაღაზია', 'Магазин' ) ) ); ?></a></h2>
					<div class="products-foo">
						<?php if ( ! empty( $footer_products ) ) : ?>
						<ul>
							<?php foreach ( $footer_products as $fp ) :
								$fp_thumb = get_the_post_thumbnail_url( $fp->ID, 'thumbnail' );
								if ( ! $fp_thumb ) { continue; }
								?>
								<li>
									<a href="<?php echo esc_url( get_permalink( $fp->ID ) ); ?>"><img src="<?php echo esc_url( $fp_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $fp->ID ) ); ?>" /></a>
								</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
						<p><?php echo esc_html( mygun_opt( 'footer_shop_text', mygun_t( 'For more products and offers, click here!', 'მეტი პროდუქტისა და შეთავაზებისთვის დააჭირეთ აქ!', 'Больше товаров и предложений — нажмите здесь!' ) ) ); ?></p>
						<a href="<?php echo esc_url( $footer_shop_url ); ?>" class="btn1"><?php echo esc_html( mygun_t( 'Shop', 'მაღაზია', 'Магазин' ) ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="copyright sm-t-center">
						<p><?php echo esc_html( $footer_copy ); ?></p>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="foo-links sm-t-center">
						<ul>
							<?php foreach ( $footer_bottom_links as $fl ) : ?>
								<li><a href="<?php echo esc_url( $fl['url'] ? $fl['url'] : '#' ); ?>"><?php echo esc_html( $fl['text'] ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!--Footer area end here-->

<?php wp_footer(); ?>

<!-- All JavaScript Here -->

<!-- jQuery latest version -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery-3.6.0.js"></script>
<!-- tether JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/tether.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/bootstrap.min.js"></script>
<!-- Owl.carousel JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/owl.carousel.min.js"></script>
<!-- Bxslider JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.bxslider.min.js"></script>
<!-- isotope JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/isotope.pkgd.min.js"></script>
<!-- Magnific Popup JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.magnific-popup.min.js"></script>
<!-- meanmenu JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.meanmenu.js"></script>
<!-- jarallax JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jarallax.min.js"></script>
<!-- jQuery-ui JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery-ui.min.js"></script>
<!-- Progressbar Animation JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.waypoints.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.counterup.min.js"></script>
<!-- masonry JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/masonry.pkgd.min.js"></script>
<!-- bootstrap-touchspin JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.bootstrap-touchspin.min.js"></script>

<!-- wow JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/wow.min.js"></script>
<!-- slick JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/slick.min.js"></script>
<!-- Init JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/main.js"></script>
<!-- Auth JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/auth.js"></script>
<?php if ( is_page_template( 'templates/tpl-contact.php' ) ) : ?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/contact_form.js"></script>
<?php endif; ?>
<?php if ( is_page_template( 'templates/tpl-add-product.php' ) ) : ?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/add-product.js"></script>
<?php endif; ?>
<?php if ( is_page_template( 'templates/tpl-profile.php' ) ) : ?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/profile.js"></script>
<?php endif; ?>
<?php if ( is_singular( 'product' ) ) : ?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/single-product.js"></script>
<?php endif; ?>

<?php if ( ! is_user_logged_in() ) :
	$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
?>
<!-- Login Modal -->
<div class="modal fade auth-modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="loginModalLabel"><i class="fas fa-sign-in-alt"></i> <?= mygun_t( 'Authorization', 'ავტორიზაცია', 'Авторизация' ); ?></h4>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="auth-alert" id="loginAlert"></div>
				<form id="loginForm" novalidate>
					<?php wp_nonce_field( 'mygun_login_nonce', 'login_nonce' ); ?>
					<div class="form-group">
						<label for="login_username"><i class="fas fa-user"></i> <?= mygun_t( 'Username or Email', 'მომხმარებლის სახელი ან ელფოსტა', 'Имя пользователя или Email' ); ?></label>
						<input type="text" class="form-control" id="login_username" name="login_username" required placeholder="<?= mygun_t( 'Enter username or email', 'შეიყვანეთ სახელი ან ელფოსტა', 'Введите имя или email' ); ?>">
					</div>
					<div class="form-group">
						<label for="login_password"><i class="fas fa-lock"></i> <?= mygun_t( 'Password', 'პაროლი', 'Пароль' ); ?></label>
						<div class="password-field">
							<input type="password" class="form-control" id="login_password" name="login_password" required placeholder="<?= mygun_t( 'Enter password', 'შეიყვანეთ პაროლი', 'Введите пароль' ); ?>">
							<button type="button" class="toggle-password" data-target="#login_password">
								<i class="fas fa-eye"></i>
							</button>
						</div>
					</div>
					<div class="form-group form-check-group">
						<label class="custom-checkbox">
							<input type="checkbox" name="remember_me" value="1">
							<span class="checkmark"></span>
							<?= mygun_t( 'Remember me', 'დამიმახსოვრე', 'Запомнить меня' ); ?>
						</label>
					</div>
					<button type="submit" class="auth-submit-btn" id="loginSubmit">
						<span class="btn-text"><?= mygun_t( 'Login', 'შესვლა', 'Вход' ); ?></span>
						<span class="btn-loader" style="display:none;"><i class="fas fa-spinner fa-spin"></i></span>
					</button>
				</form>
				<div class="auth-footer">
					<p><?= mygun_t( "Don't have an account?", 'არ გაქვთ ანგარიში?', 'Нет аккаунта?' ); ?> <a href="#" class="switch-modal" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal"><?= mygun_t( 'Register', 'რეგისტრაცია', 'Регистрация' ); ?></a></p>
					<p><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="forgot-password-link"><?= mygun_t( 'Forgot password?', 'დაგავიწყდათ პაროლი?', 'Забыли пароль?' ); ?></a></p>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Register Modal -->
<div class="modal fade auth-modal" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="registerModalLabel"><i class="fas fa-user-plus"></i> <?= mygun_t( 'Registration', 'რეგისტრაცია', 'Регистрация' ); ?></h4>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="auth-alert" id="registerAlert"></div>
				<form id="registerForm" novalidate>
					<?php wp_nonce_field( 'mygun_register_nonce', 'register_nonce' ); ?>
					<div class="form-group">
						<label for="reg_username"><i class="fas fa-user"></i> <?= mygun_t( 'Username', 'მომხმარებლის სახელი', 'Имя пользователя' ); ?></label>
						<input type="text" class="form-control" id="reg_username" name="reg_username" required placeholder="<?= mygun_t( 'Enter username', 'შეიყვანეთ სახელი', 'Введите имя' ); ?>" minlength="3">
					</div>
					<div class="form-group">
						<label for="reg_email"><i class="fas fa-envelope"></i> <?= mygun_t( 'Email', 'ელფოსტა', 'Email' ); ?></label>
						<input type="email" class="form-control" id="reg_email" name="reg_email" required placeholder="<?= mygun_t( 'Enter email', 'შეიყვანეთ ელფოსტა', 'Введите email' ); ?>">
					</div>
					<div class="form-group">
						<label for="reg_password"><i class="fas fa-lock"></i> <?= mygun_t( 'Password', 'პაროლი', 'Пароль' ); ?></label>
						<div class="password-field">
							<input type="password" class="form-control" id="reg_password" name="reg_password" required placeholder="<?= mygun_t( 'Enter password', 'შეიყვანეთ პაროლი', 'Введите пароль' ); ?>" minlength="6">
							<button type="button" class="toggle-password" data-target="#reg_password">
								<i class="fas fa-eye"></i>
							</button>
						</div>
						<div class="password-strength" id="passwordStrength"></div>
					</div>
					<div class="form-group">
						<label for="reg_password_confirm"><i class="fas fa-lock"></i> <?= mygun_t( 'Confirm Password', 'გაიმეორეთ პაროლი', 'Повторите пароль' ); ?></label>
						<div class="password-field">
							<input type="password" class="form-control" id="reg_password_confirm" name="reg_password_confirm" required placeholder="<?= mygun_t( 'Confirm password', 'გაიმეორეთ პაროლი', 'Повторите пароль' ); ?>">
							<button type="button" class="toggle-password" data-target="#reg_password_confirm">
								<i class="fas fa-eye"></i>
							</button>
						</div>
					</div>
					<button type="submit" class="auth-submit-btn" id="registerSubmit">
						<span class="btn-text"><?= mygun_t( 'Register', 'რეგისტრაცია', 'Регистрация' ); ?></span>
						<span class="btn-loader" style="display:none;"><i class="fas fa-spinner fa-spin"></i></span>
					</button>
				</form>
				<div class="auth-footer">
					<p><?= mygun_t( 'Already have an account?', 'უკვე გაქვთ ანგარიში?', 'Уже есть аккаунт?' ); ?> <a href="#" class="switch-modal" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal"><?= mygun_t( 'Login', 'შესვლა', 'Вход' ); ?></a></p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-M08KFZ8XZM"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-M08KFZ8XZM');
</script>

</body>

</html>