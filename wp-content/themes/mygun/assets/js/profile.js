(function ($) {
	'use strict';

	var lang = mygun_auth.lang || 'ka';

	function t(en, ka) {
		return lang === 'en' ? en : ka;
	}

	/* ========================================
	   Alert Helpers
	   ======================================== */
	function showAlert(containerId, type, message) {
		var $alert = $('#' + containerId);
		$alert.removeClass('alert-success alert-error').addClass('alert-' + type).html(message).show();
		$('html, body').animate({ scrollTop: $alert.offset().top - 150 }, 300);
	}

	function hideAlert(containerId) {
		$('#' + containerId).removeClass('alert-success alert-error').html('').hide();
	}

	function setLoading($btn, loading) {
		if (loading) {
			$btn.prop('disabled', true);
			$btn.find('.btn-text').hide();
			$btn.find('.btn-loader').show();
		} else {
			$btn.prop('disabled', false);
			$btn.find('.btn-text').show();
			$btn.find('.btn-loader').hide();
		}
	}

	/* ========================================
	   Password Strength for new password
	   ======================================== */
	$('#new_password').on('keyup', function () {
		var password = $(this).val();
		var $container = $('#newPasswordStrength');
		var strength = getPasswordStrength(password);

		$container.html('<div class="strength-bar ' + strength.level + '"></div>');
		$container.next('.password-strength-text').remove();

		if (password.length > 0) {
			$container.after('<div class="password-strength-text ' + strength.level + '">' + strength.text + '</div>');
		}
	});

	function getPasswordStrength(password) {
		var score = 0;
		if (password.length >= 6) score++;
		if (password.length >= 10) score++;
		if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
		if (/\d/.test(password)) score++;
		if (/[^a-zA-Z0-9]/.test(password)) score++;

		if (score <= 2) {
			return { level: 'weak', text: t('Weak', 'სუსტი') };
		} else if (score <= 3) {
			return { level: 'medium', text: t('Medium', 'საშუალო') };
		} else {
			return { level: 'strong', text: t('Strong', 'ძლიერი') };
		}
	}

	/* ========================================
	   Update Profile Form
	   ======================================== */
	$('#profileForm').on('submit', function (e) {
		e.preventDefault();
		hideAlert('profileAlert');

		var displayName = $.trim($('#profile_display_name').val());
		var phone = $.trim($('#profile_phone').val());
		var bio = $.trim($('#profile_bio').val());

		$('.ap-form-control').removeClass('error');

		if (!displayName) {
			$('#profile_display_name').addClass('error');
			showAlert('profileAlert', 'error', t('Please enter a display name.', 'გთხოვთ შეიყვანოთ სახელი.'));
			return;
		}

		var $btn = $('#profileSubmit');
		setLoading($btn, true);

		$.ajax({
			url: mygun_auth.ajax_url,
			type: 'POST',
			data: {
				action: 'mygun_update_profile',
				nonce: $('[name="profile_nonce"]').val(),
				lang: lang,
				display_name: displayName,
				phone: phone,
				bio: bio
			},
			success: function (response) {
				if (response.success) {
					showAlert('profileAlert', 'success', response.data.message);
				} else {
					showAlert('profileAlert', 'error', response.data.message);
				}
				setLoading($btn, false);
			},
			error: function () {
				showAlert('profileAlert', 'error', t('An error occurred. Please try again later.', 'დაფიქსირდა შეცდომა. სცადეთ მოგვიანებით.'));
				setLoading($btn, false);
			}
		});
	});

	/* ========================================
	   Change Password Form
	   ======================================== */
	$('#passwordForm').on('submit', function (e) {
		e.preventDefault();
		hideAlert('passwordAlert');

		var currentPass = $('#current_password').val();
		var newPass = $('#new_password').val();
		var confirmPass = $('#confirm_new_password').val();

		$('.ap-form-control').removeClass('error');

		if (!currentPass) {
			$('#current_password').addClass('error');
			showAlert('passwordAlert', 'error', t('Please enter your current password.', 'გთხოვთ შეიყვანოთ მიმდინარე პაროლი.'));
			return;
		}

		if (!newPass || newPass.length < 6) {
			$('#new_password').addClass('error');
			showAlert('passwordAlert', 'error', t('New password must be at least 6 characters.', 'ახალი პაროლი უნდა შეიცავდეს მინიმუმ 6 სიმბოლოს.'));
			return;
		}

		if (newPass !== confirmPass) {
			$('#confirm_new_password').addClass('error');
			showAlert('passwordAlert', 'error', t('Passwords do not match.', 'პაროლები არ ემთხვევა.'));
			return;
		}

		var $btn = $('#passwordSubmit');
		setLoading($btn, true);

		$.ajax({
			url: mygun_auth.ajax_url,
			type: 'POST',
			data: {
				action: 'mygun_change_password',
				nonce: $('[name="password_nonce"]').val(),
				lang: lang,
				current_password: currentPass,
				new_password: newPass
			},
			success: function (response) {
				if (response.success) {
					showAlert('passwordAlert', 'success', response.data.message);
					$('#passwordForm')[0].reset();
					$('#newPasswordStrength').html('');
					$('#newPasswordStrength').next('.password-strength-text').remove();
				} else {
					showAlert('passwordAlert', 'error', response.data.message);
				}
				setLoading($btn, false);
			},
			error: function () {
				showAlert('passwordAlert', 'error', t('An error occurred. Please try again later.', 'დაფიქსირდა შეცდომა. სცადეთ მოგვიანებით.'));
				setLoading($btn, false);
			}
		});
	});

})(jQuery);
