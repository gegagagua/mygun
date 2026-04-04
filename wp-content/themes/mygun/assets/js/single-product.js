(function ($) {
	'use strict';

	$(function () {
		var $slider = $('.product-single-slider');
		if (
			$slider.length &&
			$slider.find('.product-single-slide').length > 1 &&
			typeof $slider.owlCarousel === 'function'
		) {
			$slider.owlCarousel({
				autoPlay: false,
				slideSpeed: 500,
				pagination: false,
				navigation: true,
				singleItem: true,
				navigationText: [
					"<i class='fas fa-long-arrow-alt-left'></i>",
					"<i class='fas fa-long-arrow-alt-right'></i>"
				]
			});
		}

		if (typeof $.fn.magnificPopup === 'function') {
			$('.product-single-media-gallery').each(function () {
				$(this).magnificPopup({
					delegate: 'a.product-single-lightbox',
					type: 'image',
					gallery: { enabled: true, navigateByImgClick: true },
					mainClass: 'mfp-with-zoom mfp-img-mobile'
				});
			});
		}
	});
})(jQuery);
