@if($session->is_cancelled == "1")
        @php
            $status = '<button type="button" class="btn btn-xs btn-danger disabled">Cancelled</button>';
            $background_color = 'bg-danger';
            $disable_status = 'disabled="disabled"';
        @endphp
    @else 
        @if($session->completed_at == null || $session->completed_at == "")
            @php
                $status = '<button type="button" class="btn btn-xs btn-light disabled">Pending</button>';
                $background_color = 'bg-secondary';
                $disable_status = '';
            @endphp
        @else
            @php
                $status = '<button type="button" class="btn btn-xs btn-primary disabled">Completed</button>';
                $background_color = 'bg-info';
                $disable_status = 'disabled="disabled"';
            @endphp
        @endif
    @endif

    @php $physician_specialization_array = array(); @endphp
    @foreach ($session->physician->specializations as $specialization)
        @php $physician_specialization_array[] = $specialization->description; @endphp
    @endforeach
<div class="col-sm-12 session-card-container">
    <div class="card card-accent-secondary session-card">
        <div class="card-header text-dark {{$background_color}}">
            <div class="row">
                <div class="col-sm-9" style="padding:2px;">
                    <span><b>{{  $session->physician->title->short_code." ".$session->physician->physician_name }}</b></span><br>
                    <span><b>Specialization: </b>{{  join(", ",$physician_specialization_array) }}</b><span><br>
                    <span><b>Date/Time: </b>{{ (date("jS M, Y", strtotime($session->date)))." [".(date("g:i A",(strtotime($session->start_time))))." - ".(date("g:i A", (strtotime($session->end_time))))."] " }} </span><br>
                    <span><b>Room: </b>{{ $session->department->short_code ." - ". $session->room->short_code }}</span>
                </div>
                <div class="col-sm-3" style="padding:2px; text-align:right;">
                    <div class="c-callout c-callout-info">
                        <table width="100%" class="text-center">
                            <tr><td><div class="bg-light text-dark" style="padding:2px; font-weight:bold; font-size:16px; width:100px; margin:6px; border-radius:4px;"><span id="booked_count_span">{{ count($session->appointment)}}</span> <small class="text-muted">Booked</small></div></td></tr>
                            <tr><td><div class="bg-light text-dark" style="padding:2px; font-weight:bold; font-size:16px; width:100px; margin:6px; border-radius:4px;">{{ $session->number_of_slots }} <small class="text-muted">Total slots</small></div></td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr style="margin:2px;">
@php $appointments_arr = array(); @endphp
@foreach($session->appointment->sortBy('appointment_number') as $appointment)
    @php
        $appointments_arr[$appointment->appointment_number] = $appointment;
    @endphp
@endforeach
<div style="max-height:275px; overflow-y:auto;">
<table width="100%" class="table table-borderless table-striped">
    <tr>
        <th>#Slot</th>
        <th>Reference No.</th>
        <th style="width:60%;">Patient</th>
        <th>Time</th>
    </tr>
    @for($i = 1 ; $i <= $session->number_of_slots ; $i++)
        @if(isset($appointments_arr[$i]))
            @php
                $reference_number = $appointments_arr[$i]->reference_number;
                $reference_code = $appointments_arr[$i]->reference_code;
                $patient_id = $appointments_arr[$i]->patient_id;
                $appointment_time = $appointments_arr[$i]->appointment_time;
            @endphp
        @else
            @php
                $reference_number = "";
                $reference_code = "";
                $patient_id = 0;
                $appointment_time = "";
            @endphp
        @endif
    <tr id="booking_tr_loader{{$i}}" style="display:none;">
        <td class="text-center" colspan="4">
            <div class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </td>
    </tr>
    <tr id="booking_tr{{$i}}">
            <td>{{ $i }}</td>
            <td id="reference_code_td{{$i}}">{{ $reference_code }}</td>
            <td>
                <select class="form-control selectpicker form-control form-control-xs" id="booking_patient_id{{$i}}" name="booking_patient_id" style="margin:2px;" onchange="bookAppointment(this, 'patient', {{$session->id}}, {{$i}}, {{$session->currency_id}}, {{$session->amount_per_slot}}, {{$session->number_of_slots}})" {{$disable_status}}>
                    <option value="0"></option>
                    @foreach($patients as $patient)
                        @if($patient->id == $patient_id)
                            <option value="{{$patient->id}}" selected="selected">{{$patient->patient_code." | ".$patient->patient_name}}</option>
                        @else
                            <option value="{{$patient->id}}">{{$patient->patient_code." | ".$patient->patient_name}}</option>
                        @endif
                    @endforeach
                </select>
            </td>
            <td>
                @if($appointment_time  == "" || $appointment_time == null || $appointment_time == "00:00:00")
                   @php 
                        $start_time = strtotime($session->start_time);
                        $difference = ($session->duration_per_slot)*(($i)-1);
                        $app_time = date("H:i:s", strtotime('+'.$difference.' minutes', $start_time))
                   @endphp
                @else
                    @php
                        $app_time = $appointment_time;
                    @endphp
                @endif

                <!-- Appointment Time Field -->
                <input type="text" class="form-control form-control-xs timepicker" id="booking_appointment_time{{$i}}" name="booking_appointment_time{{$i}}" value="{{$app_time}}" onblur="bookAppointment(this, 'time', {{$session->id}}, {{$i}}, {{$session->currency_id}}, {{$session->amount_per_slot}}, {{$session->number_of_slots}})" {{$disable_status}}>
                
            </td>
    </tr>
    @endfor
