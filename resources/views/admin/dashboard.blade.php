@extends('layout.master')
@section('page-title')
  Dashboard
@endsection
@section('main-content')
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
	  <div class="row">
	    <div class="col-12 d-flex no-block align-items-center">
	      <h4 class="page-title">Dashboard</h4>
	      <div class="ms-auto text-end">
	        <nav aria-label="breadcrumb">
	          <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="#">Home</a></li>
	            <li class="breadcrumb-item active" aria-current="page">
	              Dashboard
	            </li>
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
	  <!-- Sales Cards  -->
	  <!-- ============================================================== -->
	  <div class="row">
  		<div class="col-md-4">
  			<div class="icon-box box">
  				<div class="icon-wrap">
  					<svg class="widget-icon" style="width: 85px;margin-left: 12px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M219.3 .5c3.1-.6 6.3-.6 9.4 0l200 40C439.9 42.7 448 52.6 448 64s-8.1 21.3-19.3 23.5L352 102.9V160c0 70.7-57.3 128-128 128s-128-57.3-128-128V102.9L48 93.3v65.1l15.7 78.4c.9 4.7-.3 9.6-3.3 13.3s-7.6 5.9-12.4 5.9H16c-4.8 0-9.3-2.1-12.4-5.9s-4.3-8.6-3.3-13.3L16 158.4V86.6C6.5 83.3 0 74.3 0 64C0 52.6 8.1 42.7 19.3 40.5l200-40zM129.1 323.2l83.2 88.4c6.3 6.7 17 6.7 23.3 0l83.2-88.4c73.7 14.9 129.1 80 129.1 158.1c0 17-13.8 30.7-30.7 30.7H30.7C13.8 512 0 498.2 0 481.3c0-78.1 55.5-143.2 129.1-158.1z"/></svg>
  				</div>
  				<div class="icon-details">
					<h2 style="padding: 0px 10px 0px 10px; font-size: 22px;">Users</h2>
					<p style="padding-left: 10px;font-size: 20px;">{{ $users_count }}</p>
  				</div>
  			</div>
  		</div>
  		<div class="col-md-4">
  			<div class="icon-box box">
  				<div class="icon-wrap">
  					<svg class="widget-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 160c-44.2 0-80-35.8-80-80S99.8 0 144 0s80 35.8 80 80s-35.8 80-80 80zm368 0c-44.2 0-80-35.8-80-80s35.8-80 80-80s80 35.8 80 80s-35.8 80-80 80zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM416 224c0 53-43 96-96 96s-96-43-96-96s43-96 96-96s96 43 96 96zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
  				</div>
  				<div class="icon-details">
					<h2 style="padding: 0px 10px 0px 10px; font-size: 22px;">Groups</h2>
					<p style="padding-left: 10px;font-size: 20px;">{{ $groups_count }}</p>
  				</div>
  			</div>
  		</div>
  		<div class="col-md-4">
  			<div class="icon-box box">
  				<div class="icon-wrap">
  					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="widget-icon"><path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/></svg>
  				</div>
  				<div class="icon-details">
					<h2 style="padding: 0px 10px 0px 10px; font-size: 22px;">Papers</h2>
					<p style="padding-left: 10px;font-size: 20px;">{{ $papers_count }}</p>
  				</div>
  			</div>
  		</div>
	  </div>
	</div>
@endsection
@section('scripts')
@if(Session::has('message'))
<script>
	const Toast = Swal.mixin({
	  toast: true,
	  position: 'top-end',
	  showConfirmButton: false,
	  timer: 3000,
	  timerProgressBar: true,
	  didOpen: (toast) => {
	    toast.addEventListener('mouseenter', Swal.stopTimer)
	    toast.addEventListener('mouseleave', Swal.resumeTimer)
	  }
	})

	Toast.fire({
	  icon: 'success',
	  title: 'Signed in successfully'
	})    	
</script>
@endif
@endsection