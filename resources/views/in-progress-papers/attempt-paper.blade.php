<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>Quizdeck | Attempt Paper</title>
	<link rel="icon" type="image/png" sizes="16x16" href="/admin/assets/images/favicon.png"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="/style.css">
</head>
<body>
	<style>
		.swal2-container.swal2-center>.swal2-popup {
			font-size: 15px;
		}
	</style>
	<div class="main">
		<div class="container">
			<div class="attempt-paper-wrap">
		    	<h2 class="h2-padding">Attempt Paper ( {{ $assign_paper->paper->name }} )</h2>
				<form id="storeAnswers" method="post" action="{{ route('attempt.paper.store.answers') }}">
					<div class="col-md-3">
						<h4><i class="fa fa-clock"></i>&nbsp; Time Taken</h4>
						<div class="btn btn-timeClass" style="width:82%;">
	                       	<span id="timer"></span>   
	        				<!-- Timer hidden input -->
							<input type="hidden" name="time" id="timer_input" value="00:00:00" />
							<input type="hidden" name="assign_paper_id" value="{{ $id }}" />
	                    </div>
	                    <div class="question-numbers">

	                    	<!-- Total Number Of Questions -->
	                    	<input type="hidden" id="number_of_questions" value="{{ $assign_paper->paper->number_of_questions }}">
	                    	<div id="question_num">
		                    	@foreach($question_numbers as $key => $question_number)
		                    		<a title="Question {{ $key+1 }}" data-key="{{ $key+1 }}" questionID="{{ $question_number->id }}" id="questionNo{{ $key }}" class="btn btn-mini">{{ str_pad($key+1, 2, '0', STR_PAD_LEFT) }}</a>
		                    	@endforeach
	                    	</div>

	                    </div>
	                    <div class="buttons-info">
	                    	<a title="Current" class="btn btn-mini btn-warning"></a><span style="color: #fff; margin-bottom: 6px;"> Current</span><br>
	                    	<a title="Answered" class="btn btn-mini btn-info"></a><span style="color: #fff; margin-top: 10px; margin-bottom: 6px;"> Answered</span><br>
	                    	<a title="Un Answered" class="btn btn-mini"></a><span style="color: #fff; margin-top: 10px;"> Un Answered</span>
	                    </div>
					</div>
					<div class="col-md-9 q-main">
					</div>
				</form>

				<div class="col-md-3"></div>
				<div class="col-md-9 buttons-area">
					<div class="row">
						<div class="col-md-6 mt-15">
                            <a href="#" title="Submit Paper" class="btn btn-sm btn-warning" id="submit_paper"><i class="fa fa-book"></i> Submit Paper</a>
                            <a href="#" title="Save Paper" class="btn btn-sm btn-warning" id="save_paper"><i class="fa fa-book"></i> Save Paper</a>
						</div>
						<div align="right" class="col-md-6 mt-15">
                            <a title="Previous" class="btn btn-sm btn-info" id="prev"><i class="fa fa-arrow-left"></i> Previous</a>
							<a title="Next" class="btn btn-sm btn-info" id="next">Next <i class="fa fa-arrow-right"></i></a>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="/admin/assets/libs/sweetalert/all.min.js"></script>

	<script type="text/javascript">
	   	// Timer 	  
	   	var myCounter = parseFloat('{{ $assign_paper->time }}'-2);
	   	var intervalSeconds;
	   	var timerIsOn = 0;

	   	function timeCount() {
	       	myCounter = myCounter + 1;

	       	var hours = parseInt(myCounter / 3600) % 24;
	       	var minutes = parseInt(myCounter / 60) % 60;
	       	var seconds = myCounter % 60;
	       	var result = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds < 10 ? "0" + seconds : seconds);

	       	intervalSeconds = setTimeout("timeCount()", 1000);
	       	document.getElementById('timer_input').value = myCounter;
	       	document.getElementById('timer').innerHTML = result;
	   	}


	   	if (!timerIsOn)
	   	{
	       timerIsOn = 1;
	       timeCount();
	   	}
	</script>

	<script>
		$(document).ready(function() {

			// Call CSRF Meta
	        $.ajaxSetup({
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
	        });

			// On Click Question Numbers	
			jQuery(function(){
			   jQuery('#questionNo0').click();
			});
			var number_of_questions = $("#number_of_questions").val();

			for(var i = 0; i < number_of_questions; ++i){

				$("body").delegate("#questionNo"+i, 'click', function(event) {
					
					event.preventDefault();
					var questionID = $(this).attr('questionID');
					var assign_paper_id = $("input[name='assign_paper_id']").val();
					var key = $(this).data('key');

					$.post('{{ route('attempt.paper.get.question') }}', {questionID: questionID, assign_paper_id:assign_paper_id}, function(data) {

						// Reset Question Numbers
						$("#question_num").empty();

						$.each(data.question_numbers, function(index, val) {
							
							$("#question_num").append('<a title="Question '+parseFloat(index+1)+'" data-key="'+parseFloat(index+1)+'" questionID="'+val.question_id+'" id="questionNo'+index+'" class="btn btn-mini '+(val.question_id == questionID ? 'btn-warning' : (val.completed == 'completed' ? 'btn-info' : ''))+'">'+('0'+parseFloat(index+1)).slice(-2)+'</a>');

						});


						$(".q-main").empty();
						$(".q-main").append('\
							<div class="question-wrap">\
								<div class="question">\
									<div class="q-heading">Question No. '+('0' + key).slice(-2)+'</div>\
									<input type="hidden" name="question_id" value="'+data.question.id+'">\
									<input type="hidden" name="paper_id" value="'+data.question.paper_id+'">\
									<p>'+data.question.question+'</p>\
								</div>\
								<hr>\
		                        '+(data.question.type == 2 ? '<h4 style="color: #000;">-- Multiple Select --</h4>' : '') +'\
								<div class="row justify-content-center m-0 p-0" id="options">\
		      					</div>\
							</div>\
						');

						$("#options").empty();
						$.each(data.options, function(index, val) {

							if (data.question.type == 1) {
								
								$("#options").append('\
									<div class="col-md-6 option-wrap p-0">\
		                                <div class="custom-checkbox">\
		                                  <input type="radio" name="radio" id="radio'+index+'" '+val.checked+' value="'+val.option+'_'+val.option_id+'"/>\
		                                  <svg viewBox="0 0 35.6 35.6">\
		                                    <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>\
		                                    <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>\
		                                    <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>\
		                                  </svg>\
		                                </div>\
		          						<label class="m-10 double-border option-label" for="radio'+index+'">\
		          							'+val.option+'\
		          						</label>\
		          					</div>\
		          				');

							}

							if (data.question.type == 2) {

								$("#options").append('\
									<div class="col-md-6 option-wrap p-0">\
		                                <div class="custom-checkbox">\
		                                  <input type="checkbox" name="checkbox[]" '+val.checked+' id="checkbox'+index+'" value="'+val.option+'_'+val.option_id+'" />\
		                                  <svg viewBox="0 0 35.6 35.6">\
		                                    <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>\
		                                    <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>\
		                                    <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>\
		                                  </svg>\
		                                </div>\
		          						<label class="m-10 double-border option-label" for="checkbox'+index+'">\
		          							'+val.option+'\
		          						</label>\
		          					</div>\
		          				');

							}
						});

					});

				});

			}

			// Pagination
		    $("#next").click(function(){
		      	if($("a.btn-warning.btn-mini").next().length > 0){
		        	$("a.btn-warning.btn-mini").next("a").trigger('click');
		      	}
		    });
		    $("#prev").click(function(){
		        if($("a.btn-warning.btn-mini").prev().length > 0){
		            $("a.btn-warning.btn-mini").prev("a").trigger('click');
		        }
		    });

		    // Submit From On Select Option
		    $(".q-main").change(function(event) {
		    	event.preventDefault();
		    	$("#storeAnswers").submit();
		    });

		    // When Form Submit
		    $("#storeAnswers").submit(function(event) {
		    	
		    	event.preventDefault();
		    	var self = $(this);

		    	$.ajax({
		    		url: self.attr('action'),
		    		type: 'POST',
		    		data: self.serialize(),
		    	})
		    	.done(function(data) {
		    	})
		    	.fail(function() {
		    	})
		    	.always(function() {
		    	});

		    });

		    // ON CLICK SAVE PAPER
		    $("#save_paper").on('click', function(event) {
		    	event.preventDefault();

		    	// Sweet Alert
		    	Swal.fire({
					title: 'Are you sure?',
					text: "You won't be save this Paper!",
					icon: 'info',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, Save it!'
	            }).then((result) => {
	            	if (result.isConfirmed) {
	               		
	            		var assign_paper_id = $("input[name='assign_paper_id']").val();
	            		var time = $("#timer_input").val();
	            		$.post('{{ route('attempt.paper.save.paper') }}', {assign_paper_id: assign_paper_id, time: time}, function(data) {
	            			window.location.href = '{{ url('/in-progress-papers') }}';
	            		});

	              	}
	            })
		    	
		    });

		    // ON CLICK SUBMIT PAPER
		    $("#submit_paper").on('click', function(event) {
		    	event.preventDefault();
		    	var assign_paper_id = $("input[name='assign_paper_id']").val();
		    	var time = $("#timer_input").val();

		    	// Sweet Alert
		    	Swal.fire({
					title: 'Are you sure?',
					text: "You won't be submit this Paper!",
					icon: 'info',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, Submit it!'
	            }).then((result) => {
	            	if (result.isConfirmed) {
	            		$.post('{{ route('attempt.paper.submit.paper') }}', {assign_paper_id: assign_paper_id, time: time}, function(data) {
	            			window.location.href = '{{ url('/in-progress-papers') }}';
            			});
	              	}
	            })
		    });
		});
	</script>
</body>
</html>