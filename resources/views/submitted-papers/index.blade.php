@extends('layout.master')
@section('page-title', 'Submitted Papers')
@section('main-content')
<div class="card">
    <div class="card-body">
    <div style="display: inline-flex; width: 100%;">
      <h5 class="card-title">Manage Papers</h5>
    </div>
      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Paper Name</th>
              <th>Submission Date</th>
              <th>Number Of Questions</th>
              <th>Taken Time</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($papers as $paper)
              <tr>
                <td>{{ $paper->paper->name }}</td>
                <td>{{ date_format($paper->updated_at, 'd / M / Y') }}</td>
                <td>{{ $paper->paper->number_of_questions }}</td>
                <td>{{ gmdate("H:i:s", $paper->time) }}</td>
                <td>
                  <a href="/submitted-papers/review-result/{{ $paper->id }}" class="btn btn-success text-white review-result"><i class="fa fa-eye"></i> Review Result</a>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Paper Name</th>
              <th>Submission Date</th>
              <th>Number Of Questions</th>
              <th>Taken Time</th>
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
</script>
@endsection