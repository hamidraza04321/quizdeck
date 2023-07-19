
$(document).ready(function() {
	
	var baseUrl = $("#base_url").val();

	// AJAX CSRF META
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	// ON CLIK LOGIN BUTTON
	$(document).on('click', '#login-btn', function(event) {
		event.preventDefault();

		$('.input').removeClass('border-red').siblings('span.error-txt').remove();

		var username = $("#username").val();
			password = $("#password").val();
			flag     = true;

		if (username == '') {
			$(".input-username").addClass('border-red').after('<span class="error-txt margin-bottom-8px">The field is required !</span>');
			flag = false;
		}

		if (password == '') {
			$(".input-password").addClass('border-red').after('<span class="error-txt">The field is required !</span>');
			flag = false;
		}

		if (flag) {

			// LOADING START
			$(".login-form").addClass('opacity');
			$(".loading").addClass('loader');
			$("#login-btn").attr('disabled');

			$.ajax({
				url: baseUrl + 'login',
				type: 'POST',
				data: {
					username: username,
					password: password
				},
				success: function(response) {
					if (response.error) {

						// LOADING STOP
						$(".login-form").removeClass('opacity');
						$(".loading").removeClass('loader');
						$("#login-btn").removeAttr('disabled');
						
						$(".input-username").addClass('border-red').after('<span class="error-txt margin-bottom-8px">'+response.error+'</span>');
						$("#password").val('');
					
					} else {
						if (response.role == 'admin') {
							window.location.href = baseUrl + 'admin/dashboard';
						} else {
							window.location.href = baseUrl + 'dashboard';
						}
					}
				},
				error: function() {
					alert('Oops Something went wrong please try again!');	
				}
			});
		}
	});

	// ON CLICK REGISTER BUTTON
	$(document).on('click', '#register-btn', function(event) {
		event.preventDefault();

		$('.input').removeClass('border-red').siblings('span.error-txt').remove();

		var name 				= $("#register-fullname").val();
			username 			= $("#register-username").val();
			password 			= $("#register-password").val();
			flag 				= true;

		if (name == '') {
			$(".input-register-fullname").addClass('border-red').after('<span class="error-txt">The field is required !</span>');
			flag = false;
		}

		if (username == '') {
			$(".input-register-username").addClass('border-red').after('<span class="error-txt">The field is required !</span>');
			flag = false;
		}

		if (password == '') {
			$(".input-register-password").addClass('border-red').after('<span class="error-txt">The field is required !</span>');
			flag = false;
		} else{
			if (password.length < 6) {
				$(".input-register-password").addClass('border-red').after('<span class="error-txt">The password is minimum 6 characters required !</span>');
				flag = false;
			}
		}

		if (flag) {

			// LOADING START
			$(".register-form").addClass('opacity').css('overflow', 'hidden');
			$(".loading-regster").addClass('loader');
			$("#register-btn").attr('disabled');

			setTimeout(function() { 
				$.ajax({
					url: baseUrl + 'register',
					type: 'POST',
					data: {
						name: name,
						username: username,
						password: password
					},
					success: function(response) {
						if (response.status == false) {
							if (response.error.username) {
								$(".input-register-username").addClass('border-red').after('<span class="error-txt">'+response.error.username[0]+'</span>');
							}
							if (response.error.name) {
								$(".input-register-fullname").addClass('border-red').after('<span class="error-txt">'+response.error.name[0]+'</span>');
							}
						} else {
							
							localStorage.setItem("sign-up", true);
							
							Swal.fire(
							    'Registration Successfully!',
							    'Please sign in to continue!',
							    'success'
							);

				            $("#register-username, #register-password, #confirm-password").val('');
							$("#option1").trigger('click');
						}
					},
					error: function() {
						alert('Oops! Something went wrong please try again!');	
					},
					complete: function(){
						// LOADING STOP
						$(".register-form").removeClass('opacity');
						$(".loading-regster").removeClass('loader');
						$("#register-btn").removeAttr('disabled');
					}
				});
		    }, 1000);		

		}
	});

	// ON CLICK REGISTER BUTTON
	$(document).on('click', '#btn-reset-password', function(event) {
		event.preventDefault();

		$('.input').removeClass('border-red').siblings('span.error-txt').remove();
		$('.alert').remove();

		var email = $("#email").val();
			flag  = true;

		if (email == '') {
			$(".input-email").addClass('border-red').after('<span class="error-txt">The field is required !</span>');
			flag = false;
		}

		if (flag) {

			// LOADING START
			$(".reset-password").addClass('opacity').css('overflow', 'hidden');
			$(".loading-reset-password").addClass('loader');
			$("#btn-reset-password").attr('disabled');

			var form = $("#reset-password-form");
				url  = form.attr('action');

			$.ajax({
				url: url,
				type: 'POST',
				data: { email: email },
				success: function(response) {
					if (response.status == false) {
						if (response.error.email) {
							$(".input-email").addClass('border-red').after('<span class="error-txt">'+response.error.email[0]+'</span>');
						}
					} else {
			            $("#email").val('');
			            $(".input-email").before('<div class="alert alert-success" role="alert">Email Sent Successfully!</div>');
					}
				},
				error: function() {
					alert('Oops! Something went wrong please try again!');	
				},
				complete: function(){
					// LOADING STOP
					$(".reset-password").removeClass('opacity');
					$(".loading-reset-password").removeClass('loader');
					$("#btn-reset-password").removeAttr('disabled');
				}
			});
		}
	});

	// ON CLICK PASSWORD RESET BUTTON
	$(document).on('click', '#reset-password-btn', function(event) {
		event.preventDefault();

		$('.input').removeClass('border-red').siblings('span.error-txt').remove();

		var new_password 	 = $("#new-password").val();
			confirm_password = $("#confirm-password").val();
			flag  = true;

		if (new_password == '') {
			$(".input-new-password").addClass('border-red').after('<span class="error-txt">The field is required !</span>');
			flag = false;
		} else {
			if (new_password.length < 6) {
				$(".input-new-password").addClass('border-red').after('<span class="error-txt">The Password is minimum six characters required !</span>');
				flag = false;
			}
		}

		if (confirm_password == '') {
			$(".input-confirm-password").addClass('border-red').after('<span class="error-txt">The field is required !</span>');
			flag = false;
		}

		if (new_password != confirm_password) {
			$(".input-confirm-password").addClass('border-red').after('<span class="error-txt">The Confirm Password does not match !</span>');
			flag = false;
		}

		if (flag) {

			// LOADING START
			$(".reset-password").addClass('opacity').css('overflow', 'hidden');
			$(".loading-reset-password-form").addClass('loader');
			$("#reset-password-btn").attr('disabled');

			var url 		= $("#reset-password-form").attr('action');
				formData 	= $("#reset-password-form").serialize();

			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				success: function(response) {
					if (response.status === false) {
                        if (response.errors) {
                            if (Object.keys(response.errors).length > 0) {
                                var input_fields = ['email', 'password'];
                                $.each(response.errors, function (key, value) {
                                    if (input_fields.indexOf(key) >= 0) {
                                        $("input[name='" + key + "']").addClass("border-red");
                                        $("input[name='" + key + "']").after("<span class='error'>" + value.toString().split(/[,]+/) + "</span>");
                                    }
                                });
                            }
                        }
                    } else {
                    	window.location.href = baseUrl + 'login?resetPassword=true'
                    }
				}
			});
			
		}
	});
});