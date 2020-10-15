@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Appointments</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card" style="margin-bottom:5px;">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Appointments
                             <a class="pull-right" href="{{ route('appointments.create') }}"><i class="fa fa-plus-square fa-lg"></i></a>
                         </div>
                         <div class="card-body">
                         <div class="well well-sm">
                                <div class="row">
                                    <div class="col-sm-12">
                                        {!! Form::label('filter_session_id', 'Session:') !!}
                                        <select class="selectpicker form-control" id="filter_session_id" onchange="getAppointmentDetails(this)" data-live-search="true">
                                        <option value="0">Select Session</option>
                                            @foreach($sessions as $session)
                                                <option value="{{$session->id}}">
                                                    {{" [".$session->physician->physician_code."|".$session->physician->physician_name."] ".$session->name." ".(date("jS M, Y", strtotime($session->date)))." ".((date("g:i A",(strtotime($session->start_time)))))}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                              <div class="pull-right mr-3">
                                     
                              </div>
                         </div>
                     </div>
                  </div>
                  <div class="col-lg-12">
                    
                            <x-loader loader-id="detailsLoader_div" min-height="200px"></x-loader>

                            <div id="appointmentDetails_div">

                            </div>
                </div>
             </div>
            
         </div>
    </div>
@stack('scripts')
<script>
    $(document).ready(function(){

        var editedSessionId = "{{ session('editedSessionId') }}";
        var editedAppointmentId = "{{ session('editedAppointmentId') }}";

        if(editedSessionId == "" || editedSessionId == null) {} else {
            $('#filter_session_id').val(editedSessionId).trigger('change');
            $('#filter_session_id').selectpicker('refresh');
            
        }

    })

function getAppointmentDetails(x) {

    var session_id = document.getElementById('filter_session_id').value;

    if(session_id == "" || session_id == null || session_id == '0'){} else {

        $.ajax({
            type:'POST',
            url:"{{route('appointments.getAppointmentDetails')}}",
            data: {_token: "{{ csrf_token() }}" , session_id: session_id},
            beforeSend: function () {
                document.getElementById('appointmentDetails_div').style.display = "none";
                document.getElementById('detailsLoader_div').style.display = "block";
            },
            success:function(data) {
                $("#appointmentDetails_div").html(data);
                document.getElementById('detailsLoader_div').style.display = "none";
                document.getElementById('appointmentDetails_div').style.display = "block";

            }
        });

    } 

}

</script>

@endsection

