@extends('layout.master')
@section('page-title', 'Edit User')
@section('main-content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Edit User</h4>
      <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/user">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
  <!-- ============================================================== -->
  <!-- Start Page Content -->
  <!-- ============================================================== -->
  <div class="card">
    <div class="card-body wizard-content">
      <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
      	@csrf
        @method('PUT')
        <div role="application" class="wizard clearfix" id="steps-uid-0">
        <div class="content clearfix">
          <section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current" aria-hidden="false">
            
            <label for="name">Full Name *</label>
            @error('name')
            	<label class="error" for="name">{{ $message }}</label>
            @enderror
            <input id="name" name="name" type="text" class="required form-control @error('name') error @enderror" value="{{ $user->name }}">

            <label for="username">User name *</label>
            @error('username')
            	<label class="error" for="name">{{ $message }}</label>
            @enderror
            <input id="username" name="username" type="text" class="required form-control @error('username') error @enderror" value="{{ $user->username }}">

            <label for="email">Email *</label>
            @error('email')
            	<label class="error" for="email">{{ $message }}</label>
            @enderror
            <input id="email" name="email" type="text" class="required form-control @error('email') error @enderror" value="{{ $user->email }}">
            
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
            <input id="designation" name="designation" type="text" class="form-control" value="{{ $user->designation }}">

            <label for="email">Phone No (optional)</label>
            <input id="phone_no" name="phone_no" type="text" class="form-control" value="{{ $user->phone_no }}">

            <label for="email">Address (optional)</label>
            <textarea name="address" id="address" class="form-control">{{ $user->address }}</textarea>

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
              <img src="{{ asset('/admin/assets/images/user') . '/' . $user->user_image  }}" id="img">
            </div>

          </section>
        </div>
        <div class="actions clearfix">
        	<button type="button" onclick="window.location.href='/admin/user'" class="btn btn-secondary">Cancel</button>
        	<button type="submit" class="btn btn-outline-primary">Update</button>
        </div></div>
      </form>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- End PAge Content -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- Right sidebar -->
  <!-- ============================================================== -->
  <!-- .right-sidebar -->
  <!-- ============================================================== -->
  <!-- End Right sidebar -->
  <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
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