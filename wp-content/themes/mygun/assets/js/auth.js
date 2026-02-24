(function ($) {
	'use strict';

	var lang = (typeof mygun_auth !== 'undefined' && mygun_auth.lang) ? mygun_auth.lang : 'ka';

	function t(en, ka) {
		return lang === 'en' ? en : ka;
	}

	/* ========================================
	   Prevent auth nav links from scrolling
	   ======================================== */
	$(document).on('click', '.nav-auth-item > a[data-bs-toggle="modal"]', function (e) {
		e.preventDefault();
	});

	/* ========================================
	   Toggle Password Visibility
	   ======================================== */
	$(document).on('click', '.toggle-password', function () {
		var target = $($(this).data('target'));
		var icon = $(this).find('i');

		if (target.attr('type') === 'password') {
			target.attr('type', 'text');
			icon.removeClass('fa-eye').addClass('fa-eye-slash');
		} else {
			target.attr('type', 'password');
			icon.removeClass('fa-eye-slash').addClass('fa-eye');
		}
	});

	/* ========================================
	   Password Strength Indicator
	   ======================================== */
	$(document).on('keyup', '#reg_password', function () {
		var password = $(this).val();
		var $container = $('#passwordStrength');
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
	   Alert Helper
	   ======================================== */
	function showAlert(containerId, type, message) {
		var $alert = $('#' + containerId);
		$alert.removeClass('alert-success alert-error').addClass('alert-' + type).html(message).show();
	}

	function hideAlert(containerId) {
		$('#' + containerId).removeClass('alert-success alert-error').html('').hide();
	}

	/* ========================================
	   Toggle Button Loading State
	   ======================================== */
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
	   Login Form Submit (delegated)
	   ======================================== */
	$(document).on('submit', '#loginForm', function (e) {
		e.preventDefault();
		hideAlert('loginAlert');

		var username = $.trim($('#login_username').val());
		var password = $('#login_password').val();
		var nonce = $('[name="login_nonce"]').val();
		var remember = $('[name="remember_me"]').is(':checked') ? 1 : 0;

		$('.form-control').removeClass('error');

		if (!username) {
			$('#login_username').addClass('error');
			showAlert('loginAlert', 'error', t('Please enter your username or email.', 'გთხოვთ შეიყვანოთ მომხმარებლის სახელი ან ელფოსტა.'));
			return;
		}
		if (!password) {
			$('#login_password').addClass('error');
			showAlert('loginAlert', 'error', t('Please enter your password.', 'გთხოვთ შეიყვანოთ პაროლი.'));
			return;
		}

		var $btn = $('#loginSubmit');
		setLoading($btn, true);

		$.ajax({
			url: mygun_auth.ajax_url,
			type: 'POST',
			data: {
				action: 'mygun_login',
				username: username,
				password: password,
				remember: remember,
				nonce: nonce,
				lang: lang
			},
			success: function (response) {
				if (response.success) {
					showAlert('loginAlert', 'success', response.data.message);
					setTimeout(function () {
						window.location.reload();
					}, 1000);
				} else {
					showAlert('loginAlert', 'error', response.data.message);
					setLoading($btn, false);
				}
			},
			error: function () {
				showAlert('loginAlert', 'error', t('An error occurred. Please try again later.', 'დაფიქსირდა შეცდომა. სცადეთ მოგვიანებით.'));
				setLoading($btn, false);
			}
		});
	});

	/* ========================================
	   Register Form Submit (delegated)
	   ======================================== */
	$(document).on('submit', '#registerForm', function (e) {
		e.preventDefault();
		hideAlert('registerAlert');

		var username = $.trim($('#reg_username').val());
		var email = $.trim($('#reg_email').val());
		var password = $('#reg_password').val();
		var passwordConfirm = $('#reg_password_confirm').val();
		var nonce = $('[name="register_nonce"]').val();

		$('.form-control').removeClass('error');

		if (!username || username.length < 3) {
			$('#reg_username').addClass('error');
			showAlert('registerAlert', 'error', t('Username must be at least 3 characters.', 'მომხმარებლის სახელი უნდა შეიცავდეს მინიმუმ 3 სიმბოლოს.'));
			return;
		}

		if (!email || !isValidEmail(email)) {
			$('#reg_email').addClass('error');
			showAlert('registerAlert', 'error', t('Please enter a valid email address.', 'გთხოვთ შეიყვანოთ სწორი ელფოსტის მისამართი.'));
			return;
		}

		if (!password || password.length < 6) {
			$('#reg_password').addClass('error');
			showAlert('registerAlert', 'error', t('Password must be at least 6 characters.', 'პაროლი უნდა შეიცავდეს მინიმუმ 6 სიმბოლოს.'));
			return;
		}

		if (password !== passwordConfirm) {
			$('#reg_password_confirm').addClass('error');
			showAlert('registerAlert', 'error', t('Passwords do not match.', 'პაროლები არ ემთხვევა.'));
			return;
		}

		var $btn = $('#registerSubmit');
		setLoading($btn, true);

		$.ajax({
			url: mygun_auth.ajax_url,
			type: 'POST',
			data: {
				action: 'mygun_register',
				username: username,
				email: email,
				password: password,
				nonce: nonce,
				lang: lang
			},
			success: function (response) {
				if (response.success) {
					showAlert('registerAlert', 'success', response.data.message);
					setTimeout(function () {
						window.location.reload();
					}, 1500);
				} else {
					showAlert('registerAlert', 'error', response.data.message);
					setLoading($btn, false);
				}
			},
			error: function () {
				showAlert('registerAlert', 'error', t('An error occurred. Please try again later.', 'დაფიქსირდა შეცდომა. სცადეთ მოგვიანებით.'));
				setLoading($btn, false);
			}
		});
	});

	function isValidEmail(email) {
		var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		return re.test(email);
	}

	/* ========================================
	   Reset forms when modals close (delegated)
	   ======================================== */
	$(document).on('hidden.bs.modal', '.auth-modal', function () {
		$(this).find('form')[0].reset();
		$(this).find('.auth-alert').removeClass('alert-success alert-error').html('').hide();
		$(this).find('.form-control').removeClass('error');
		$(this).find('.password-strength-text').remove();
		$(this).find('#passwordStrength').html('');
		$(this).find('.btn-text').show();
		$(this).find('.btn-loader').hide();
		$(this).find('button[type="submit"]').prop('disabled', false);
		$(this).find('.toggle-password i').removeClass('fa-eye-slash').addClass('fa-eye');
		$(this).find('input[type="text"].form-control').each(function () {
			if ($(this).closest('.password-field').length) {
				$(this).attr('type', 'password');
			}
		});
	});

	/* ========================================
	   Focus on input when modal opens (delegated)
	   ======================================== */
	$(document).on('shown.bs.modal', '#loginModal', function () {
		$('#login_username').focus();
	});

	$(document).on('shown.bs.modal', '#registerModal', function () {
		$('#reg_username').focus();
	});

})(jQuery);
