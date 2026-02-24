<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mygun
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- All css Here -->
	<!-- All plugins css -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/allplugins.css">
	<!-- Style css -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/style.css">
	<!-- Responsive css -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/responsive.css">

	<!-- Customization css -->
	<!--If u need any change then use this css file-->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/custom.css">

	<!-- Modernizr JavaScript -->
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/modernizr-2.8.3.min.js"></script>

	<style>
		@media (min-width: 992px) {
			.mobilemenu .mobile-menu,
			.mobilemenu .mobile-menu *  { display: none !important; }
		}
	</style>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<?php $lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka'; ?>

	<!--Header area start here-->
	<header>

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2 col-sm-2 col-xs-12">
					<div class="logo-area">
						<a href="<?=site_url();?>">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/logo.png" alt="" />
						</a>
					</div>
				</div>
				<div class="col-md-10 col-sm-10 d-md-block d-sm-none d-none">
					<div class="main-header">
						<div class="main-menus">
							<nav>
								<?php
								// Build extra items: auth + language switcher
								$desktop_extra_items = '';

								// Auth items
								if ( is_user_logged_in() ) {
									$current_user = wp_get_current_user();
									$add_product_page = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'templates/tpl-add-product.php', 'number' => 1 ) );
									$add_product_url  = ! empty( $add_product_page ) ? get_permalink( $add_product_page[0]->ID ) : '#';
									$profile_page = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'templates/tpl-profile.php', 'number' => 1 ) );
									$profile_url  = ! empty( $profile_page ) ? get_permalink( $profile_page[0]->ID ) : admin_url( 'profile.php' );

									$desktop_extra_items .= '<li class="menu-item menu-item-has-children nav-auth-item"><a href="#"><i class="fas fa-user-circle"></i> ' . esc_html( $current_user->display_name ) . '</a>';
									$desktop_extra_items .= '<ul class="sub-menu">';
									$desktop_extra_items .= '<li><a href="' . esc_url( $add_product_url ) . '"><i class="fas fa-plus-circle"></i> ' . ( $lang === 'en' ? 'Add Product' : 'პროდუქტის დამატება' ) . '</a></li>';
									$desktop_extra_items .= '<li><a href="' . esc_url( $profile_url ) . '"><i class="fas fa-cog"></i> ' . ( $lang === 'en' ? 'Profile' : 'პროფილი' ) . '</a></li>';
									if ( current_user_can( 'manage_options' ) ) {
										$desktop_extra_items .= '<li><a href="' . esc_url( admin_url() ) . '"><i class="fas fa-tachometer-alt"></i> ' . ( $lang === 'en' ? 'Admin Panel' : 'ადმინ პანელი' ) . '</a></li>';
									}
									$desktop_extra_items .= '<li><a href="' . esc_url( wp_logout_url( home_url() ) ) . '"><i class="fas fa-sign-out-alt"></i> ' . ( $lang === 'en' ? 'Logout' : 'გასვლა' ) . '</a></li>';
									$desktop_extra_items .= '</ul></li>';
								} else {
									$desktop_extra_items .= '<li class="menu-item nav-auth-item"><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt"></i> ' . ( $lang === 'en' ? 'Login' : 'შესვლა' ) . '</a></li>';
									$desktop_extra_items .= '<li class="menu-item nav-auth-item"><a href="#" data-bs-toggle="modal" data-bs-target="#registerModal"><i class="fas fa-user-plus"></i> ' . ( $lang === 'en' ? 'Register' : 'რეგისტრაცია' ) . '</a></li>';
								}

								// Language switcher as menu item with dropdown
								if ( function_exists( 'pll_the_languages' ) ) {
									$pll_languages = pll_the_languages( array( 'raw' => 1 ) );
									if ( ! empty( $pll_languages ) ) {
										$other_langs = '';
										foreach ( $pll_languages as $pl ) {
											if ( ! $pl['current_lang'] ) {
												$other_langs .= '<li><a href="' . esc_url( $pl['url'] ) . '">' . strtoupper( $pl['slug'] ) . '</a></li>';
											}
										}
										if ( $other_langs ) {
											$desktop_extra_items .= '<li class="menu-item menu-item-has-children nav-lang-item"><a href="#"><i class="fas fa-globe"></i> ' . strtoupper( pll_current_language() ) . '</a>';
											$desktop_extra_items .= '<ul class="sub-menu">' . $other_langs . '</ul></li>';
										}
									}
								}

								// Get menu HTML and inject extra items before closing </ul>
								$desktop_menu_html = wp_nav_menu( array(
									'theme_location' => 'menu-1',
									'container'      => false,
									'items_wrap'     => '<ul class="mamnu">%3$s</ul>',
									'fallback_cb'    => '__return_false',
									'echo'           => false,
								));

								if ( $desktop_menu_html ) {
									$last_ul = strrpos( $desktop_menu_html, '</ul>' );
									if ( $last_ul !== false ) {
										echo substr_replace( $desktop_menu_html, $desktop_extra_items . '</ul>', $last_ul, 5 );
									} else {
										echo $desktop_menu_html;
									}
								} else {
									echo '<ul class="mamnu">';
									wp_list_pages( array( 'title_li' => '', 'depth' => 2 ) );
									echo $desktop_extra_items . '</ul>';
								}
								?>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--Responsive Menu area-->
		<div class="mobilemenu">
			<div class="mobile-menu d-md-none d-sm-block d-block">
				<nav>
					<?php
					// Build auth menu items to inject into the mobile menu
					$mobile_auth_items = '';
					if ( is_user_logged_in() ) {
						$add_product_page_m = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'templates/tpl-add-product.php', 'number' => 1 ) );
						$add_product_url_m  = ! empty( $add_product_page_m ) ? get_permalink( $add_product_page_m[0]->ID ) : '#';
						$profile_page_m = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'templates/tpl-profile.php', 'number' => 1 ) );
						$profile_url_m  = ! empty( $profile_page_m ) ? get_permalink( $profile_page_m[0]->ID ) : admin_url( 'profile.php' );

						$mobile_auth_items .= '<li class="mobile-auth-item"><a href="' . esc_url( $add_product_url_m ) . '"><i class="fas fa-plus-circle"></i> ' . ( $lang === 'en' ? 'Add Product' : 'პროდუქტის დამატება' ) . '</a></li>';
						$mobile_auth_items .= '<li class="mobile-auth-item"><a href="' . esc_url( $profile_url_m ) . '"><i class="fas fa-cog"></i> ' . ( $lang === 'en' ? 'Profile' : 'პროფილი' ) . '</a></li>';
						if ( current_user_can( 'manage_options' ) ) {
							$mobile_auth_items .= '<li class="mobile-auth-item"><a href="' . esc_url( admin_url() ) . '"><i class="fas fa-tachometer-alt"></i> ' . ( $lang === 'en' ? 'Admin Panel' : 'ადმინ პანელი' ) . '</a></li>';
						}
						$mobile_auth_items .= '<li class="mobile-auth-item"><a href="' . esc_url( wp_logout_url( home_url() ) ) . '"><i class="fas fa-sign-out-alt"></i> ' . ( $lang === 'en' ? 'Logout' : 'გასვლა' ) . '</a></li>';
					} else {
						$mobile_auth_items .= '<li class="mobile-auth-item"><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt"></i> ' . ( $lang === 'en' ? 'Login' : 'შესვლა' ) . '</a></li>';
						$mobile_auth_items .= '<li class="mobile-auth-item"><a href="#" data-bs-toggle="modal" data-bs-target="#registerModal"><i class="fas fa-user-plus"></i> ' . ( $lang === 'en' ? 'Register' : 'რეგისტრაცია' ) . '</a></li>';
					}

					// Add language switcher for mobile
					if ( function_exists( 'pll_the_languages' ) ) {
						$pll_langs = pll_the_languages( array( 'raw' => 1 ) );
						if ( ! empty( $pll_langs ) ) {
							foreach ( $pll_langs as $pl ) {
								if ( ! $pl['current_lang'] ) {
									$mobile_auth_items .= '<li class="mobile-auth-item"><a href="' . esc_url( $pl['url'] ) . '"><i class="fas fa-globe"></i> ' . strtoupper( $pl['slug'] ) . '</a></li>';
								}
							}
						}
					}

					// Get wp_nav_menu HTML and inject auth items before closing </ul>
					$mobile_menu_html = wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'container'      => false,
						'items_wrap'     => '<ul>%3$s</ul>',
						'fallback_cb'    => false,
						'echo'           => false,
					));

					if ( $mobile_menu_html ) {
						echo str_replace( '</ul>', $mobile_auth_items . '</ul>', $mobile_menu_html );
					} else {
						echo '<ul>' . $mobile_auth_items . '</ul>';
					}
					?>
				</nav>
			</div>
		</div>
		<!--Responsive Menu area End-->
	</header>
	<!--Header area end here-->
