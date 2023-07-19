@extends('layout.master')
@section('page-title')
	Manage Users
@endsection
@section('main-content')
<div class="card">
    <div class="card-body">
    <div style="display: inline-flex; width: 100%;">
      <h5 class="card-title">Manage Users</h5>
      <a href="/admin/user/create" style="margin-left: 79%; margin-bottom: 15px;" class="btn btn-outline-primary"><i class="fas fa-user-plus"></i> Add User</a>
    </div>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Full Name</th>
              <th>Username</th>
              <th>Email</th>
              <th>Status</th>
              <th>Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          	@foreach($users as $user)
	            <tr>
	              <td>{{ $user->name }}</td>
	              <td>{{ $user->username }}</td>
	              <td>{{ $user->email ?? '-' }}</td>
	              <td>
                  @if($user->status == 'ACTIVE')
                      <button type="button" userID="{{ $user->id }}" class="btn btn-success text-white status">Active</button>
                  @else
                      <button type="button" userID="{{ $user->id }}" class="btn btn-danger text-white status">Deactive</button>
                  @endif
                </td>
                <td>
                  @if($user->user_image == null)
                    <img src="{{ asset('/admin/assets/images/no_image_found.png') }}" width="100" height="100">
                  @else
                    <img src="{{ url('/admin/assets/images/user') . '/' . $user->user_image }}" width="100" height="100">
                  @endif
                </td>
	              <td>
                   <a href="/user/profile/{{ $user->id }}" class="btn btn-outline-info"><i class="fas fa-eye"></i></a>
                   <button type="button" userID="{{ $user->id }}" class="btn btn-outline-danger delete"><i class="fas fa-trash-alt"></i></button>
                   <a href="/admin/user/{{ $user->id }}/edit" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
                </td>
	            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Full Name</th>
              <th>Username</th>
              <th>Email</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script>
  /****************************************
   *       Basic Table                   *
   ****************************************/
  $("#zero_config").DataTable();
  
  @if(Session::has('message'))
    toastr.success("{{ session()->get('message') }}");
  @endif
</script>

{{-- JQUERY SCRUPTS --}}
<script>
    $(document).ready(function() {
        
        // Call CSRF Meta
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Delete
        $(".delete").on('click', function(event) {
            event.preventDefault();
            var self = $(this);
            var userID = self.attr('userID');

            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                $.post('{{ route('user.delete') }}', {userID: userID}, function(data) {
                    self.closest('tr').fadeOut().remove();
                    Swal.fire(
                      'Deleted!',
                      'User has been deleted.',
                      'success'
                    )
                });
              }
            })    
        });

        // STAUTS
        $('.status').on('click', function(event) {
            event.preventDefault();
            var self = $(this);
            var userID = self.attr('userID');

            $.post('{{ route('user.change.status') }}', {userID: userID}, function(data) {
                
                if (data == 'ACTIVE') 
                    self.removeClass('btn-danger').addClass('btn-success').empty().html('Active');
                
                if (data == 'DEACTIVE')
                    self.removeClass('btn-success').addClass('btn-danger').empty().html('Deactive');
            });
        });
    });
</script>
@endsection