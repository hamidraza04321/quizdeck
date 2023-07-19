@extends('layout.master')
@section('page-title')
  In Progress Papers
@endsection
@section('main-content')
<div class="card">
    <div class="card-body">
    <div style="display: inline-flex; width: 100%;">
      <h5 class="card-title">Manage Papers</h5>
    </div>
      <div class="table-responsive">
        <table
          id="zero_config"
          class="table table-striped table-bordered"
        >
          <thead>
            <tr>
              <th>Paper Name</th>
              <th>Assign Date</th>
              <th>Number Of Questions</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          	@foreach($assign_papers as $assign_paper)
	          	<tr>
	          		<td>{{ $assign_paper->paper->name }}</td>
	          		<td>{{ date_format($assign_paper->created_at, 'd / M / Y') }}</td>
	          		<td>{{ $assign_paper->paper->number_of_questions }}</td>
	          		<td>{{ $assign_paper->status }}</td>
	          		<td>
                        <button class="btn btn-success text-white attempt-paper" paperID="{{ $assign_paper->id }}"><i class="fa fa-flag"></i> Attempt Paper</button>
                        @if($assign_paper->status == 'In Progress')
	          			    <button class="btn btn-warning text-white submit-paper" paperID="{{ $assign_paper->id }}" time="{{ $assign_paper->time }}"><i class="fa fa-book"></i> Submit Paper</button>
	          		    @endif
                    </td>
	          	</tr>
          	@endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Paper Name</th>
              <th>Assign Date</th>
              <th>Number Of Questions</th>
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
  	$("#zero_config").DataTable();
    @if(Session::has('message'))
      toastr.error("{{ session()->get('message') }}");
    @endif

  	$(document).ready(function() {

        // Call CSRF Meta
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
  		
  		// On Click Attempt Paper
  		$(".attempt-paper").on('click', function(event) {
  			event.preventDefault();
            var paperID = $(this).attr('paperID');

            Swal.fire({
				title: 'Are you sure?',
				text: "You won't start this paper ? Do you wish to continue ?",
				icon: 'info',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, start it!'
            }).then((result) => {
             	if (result.isConfirmed) {
              	    $.post('{{ route('attempt.paper.change.status') }}', {paperID: paperID}, function(data) {
                        window.location.href = '{{ url('/in-progress-papers/attempt-paper') }}/'+paperID;
                    });
              	}
            })
  		});

        // On Click Submit Paper
        $(".submit-paper").on('click', function(event) {
            event.preventDefault();
            var self = $(this);
            var assign_paper_id = self.attr('paperID');
            var time = self.attr('time');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't submit this paper ? Do you wish to continue ?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('{{ route('attempt.paper.submit.paper') }}', {assign_paper_id: assign_paper_id, time: time}, function(data) {
                        self.closest('tr').fadeOut().remove();
                        Swal.fire(
                          'Submitted!',
                          'Your Paper has been submitted.',
                          'success'
                        )
                    });
                }
            })
        });

  	});

</script>
@endsection