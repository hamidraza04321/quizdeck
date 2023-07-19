@extends('layout.master')
@section('page-title', 'User Profile')
@section('main-content')
<style>
	.border-red {
		border: 1px solid red;
	}

	.error {
		color: red;
	}

	button {
		all: unset;
	}

	h1 {
		margin-bottom: 2rem;
		font-weight: 700;
		font-size: 3rem;
		color: #000;
		line-height: 1.2;
	}
	h1 strong {
		display: block;
		font-weight: 500;
		color: #999;
		font-size: 1rem;
	}
	.tabs {
		border: 1px solid rgba(0, 0, 0, 0.125);
		border-radius: 0.25rem;
	}
	.tabs__nav {
		border-bottom: 1px solid rgba(0, 0, 0, 0.125);
		background-color: var(--color-accent-x-light);
	}
	.tabs__btn {
		position: relative;
		padding: 1rem 1.25rem;
		cursor: pointer;
		transition: opacity 0.3s;
	}
	.tabs__btn:not(.is-active) {
		opacity: 0.6;
	}
	.tabs__btn:not(.is-active):hover {
		opacity: 1;
	}
	.tabs__btn.is-active {
		color: var(--color-accent);
		background-color: #fff;
		border-right: 1px solid rgba(0, 0, 0, 0.125);
		border-left: 1px solid rgba(0, 0, 0, 0.125);
	}
	.tabs__btn.is-active::after {
		content: "";
		position: absolute;
		bottom: -1px;
		left: 0;
		height: 1px;
		width: 100%;
		background-color: #fff;
	}
	.tabs__btn:first-child.is-active {
		border-left: none;
	}
	.tabs__pane {
		display: none;
		padding: 2rem 1.25rem;
	}
	.tabs__pane.is-visible {
		display: block;
	}
	.main-body {
	    padding: 15px;
	}
	.card {
	    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
	}

	.card {
	    position: relative;
	    display: flex;
	    flex-direction: column;
	    min-width: 0;
	    word-wrap: break-word;
	    background-color: #fff;
	    background-clip: border-box;
	    border: 0 solid rgba(0,0,0,.125);
	    border-radius: .25rem;
	}

	.card-body {
	    flex: 1 1 auto;
	    min-height: 1px;
	    padding: 1rem;
	}

	.gutters-sm {
	    margin-right: -8px;
	    margin-left: -8px;
	}

	.gutters-sm>.col, .gutters-sm>[class*=col-] {
	    padding-right: 8px;
	    padding-left: 8px;
	}
	.mb-3, .my-3 {
	    margin-bottom: 1rem!important;
	}

	.bg-gray-300 {
	    background-color: #e2e8f0;
	}
	.h-100 {
	    height: 100%!important;
	}
	.shadow-none {
	    box-shadow: none!important;
	}
	.profile-pic-wrapper {
	  width: 100%;
	  position: relative;
	  display: flex;
	  flex-direction: column;
	  justify-content: center;
	  align-items: center;
	}
	.pic-holder {
	  text-align: center;
	  position: relative;
	  border-radius: 50%;
	  width: 150px;
	  height: 150px;
	  overflow: hidden;
	  display: flex;
	  justify-content: center;
	  align-items: center;
	  margin-bottom: 20px;
	}

	.pic-holder .pic {
	  height: 100%;
	  width: 100%;
	  -o-object-fit: cover;
	  object-fit: cover;
	  -o-object-position: center;
	  object-position: center;
	}

	.pic-holder .upload-file-block,
	.pic-holder .upload-loader {
	  position: absolute;
	  top: 0;
	  left: 0;
	  height: 100%;
	  width: 100%;
	  background-color: rgba(90, 92, 105, 0.7);
	  color: #f8f9fc;
	  font-size: 12px;
	  font-weight: 600;
	  opacity: 0;
	  display: flex;
	  align-items: center;
	  justify-content: center;
	  transition: all 0.2s;
	}

	.pic-holder .upload-file-block {
	  cursor: pointer;
	}

	.pic-holder:hover .upload-file-block,
	.uploadProfileInput:focus ~ .upload-file-block {
	  opacity: 1;
	}

	.pic-holder.uploadInProgress .upload-file-block {
	  display: none;
	}

	.pic-holder.uploadInProgress .upload-loader {
	  opacity: 1;
	}

	/* Snackbar css */
	.snackbar {
	  visibility: hidden;
	  min-width: 250px;
	  background-color: #333;
	  color: #fff;
	  text-align: center;
	  border-radius: 2px;
	  padding: 16px;
	  position: fixed;
	  z-index: 1;
	  left: 50%;
	  bottom: 30px;
	  font-size: 14px;
	  transform: translateX(-50%);
	}

	.snackbar.show {
	  visibility: visible;
	  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
	  animation: fadein 0.5s, fadeout 0.5s 2.5s;
	}

	@-webkit-keyframes fadein {
	  from {
	    bottom: 0;
	    opacity: 0;
	  }
	  to {
	    bottom: 30px;
	    opacity: 1;
	  }
	}

	@keyframes fadein {
	  from {
	    bottom: 0;
	    opacity: 0;
	  }
	  to {
	    bottom: 30px;
	    opacity: 1;
	  }
	}

	@-webkit-keyframes fadeout {
	  from {
	    bottom: 30px;
	    opacity: 1;
	  }
	  to {
	    bottom: 0;
	    opacity: 0;
	  }
	}

	@keyframes fadeout {
	  from {
	    bottom: 30px;
	    opacity: 1;
	  }
	  to {
	    bottom: 0;
	    opacity: 0;
	  }
	}

