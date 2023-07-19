@extends('layout.master')
@section('page-title')
	Assign Paper
@endsection
@section('main-content')

<style>
.funkyradio div {
  clear: both;
  width: 23%;
  overflow: hidden;
  margin-right: 15px;
}

.funkyradio label {
  width: 100%;
  border-radius: 3px;
  border: 1px solid #D1D3D4;
  font-weight: normal;
}

.funkyradio input[type="radio"]:empty {
  display: none;
}

.funkyradio input[type="radio"]:empty ~ label {
  position: relative;
  line-height: 2.5em;
  text-indent: 3.25em;
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}

.funkyradio input[type="radio"]:empty ~ label:before {
  position: absolute;
  display: block;
  top: 0;
  bottom: 0;
  left: 0;
  content: '';
  width: 2.5em;
  background: #D1D3D4;
  border-radius: 3px 0 0 3px;
}

.funkyradio input[type="radio"]:hover:not(:checked) ~ label {
  color: #888;
}

.funkyradio input[type="radio"]:hover:not(:checked) ~ label:before {
  content: '\2714';
  text-indent: .9em;
  color: #C2C2C2;
}

.funkyradio input[type="radio"]:checked ~ label {
  color: #777;
}

.funkyradio input[type="radio"]:checked ~ label:before {
  content: '\2714';
  text-indent: .9em;
  color: #333;
  background-color: #ccc;
}

.funkyradio input[type="radio"]:focus ~ label:before {
  box-shadow: 0 0 0 3px #999;
}

.funkyradio-info input[type="radio"]:checked ~ label:before {
  color: #fff;
  background-color: #5bc0de;
}
</style>




<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Assign Paper</h4>
      <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/assign-paper">Assign Paper</a></li>
            <li class="breadcrumb-item active" aria-current="page">Assign New Paper</li>
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
  <!-- ============================================================== -->
  <!-- Start Page Content -->
  <!-- ============================================================== -->
  <div class="card">
    <div class="card-body wizard-content">
      <form action="{{ route('assign-paper.store') }}" method="post">
      	@csrf
        <div role="application" class="wizard clearfix" id="steps-uid-0">
        <div class="content clearfix">
          <section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current" aria-hidden="false">
            

            <div class="funkyradio d-flex">
              <div class="funkyradio-info">
                  <input type="radio" value="A" class="radio_button" name="radio" id="radio1" />
                  <label for="radio1">All</label>
              </div>
              <div class="funkyradio-info">
                  <input type="radio" value="S" class="radio_button" name="radio" id="radio2" />
                  <label for="radio2">Student</label>
              </div>
              <div class="funkyradio-info">
                  <input type="radio" value="G" class="radio_button" name="radio" id="radio3" />
                  <label for="radio3">Group</label>
              </div>
            </div>
            
            <div class="form-group">
                <select name="assign_for_id" required="" id="assign_for_id" class="form-control">
                </select>
            </div>
            
            <div class="form-group">
                <select name="subject_id" required="" id="subject_id" class="form-control">
                    <option value="">-- Select Subject --</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <select name="paper_id" required="" id="paper_id" class="form-control">
                    <option value="">-- Select Paper --</option>
                </select>
            </div>

            <div class="form-group">
                <input name="description" id="description" type="text" placeholder="Description ( Optional )" class="form-control">
            </div>

          </section>
        </div>
        <div class="actions clearfix">
          <button type="button" onclick="window.location.href='/admin/assign-paper'" class="btn btn-secondary">Cancel</button>
          <button type="submit" class="btn btn-outline-primary">Create</button>
        </div></div>
      </form>
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

        // ON CHANGE RADIO BUTTON
        $(".radio_button").change(function(event) {
            event.preventDefault();
            var val = $(this).val();

            $.post('{{ route('assign-paper.assign-for') }}', {value: val}, function(data) {

                // IF SELECT (ALL)
                if (data.status == 'A') {
                    
                    $("#assign_for_id").empty();
                    $("#assign_for_id").removeAttr('required');
                    $("#assign_for_id").append('<option value="">-- Assign For All --</option>');
                
                }

                // IF SELECT (STUDENT)
                if (data.status == 'S') {

                    $("#assign_for_id").empty();
                    $("#assign_for_id").attr('required', '');
                    $("#assign_for_id").append('<option value="">-- Select Student --</option>');

                    $.each(data.users, function(index, val) {
                        $("#assign_for_id").append('<option value="'+val.id+'">'+val.name+'</option>');
                    });
                
                }

                // IF SELECT (GROUP)
                if (data.status == 'G') {

                    $("#assign_for_id").empty();
                    $("#assign_for_id").attr('required', '');
                    $("#assign_for_id").append('<option value="">-- Select Group --</option>');

                    $.each(data.groups, function(index, val) {
                        $("#assign_for_id").append('<option value="'+val.id+'">'+val.name+'</option>');
                    });    

                }

            });

        });

        // ON CHANGE SUBJECT DROPDOWN
        $("#subject_id").change(function(event) {
            event.preventDefault();
            var id = $(this).val();

            $.post('{{ route('assign-paper.get-papers') }}', {subject_id: id}, function(data) {

                $("#paper_id").empty();
                $("#paper_id").append('<option value="">-- Select Paper --</option>');
                $.each(data, function(index, val) {
                    $("#paper_id").append('<option value="'+val.id+'">'+val.name+'</option>')
                });
                
            });

        });

        // ON CHANGE PAPER
        $("#paper_id").change(function(event) {
            event.preventDefault();
            var id = $(this).val();
            $.post('{{ route('assign-paper.get-description') }}', {paper_id: id}, function(data) {

                // Remove Old Value
                $("#description").val('');

                // Show Description
                $("#description").val(data.description);
            });
        });

        // SELECT 2
        $("#assign_for_id").select2();
        $("#subject_id").select2();
        $("#paper_id").select2();
    
    });
</script>
@endsection