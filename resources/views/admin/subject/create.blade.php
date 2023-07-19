@extends('layout.master')
@section('page-title')
  Create Subject
@endsection
@section('main-content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Create Subject</h4>
      <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/subject">Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Subject</li>
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
      <form action="{{ route('subject.store') }}" enctype="multipart/form-data" method="post">
      	@csrf
        <div role="application" class="wizard clearfix" id="steps-uid-0">
        <div class="content clearfix">
          <section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current" aria-hidden="false">
            
            <label for="name">Subject Name *</label>
            @error('name')
            	<label class="error" for="name">{{ $message }}</label>
            @enderror
            <input id="name" name="name" type="text" class="required form-control @error('name') error @enderror" value="{{ old('name') }}">
			
    			<div class="form-group">
	          <label for="image">Subject Image *</label>
	          @error('image')
            	<label class="error" for="image">{{ $message }}</label>
              @enderror
	          <div class="input-group">
	            <input type="file" name="image" accept="image/*" onchange="readURL(this)" class="form-control @error('image') error @enderror">
	          </div>
	        </div>

	        <div class="form-group">
	        	<img src="" id="img">
	        </div>

          </section>
        </div>
        <div class="actions clearfix">
          <button type="button" onclick="window.location.href='/admin/subject'" class="btn btn-secondary">Cancel</button>
          <button type="submit" class="btn btn-outline-primary">Create</button>
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