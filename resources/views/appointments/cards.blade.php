<style>

    /* styling session cards container*/
    .cards-group {
        overflow-y: auto;
        overflow-x:hidden;
        max-height:275px;
        border:1px solid #c8ced3;
        margin-top:4px;
        padding:10px;
        background-color:white;
        font-size:12px;
    }

    /**styling session cards */
    .session-card-container {
        padding:4px;
    }

    .session-card {
        margin-bottom:5px !important;
        border:none;
        
    }

    .session-card > .card-header {
        padding:4px;
        border-radius:8px !important;
    }

    

</style>

@if(empty($sessions)) <!--if no sessions-->

        <x-panel_messages>
            <x-slot name="icon">
                <i class="fa fa-exclamation-triangle panel-icon" aria-hidden="true"></i>
            </x-slot>
            <x-slot name="message">
                <span>No sessions for the day</span>
            </x-slot>
        </x-panel_messages>

@else

    @foreach($sessions as $date_session)
    @if(strtotime($date_session['date']) == strtotime(date('Y-m-d')))
        @php $day = "Today" @endphp
    @else
        @php $day = date('l', strtotime($date_session['date'])) @endphp
    @endif
    <span class="badge badge-secondary"><b>{{$day}} - {{date('jS M, Y', strtotime($date_session['date']))}} </b></span>
    <div style="padding-left:12px; border-left:4px solid #CCC; margin-left:6px;">
        <div class="cards-group">
            <div class="row">
                @foreach($date_session['date_sessions'] as $session)
                    @php $cancel_btn = ""; @endphp
                    @php $start_btn = ""; @endphp
                    @php $complete_btn = ""; @endphp
                    @if($session->is_cancelled == "1")
                        <!--Cancelled Sessions-->
                        @php 
                            $status = '<button type="button" class="btn btn-xs btn-danger disabled">Cancelled</button>';
                            $background_color = 'bg-danger';
                            $bg_color = '#ffe6e6';
                        @endphp
                    @else 
                        @if($session->completed_at == null || $session->completed_at == "")
                            @if($session->starts_at == null || $session->starts_at == "") 
                                <!--Pending Sessions-->
                                @php 
                                    $status = '<button type="button" class="btn btn-xs btn-light disabled">Pending</button>';
                                    $cancel_btn = '<button type="button" class="btn btn-xs btn-reddit" id="cancel_session_btn{{$session->id}}" data-toggle="modal" data-target="#cancelSessionModal" data-toggle="tooltip" data-placement="top" title="Cancel Session" onclick="displayCancellationForm('.$session->id.')"><i class="fa fa-ban" aria-hidden="true"></i></button>';
                                    $start_btn = '<button type="button" class="btn btn-xs btn-success" id="start_session_btn{{$session->id}}" data-toggle="modal" data-target="#startSessionModal" data-toggle="tooltip" data-placement="top" title="Start Session" onclick="displaySessionStartForm('.$session->id.')"><i class="fa fa-play" aria-hidden="true"></i></button>';
                                    $background_color = 'bg-secondary';
                                    $bg_color = '#f2f2f2';
                                @endphp
                            @else
                                <!--On-going Sessions-->
                                @php 
                                    $status = '<button type="button" class="btn btn-xs btn-xing disabled">On-going...</button>';
                                    $complete_btn = '<button type="button" class="btn btn-xs btn-primary" id="complete_session_btn{{$session->id}}" data-toggle="modal" data-target="#completeSessionModal" data-toggle="tooltip" data-placement="top" title="Complete Session" onclick="displaySessionCompleteForm('.$session->id.')"><i class="fa fa-stop-circle" aria-hidden="true"></i></button>';
                                    $background_color = 'bg-success';
                                    $bg_color = '#d8f3e5';
                                @endphp
                            @endif
                        @else
                            <!-- Completed Sessions-->
                            @php 
                                $status = '<button type="button" class="btn btn-xs btn-primary disabled">Completed</button>';
                                $background_color = 'bg-info';
                                $bg_color = '#e6f2ff';
                            @endphp
                        @endif
                    @endif

                    @php $physician_specialization_array = array(); @endphp
                    @foreach ($session->physician->specializations as $specialization)
                        @php $physician_specialization_array[] = $specialization->description; @endphp
                    @endforeach
                <div class="col-sm-3 session-card-container" id="session_card{{$session->id}}">
                    <div class="card card-accent-secondary session-card">
                        <div class="card-header text-dark {{$background_color}}" style="border:1px solid #CCC;">
                            <div class="row">
                                <div class="col-sm-8" style="padding:2px;">
                                    <span><b>{{  $session->physician->title->short_code." ".$session->physician->physician_name }}</b></span><br>
                                    <span>{{  join(" , ",$physician_specialization_array) }}</b><span><br>
                                    <span>{{ (date("g:i A",(strtotime($session->start_time))))." - ".(date("g:i A", (strtotime($session->end_time)))) }} </span><br>
                                </div>
                                <div class="col-sm-4" style="padding:2px; text-align:center;">
                                    <div class="c-callout c-callout-info" style="text-align:center;">
                                        <small class="text-muted">Booked</small><br>
                                        <strong class="h6"><span id="card_booked_count_span{{$session->id}}">{{ count($session->appointment )}} </span>/{{ $session->number_of_slots }}</strong>
                                    </div>
                                    <span class="badge">{{ $session->department->short_code." - ".$session->room->short_code }}</span>
                                </div>
                            </div>
                            <hr style="margin-top:5px; margin-bottom:5px;">
                            <span class="pull-left">
                                <span id="card_status_span">@php echo $status @endphp</span>
                                <span id="card_cancel_span">@php echo $cancel_btn @endphp</span>
                                <span id="card_start_span">@php echo $start_btn @endphp</span>
                                <span id="card_complete_span">@php echo $complete_btn @endphp</span>
                            </span>
                            <span class="pull-right">
                                <button type="button" class="btn btn-xs btn-tumblr" data-toggle="tooltip" data-placement="top" title="Session Detail" onclick="getAppointmentDetails(this,{{$session->id}})"> <i class="fa fa-info-circle" aria-hidden="true"></i></button>
                                <span id="card_bookNow_span">
                                    @if($session->is_cancelled == "1")
                                    @else 
                                        @if($session->completed_at == null || $session->completed_at == "")
                                            @if(count($session->appointment) == $session->number_of_slots) <!--session full-->
                                                <button type="button" class="btn btn-xs btn-instagram" id="card_booking_btn{{$session->id}}" data-toggle="modal" data-target="#cardBookingModal" onclick="getBookingDetails({{$session->id}})">Session Full</button>
                                            @else <!--Book Now-->
                                                <button type="button" class="btn btn-xs btn-youtube" id="card_booking_btn{{$session->id}}" data-toggle="modal" data-target="#cardBookingModal" onclick="getBookingDetails({{$session->id}})">Book Now</button>
                                            @endif
                                        @endif
                                    @endif
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @endforeach

