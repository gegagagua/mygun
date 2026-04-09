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
$footer_lang     = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
$footer_shop_url = mygun_get_shop_page_url();
?>

<!--Footer area start here-->
<footer class="jarallax">
	<div class="footer-top section">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-6">
					<div class="foo-about">
						<figure><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/logo.png" alt="" /></figure>
						<div class="contents">
							<p><?= $footer_lang === 'en' ? 'All modern weapon enthusiasts can appreciate our broad services and experienced support team.' : 'თანამედროვე იარაღის მოყვარულებისთვის გვაქვს ფართო სერვისები და გამოცდილი მხარდაჭერის გუნდი.'; ?></p>
							<a href="#" class="btn3"><?= $footer_lang === 'en' ? 'Read More' : 'დაწვრილებით'; ?> <i class="fas fa-arrow-right"></i></a>
						</div>
						<ul class="foo-social">
							<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#"><i class="fab fa-youtube"></i></a></li>
							<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
				</div>
				<div class="col-md-4 col-sm-6">
					<h2><a href="<?= esc_url( $footer_shop_url ); ?>"><?= $footer_lang === 'en' ? 'Product Shop' : 'პროდუქტების მაღაზია'; ?></a></h2>
					<div class="products-foo">
						<ul>
							<li>
								<a href="<?= esc_url( $footer_shop_url ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/sm1.jpg" alt="" /></a>
							</li>
							<li>
								<a href="<?= esc_url( $footer_shop_url ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/sm3.jpg" alt="" /></a>
							</li>
							<li>
								<a href="<?= esc_url( $footer_shop_url ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/sm4.jpg" alt="" /></a>
							</li>
						</ul>
						<p><?= $footer_lang === 'en' ? 'For more products and offers, click here!' : 'მეტი პროდუქტისა და შეთავაზებისთვის დააჭირეთ აქ!'; ?></p>
						<a href="<?= esc_url( $footer_shop_url ); ?>" class="btn1"><?= $footer_lang === 'en' ? 'Shop' : 'მაღაზია'; ?></a>
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
						<p><?= $footer_lang === 'en' ? 'Copyright' : 'საავტორო უფლება'; ?> © 2025 <a href="#"><span>Weapon</span></a></p>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="foo-links sm-t-center">
						<ul>
							<li><a href="#"><?= $footer_lang === 'en' ? 'Privacy Policy' : 'კონფიდენციალურობის პოლიტიკა'; ?></a></li>
							<li><a href="#"><?= $footer_lang === 'en' ? 'Terms & Conditions' : 'წესები და პირობები'; ?></a></li>
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
				<h4 class="modal-title" id="loginModalLabel"><i class="fas fa-sign-in-alt"></i> <?= $lang === 'en' ? 'Authorization' : 'ავტორიზაცია'; ?></h4>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="auth-alert" id="loginAlert"></div>
				<form id="loginForm" novalidate>
					<?php wp_nonce_field( 'mygun_login_nonce', 'login_nonce' ); ?>
					<div class="form-group">
						<label for="login_username"><i class="fas fa-user"></i> <?= $lang === 'en' ? 'Username or Email' : 'მომხმარებლის სახელი ან ელფოსტა'; ?></label>
						<input type="text" class="form-control" id="login_username" name="login_username" required placeholder="<?= $lang === 'en' ? 'Enter username or email' : 'შეიყვანეთ სახელი ან ელფოსტა'; ?>">
					</div>
					<div class="form-group">
						<label for="login_password"><i class="fas fa-lock"></i> <?= $lang === 'en' ? 'Password' : 'პაროლი'; ?></label>
						<div class="password-field">
							<input type="password" class="form-control" id="login_password" name="login_password" required placeholder="<?= $lang === 'en' ? 'Enter password' : 'შეიყვანეთ პაროლი'; ?>">
							<button type="button" class="toggle-password" data-target="#login_password">
								<i class="fas fa-eye"></i>
							</button>
						</div>
					</div>
					<div class="form-group form-check-group">
						<label class="custom-checkbox">
							<input type="checkbox" name="remember_me" value="1">
							<span class="checkmark"></span>
							<?= $lang === 'en' ? 'Remember me' : 'დამიმახსოვრე'; ?>
						</label>
					</div>
					<button type="submit" class="auth-submit-btn" id="loginSubmit">
						<span class="btn-text"><?= $lang === 'en' ? 'Login' : 'შესვლა'; ?></span>
						<span class="btn-loader" style="display:none;"><i class="fas fa-spinner fa-spin"></i></span>
					</button>
				</form>
				<div class="auth-footer">
					<p><?= $lang === 'en' ? "Don't have an account?" : 'არ გაქვთ ანგარიში?'; ?> <a href="#" class="switch-modal" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal"><?= $lang === 'en' ? 'Register' : 'რეგისტრაცია'; ?></a></p>
					<p><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="forgot-password-link"><?= $lang === 'en' ? 'Forgot password?' : 'დაგავიწყდათ პაროლი?'; ?></a></p>
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
				<h4 class="modal-title" id="registerModalLabel"><i class="fas fa-user-plus"></i> <?= $lang === 'en' ? 'Registration' : 'რეგისტრაცია'; ?></h4>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="auth-alert" id="registerAlert"></div>
				<form id="registerForm" novalidate>
					<?php wp_nonce_field( 'mygun_register_nonce', 'register_nonce' ); ?>
					<div class="form-group">
						<label for="reg_username"><i class="fas fa-user"></i> <?= $lang === 'en' ? 'Username' : 'მომხმარებლის სახელი'; ?></label>
						<input type="text" class="form-control" id="reg_username" name="reg_username" required placeholder="<?= $lang === 'en' ? 'Enter username' : 'შეიყვანეთ სახელი'; ?>" minlength="3">
					</div>
					<div class="form-group">
						<label for="reg_email"><i class="fas fa-envelope"></i> <?= $lang === 'en' ? 'Email' : 'ელფოსტა'; ?></label>
						<input type="email" class="form-control" id="reg_email" name="reg_email" required placeholder="<?= $lang === 'en' ? 'Enter email' : 'შეიყვანეთ ელფოსტა'; ?>">
					</div>
					<div class="form-group">
						<label for="reg_password"><i class="fas fa-lock"></i> <?= $lang === 'en' ? 'Password' : 'პაროლი'; ?></label>
						<div class="password-field">
							<input type="password" class="form-control" id="reg_password" name="reg_password" required placeholder="<?= $lang === 'en' ? 'Enter password' : 'შეიყვანეთ პაროლი'; ?>" minlength="6">
							<button type="button" class="toggle-password" data-target="#reg_password">
								<i class="fas fa-eye"></i>
							</button>
						</div>
						<div class="password-strength" id="passwordStrength"></div>
					</div>
					<div class="form-group">
						<label for="reg_password_confirm"><i class="fas fa-lock"></i> <?= $lang === 'en' ? 'Confirm Password' : 'გაიმეორეთ პაროლი'; ?></label>
						<div class="password-field">
							<input type="password" class="form-control" id="reg_password_confirm" name="reg_password_confirm" required placeholder="<?= $lang === 'en' ? 'Confirm password' : 'გაიმეორეთ პაროლი'; ?>">
							<button type="button" class="toggle-password" data-target="#reg_password_confirm">
								<i class="fas fa-eye"></i>
							</button>
						</div>
					</div>
					<button type="submit" class="auth-submit-btn" id="registerSubmit">
						<span class="btn-text"><?= $lang === 'en' ? 'Register' : 'რეგისტრაცია'; ?></span>
						<span class="btn-loader" style="display:none;"><i class="fas fa-spinner fa-spin"></i></span>
					</button>
				</form>
				<div class="auth-footer">
					<p><?= $lang === 'en' ? 'Already have an account?' : 'უკვე გაქვთ ანგარიში?'; ?> <a href="#" class="switch-modal" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal"><?= $lang === 'en' ? 'Login' : 'შესვლა'; ?></a></p>
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