</style>
<div class="container">
    <div class="main-body">
		<div class="row gutters-sm">
			<div class="col-md-4 mb-3">
			  <div class="card">
			    <div class="card-body">
			      <div class="d-flex flex-column align-items-center text-center">
			        <form action="{{ route('update.user.profile.image') }}" id="updateProfileImage" enctype="multipart/form-data">
				        @csrf
				        <input type="hidden" name="user_id" value="{{ $user->id }}">
				        <div class="profile-pic-wrapper">
						    <div class="pic-holder">
							    <!-- uploaded pic shown here -->
							    @if($user->user_image == null)
							    	<img id="profilePic" class="pic" src="{{ asset('/admin/assets/images/no_image_found.png') }}">
							    @else
							    	<img id="profilePic" class="pic" src="{{ asset('/admin/assets/images/user') . '/' . $user->user_image }}">
							    @endif
							    <input class="uploadProfileInput" type="file" name="user_image" id="newProfilePhoto" accept="image/*" style="opacity: 0;" />
							    <label for="newProfilePhoto" class="upload-file-block">
							      	<div class="text-center">
							        	<div class="mb-2"><i class="fa fa-camera fa-2x"></i></div>
							        	<div class="text-uppercase">Update <br /> Profile Photo</div>
							      	</div>
							    </label>
							</div>
						</div>
					</form>
			        <div class="mt-3">
			          <h4>{{ $user->name }}</h4>
			          @if($user->designation != '')
			          	<p class="text-secondary mb-1">{{ $user->designation }}</p>
			          @endif
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
			<div class="col-md-8">
			  	<div class="card mb-3">
			    	<div class="card-body">
			    		<div class="tabs">
							<nav class="tabs__nav" role="tablist">
								<button class="tabs__btn is-active" data-tab-target="tab-1" type="button" role="tab" aria-selected="true" style="outline: none;">Profile</button>
								<button class="tabs__btn" data-tab-target="tab-2" type="button" role="tab" aria-selected="false" style="outline: none;">Change Password</button>
							</nav>
							<div class="tabs__content">
								<form action="{{ route('user.profile.update', $user->id) }}" method="POST" id="update-user">
									@csrf
									<div class="tabs__pane is-visible" id="tab-1" role="tabpanel">
										<div class="row">
							        		<div class="col-sm-3">
								          		<h6 class="mb-0">Full Name</h6>
									        </div>
									        <div class="input-fullname col-sm-9">
								        		<div class="text-secondary">{{ $user->name }}</div>
									        </div>
								      	</div>
								      	<hr>
								      	<div class="row">
							        		<div class="col-sm-3">
								          		<h6 class="mb-0">User Name</h6>
									        </div>
									        <div class="input-username col-sm-9">
								        		<div class="text-secondary">{{ $user->username }}</div>
									        </div>
								      	</div>
								      	<hr>
								      	<div class="row">
								        	<div class="col-sm-3">
								          		<h6 class="mb-0">Email</h6>
								        	</div>
								        	<div class="input-email col-sm-9">
								        		<div class="text-secondary">{{ ($user->email == '' ? '--' : $user->email) }}</div>
								        	</div>
								      	</div>
								      	<hr>
								      	<div class="row">
							        		<div class="col-sm-3">
								          		<h6 class="mb-0">Designation</h6>
									        </div>
									        <div class="input-designation col-sm-9">
								        		<div class="text-secondary">{{ ($user->designation == '' ? '--' : $user->designation) }}</div>
									        </div>
								      	</div>
								      	<hr>
								      	<div class="row">
								        	<div class="col-sm-3">
								          		<h6 class="mb-0">Phone No.</h6>
								        	</div>
								        	<div class="input-phone-no col-sm-9">
								        		<div class="text-secondary">{{ ($user->phone_no == '' ? '--' : $user->phone_no) }}</div>
								        	</div>
								      	</div>
								      	<hr>
								      	<div class="row">
								        	<div class="col-sm-3">
								          		<h6 class="mb-0">Address</h6>
								        	</div>
								        	<div class="input-address col-sm-9">
							        			<div class="text-secondary">{{ ($user->address == '' ? '--' : $user->address) }}</div>
								        	</div>	
							      		</div>
								      	<hr>
								      	<div class="row">
								        	<div class="col-sm-12 profile-detail-btns">
								          		<button type="button" class="btn btn-info btn-edit-user"><i class="fa fa-edit"></i> Edit</button>
								        	</div>
								      	</div>
									</div>
								</form>
								<form action="{{ route('user.profile.change.password') }}" method="POST" id="form-change-password">
									@csrf
									<input type="hidden" name="user_id" value="{{ $user->id }}">
									<div class="tabs__pane" id="tab-2" role="tabpanel">
										<div class="form-group">
											<label>Current Password</label>
											<input type="password" name="current_password" id="current-password" class="form-control">
										</div>
										<div class="form-group">
											<label>New Password</label>
											<input type="password" name="new_password" id="new-password" class="form-control">
										</div>
										<div class="form-group">
											<label>Retype Password</label>
											<input type="password" name="retype_password" id="retype-password" class="form-control">
										</div>
										<div class="form-group">
											<div class="row">
									        	<div class="col-sm-12">
									          		<button type="button" id="change-password" class="btn btn-primary">Update</button>
									        	</div>
									      	</div>
										</div>
									</div>
								</form>
							</div>
						</div>
				    </div>
				 </div>
			</div>
		    <p style="margin-top: 150px;"><p>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	@if(Session::has('message'))
    	toastr.success("{{ session()->get('message') }}");
  	@endif

	$(document).ready(function() {
		
		$(document).on('click', '.btn-edit-user', function(event) {
			event.preventDefault();

			removeErrorMessages();

			// CHNAGE TEXT IN TO INPUT
			$(".input-fullname, .input-username, .input-email, .input-designation, .input-phone-no, .input-address, .profile-detail-btns").empty();

			$(".input-fullname").append('<input name="name" id="name" class="form-control" value="{{ $user->name }}">');
			$(".input-username").append('<input name="username" id="username" class="form-control" value="{{ $user->username }}">');
			$(".input-email").append('<input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">');
			$(".input-designation").append('<input type="text" name="designation" id="designation" class="form-control" value="{{ $user->designation }}">');
			$(".input-phone-no").append('<input name="phone_no" class="form-control" id="phone-no" value="{{ $user->phone_no }}">');
			$(".input-address").append('<textarea name="address" class="form-control" id="address">{{ $user->address }}</textarea>');

			$(".profile-detail-btns").append('<button type="button" id="btn-update-user" class="btn btn-info btn-update-user"> Update </button>&nbsp;<button type="button" class="btn btn-danger btn-cancel"> Cancel</button>');
		});

		$(document).on('click', '.btn-cancel', function(event) {
			event.preventDefault();

			removeErrorMessages();

			// CHNAGE INPUT IN TO TEXT
			$(".input-fullname, .input-username, .input-email, .input-designation, .input-phone-no, .input-address, .profile-detail-btns").empty();

			$(".input-fullname").append('<div class="text-secondary">{{ $user->name }}</div>');
			$(".input-username").append('<div class="text-secondary">{{ $user->username }}</div>');
			$(".input-email").append('<div class="text-secondary">{{ $user->email }}</div>');
			$(".input-designation").append('<div class="text-secondary">{{ ($user->designation == "") ? '--' : $user->designation  }}</div>');
			$(".input-phone-no").append('<div class="text-secondary">{{ ($user->phone_no == "") ? '--' : $user->phone_no }}</div>');
			$(".input-address").append('<div class="text-secondary">{{ ($user->address == "") ? '--' : $user->address }}</div>');

			$(".profile-detail-btns").append('<button type="button" class="btn btn-info btn-edit-user"><i class="fa fa-edit"></i> Edit</button>');
		});

		$(document).on('click', '#btn-update-user', function(event) {
			event.preventDefault();

			removeErrorMessages();

			var name 		= $("#name").val();
			    username 	= $("#username").val();
			    email 		= $("#email").val();
			    designation = $("#designation").val();
			    phone_no 	= $("#phone-no").val();
			    address 	= $("#address").text();
			    flag 		= true;

			if (name == "") {
				$("#name").addClass('border-red').after('<span class="error">The field is required!</span>');
				flag = false;
			}

			if (username == "") {
				$("#username").addClass('border-red').after('<span class="error">The field is required!</span>');
				flag = false;
			}

			if (email == "") {
				$("#email").addClass('border-red').after('<span class="error">The field is required!</span>');
				flag = false;
			}

			if (flag) {
				$("#btn-update-user").addClass('disabled');
				$("#btn-update-user").html('....');

				var form 	 = $("#update-user");
					url  	 = form.attr('action');
					formData = form.serialize();

				$.ajax({
					url: url,
					type: 'POST',
					data: formData,
					success: function(response){
						if (response.status === false) {
	                        if (response.errors) {
	                            if (Object.keys(response.errors).length > 0) {
	                                var input_fields = ['name', 'username', 'email'];
	                                $.each(response.errors, function (key, value) {
	                                    if (input_fields.indexOf(key) >= 0) {
	                                        $("input[name='" + key + "']").addClass("border-red");
	                                        $("input[name='" + key + "']").after("<span class='error'>" + value.toString().split(/[,]+/) + "</span>");
	                                    }
	                                });
	                            }
	                        }
	                    } else {
	                    	// CHNAGE INPUT IN TO TEXT
							$(".input-fullname, .input-username, .input-email, .input-designation, .input-phone-no, .input-address, .profile-detail-btns").empty();

							var user = response.user;

							$(".input-fullname").append('<div class="text-secondary">'+user.name+'</div>');
							$(".input-username").append('<div class="text-secondary">'+user.username+'</div>');
							$(".input-email").append('<div class="text-secondary">'+user.email+'</div>');
							$(".input-designation").append('<div class="text-secondary">'+(user.designation == "" ? '--' : user.designation)+'</div>');
							$(".input-phone-no").append('<div class="text-secondary">'+(user.phone_no == "" ? '--' : user.phone_no)+'</div>');
							$(".input-address").append('<div class="text-secondary">'+(user.address == "" ? '--' : user.address)+'</div>');

							$(".profile-detail-btns").append('<button type="button" class="btn btn-info btn-edit-user"><i class="fa fa-edit"></i> Edit</button>');
	                    	toastr.success('Profile Updated Successfully!');
	                    }
					},
					error: function(){
						alert('Oops Something went wrong please try again later');
					},
					complete: function(){
						$("#btn-update-user").removeClass('disabled');
						$("#btn-update-user").html('Update');
					},
				});	
			}
		});

		$(document).on('click', '#change-password', function(event) {
			event.preventDefault();
			
			removeErrorMessages();

			var current_password = $("#current-password").val();
			    new_password 	 = $("#new-password").val();
			    retype_password  = $("#retype-password").val();
			    flag 			 = true;

			if (current_password == "") {
				$("#current-password").addClass('border-red').after('<span class="error">The field is required!</span>');
				flag = false;
			}

			if (new_password == "") {
				$("#new-password").addClass('border-red').after('<span class="error">The field is required!</span>');
				flag = false;
			} else {
				if (new_password.length < 6) {
					$("#new-password").addClass('border-red').after('<span class="error">The password is minimum 6 characters required!</span>');
					flag = false;
				}
			}

			if (retype_password == "") {
				$("#retype-password").addClass('border-red').after('<span class="error">The field is required!</span>');
				flag = false;
			}

			if (new_password != retype_password) {
				$("#retype-password").addClass('border-red').after('<span class="error">The passowrd does not match with new passowrd!</span>');
				flag = false;
			}

			if (flag) {
				$("#change-password").addClass('disabled');
				$("#change-password").html('....');

				var form 	 = $("#form-change-password");
					url  	 = form.attr('action');
					formData = form.serialize();

				$.ajax({
					url: url,
					type: 'POST',
					data: formData,
					success: function(response){
						if (response.status === false) {
	                        if (response.errors) {
	                            if (Object.keys(response.errors).length > 0) {
	                                var input_fields = ['current_password', 'new_password', 'retype_password'];
	                                $.each(response.errors, function (key, value) {
	                                    if (input_fields.indexOf(key) >= 0) {
	                                        $("input[name='" + key + "']").addClass("border-red");
	                                        $("input[name='" + key + "']").after("<span class='error'>" + value.toString().split(/[,]+/) + "</span>");
	                                    }
	                                });
	                            }
	                        }
	                    } else {
	                    	$("input[type='password']").val('');
	                    	toastr.success('Password Updated Successfully!');
	                    }
					},
					error: function(){
						alert('Oops Something went wrong please try again later');
					},
					complete: function(){
						$("#change-password").removeClass('disabled');
						$("#change-password").html('Update');
					},
				});	
			}
		});

		$(document).on("change", ".uploadProfileInput", function () {
		  	var triggerInput  = $(this);
		        currentImg 	  = $(this).closest(".pic-holder").find(".pic").attr("src");
		        holder 		  = $(this).closest(".pic-holder");
		        wrapper       = $(this).closest(".profile-pic-wrapper");

		    $(wrapper).find('[role="alert"]').remove();
		  	triggerInput.blur();
		  	
		  	var files = !!this.files ? this.files : [];
		  	
		  	if (!files.length || !window.FileReader) {
		   		return;
		  	}
		  	if (/^image/.test(files[0].type)) {
		    	// only image file
		    	var reader = new FileReader(); // instance of the FileReader
		    	
		    	reader.readAsDataURL(files[0]); // read the local file

		    	reader.onloadend = function () {
			      	$(holder).addClass("uploadInProgress");
			      	$(holder).find(".pic").attr("src", this.result);
			      	$(holder).append('<div class="upload-loader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');

			      	$('#updateProfileImage').submit();
		    	}
		  	} else {
		    	$(wrapper).append('<div class="alert alert-danger d-inline-block p-2 small" role="alert">Please choose the valid image.</div>');
		    	setTimeout(() => {
		    		$(wrapper).find('role="alert"').remove();
		    	}, 3000);
		  	}
		});

		$('#updateProfileImage').submit(function(e) {
			e.preventDefault();
			
			var formData 	  = new FormData(this);
				url      	  = $(this).attr('action')
			    triggerInput  = $(".uploadProfileInput");
		        currentImg 	  = triggerInput.closest(".pic-holder").find(".pic").attr("src");
		        holder 		  = triggerInput.closest(".pic-holder");
		        wrapper       = triggerInput.closest(".profile-pic-wrapper");

			$.ajax({
				type: 'POST',
				url: url,
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(response){
	      			if (response.status == true) {
	      				if (response.user_id == $("input[name='user_id']").val()) {
	      					var image_path = $('input[name="base_url"]').val() + '/admin/assets/images/user/' + response.user_image;
	      					$('.aside-profile-image').attr("src", image_path);
	      				}
	      				$(wrapper).append('<div class="snackbar show" role="alert"><i class="fa fa-check-circle text-success"></i> Profile image updated successfully</div>');
	      			} else {
	      				$(holder).find(".pic").attr("src", currentImg);
			          	$(wrapper).append('<div class="snackbar show" role="alert"><i class="fa fa-times-circle text-danger"></i> There is an error while uploading! Please try again later.</div>');
	      			}
	      		},
	      		error: function(){
	      			//
	      		},
	      		complete: function() {
	      			$(holder).removeClass("uploadInProgress");
		        	$(holder).find(".upload-loader").remove();
		        	$(triggerInput).val("");
		        	setTimeout(() => {
		            	$(wrapper).find('[role="alert"]').remove();
		          	}, 3000);
	      		}
			});
		});
	});

	function removeErrorMessages()
	{
		$("span.error").remove();
		$("input").removeClass('border-red');
	}

	// Tabs
	const tabBtns = document.querySelectorAll(".tabs__btn");
	const tabPanes = document.getElementsByClassName("tabs__pane");

	let fadeTime = 200;

	function fadeOut(target) {
	  target.style.opacity = 1;
	  target.style.transition = `opacity ${fadeTime}ms`;
	  target.style.opacity = 0;
	  setTimeout(() => {
	    target.style.display = "none";
	  }, fadeTime);
	}

	function fadeIn(target) {
	  target.style.opacity = 0;
	  target.style.transition = `opacity ${fadeTime}ms`;
	  target.style.opacity = 1;
	  setTimeout(() => {
	    target.style.display = "block";
	  }, fadeTime);
	}

	function triggerTab(elt) {
	  elt.preventDefault();

	  tabBtns.forEach(btn => {
	    btn.classList.remove("is-active");
	    btn.setAttribute("aria-selected", false);
	  });

	  [].forEach.call(tabPanes, pane => {
	    fadeOut(pane);
	  });

	  elt.target.classList.add("is-active");
	  elt.target.setAttribute("aria-selected", true);
	  let clickedTab = elt.target.dataset.tabTarget;
	  fadeIn(document.querySelector(`#${clickedTab}`));
	}

	tabBtns.forEach(tab => {
	  tab.addEventListener("click", triggerTab);
	});
</script>
@endsection
