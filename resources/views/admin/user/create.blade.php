@extends('layout.master')
@section('page-title', 'Create User')
@section('main-content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Create User</h4>
      <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/user">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create User</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="card">
    <div class="card-body wizard-content">
      <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
      	@csrf
        <div role="application" class="wizard clearfix" id="steps-uid-0">
        <div class="content clearfix">
          <section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current" aria-hidden="false">
            
            <label for="name">Full Name *</label>
            @error('name')
            	<label class="error" for="name">{{ $message }}</label>
            @enderror
            <input id="name" name="name" type="text" class="required form-control @error('name') error @enderror" value="{{ old('name') }}">

            <label for="username">User name *</label>
            @error('username')
            	<label class="error" for="name">{{ $message }}</label>
            @enderror
            <input id="username" name="username" type="text" class="required form-control @error('username') error @enderror" value="{{ old('username') }}">

            <label for="email">Email *</label>
            @error('email')
            	<label class="error" for="email">{{ $message }}</label>
            @enderror
            <input id="email" name="email" type="text" class="required form-control @error('email') error @enderror" value="{{ old('email') }}">
            
            <label for="password">Password *</label>
            @error('password')
            	<label class="error" for="password">{{ $message }}</label>
            @enderror
            <input id="password" name="password" type="password" class="required form-control @error('password') error @enderror">
            
            <label for="password_confirm">Confirm Password *</label>
            @error('password_confirm')
            	<label class="error" for="password_confirm">{{ $message }}</label>
            @enderror
            <input id="password_confirm" name="password_confirm" type="password" class="required form-control @error('password_confirm') error @enderror">
            
            <label for="email">Designation (optional)</label>
            <input id="designation" name="designation" type="text" class="form-control" value="{{ old('designation') }}">

            <label for="email">Phone No (optional)</label>
            <input id="phone_no" name="phone_no" type="text" class="form-control" value="{{ old('phone_no') }}">

            <label for="email">Address (optional)</label>
            <textarea name="address" id="address" class="form-control"></textarea>

            <div class="form-group">
              <label for="image">User Image *</label>
              @error('user_image')
                <label class="error" for="image">{{ $message }}</label>
              @enderror
              <div class="input-group">
                <input type="file" name="user_image" accept="image/*" onchange="readURL(this)" class="form-control @error('user_image') error @enderror">
              </div>
            </div>

            <div class="form-group">
              <img src="" id="img">
            </div>

          </section>
        </div>
        <div class="actions clearfix">
          <button type="button" onclick="window.location.href='/admin/user'" class="btn btn-secondary">Cancel</button>
        	<button type="submit" class="btn btn-outline-primary">Create</button>
        </div></div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
  function readURL(input) {
    if (input.files && input.files[0]) {
    
      var reader = new FileReader();
      reader.onload = function (e) { 
        document.querySelector("#img").setAttribute("src",e.target.result);
      };

      reader.readAsDataURL(input.files[0]); 
    }
  }
</script>
@endsection