@extends('layout.master')
@section('page-title', 'Settings')
@section('main-content')
<style>
	.funkyradio div {
	  clear: both;
	  width: 23%;
	  overflow: hidden;
	  margin-right: 15px;
	}

	.funkyradio label {
	  width: 100%;
	  border-radius: 3px;
	  border: 1px solid #D1D3D4;
	  font-weight: normal;
	}

	.funkyradio input[type="radio"]:empty {
	  display: none;
	}

	.funkyradio input[type="radio"]:empty ~ label {
	  position: relative;
	  line-height: 2.5em;
	  text-indent: 3.25em;
	  cursor: pointer;
	  -webkit-user-select: none;
	     -moz-user-select: none;
	      -ms-user-select: none;
	          user-select: none;
	}

	.funkyradio input[type="radio"]:empty ~ label:before {
	  position: absolute;
	  display: block;
	  top: 0;
	  bottom: 0;
	  left: 0;
	  content: '';
	  width: 2.5em;
	  background: #D1D3D4;
	  border-radius: 3px 0 0 3px;
	}

	.funkyradio input[type="radio"]:hover:not(:checked) ~ label {
	  color: #888;
	}

	.funkyradio input[type="radio"]:hover:not(:checked) ~ label:before {
	  content: '\2714';
	  text-indent: .9em;
	  color: #C2C2C2;
	}

	.funkyradio input[type="radio"]:checked ~ label {
	  color: #777;
	}

	.funkyradio input[type="radio"]:checked ~ label:before {
	  content: '\2714';
	  text-indent: .9em;
	  color: #333;
	  background-color: #ccc;
	}

	.funkyradio input[type="radio"]:focus ~ label:before {
	  box-shadow: 0 0 0 3px #999;
	}

	.funkyradio-info input[type="radio"]:checked ~ label:before {
	  color: #fff;
	  background-color: #5bc0de;
	}
	#preview {
		margin-top: 20px;
		border: 2px solid #ddd;
	}

	.uploadcare--jcrop-holder>div>div, #preview {
	  	border-radius: 50%;
	}
</style>
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Settings</h4>
      <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="card">
    <div class="card-body wizard-content">
      <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
      	@csrf
        <div role="application" class="wizard clearfix" id="steps-uid-0">
	        <div class="content clearfix">
	          <section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current" aria-hidden="false">
	            <label for="app-name">App Name *</label>
	            @error('app_name')
	            	<label class="error" for="name">{{ $message }}</label>
	            @enderror
	            <input id="app-name" name="app_name" type="text" class="required form-control @error('app_name') error @enderror" value="{{ \App\Settings::find(1)->app_name }}">
	            <br>
	            <label for="app-name">App Logo *</label>&nbsp;&nbsp;&nbsp;&nbsp;
	            @error('logo')
	            	<label class="error" for="name">{{ $message }}</label>
	            @enderror
	            <input name="logo" type="hidden" role="uploadcare-uploader" value="{{ \App\Settings::find(1)->logo }}" data-crop="1:1" data-images-only>
				<div>
					<img src="{{ \App\Settings::find(1)->logo }}" alt="" id="preview" width=100 height=100 />
				</div>
	            <br>
	            <label>User Registration</label>&nbsp;&nbsp;&nbsp;&nbsp;
	            @error('user_registration')
	            	<label class="error" for="name">{{ $message }}</label>
	            @enderror
	            <div class="funkyradio d-flex">
		            <div class="funkyradio-info">
		                <input type="radio" value="1" class="radio_button" name="user_registration" id="radio1" {{ (\App\Settings::find(1)->user_registration == 1) ? 'checked' : '' }} />
		                <label for="radio1">On</label>
		            </div>
		            <div class="funkyradio-info">
		                <input type="radio" value="0" class="radio_button" name="user_registration" id="radio2" {{ (\App\Settings::find(1)->user_registration == 0) ? 'checked' : '' }} />
		                <label for="radio2">Off</label>
		            </div>
		        </div>
	            <br>
	        	<button type="submit" class="btn btn-outline-primary">Save Changes</button>
	          </section>
	        </div>
    	</div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.lang.en.min.js"></script>
<script>
	@if(Session::has('message'))
		toastr.success("{{ session()->get('message') }}");
	@endif
	UPLOADCARE_PUBLIC_KEY = "70a9af7268b6fa7df955";
	const widget = uploadcare.Widget('[role=uploadcare-uploader]');
	const preview = document.getElementById('preview');
	widget.onUploadComplete(fileInfo => {
		preview.src = fileInfo.cdnUrl;
	});
</script>
@endsection