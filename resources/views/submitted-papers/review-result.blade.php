@extends('layout.master')
@section('page-title', 'Review Result')
@section('main-content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Review Result</h4>
      <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/paper">Paper</a></li>
            <li class="breadcrumb-item active" aria-current="page">Review Result</li>
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

	.exp-btn-row{
		position: absolute;
	    margin-top: -47px;
	    width: 135px;
	    float: right;
	    margin-right: 25px;
	    right: 0;
	}
	.exp-btn-body{
		background: white;
	    padding: 7px 7px 11px 0px;
	    border-top-left-radius: 20px;
	}
	.exp-btn{
		margin-left: 8px;
    	border-top-left-radius: 15px;
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
	.icon-wrapper {
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
	svg > g > g.google-visualization-tooltip { 
		pointer-events: none 
	}
</style>
<div class="container-fluid">
  	<div class="card">
	    <div class="card-body wizard-content">
	        <div role="application" class="wizard clearfix" id="steps-uid-0">		        
		        <div class="content clearfix">
		        	<section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current" aria-hidden="false">
		        		<div class="row bg-white br-20 p-10 w-100" style="margin: auto;">
		        			<div class="col-md-6 mt-3">
		        				<h4 style="margin-bottom: 15px;">Congratulations you have scored {{ $result->correct }} out of {{ $result->assignPaper->number_of_questions }}</h4>
		        				<div class="details-wrap d-flex">
		        					<div class="icon correct-icon"><i class="fas fa-check icon-wrapper"></i></div>
		        					<span class="text" id="correct" correct="{{ $result->correct }}">Correct : {{ $result->correct }}</span>
		        				</div>
		        				<div class="details-wrap d-flex">
							        <div class="icon incorrect-icon"><i class="me-2 mdi mdi-close icon-wrapper"></i></div>
		        					<span class="text" id="incorrect" incorrect="{{ $result->incorrect }}">In Correct : {{ $result->incorrect }}</span>
		        				</div>
		        				<div class="details-wrap d-flex">
		        					<div class="icon unanswered-icon"><i class="me-2 mdi mdi-exclamation icon-wrapper"></i></div>
		        					<span class="text" id="un_answered" unanswered="{{ $result->un_answered }}">Un Answered : {{ $result->un_answered }}</span>
		        				</div>
		        			</div>
		        			<div class="col-md-6" id="pie-chart"></div>
		        		</div>
		          		<hr><hr><hr>
		          		<br>
		          		@foreach($result->attemptQuestions as $key => $attemptQuestion)
		          			@foreach($attemptQuestion->question as $question)
				          		<div class="row position-relative">
				          			<h4 align="center">Question No {{ str_pad($key+1, 2, '0', STR_PAD_LEFT) }} | @if($question->type == 1) MCQ's @else Multiple Select MCQ's @endif</h4>
				          		</div>
				          		<div class="row exp-btn-row">
				          			<div class="exp-btn-body">
			          					<button class="btn btn-outline-secondary exp-btn" questionid="{{ $attemptQuestion->question_id }}"><i class="fa fa-question"></i> Explaination</button>
				          			</div>
				          		</div>
				          		<div class="container">
				          			<div class="row bg-white br-12">
				          				<div class="col-12 p-0">
				          					<div class="m-10 p-10 double-border">
				          						{!! $question->question !!}
				          					</div>
				          				</div>

			          					<div class="row justify-content-center m-0 p-0">
			          						@foreach($question->getOptions as $option)
						          				<div class="col-6 p-0">
				          							@foreach($attemptQuestion->checkedOptions as $checkedOption)
						          						@if($checkedOption->option_id == $option->id)
							          						@if($checkedOption->is_true == 1)
							          							<div class="icon correct-icon check"><i class="fas fa-check icon-wrapper"></i></div>
							          						@else
							          							<div class="icon incorrect-icon check"><i class="me-2 mdi mdi-close icon-wrapper"></i></div>
							          						@endif
							          					@endif
					          						@endforeach
					          						<div class="m-10 p-10 double-border" style="padding-left: 20px;">         				
					          							{{ $option->option }}
					          						</div>
						          				</div>
					          				@endforeach
					          				@if($attemptQuestion->un_answered == 1)
			          							<p class="un-answered-text">You don't attempt the answer of this Question !.</p>
			          						@endif
			          					</div>

			          					<div class="row m-0 p-0">
			          						<h4 class="heading">@if($question->type == 1) Correct Answer : @else Correct Answers : @endif</h4>
				          					@foreach($question->getOptions as $getOption)
				          						@foreach($getOption->correctAnswers as $correctAnswer)
				          							@if($getOption->id == $correctAnswer->option_id)
							          					<div class="col-6 p-0">
							          						<div class="m-10 p-10 double-border" style="padding-left: 20px;">
							          							{{ $getOption->option }}
							          						</div>
							          					</div>
						          					@endif
					          					@endforeach
				          					@endforeach
			          					</div>

				          			</div>
				          		</div>
					          	<hr><hr><hr>
					          	<br>
			          		@endforeach
			          	@endforeach
		        	</section>
		        </div>
	    	
	    	</div>
	    </div>
  	</div>
</div>
@endsection
@section('scripts')
<script src="/admin/assets/dist/js/google-charts.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		
		// Chart
		google.charts.load("current", {packages:["corechart"]});
	 	google.charts.setOnLoadCallback(drawChart);
	  	
	  	function drawChart() {
		    var correct = $("#correct").attr('correct');
			var incorrect = $("#incorrect").attr('incorrect');
			var un_answered = $("#un_answered").attr('unanswered');
		    
		    var data = google.visualization.arrayToDataTable([
		      	['Task', 'Values'],
		      	['Correct Answers', parseInt(correct)],
		      	['Incorrect Answers', parseInt(incorrect)],
		        ['Un Answered', parseInt(un_answered)],
		    ]);

		    var options = {
		        pieStartAngle: 100,
		      	is3D: false,
		      	slices: {0: {color: '#5bb75b'}, 1:{color: '#da4f49'}, 2:{color: '#faa732'}}
		    };
		    
		    var chart = new google.visualization.PieChart(document.getElementById('pie-chart'));
		    chart.draw(data, options);
		}

		//// Explaination Modal ////
		// Call CSRF Meta
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

		var modalTinyNoFooter = new tingle.modal();
		
		$(".exp-btn").on('click', function(event) {
			event.preventDefault();
			var question_id = $(this).attr('questionid');

			$.post('{{ route('submitted-papers.get-explaination') }}', {question_id: question_id}, function(data) {
			    modalTinyNoFooter.open();
			    modalTinyNoFooter.setContent('<h2 align="center">Explaination</h2><p style="margin-top: 15px;border: 1px solid #8c9aa6;padding: 15px;">'+data.explaination+'</p>');
			});
		});
	});
</script>
@endsection