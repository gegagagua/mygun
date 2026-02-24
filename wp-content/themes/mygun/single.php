<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package mygun
 */

get_header();

// News post type — custom layout
if ( in_array( get_post_type(), array( 'news', 'post' ), true ) ) :

	$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
	$news_page     = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'templates/tpl-news.php', 'number' => 1 ) );
	$news_page_url = ! empty( $news_page ) ? get_permalink( $news_page[0]->ID ) : home_url( '/blog/' );

	while ( have_posts() ) : the_post();
		$cats = get_the_terms( get_the_ID(), 'news_cat' );
		if ( ! $cats || is_wp_error( $cats ) ) {
			$cats = get_the_terms( get_the_ID(), 'category' );
		}
		$cat_name = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : '';
	?>

	<!-- News Hero -->
	<section class="news-single-hero">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="news-single-hero-bg" style="background-image:url('<?= esc_url( get_the_post_thumbnail_url( get_the_ID(), 'news-single' ) ); ?>')"></div>
		<?php endif; ?>
		<div class="news-single-hero-overlay"></div>
		<div class="container">
			<div class="news-single-hero-content">
				<div class="news-single-breadcrumb">
					<a href="<?= esc_url( home_url() ); ?>"><?= $lang === 'en' ? 'Home' : 'მთავარი'; ?></a>
					<span>/</span>
					<a href="<?= esc_url( $news_page_url ); ?>"><?= $lang === 'en' ? 'News' : 'სიახლეები'; ?></a>
					<span>/</span>
					<span class="current"><?php the_title(); ?></span>
				</div>
				<?php if ( $cat_name ) : ?>
					<span class="news-single-cat"><?= esc_html( $cat_name ); ?></span>
				<?php endif; ?>
				<h1 class="news-single-title"><?php the_title(); ?></h1>
				<div class="news-single-meta">
					<span><i class="far fa-calendar-alt"></i> <?= get_the_date( 'd.m.Y' ); ?></span>
					<span><i class="far fa-user"></i> <?= get_the_author(); ?></span>
					<?php if ( $cats && ! is_wp_error( $cats ) ) : ?>
						<span><i class="far fa-folder"></i> <?= esc_html( $cat_name ); ?></span>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- News Content -->
	<section class="news-single-content section">
		<div class="container">
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<article class="news-single-article">
						<div class="news-single-body">
							<?php the_content(); ?>
						</div>

						<!-- Share -->
						<div class="news-single-share">
							<span class="share-label"><?= $lang === 'en' ? 'Share:' : 'გაზიარება:'; ?></span>
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode( get_permalink() ); ?>" target="_blank" rel="noopener" class="share-btn share-fb"><i class="fab fa-facebook-f"></i></a>
							<a href="https://twitter.com/intent/tweet?url=<?= urlencode( get_permalink() ); ?>&text=<?= urlencode( get_the_title() ); ?>" target="_blank" rel="noopener" class="share-btn share-tw"><i class="fab fa-twitter"></i></a>
							<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode( get_permalink() ); ?>" target="_blank" rel="noopener" class="share-btn share-li"><i class="fab fa-linkedin-in"></i></a>
						</div>

						<!-- Navigation -->
						<div class="news-single-nav">
							<?php
							$prev_post = get_adjacent_post( false, '', true );
							$next_post = get_adjacent_post( false, '', false );
							?>
							<div class="news-nav-item news-nav-prev">
								<?php if ( $prev_post ) : ?>
									<a href="<?= get_permalink( $prev_post->ID ); ?>">
										<span class="news-nav-label"><i class="fas fa-arrow-left"></i> <?= $lang === 'en' ? 'Previous' : 'წინა'; ?></span>
										<span class="news-nav-title"><?= esc_html( $prev_post->post_title ); ?></span>
									</a>
								<?php endif; ?>
							</div>
							<div class="news-nav-item news-nav-next">
								<?php if ( $next_post ) : ?>
									<a href="<?= get_permalink( $next_post->ID ); ?>">
										<span class="news-nav-label"><?= $lang === 'en' ? 'Next' : 'შემდეგი'; ?> <i class="fas fa-arrow-right"></i></span>
										<span class="news-nav-title"><?= esc_html( $next_post->post_title ); ?></span>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</article>

					<!-- Related News -->
					<?php
					$related_args = array(
						'post_type'      => array( 'news', 'post' ),
						'posts_per_page' => 3,
						'post__not_in'   => array( get_the_ID() ),
						'orderby'        => 'rand',
						'post_status'    => 'publish',
					);
					if ( $cats && ! is_wp_error( $cats ) ) {
						$tax = ( get_post_type() === 'news' ) ? 'news_cat' : 'category';
						$related_args['tax_query'] = array( array(
							'taxonomy' => $tax,
							'field'    => 'term_id',
							'terms'    => wp_list_pluck( $cats, 'term_id' ),
						));
					}
					$related = new WP_Query( $related_args );

					if ( $related->have_posts() ) :
					?>
						<div class="news-related">
							<h3 class="news-related-title"><?= $lang === 'en' ? 'Related News' : 'მსგავსი სიახლეები'; ?></h3>
							<div class="row">
								<?php while ( $related->have_posts() ) : $related->the_post(); ?>
									<div class="col-md-4">
										<div class="news-related-card">
											<a href="<?php the_permalink(); ?>" class="news-related-thumb">
												<?php if ( has_post_thumbnail() ) : ?>
													<?php the_post_thumbnail( 'news-thumb' ); ?>
												<?php else : ?>
													<div class="news-no-thumb news-no-thumb-sm"><i class="fas fa-newspaper"></i></div>
												<?php endif; ?>
											</a>
											<div class="news-related-info">
												<span class="news-related-date"><i class="far fa-calendar-alt"></i> <?= get_the_date( 'd.m.Y' ); ?></span>
												<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											</div>
										</div>
									</div>
								<?php endwhile; ?>
							</div>
						</div>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</section>

	<?php endwhile; ?>

<?php else : ?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'mygun' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'mygun' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile;
		?>

	</main><!-- #main -->

<?php
	get_sidebar();
endif;

get_footer();