</table>
<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
    <img src="..." class="rounded mr-2" alt="...">
    <strong class="mr-auto">Bootstrap</strong>
    <small>11 mins ago</small>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
    Hello, world! This is a toast message.
  </div>
</div>
</div>
@stack('scripts')
<script>

    $(document).ready(function() {

        $('.selectpicker').selectpicker('refresh');

        $('.timepicker').datetimepicker({
            format: 'HH:mm:ss',
            icons: {
                  time: "fa fa-clock-o",
                  date: "fa fa-calendar",
                  up: "fa fa-arrow-up",
                  down: "fa fa-arrow-down"
              }
        });

    })

    function bookAppointment(x, field_type, session_id, appointment_number, currency_id, amount_per_slot, number_of_slots){

        var patient_id = document.getElementById('booking_patient_id'+appointment_number).value;
        var appointment_time = document.getElementsByName('booking_appointment_time'+appointment_number)[0].value;

        if(patient_id == "" || patient_id == null || patient_id == '0'){
            if(field_type == "patient"){
                $.ajax({
                    type:'POST',
                    url:"{{route('appointments.cancelAppointments')}}",
                    data: {_token: "{{ csrf_token() }}" , session_id: session_id , appointment_number: appointment_number},
                    beforeSend: function () { 
                        document.getElementById('booking_tr'+appointment_number).style.display = "none";
                        document.getElementById('booking_tr_loader'+appointment_number).style.display = "table-row";
                    },
                    success:function(data) {
                        if(data.status == "1"){
                            document.getElementById('booking_tr_loader'+appointment_number).style.display = "none";
                            document.getElementById('booking_tr'+appointment_number).style.display = "table-row";
                            document.getElementById('booking_tr'+appointment_number).style.backgroundColor = "#ffffe6";
                            document.getElementById('booked_count_span').innerText = data.number_of_appointments;
                            document.getElementById('card_booked_count_span'+session_id).innerText = data.number_of_appointments;
                            document.getElementById('reference_code_td'+appointment_number).innerText = '';

                            //change card button (Session full/Book now)
                            if(data.number_of_appointments == number_of_slots){
                                document.getElementById('card_booking_btn'+session_id).className = "btn btn-xs btn-instagram";
                                document.getElementById('card_booking_btn'+session_id).innerText = "Session Full";
                            } else {
                                document.getElementById('card_booking_btn'+session_id).className = "btn btn-xs btn-youtube";
                                document.getElementById('card_booking_btn'+session_id).innerText = "Book Now";
                            }

                            toastr.success('Appointment cancelled successfully');
                        }
                    }
                });
            } 
        } else {

            $.ajax({
                type:'POST',
                url:"{{route('appointments.bookAppointments')}}",
                data: {_token: "{{ csrf_token() }}" , patient_id: patient_id , session_id: session_id, appointment_time: appointment_time , appointment_number: appointment_number, currency_id: currency_id, amount_per_slot: amount_per_slot},
                beforeSend: function () { 
                    document.getElementById('booking_tr'+appointment_number).style.display = "none";
                    document.getElementById('booking_tr_loader'+appointment_number).style.display = "table-row";
                },
                success:function(data) {
                    document.getElementById('booking_tr_loader'+appointment_number).style.display = "none";
                    document.getElementById('booking_tr'+appointment_number).style.display = "table-row";
                    document.getElementById('booking_tr'+appointment_number).style.backgroundColor = "#ffffe6";
                    document.getElementById('booked_count_span').innerText = data.number_of_appointments;
                    document.getElementById('card_booked_count_span'+session_id).innerText = data.number_of_appointments;
                    document.getElementById('reference_code_td'+appointment_number).innerText = data.ref_code;

                    //change card button (Session full/Book now)
                    if(data.number_of_appointments == number_of_slots){
                        document.getElementById('card_booking_btn'+session_id).className = "btn btn-xs btn-instagram";
                        document.getElementById('card_booking_btn'+session_id).innerText = "Session Full";
                    } else {
                        document.getElementById('card_booking_btn'+session_id).className = "btn btn-xs btn-youtube";
                        document.getElementById('card_booking_btn'+session_id).innerText = "Book Now";
                    }

                    toastr.success('Appointment booked successfully');

                }
            });

        }

    }

</script>