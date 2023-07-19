@extends('layout.master')
@section('page-title')
  Manage Papers
@endsection
@section('main-content')
<div class="card">
    <div class="card-body">
    <div style="display: inline-flex; width: 100%;">
      <h5 class="card-title">Manage Papers</h5>
      <a href="/admin/paper/create" style="margin-left: 75.5%; margin-bottom: 15px;" class="btn btn-outline-primary"><i class="fas fa-newspaper"></i> <i class="fas fa-plus"></i> Make a Paper</a>
    </div>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Subject</th>
              <th>Paper Name</th>
              <th>Number Of Questions</th>
              <th>Creation Date</th>
              <th>Review Paper</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          	@foreach($papers as $paper)
	            <tr>
	              <td>{{ $paper->subject->name }}</td>
	              <td>{{ $paper->name }}</td>
	              <td>{{ $paper->number_of_questions }}</td>
	              <td>{{ date_format($paper->created_at, 'd / M / Y') }}</td>
                <td>
                   <a class="btn btn-outline-success" href="/admin/paper/review/{{ $paper->id }}"><i class="fas fa-eye"></i> Review Paper</a>
	              </td>
                <td>
                   <button type="button" paperID="{{ $paper->id }}" class="btn btn-outline-danger delete"><i class="fas fa-trash-alt"></i> Delete</button>
                   {{-- <a href="/admin/user/{{ $paper->id }}/edit" class="btn btn-outline-primary"><i class="far fa-edit"></i> Edit</a> --}}
                </td>
	            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Subject</th>
              <th>Paper Name</th>
              <th>Number Of Questions</th>
              <th>Creation Date</th>
              <th>Review Paper</th>
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

  // AJAX SCRIPTS
  $(document).ready(function() {

    // Call CSRF Meta
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // On Click Delete Paper
    $(".delete").on('click', function(event) {
      event.preventDefault();
      var self = $(this);
      var paper_id = self.attr('paperID');
      var base_url = '{{ url('/admin/paper/destroy') }}';
      var url = base_url+'?paper_id='+paper_id;

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
          $.get(url, function(data) {
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