@endif

@stack('scripts')
<script>
function getAppointmentDetails(x, session_id) {

        if(session_id == "" || session_id == null || session_id == '0'){} else {

            displayView('detail_view');

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


    function displayCancellationForm(session_id){

        document.getElementById('cancel_session_id').value = session_id;

    }

    function displaySessionStartForm(session_id){

        document.getElementById('start_session_id').value = session_id;

        var currentdate = new Date(); 
        document.getElementById('started_at').value = currentdate.getFullYear()+"-"+(('0' + (currentdate.getMonth()+1)).slice(-2))+"-"+(('0' + currentdate.getDate()).slice(-2))+" "+(('0' + currentdate.getHours()).slice(-2))+":"+(('0' + currentdate.getMinutes()).slice(-2))+":"+(('0' + currentdate.getSeconds()).slice(-2));

    }

    function displaySessionCompleteForm(session_id){

        document.getElementById('complete_session_id').value = session_id;

        var currentdate = new Date(); 
        document.getElementById('completed_at').value = currentdate.getFullYear()+"-"+(('0' + (currentdate.getMonth()+1)).slice(-2))+"-"+(('0' + currentdate.getDate()).slice(-2))+" "+(('0' + currentdate.getHours()).slice(-2))+":"+(('0' + currentdate.getMinutes()).slice(-2))+":"+(('0' + currentdate.getSeconds()).slice(-2));

    }


</script>

@include('appointments.card_booking')
@include('appointments.card_cancel_session')
@include('appointments.card_start_session')
@include('appointments.card_complete_session')