@extends('layout.master')
@section('page-title')
  Manage Subjects
@endsection
@section('main-content')
<div class="card">
    <div class="card-body">
    <div style="display: inline-flex; width: 100%;">
      <h5 class="card-title">Manage Subjects</h5>
      <a href="/admin/subject/create" style="margin-left: 75.5%; margin-bottom: 15px;" class="btn btn-outline-primary"><i class="fas fa-book"></i> <i class="fas fa-plus"></i> Add Subject</a>
    </div>
      <div class="table-responsive">
        <table
          id="zero_config"
          class="table table-striped table-bordered"
        >
          <thead>
            <tr>
              <th width="25%">Subject Name</th>
              <th width="50%">Image</th>
              <th width="25%">Action</th>
            </tr>
          </thead>
          <tbody>
          	@foreach($subjects as $subject)
	            <tr>
	              <td>{{ $subject->name }}</td>
	              <td>
                  <img src="/images/{{ $subject->image }}" width="200" height="200" class="img-thumbnail" alt="{{ $subject->name }}">
                </td>
	              <td>
                   <button type="button" subjectID="{{ $subject->id }}" class="btn btn-outline-danger delete"><i class="fas fa-trash-alt"></i> Delete</button>
                   <a href="/admin/subject/{{ $subject->id }}/edit" class="btn btn-outline-primary"><i class="far fa-edit"></i> Edit</a>
                </td>
	            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Subject Name</th>
              <th>Image</th>
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
    toastr.options =
    {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
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
            var subjectID = self.attr('subjectID');

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
                $.post('{{ route('subject.delete') }}', {subjectID: subjectID}, function(data) {
                    self.closest('tr').fadeOut().remove();
                    Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                });
              }
            })    
        });
    });
</script>
@endsection