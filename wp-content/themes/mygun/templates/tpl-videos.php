<?php
/* Template Name: Videos */

/*
 * Note: the main videos listing lives at /videos/ (the Video Gallery archive,
 * archive-video_gallery.php). This page template renders the same UI and can be
 * assigned to a Page if you need the videos at a different URL.
 */

get_header();

$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
$t    = function( $en, $ka ) use ( $lang ) {
	return $lang === 'en' ? $en : $ka;
};
?>

<!-- Page Title area -->
<section class="page-title-area" style="background:#111; padding:60px 0 40px;">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h2 class="page-title-heading"><?php echo esc_html( mygun_t( 'Videos', 'ვიდეოები', 'Видео' ) ); ?></h2>
				<p class="page-title-sub"><?php echo esc_html( mygun_t( 'Latest videos from our channels', 'უახლესი ვიდეოები ჩვენი არხებიდან', 'Последние видео с наших каналов' ) ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="mygun-videos-area section">
	<div class="container">
		<?php mygun_render_videos_section(); ?>
	</div>
</section>

<?php
get_footer();
