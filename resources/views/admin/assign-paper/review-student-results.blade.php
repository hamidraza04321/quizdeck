@extends('layout.master')
@section('page-title', 'Review Student Results')
@section('main-content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Review Student Results</h4>
      <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/assign-paper">Assign Paper</a></li>
            <li class="breadcrumb-item active" aria-current="page">Review Student Results</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<style>
	.double-border{
		border: double 4px #e9ecef;
	}
	.br-12{
		border-radius: 12px;
	}
	.br-20 {
		border-radius: 20px;
	}
	.icon {
		width: 35px;
	    height: 35px;
	    border-radius: 100%;
	    margin-top: 8px;
	}
	.correct-icon {
		background-color: #5bb75b;
	}
	.incorrect-icon {
		background-color: #da4f49;
	}
	.unanswered-icon{
		background-color: #faa732;
	}
	.icon-wrap {
		color: #fff;
	    font-size: 20px;
	    padding: 9px 0px 0px 8px;
	}
	.mdi-close:before, .mdi-exclamation:before{
		margin-top: 3px;
		font-weight: bold;
	}
	.text {
		font-size: 18px;
	    font-weight: 600;
	    margin-top: 12px;
	    margin-left: 15px;
	}
	.check {
		position: absolute;
	    margin-top: -5px;
	}
	.heading {
		font-weight: 600;
	    margin-bottom: 0px;
	    margin-left: 10px;
	    margin-top: 20px;
	}
	.un-answered-text{
		font-size: 17px;
	    margin: 10px 0px 0px 20px;
	}
</style>
<div class="container-fluid">
  	<div class="card">
	    <div class="card-body wizard-content">
	        <div role="application" class="wizard clearfix" id="steps-uid-0">		        
		        <div class="content clearfix">
		        	<section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current" aria-hidden="false">
		        		<input type="hidden" value="{{ count($student_results) }}" id="number_of_results">
		        		<input type="hidden" value="{{ $paper->number_of_questions }}" id="number_of_questions">
		        		@foreach($student_results as $key => $result)
			        		<div class="row" style="height: 350px;">
			        			<div class="col-md-3">
			        				<b>Student Name : </b> {{ $result->user->name }}<br>
			        				<b>Status : </b> {{ $result->status }}<br>
		        					<b>Number Of Correct : </b>
		        					<span id="correct{{ $key }}">{{ ($result->status == 'Submitted') ? $result->correct : '--' }}</span><br>
			        				<b>Number Of Incorrect : </b>
			        				<span id="incorrect{{ $key }}">{{ ($result->status == 'Submitted') ? $result->incorrect : '--' }}</span><br>
			        				<b>Un Answered :</b>
			        				<span id="un_answered{{ $key }}">{{ ($result->status == 'Submitted') ? $result->un_answered : '--' }}</span><br>
			        				<b>Time Taken : </b> {{ gmdate("H:i:s", $result->time) }}
			        			</div>
			        			<div class="col-md-5" id="chart{{ $key }}">
			        			</div>
			        			<div class="col-md-4">
			        				@if($result->status == 'Submitted')
			        					<a href="{{ route('assign-paper.view-result', $result->id) }}" class="btn btn-primary view-result" title="View Result"><i class="fa fa-eye"></i> View Result</a>
			        				@endif
			        				<a class="btn btn-danger delete" paperID="{{ $result->id }}" title="Delete"><i class="fa fa-trash"></i> Delete</a>
			        			</div>
			        		</div>
			        		@if($loop->last) @else <hr> @endif
		        		@endforeach
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
		/****************************************
	   	*         CALL AJAX CSRF META           *
	   	****************************************/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /****************************************
	   	*             Highcharts                *
	   	****************************************/
		var results = $("#number_of_results").val();
		var number_of_questions = $("#number_of_questions").val();
		for (var i = 0; i < results; i++) {
			var correct = $("#correct"+i).text();
			var incorrect = $("#incorrect"+i).text();
			var un_answered = $("#un_answered"+i).text();
			
			if (un_answered == '--') {
				Highcharts.chart('chart'+i, {
		            chart: { type: 'pie', backgroundColor: '#eee' },
		            title: { text: null },
		            tooltip: { pointFormat: '{this.series.data} {point.y} <br> Percentage: {point.percentage:.1f}%' },
		            plotOptions: {
		            	pie: {
							colors: ['#DDDF00'],
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: { enabled: false },
							showInLegend: true
		             	}
		            },
		            credits: { enabled: false },
		            options:{ chart:'line' },
		            series: [{
		                name: 'Score',
		                data: [{
		                    name: 'Un Answered',
		                    y: parseInt(number_of_questions)
		                }]
		            }]
		        });
			} else {
				Highcharts.chart('chart'+i, {
		            chart: { type: 'pie', backgroundColor: '#eee' },
		            title: { text: null },
		            tooltip: { pointFormat: '{this.series.data} {point.y} <br> Percentage: {point.percentage:.1f}%' },
		            plotOptions: {
		            	pie: {
							colors: ['#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: { enabled: false },
							showInLegend: true
		             	}
		            },
		            credits: { enabled: false },
		            options:{ chart:'line' },
		            series: [{
		                name: 'Score',
		                data: [{
		                    name: 'Correct',
		                    y: parseInt(correct)
		                }, {
		                    name: 'In Correct',
		                    y: parseInt(incorrect)
		                }, {
		                    name: 'Un Answered',
		                    y: parseInt(un_answered)
		                }]
		            }]
		        });
			}
		}

		/****************************************
	   	*             Delete Test               *
	   	****************************************/
		$(".delete").on('click', function(event) {
			event.preventDefault();
			var self = $(this);
			var paper_id = self.attr('paperID');
			
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to delete this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                $.post('{{ route('delete.student.result') }}', {paper_id: paper_id}, function(data) {
                    self.closest('.row').fadeOut().remove();
                    Swal.fire(
                      'Deleted!',
                      'Test has been deleted successfully!.',
                      'success'
                    )
                });
              }
            })
		});

		/****************************************
	   	*           View Test Modal             *
	   	****************************************/

	   	$(".view-paper").on('click', function(event) {
	   		event.preventDefault();
	   		var username = $(this).attr("username");
	   		$("#username").empty().text(username);
	   	});
	});
</script>
@endsection