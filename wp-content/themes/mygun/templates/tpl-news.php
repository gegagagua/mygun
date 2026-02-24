<?php
/* Template Name: News */

get_header();

$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

$news_query = new WP_Query( array(
	'post_type'      => array( 'news', 'post' ),
	'posts_per_page' => 9,
	'paged'          => $paged,
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
));
?>

<!-- Page Title area -->
<section class="page-title-area" style="background:#111; padding:60px 0 40px;">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h2 class="page-title-heading"><?= $lang === 'en' ? 'News' : 'სიახლეები'; ?></h2>
				<p class="page-title-sub"><?= $lang === 'en' ? 'Latest news and updates' : 'უახლესი სიახლეები და განახლებები'; ?></p>
			</div>
		</div>
	</div>
</section>

<!-- News Listing area -->
<section class="news-area section">
	<div class="container">

		<?php if ( $news_query->have_posts() ) : ?>
			<div class="row news-grid">
				<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
					<?php
					$cats = get_the_terms( get_the_ID(), 'news_cat' );
					if ( ! $cats || is_wp_error( $cats ) ) {
						$cats = get_the_terms( get_the_ID(), 'category' );
					}
					$cat_name = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : '';
					?>
					<div class="col-md-4 col-sm-6">
						<article class="news-card">
							<div class="news-card-thumb">
								<a href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'news-thumb' ); ?>
									<?php else : ?>
										<div class="news-no-thumb"><i class="fas fa-newspaper"></i></div>
									<?php endif; ?>
								</a>
								<?php if ( $cat_name ) : ?>
									<span class="news-card-cat"><?= esc_html( $cat_name ); ?></span>
								<?php endif; ?>
							</div>
							<div class="news-card-body">
								<div class="news-card-date">
									<i class="far fa-calendar-alt"></i> <?= get_the_date( 'd.m.Y' ); ?>
									<span class="news-card-author"><i class="far fa-user"></i> <?= get_the_author(); ?></span>
								</div>
								<h3 class="news-card-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<p class="news-card-excerpt"><?= wp_trim_words( get_the_excerpt(), 18, '...' ); ?></p>
								<a href="<?php the_permalink(); ?>" class="news-card-link">
									<?= $lang === 'en' ? 'Read More' : 'სრულად'; ?> <i class="fas fa-arrow-right"></i>
								</a>
							</div>
						</article>
					</div>
				<?php endwhile; ?>
			</div>

			<?php if ( $news_query->max_num_pages > 1 ) : ?>
				<div class="news-pagination">
					<?php
					echo paginate_links( array(
						'total'     => $news_query->max_num_pages,
						'current'   => $paged,
						'prev_text' => '<i class="fas fa-chevron-left"></i>',
						'next_text' => '<i class="fas fa-chevron-right"></i>',
					));
					?>
				</div>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

		<?php else : ?>
			<div class="no-news-msg">
				<i class="fas fa-newspaper"></i>
				<p><?= $lang === 'en' ? 'No news articles found.' : 'სიახლეები ვერ მოიძებნა.'; ?></p>
			</div>
		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>
