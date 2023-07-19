@extends('layout.master')
@section('page-title')
	Manage Assign Papers
@endsection
@section('main-content')
<div class="card">
    <div class="card-body">
    <div style="display: inline-flex; width: 100%;">
      <h5 class="card-title">Assign Papers</h5>
      <a href="/admin/assign-paper/create" style="margin-left: 74%; margin-bottom: 15px;" class="btn btn-outline-primary"><i class="fas fa-plus"></i> Assign New Paper</a>
    </div>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <thead>
            <tr>
                <th>Paper Name</th>
                <th>Assign For</th>
                <th>Assign Date</th>
                <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($assign_papers as $paper)
            	<tr>
                    <td>{{ $paper->name }}</td> 
                    <td>
                        @if($paper->assign_for == 'A')
                            <button class="btn btn-sm btn-primary"><i class="fas fa-list"></i> All</button>
                        @elseif($paper->assign_for == 'G')
                            <button class="btn btn-sm btn-primary"><i class="fas fa-users"></i> Group</button>
                        @else
                            <button class="btn btn-sm btn-primary"><i class="fas fa-user"></i> Student</button>
                        @endif
                    </td> 
                    <td>{{ date_format($paper->created_at, 'd / M / Y') }}</td> 
                    <td>
                        <a href="/admin/assign-paper/view-paper/{{ $paper->id }}" class="btn btn-primary" title="View Paper"><i class="fa fa-search"></i> View Paper</a>
                        <a href="/admin/assign-paper/reivew-student-results/{{ $paper->id }}" class="btn btn-warning" title="Review Student Results"><i class="fa fa-eye"></i> Review Student Results</a>
                        <button class="btn btn-danger delete" paperID="{{ $paper->id }}" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                    </td>
                </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Paper Name</th>
              <th>Assign For</th>
              <th>Assign Date</th>
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
    *             Data Table                *
    ****************************************/
    $("#zero_config").DataTable();

    @if(Session::has('message'))
        toastr.success("{{ session()->get('message') }}");
    @endif

    // JQUERY
    $(document).ready(function() {
      
        // Call CSRF Meta
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".delete").on('click', function(event) {
            event.preventDefault();
            var self = $(this);
            var paperID = self.attr('paperID');

            // Sweet Alert
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to delete this Paper!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('{{ route('assign-paper.destroy') }}', {paper_id: paperID}, function(data) {
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