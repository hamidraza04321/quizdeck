@extends('layout.master')
@section('page-title')
  Create Paper
@endsection
@section('main-content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Create Paper</h4>
      <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/paper">Paper</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Paper</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
  <div class="card">
    <div class="card-body wizard-content">
      
      {{-- FORM START --}}
      <form action="{{ route('paper.store') }}" name="make_a_paper" id="make_a_paper" method="post">
      <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
      @csrf      			
        
        <div role="application" class="wizard clearfix" id="steps-uid-0">
        <div class="content clearfix">
          <section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current" aria-hidden="false">
                
            <div class="form-group">
              <label for="subject_id">Subject *</label>
              @error('subject_id')
                <label class="error" for="subject_id">{{ $message }}</label>
              @enderror
              <select name="subject_id" required class="form-control" id="subject_id">
        				<option selected value=""> -- Select Subject -- </option>
        				@foreach($subjects as $subject)
                  <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
        			</select>
            </div>

            <div class="form-group">
              <label for="name">Name *</label>
              @error('name')
                <label class="error" for="name">{{ $message }}</label>
              @enderror
              <input id="name" name="name" required type="text" class="form-control @error('name') error @enderror" value="{{ old('name') }}">
            </div>

            <div class="form-group">
              <label for="number_of_questions">Number Of Questions *</label>
              <select name="number_of_questions" required class="form-control" id="number_of_questions">
                <option selected value=""> -- Number Of Questions -- </option>
                  @for ($val=5; $val < 101; $val++)
                    <option value="{{$val}}">{{$val}}</option>
                  @endfor
              </select>
            </div>

            <table class="table table-bordered" id="dynamicAddRemoveQuestions">
            </table>

            <div class="form-group">
                <label for="description">Description ( Optional ) </label>
                <input type="text" name="description" class="form-control" id="description" placeholder="Description">
            </div>            


          </section>
        </div>
        <div class="actions clearfix">
          <button type="button" onclick="window.location.href='/admin/paper'" class="btn btn-secondary">Cancel</button>
          <button type="submit" class="btn btn-outline-primary">Create</button>
        </div></div>
      </form>
      {{-- FORM END --}}
    </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection
@section('scripts')
<script src="/admin/assets/libs/summer-note/summer-note.min.js"></script>
<script>

	$(document).ready(function() {
    // For SELECT 2
		$('#subject_id').select2();
    $('#number_of_questions').select2();
	   
    // On Change Number Of Question Showing Tables
    var i = 0;
    var a = 0;
    $('#number_of_questions').on('change', function() {
        ++i;
        ++a;
        var question_no = $(this).val();
        $("#dynamicAddRemoveQuestions").html('');
        for (let index =0; index < question_no; index++) {
            $("#dynamicAddRemoveQuestions").append('<hr><hr><hr><div class="row">\
              <div class="col-12">\
                <div class="card">\
                  <div class="card-body">\
                    <h5 class="card-title mb-0">Question No '+ parseFloat(index + 1) +'</h5>\
                  </div>\
                  <textarea required name="questions[]" class="form-control summernote" placeholder="Question No '+ parseFloat(index + 1) +'"></textarea>\
                  <div class="form-group">\
                    <div class="card-body">\
                      <h5 class="card-title mb-0">Type</h5>\
                    </div>\
                    <select required name="question_type[]" class="form-control" id="question_type">\
                      <option selected value="">--Select Type--</option>\
                      <option value="1">MCQs</option>\
                      <option value="2">Multi-Select MCQs</option>\
                    </select>\
                  </div>\
                  <table class="table table-bordered bg-white">\
                    <thead>\
                      <tr>\
                        <th scope="col">Action</th>\
                        <th scope="col">Options</th>\
                        <th scope="col">Select Answer</th>\
                      </tr>\
                    </thead>\
                    <tbody class="dynamicAddRemove'+index+'">\
                      <tr>\
                        <td></td>\
                        <td><button type="button" data-id="'+index+'" class="btn btn-outline-primary dynamic-ar">Add Option</button></td>\
                      </tr>\
                    </tbody>\
                  </table>\
                  <div class="card-body">\
                    <h5 class="card-title mb-0">Explaination</h5>\
                  </div>\
                  <textarea required name="correct_answer_explaination[]" class="form-control" placeholder="Explaination"></textarea>\
                </div>\
              </div>\
            </div>');
        }
        $(".summernote").summernote({
            tabsize: 2,
            height: 120,
            toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link', 'picture', 'video']],
              ['view', ['fullscreen', 'codeview', 'help']]
            ],
        });
        $(".note-image-btn").attr('style', 'margin-top: -24px !important');
        $(".note-editable").attr('style', 'background: #fff');
    })

    // On CLick Add Option
    var i = 0;
    var z = -1;
    $("body").delegate('.dynamic-ar', 'click', function(e){
        var data_id = $(this).data("id");
        ++i;
        ++z;
        $(".dynamicAddRemove"+data_id).append('\
        <tr>\
            <td>\
                <button type="button" class="btn btn-outline-danger remove-input-field">Delete</button>\
            </td>\
            <td>\
                <input type="text" required name="options['+data_id+'][]" onchange="myFunction('+z+')" value="" id="options'+z+'" class="form-control  textString'+data_id+'" placeholder="Enter Option" class="form-control" />\
            </td>\
            <td>\
                <input type="checkbox" name="radio['+data_id+'][]" id="radio'+z+'" style="width: 100px;height: 30px;"/>\
            </td>\
        </tr>');
    });

    // DELECT OPTIONN
    $("body").delegate('.remove-input-field', 'click', function() {
        $(this).parents('tr').remove();
    });

  });
</script>

{{-- PUT OPTION VALUE IN CHECKBOX --}}
<script>
    function myFunction(id) {
      var a = document.getElementById("options"+id).value;
      var b = a;
      document.getElementById("radio"+id).value = b;
    }
</script>
<script>
  var slug = function(str) {
    var $slug = '';
    var trimmed = $.trim(str);
    $slug = trimmed.replace(/[^a-z0-9-]/gi,'-').
      replace(/-+/g,'-').
      replace(/^-|-$/g,'');
      return $slug.toLowerCase();
  }
  $('.slug').text(slug($('.test').text()));
</script>
<script>
  function slug(params) {
    document.getElementsByClass("textString"+params).addEventListener("input",
    function () {
      let theSlug = string_to_slug(this.value);
      document.getElementsByClass("textSlug"+params).value = theSlug;
    });
    function string_to_slug(str) {
      str = str.replace(/^\s+|\s+$/g,""); // trim
      str = str.toLowerCase();
      // remove accents,
      swap ñ for n,
      etc
      var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
      var to = "aaaaeeeeiiiioooouuuunc------";
      for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i),"g"),to.charAt(i));
      }
      str = str
      .replace(/[^a-z0-9 -]/g,"") // remove invalid chars
      .replace(/\s+/g,"-") // collapse whitespace and replace by -
      .replace(/-+/g,"-"); // collapse dashes
      return str;
    }
  }
</script>
@endsection