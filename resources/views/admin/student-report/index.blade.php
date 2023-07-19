@extends('layout.master')
@section('page-title', 'Students Report')  
@section('main-content')
<style>
	#last-ten-result-score{
		width: 100%;
		overflow-y: scroll;
	}
</style>
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Students Report</h4>
      <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/students-report">Students Report</a></li>
            <li class="breadcrumb-item active" aria-current="page">Report</li>
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
		        	<div class="form-group">
		              	<label for="student_id">Select Student For Report</label>
		            	<select name="student_id" required class="form-control select2" id="student_id">
		        			<option selected> -- Select Student -- </option>
		            		@foreach($users as $user)
		            			<option value="{{ $user->id }}">{{ $user->name }}</option>
		            		@endforeach
		        		</select>
		            </div>
		            <div id="last-ten-result-score"></div>
		        </section>
	     	</div>
	     </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
	$(".select2").select2();
	
	$(document).ready(function() {
		// Call CSRF Meta
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
		
		$("#student_id").change(function(event) {
			event.preventDefault();
			var user_id = $(this).val();
			if (user_id) {
				$.post('{{ route('student-report.get-report') }}', {user_id: user_id}, function(data) {
					Highcharts.chart('last-ten-result-score', {
				        chart: {
				        	type: 'column'
				        },
				        title: {
				            text: ['Last 10 records By score']
				        },
				        lang: {
				            noData: 'No data is available in the chart'
				        },
				        xAxis: {
				          	categories: data.number_of_questions,
				          	crosshair: true
				        },
				        yAxis: {
				          	min: 0,
				          	title: {
				            	text: ''
				          	}
				        },
				        tooltip: {
							headerFormat: '<span style="font-size:10px">Number Of Questions: {point.key}<table>',
							pointFormat: '<tr><td style="padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y}</b></td></tr>',
							footerFormat: '</table>',
							shared: true,
							useHTML: true
				        },
				        exporting: {
				        	sourceWidth: 1443,
				        	scale:1
				        },
				        plotOptions: {
				            column: {
				                pointPadding: 0.2,
				                borderWidth: 0
				            },
				            series: {
				                dataLabels: {
				                    enabled: true
				                }
				            }
				        },
				        series: [{
						    name: 'Number Of Correct',
						    data: data.number_of_correct
						}, {
						    name: 'Taking Time In Seconds',
						    data: data.time,
						    color: 'yellow'
						}]
				    });
				});
			}
		});
	});
</script>
@endsection