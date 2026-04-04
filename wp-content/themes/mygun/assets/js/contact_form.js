(function ($) {
	'use strict';

	function getLang() {
		if (typeof mygun_auth !== 'undefined' && mygun_auth.lang) {
			return mygun_auth.lang;
		}
		return 'ka';
	}

	function t(en, ka) {
		return getLang() === 'en' ? en : ka;
	}

	function showResponse($target, type, text) {
		var color = type === 'success' ? '#5cb85c' : '#d82e2e';
		$target.html('<p style="color:' + color + ';">' + text + '</p>');
	}

	function validateForm($form, $response) {
		var isValid = true;
		var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

		$response.html('');
		$form.find('.error').removeClass('error');

		$form.find('input.require, textarea.require').each(function () {
			if ($.trim($(this).val()) === '') {
				$(this).addClass('error');
				if (isValid) {
					$(this).focus();
				}
				isValid = false;
			}
		});

		var $email = $form.find('input[name="email"]');
		if ($email.length && $.trim($email.val()) !== '' && !emailRegex.test($.trim($email.val()))) {
			$email.addClass('error');
			if (isValid) {
				$email.focus();
			}
			isValid = false;
			showResponse($response, 'error', t('Please enter a valid email address.', 'გთხოვთ შეიყვანოთ სწორი ელფოსტის მისამართი.'));
			return false;
		}

		if (!isValid) {
			showResponse($response, 'error', t('Please fill in all required fields.', 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი.'));
		}

		return isValid;
	}

	$(document).on('click', '.submitForm', function (e) {
		e.preventDefault();

		var $btn = $(this);
		var $form = $btn.closest('form');
		var $response = $form.find('.response');
		var nonce = $form.find('input[name="contact_nonce"]').val();

		if (!validateForm($form, $response)) {
			return;
		}

		$btn.prop('disabled', true);

		$.ajax({
			type: 'POST',
			url: (typeof mygun_auth !== 'undefined' ? mygun_auth.ajax_url : '/wp-admin/admin-ajax.php'),
			dataType: 'json',
			data: {
				action: 'mygun_contact_form',
				nonce: nonce,
				lang: getLang(),
				full_name: $.trim($form.find('input[name="full_name"]').val()),
				email: $.trim($form.find('input[name="email"]').val()),
				subject: $.trim($form.find('input[name="subject"]').val()),
				message: $.trim($form.find('textarea[name="message"]').val())
			}
		}).done(function (resp) {
			if (resp && resp.success) {
				$form[0].reset();
				showResponse($response, 'success', resp.data && resp.data.message ? resp.data.message : t('Your message has been sent successfully!', 'თქვენი შეტყობინება წარმატებით გაიგზავნა!'));
			} else {
				showResponse($response, 'error', resp && resp.data && resp.data.message ? resp.data.message : t('Failed to send message. Please try again later.', 'შეტყობინების გაგზავნა ვერ მოხერხდა. სცადეთ მოგვიანებით.'));
			}
		}).fail(function () {
			showResponse($response, 'error', t('Something went wrong. Please try again later.', 'დაფიქსირდა შეცდომა. სცადეთ მოგვიანებით.'));
		}).always(function () {
			$btn.prop('disabled', false);
		});
	});

})(jQuery);