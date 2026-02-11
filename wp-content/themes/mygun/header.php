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

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>


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
								wp_nav_menu(array(
									'theme_location' => 'menu-1',
									'container' => false, // Remove the container div
									'items_wrap' => '<ul class="mamnu">%3$s</ul>', // Wrap the menu items in <ul>
									'link_before' => '', // Add content before the link text
									'link_after' => '', // Add content after the link text
								));
								?>
							</nav>
						</div>

						<div class="cart-head">
							<button><i class="fas fa-shopping-cart"></i></button>
							<div class="nav-shop-cart">
								<div class="widget_shopping_cart_content">
									<ul class="product_list_widget ">
										<li class="mini_cart_item">

											<a href="#">
												<img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/5.jpg" alt="" />
												<p class="product-name">Shop Item 01</p>
											</a>

											<p class="quantity">1 x
												<strong class="Price-amount">$200.00</strong>
											</p>

											<a href="#" class="remove" title="Remove this item">x</a>
										</li>
										<li class="mini_cart_item">

											<a href="#">
												<img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/6.jpg" alt="" />
												<p class="product-name">Shop Item 01</p>
											</a>

											<p class="quantity">1 x
												<strong class="Price-amount">$200.00</strong>
											</p>

											<a href="#" class="remove" title="Remove this item">x</a>
										</li>
										<li class="mini_cart_item">

											<a href="#">
												<img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/7.jpg" alt="" />
												<p class="product-name">Shop Item 01</p>
											</a>

											<p class="quantity">1 x
												<strong class="Price-amount">$200.00</strong>
											</p>

											<a href="#" class="remove" title="Remove this item">x</a>
										</li>
									</ul>
									<!-- /.product_list_widget -->

									<p class="total">
										<strong>Subtotal:</strong>
										<span class="amount">$300.00
										</span>
									</p>

									<p class="buttons">
										<a href="#" class="btn1">View Cart</a>
										<a href="#" class="btn2">Checkout</a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--Responsive Menu area-->
		<div class="mobilemenu">
			<div class="mobile-menu d-md-none d-sm-block d-block">
				<nav>
					<ul>
						<li><a href="index.html">Home</a>
							<ul>
								<li><a href="index.html">Home-1</a></li>
								<li><a href="index-2.html">Home-2</a></li>
								<li><a href="index-3.html">Home-3</a></li>
							</ul>
						</li>
						<li><a href="about.html">About</a></li>
						<li><a href="services.html">services</a></li>
						<li>
							<a href="javascript:void(0)">pages</a>
							<ul>
								<li><a href="about.html">about</a></li>
								<li><a href="shop.html">shop</a></li>
								<li><a href="product-single.html">shop single</a></li>
								<li><a href="event.html">event</a></li>
								<li><a href="event-single.html">event-single</a></li>
								<li><a href="gallery.html">gallery</a></li>
								<li><a href="blog.html">blog</a></li>
								<li><a href="blog-single.html">blog single</a></li>
								<li><a href="contact.html">contact</a></li>
							</ul>
						</li>
						<li>
							<a href="#">shop</a>
							<ul>
								<li><a href="shop.html">shop page</a></li>
								<li><a href="product-single.html">shop single</a></li>

							</ul>
						</li>
						<li>
							<a href="#">blog</a>
							<ul>
								<li><a href="blog.html">blog page</a></li>
								<li><a href="blog-single.html">blog single</a></li>
							</ul>
						</li>
						<li><a href="contact.html">Contact</a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!--Responsive Menu area End-->
	</header>
	<!--Header area end here-->