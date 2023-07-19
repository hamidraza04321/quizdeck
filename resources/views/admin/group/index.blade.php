@extends('layout.master')
@section('page-title')
	Manage Groups
@endsection
@section('main-content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Manage Groups</h4>
      <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/user">Groups</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage Groups</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="card">
    <div class="card-body wizard-content">
	    <div role="application" class="wizard clearfix" id="steps-uid-0">
	    	<div class="content clearfix">
		    	<section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current" aria-hidden="false">
    				<label for="group_name">Create Group * </label>
    				<label for="group_name" class="error-txt"></label>
		    		<div class="row">
    					<div class="col-md-11">
    				        <input type="text" placeholder="Group Name" class="form-control" name="group_name" id="group_name">
    					</div>
    					<div class="col-md-1 p-0">
    				        <button class="btn btn-outline-primary createGroup">Create </button>
    					</div>
		    		</div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="groups">Groups *</label>
                            <label for="groups" class="error-txt-group error"></label>
                        </div>
                        <div class="col-md-6">
                            <label for="users">Users *</label>
                            <label for="users" class="error-txt-user error"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <select name="groups" id="groups" style="width: 82%;" class="form-control select2">
                                    <option value="">-- Select Group --</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-outline-danger delete_group"><i class="fa fa-trash"></i> Delete </button>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex">
                            <select name="users" style="width: 73%" id="users" class="form-control select2">
                                <option value="">-- Select User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-primary add_in_group"><i class="fa fa-plus"></i> Add In Group </button>
                        </div>
                    </div>
                    <br>
                    <table class="table table-bordered bg-white">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Username</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody id="group_table">
                        </tbody>
                    </table>

		    	</section>
	    	</div>
	    </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
	$(document).ready(function() {
		
		// Call CSRF Meta
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Select 2
        $(".select2").select2();

        // Create Group
        $(".createGroup").on('click', function(event) {
        	event.preventDefault();
            var self = $(this);
            var group_name = $("#group_name").val();
            if (group_name) {
            	$.post('{{ route('group.store') }}', {group_name: group_name}, function(data) {
            		if (data == 'false') {
            			toastr.error("The Group Name is Already Exists!");
	            		$("#group_name").removeClass('error');
	            		$(".error-txt").empty();
            		}
            		if (data.status == 'true') {
	            		$("#group_name").removeClass('error');
	            		$(".error-txt").empty();
	            		$("#group_name").val('');
                        $("#groups").append('<option value="'+data.group.id+'">'+data.group.name+'</option>')
            			toastr.success("Group Added Successfully!");
            		}
            	});
            }else{
                $("#group_name").removeClass('error');
                $(".error-txt").empty();
            	$("#group_name").addClass('error');
            	$(".error-txt").append('The Group Name Field is Required!');
            }
        });

        // On Chnage Group Dropdown
        $("#groups").on('change', function(event) {
            event.preventDefault();
            var group_id = $(this).val();
            if(group_id){

                $.post('{{ route('get.group.users') }}', {group_id: group_id}, function(data) {

                    // Empty Table
                    $("#group_table").empty();

                    // Show Users In Table
                    $.each(data, function(index, val) {
                        $("#group_table").append('\
                            <tr>\
                                <td>'+val.name+'</td>\
                                <td>'+val.username+'</td>\
                                <td>\
                                    <button class="btn btn-outline-danger remove-from-group" userID="'+val.id+'"><i class="fa fa-trash"></i> Remove From Group</button>\
                                </td>\
                            </tr>\
                        ');
                    });

                });

            }
        });
	    
        // Add In Group
        $(".add_in_group").on('click', function(event) {
            event.preventDefault();

            // Get Ids
            var group_id = $("#groups").val();
            var user_id = $("#users").val();
            
            if (!group_id) {
                $(".error-txt-group").empty();
                $(".error-txt-group").append('Please Select Group!');
            }else{
                $(".error-txt-group").empty();
                $(".error-txt-user").empty();
                if (!user_id) {
                    $(".error-txt-user").empty();
                    $(".error-txt-user").append('Please Select User!');
                }else{
                    $(".error-txt-user").empty();
                    $.post('{{ route('add.user.in.group') }}', {user_id: user_id, group_id: group_id}, function(data) {
                        
                        // Add User In Table
                        $("#group_table").append('\
                            <tr>\
                                <td>'+data.name+'</td>\
                                <td>'+data.username+'</td>\
                                <td>\
                                    <button class="btn btn-outline-danger remove-from-group" userID="'+data.id+'"><i class="fa fa-trash"></i> Remove From Group</button>\
                                </td>\
                            </tr>\
                        ');

                        // Remove User In Dropdown
                        $("#users option:selected").remove();

                        // Toastr
                        toastr.success('User Add In Group Successfully!')

                    });   
                }
            }
        });

        // Delete Group
        $(".delete_group").on('click', function(event) {
            event.preventDefault();
            var group_id = $("#groups").val();

            if (group_id) {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be delete this group!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.post('{{ route('delete.group') }}', {group_id: group_id}, function(data) {
                    
                            // Empty Table
                            $("#group_table").empty();
                            
                            // Take Users in Dropdown
                            $.each(data, function(index, val) {
                                $("#users").append('<option value="'+val.id+'">'+val.name+'</option>')
                            });

                            // Remove Group Name In Dropdown
                            $("#groups option:selected").remove();

                            // Selected First In Dropdown
                            $("#groups").prop("selectedIndex", 0);

                            // toastr
                            toastr.success('Group Deleted Successfully!');
                        });

                    }
                })
            }else{

                // Show Error When Group is Not Selected
                $(".error-txt-group").empty();
                $(".error-txt-group").append('Please Select Group To Delete!');

            }
        });

        // Remove From Group
        $('body').delegate('.remove-from-group', 'click', function(event) {
            event.preventDefault();

            var user_id = $(this).attr('userID');
            var self = $(this);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be remove user form this group!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('{{ route('remove.user.from.group') }}', {user_id: user_id}, function(data) {

                        // Remove tr
                        self.closest('tr').fadeOut().remove();

                        // Show User in Dropdown
                        $("#users").append('<option value="'+data.id+'">'+data.name+'</option>');

                        // Toastr
                        toastr.success('User Remove From Group Successfully!');
                    });
                }
            })

        });


    });
</script>
@endsection