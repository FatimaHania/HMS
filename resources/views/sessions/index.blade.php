@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Sessions</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Sessions
                             <a class="pull-right" href="{{ route('sessions.create') }}"><i class="fa fa-plus-square fa-lg"></i></a>
                         </div>
                         <div class="card-body">
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-sm-6">
                                        {!! Form::label('filter_physician_id', 'Physician:') !!}
                                        {!! Form::select('filter_physician_id', $physicians, null, ['class' => 'selectpicker form-control' , 'onchange' => 'getSessionDates(this); getSessionDetails(this);' , 'data-live-search' => "true"]) !!}
                                    </div>

                                    <div class="form-group col-sm-6">
                                        {!! Form::label('filter_session_date', 'Session Date:') !!}
                                        {!! Form::select('filter_session_date', ['Select Date'], null, ['class' => 'selectpicker form-control' , 'onchange' => 'scrollToSessionDate();' , 'data-live-search' => "true"]) !!}
                                    </div>
                                </div>

                            </div>

                            <x-loader loader-id="detailsLoader_div" min-height="200px"></x-loader>

                            <div id="sessionDetails_div">

                            </div>

                              <div class="pull-right mr-3">
                                     
                              </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>

@stack('scripts')
<script>

    $(document).ready(function(){

        var editedPhysicianId = "{{ session('editedPhysicianId') }}";
        var editedSessionDate = "{{ session('editedSessionDate') }}";
        
        if(editedPhysicianId == "" || editedPhysicianId == null) {} else {
            $('#filter_physician_id').val(editedPhysicianId).trigger('change');
            $('#filter_physician_id').selectpicker('refresh');
            
        }

    })

    function getSessionDates(x) {

        var physician_id = x.value;

        if(physician_id == "" || physician_id == null){} else {

            $.ajax({
                type:'POST',
                url:"{{route('sessions.getSessionDates')}}",
                data: {_token: "{{ csrf_token() }}" , physician_id: physician_id},
                beforeSend: function () { 
                    document.getElementById('filter_session_date').readonly = true;
                },
                success:function(data) {
                    $("#filter_session_date").html(data);
                    $("#filter_session_date").selectpicker('refresh');
                    document.getElementById('filter_session_date').readonly = false;

                }
            });

        } 

    }


    function getSessionDetails(x) {

        var physician_id = document.getElementById('filter_physician_id').value;
        var session_date = document.getElementById('filter_session_date').value;

        if(physician_id == "" || physician_id == null){} else {

            $.ajax({
                type:'POST',
                url:"{{route('sessions.getSessionDetails')}}",
                data: {_token: "{{ csrf_token() }}" , physician_id: physician_id , session_date: session_date},
                beforeSend: function () {
                    document.getElementById('sessionDetails_div').style.display = "none";
                    document.getElementById('detailsLoader_div').style.display = "block";
                },
                success:function(data) {
                    $("#sessionDetails_div").html(data);
                    $("#filter_session_date").selectpicker('refresh');
                    document.getElementById('detailsLoader_div').style.display = "none";
                    document.getElementById('sessionDetails_div').style.display = "block";

                    var editedSessionDate = "{{ session('editedSessionDate') }}";
        
                    if(editedSessionDate == "" || editedSessionDate == null) {} else {
                        $('#filter_session_date').val(editedSessionDate).trigger('change');
                        $('#filter_session_date').selectpicker('refresh');

                    }

                }
            });

        } 

    }

    function scrollToSessionDate(sess_date=0) {

        if(sess_date == "0"){
            var session_date = document.getElementById('filter_session_date').value;
        } else {
            var session_date = sess_date;
        }

        if(session_date == "" || session_date == null || session_date == 0){} else {
            var numb = session_date.match(/\d/g);
            numb = numb.join("");

            document.getElementById("physicianSessionListItem"+numb).scrollIntoView(true);
            // $('#physicianSessionListItem'+numb).css('background-color','red');
        }

    }

</script>

@endsection

