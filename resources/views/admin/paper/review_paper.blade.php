@extends('layout.master')
@section('page-title')
  Review Paper
@endsection
@section('main-content')

<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Review Paper</h4>
      <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/paper">Paper</a></li>
            <li class="breadcrumb-item active" aria-current="page">Review Paper</li>
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
	.br-20{
		border-radius: 20px;
	}

	.checkmark {
	  width: 56px;
	  height: 56px;
	  border-radius: 50%;
	  stroke-width: 2;
	  stroke: #fff;
	  stroke-miterlimit: 10;
	  box-shadow: inset 0px 0px 0px #7ac142;
	  animation: fill 0.4s ease-in-out 0.4s forwards,
	    scale 0.3s ease-in-out 0.9s both;
	}

	.checkmark__circle {
	  stroke-dasharray: 166;
	  stroke-dashoffset: 166;
	  stroke-width: 2;
	  stroke-miterlimit: 10;
	  stroke: #7ac142;
	  fill: none;
	  animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
	}

	.checkmark__check {
	  transform-origin: 50% 50%;
	  stroke-dasharray: 48;
	  stroke-dashoffset: 48;
	  animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
	}

	@keyframes stroke {
	  100% {
	    stroke-dashoffset: 0;
	  }
	}

	@keyframes scale {
	  0%,
	  100% {
	    transform: none;
	  }
	  50% {
	    transform: scale3d(1.1, 1.1, 1);
	  }
	}

	@keyframes fill {
	  100% {
	    box-shadow: inset 0px 0px 0px 30px #7ac142;
	  }
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
</style>
<div class="container-fluid">
  	<div class="card">
	    <div class="card-body wizard-content">
	        <div role="application" class="wizard clearfix" id="steps-uid-0">		        
		        <div class="content clearfix">
		        	<section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current" aria-hidden="false">
		          		<table class="table table-bordered bg-white br-20">
		          			<thead>
		          				<tr align="center">
		          					<td><strong>Subject</strong></td>
		          					<td><strong>Name</strong></td>
		          					<td><strong>Number Of Questions</strong></td>
		          					<td><strong>Creation Date</strong></td>
		          				</tr>
		          			</thead>
                            <tbody>
                            	<tr align="center">
                            		<td>{{ $paper->subject->name }}</td>
                            		<td>{{ $paper->name }}</td>
                            		<td>{{ $paper->number_of_questions }}</td>
                            		<td>{{ date_format($paper->created_at, 'd / M / Y') }}</td>
                            	</tr>
                            </tbody>
		          		</table>

		          		@foreach($questions as $key => $value)
		          		<hr><hr><hr>
		          		<br>
		          		<div class="row position-relative">
		          			<h4 align="center">Question No {{ $key+1 }} | @if($value->type == 1) MCQ's @else Multiple Select MCQ's @endif</h4>
		          		</div>
		          		<div class="row exp-btn-row">
		          			<div class="exp-btn-body">
	          					<button class="btn btn-outline-secondary exp-btn" questionID="{{ $value->id }}"><i class="fa fa-question"></i> Explaination</button>
		          			</div>
		          		</div>
		          		<div class="container">
		          			<div class="row bg-white br-12">
		          				<div class="col-12 p-0">
		          					<div class="m-10 p-10 double-border">
		          						{!! $value->question !!}
		          					</div>
		          				</div>
	          					<div class="row justify-content-center m-0 p-0">
		          					@foreach($value->getOptions as $option)	
			          					<div class="col-6 p-0">
			          						@foreach($option->correctAnswers as $answer)
				          						@if($answer->option_id)
			          								<svg class="checkmark position-absolute" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" style="width: 30px; height: 30px;"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
				          						@endif
			          						@endforeach
			          						<div class="m-10 p-10 double-border" style="padding-left: 20px;">         				
			          							{{ $option->option }}
			          						</div>	
			          					</div>
	          						@endforeach
	          					</div>
		          			</div>
		          		</div>
		          		@if($loop->last)
		          			<hr><hr><hr>
		          		@endif
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

		// Call CSRF Meta
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

		var modalTinyNoFooter = new tingle.modal();
		
		$(".exp-btn").on('click', function(event) {
			event.preventDefault();
			var question_id = $(this).attr('questionID');

			$.post('{{ route('get.question.explaination') }}', {question_id: question_id}, function(data) {
			    modalTinyNoFooter.open();
			    modalTinyNoFooter.setContent('<h2 align="center">Explaination</h2><p style="margin-top: 15px;border: 1px solid #8c9aa6;padding: 15px;">'+data.explaination+'</p>');
			});

		});
	});
</script>
@endsection