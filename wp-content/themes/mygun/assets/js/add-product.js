(function ($) {
	'use strict';

	var lang = mygun_auth.lang || 'ka';

	function t(en, ka) {
		return lang === 'en' ? en : ka;
	}

	/* ========================================
	   Alert Helper
	   ======================================== */
	function showAlert(type, message) {
		var $alert = $('#addProductAlert');
		$alert.removeClass('alert-success alert-error').addClass('alert-' + type).html(message).show();
		$('html, body').animate({ scrollTop: $alert.offset().top - 150 }, 300);
	}

	function hideAlert() {
		$('#addProductAlert').removeClass('alert-success alert-error').html('').hide();
	}

	/* ========================================
	   Main Image Preview
	   ======================================== */
	$('#product_image').on('change', function () {
		var file = this.files[0];
		if (!file) return;

		if (!file.type.match('image.*')) {
			showAlert('error', t('Please select an image file.', 'გთხოვთ აირჩიოთ სურათის ფაილი.'));
			$(this).val('');
			return;
		}

		if (file.size > 5 * 1024 * 1024) {
			showAlert('error', t('Image must be less than 5MB.', 'სურათი უნდა იყოს 5MB-ზე ნაკლები.'));
			$(this).val('');
			return;
		}

		var reader = new FileReader();
		reader.onload = function (e) {
			$('#mainImagePreviewImg').attr('src', e.target.result);
			$('#mainImagePreview').show();
			$('#mainImagePlaceholder').hide();
		};
		reader.readAsDataURL(file);
	});

	// Remove main image
	$(document).on('click', '.ap-remove-image[data-target="main"]', function (e) {
		e.preventDefault();
		e.stopPropagation();
		$('#product_image').val('');
		$('#mainImagePreview').hide();
		$('#mainImagePlaceholder').show();
	});

	/* ========================================
	   Gallery Images Preview
	   ======================================== */
	var galleryFiles = [];

	$('#product_gallery').on('change', function () {
		var files = Array.from(this.files);
		var maxFiles = 5;

		if (galleryFiles.length + files.length > maxFiles) {
			showAlert('error', t('Maximum 5 gallery images allowed.', 'მაქსიმუმ 5 გალერეის სურათია დაშვებული.'));
			return;
		}

		files.forEach(function (file) {
			if (!file.type.match('image.*')) return;
			if (file.size > 5 * 1024 * 1024) return;

			galleryFiles.push(file);
			var reader = new FileReader();
			reader.onload = function (e) {
				var idx = galleryFiles.length - 1;
				var thumb = '<div class="gallery-thumb" data-index="' + idx + '">';
				thumb += '<img src="' + e.target.result + '" alt="">';
				thumb += '<button type="button" class="ap-remove-image" data-target="gallery" data-index="' + idx + '"><i class="fas fa-times"></i></button>';
				thumb += '</div>';
				$('#galleryPreview').append(thumb);
			};
			reader.readAsDataURL(file);
		});

		if (galleryFiles.length > 0) {
			$('#galleryPlaceholder').hide();
		}
	});

	// Remove gallery image
	$(document).on('click', '.ap-remove-image[data-target="gallery"]', function (e) {
		e.preventDefault();
		e.stopPropagation();
		var idx = $(this).data('index');
		galleryFiles[idx] = null;
		$(this).closest('.gallery-thumb').remove();

		var hasImages = false;
		galleryFiles.forEach(function (f) { if (f) hasImages = true; });
		if (!hasImages) {
			$('#galleryPlaceholder').show();
			galleryFiles = [];
		}
	});

	/* ========================================
	   Drag & Drop
	   ======================================== */
	$('.ap-file-upload').on('dragover dragenter', function (e) {
		e.preventDefault();
		$(this).addClass('dragover');
	}).on('dragleave drop', function (e) {
		e.preventDefault();
		$(this).removeClass('dragover');
	});

	/* ========================================
	   Form Submit
	   ======================================== */
	$('#addProductForm').on('submit', function (e) {
		e.preventDefault();
		hideAlert();

		var title       = $.trim($('#product_title').val());
		var price       = $.trim($('#product_price').val());
		var description = $.trim($('#product_description').val());
		var mainImage   = $('#product_image')[0].files[0];

		// Validate
		$('.ap-form-control').removeClass('error');

		if (!title) {
			$('#product_title').addClass('error');
			showAlert('error', t('Please enter a product name.', 'გთხოვთ შეიყვანოთ პროდუქტის სახელი.'));
			return;
		}

		if (!price || isNaN(price) || parseFloat(price) < 0) {
			$('#product_price').addClass('error');
			showAlert('error', t('Please enter a valid price.', 'გთხოვთ შეიყვანოთ სწორი ფასი.'));
			return;
		}

		if (!description) {
			$('#product_description').addClass('error');
			showAlert('error', t('Please enter a description.', 'გთხოვთ შეიყვანოთ აღწერა.'));
			return;
		}

		if (!mainImage) {
			showAlert('error', t('Please upload a main image.', 'გთხოვთ ატვირთოთ მთავარი სურათი.'));
			return;
		}

		// Build FormData
		var formData = new FormData();
		formData.append('action', 'mygun_add_product');
		formData.append('nonce', $('[name="add_product_nonce"]').val());
		formData.append('lang', lang);
		formData.append('product_title', title);
		formData.append('product_price', price);
		formData.append('product_description', description);
		formData.append('product_category', $('#product_category').val());
		formData.append('product_condition', $('#product_condition').val());
		formData.append('mygun_location', $('#mygun_location').length ? ($('#mygun_location').val() || '') : '');
		formData.append('product_phone', $('#product_phone').val());
		formData.append('mygun_caliber', $('#mygun_caliber').val() || '');
		formData.append('mygun_firearm_type', $('#mygun_firearm_type').val() || '');
		formData.append('mygun_stock_included', $('#mygun_stock_included').length ? ($('#mygun_stock_included').val() || '') : '');
		formData.append('mygun_body', $('#mygun_body').length ? ($('#mygun_body').val() || '') : '');
		formData.append('mygun_length_mm', $('#mygun_length_mm').length ? ($('#mygun_length_mm').val() || '') : '');
		formData.append('mygun_weight_g', $('#mygun_weight_g').length ? ($('#mygun_weight_g').val() || '') : '');
		formData.append('product_image', mainImage);

		// Add gallery files
		galleryFiles.forEach(function (file) {
			if (file) {
				formData.append('product_gallery[]', file);
			}
		});

		var $btn = $('#addProductSubmit');
		$btn.prop('disabled', true);
		$btn.find('.btn-text').hide();
		$btn.find('.btn-loader').show();

		$.ajax({
			url: mygun_auth.ajax_url,
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function (response) {
				if (response.success) {
					showAlert('success', response.data.message);
					$('#addProductForm')[0].reset();
					$('#mainImagePreview').hide();
					$('#mainImagePlaceholder').show();
					$('#galleryPreview').html('');
					$('#galleryPlaceholder').show();
					galleryFiles = [];
				} else {
					showAlert('error', response.data.message);
				}
				$btn.prop('disabled', false);
				$btn.find('.btn-text').show();
				$btn.find('.btn-loader').hide();
			},
			error: function () {
				showAlert('error', t('An error occurred. Please try again later.', 'დაფიქსირდა შეცდომა. სცადეთ მოგვიანებით.'));
				$btn.prop('disabled', false);
				$btn.find('.btn-text').show();
				$btn.find('.btn-loader').hide();
			}
		});
	});

})(jQuery);
