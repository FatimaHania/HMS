<style>

    .session_list_td {
        padding:5px;
    }

    .session_date {
        text-align:center;
        border-radius : 75px ;
        padding: 8px ;
        min-height :65px;
        border:2px solid #f2f2f2;
        background-color:white;
    }

    .session_detail {
        border-radius : 5px ;
        padding: 8px ;
        padding-left:10px;
        border:1px solid #f2f2f2;
        min-height :65px;
        margin-bottom: 8px;
        margin-top: 8px;
        background-color:#e6f7ff;
        font-size:11px;
    }



</style>

    @if($session->is_cancelled == "1")
        @php
            $status = '<span class="badge badge-danger">Cancelled</span>';
            $background_color = 'bg-danger';
            
        @endphp
    @else
        @if($session->completed_at == null || $session->completed_at == "")
            @php
                $status = '<span class="badge badge-warning">Pending</span>';
                $background_color = 'bg-secondary';
                $edit_button = '';
            @endphp
        @else
            @php
                $status = '<span class="badge badge-info">Completed</span>';
                $background_color = 'bg-info';
            @endphp
        @endif
    @endif
<div class="card">
    <div class="card-body">

        <div class="session_detail text-dark">
            <b>{{ $session->name }}</b> | <span class="badge badge-light"> {{ (date("g:i A",(strtotime($session->start_time))))." - ".(date("g:i A", (strtotime($session->end_time)))) }}</span>
            <span class="pull-right">
                <b> Physician : </b> {{$session->physician->physician_code." | ".$session->physician->physician_name}}
            </span>
            <hr style="margin-top:6px; margin-bottom: 6px;">
            <div class="row">
                <div class="col-md-2">Room <span class="badge badge-secondary">{{ $session->room->short_code }}</span></div>
                <div class="col-md-2">#Slots <span class="badge badge-info">{{ $session->number_of_slots }}</span></div>
                <div class="col-md-2">Booked 
                    <span class="badge badge-success">
                        @php $a = 0; @endphp
                        @foreach($appointments as $appointment)
                            @if($appointment->is_cancelled == '1')
                            @else 
                                @php $a++; @endphp
                            @endif
                        @endforeach
                        {{$a}}
                    </span>
                </div>
                <div class="col-md-3">Amount <span class="badge badge-secondary">{{ $session->currency->short_code." ".$session->amount_per_slot }}</span></div>
                <div class="col-md-3" style="text-align:right;">
                    @php echo $status; @endphp
                </div>
            </div>
        </div>

    <div class="table-responsive-sm">
        <table class="table table-striped" id="appointments-table">
            <thead>
                <tr>
                    <th>Reference Code</th>
                    <th>Patient</th>
                    <th>App No.</th>
                    <th>App Time</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Attended</th>
                    <th>Cancelled</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($appointments as $appointment)

                <tr>
                <td>{{ $appointment->reference_code }}</td>
                <td>{{ $appointment->patient->patient_code." | ".$appointment->patient->patient_name }}</td>
                <td>{{ $appointment->appointment_number }}</td>
                <td>{{ (date("g:i A",(strtotime($appointment->appointment_time)))) }}</td>
                <td>{{ $appointment->currency->short_code." ".$appointment->amount }}</td>
                <td>
                    @if($appointment->is_paid == "1")
                        <div id="payment_status_div{{$appointment->id}}"><span class="badge badge-success">Settled</span></div>
                    @else
                        <div id="payment_status_div{{$appointment->id}}"><span class="badge badge-warning">Pending</span></div>
                    @endif
                    <input type="hidden" id="is_paid_value{{$appointment->id}}" value="{{$appointment->is_paid}}">
                </td>
                <td style="text-align:center;">
                    @if($appointment->attended_at == "" || $appointment->attended_at == null || $appointment->attended_at == "0000-00-00 00:00:00")
                        <img src="{{ URL::to('/') }}/storage/images/sys_cross_icon.png" height="15px" width="15px">
                    @else
                        <span class="badge badge-default">(date("jS M, Y g:i A", strtotime($appointment->attended_at)))</span>
                    @endif
                </td>
                <td>
                    @if($appointment->cancelled_at == "" || $appointment->cancelled_at == null || $appointment->cancelled_at == "0000-00-00 00:00:00")
                        -
                    @else
                        <span class="badge badge-default">{{(date("jS M, Y g:i A", strtotime($appointment->cancelled_at)))}}</span>
                    @endif
                </td>
                    <td>
                        {!! Form::open(['route' => ['appointments.destroy', $appointment->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('appointments.show', [$appointment->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-eye"></i></a>
                            @if($session->is_cancelled == "1")
                            @else
                                @if($session->completed_at == null || $session->completed_at == "")
                                    <a href="{{ route('appointments.edit', [$appointment->id]) }}" class="btn btn-xs btn-ghost-info"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-xs btn-ghost-warning" data-toggle="tooltip" title="payment" onclick="setPaymentAppointmentID({{$appointment->id}})"><i class="fa fa-usd" aria-hidden="true"></i></a>
                                    {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                @endif
                            @endif
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@include('appointments.payment')

@stack('scripts')
<script>

function setPaymentAppointmentID(appointmentID){

    document.getElementById('payment_appointment_id').value = appointmentID;

    var isPaid = document.getElementById('is_paid_value'+appointmentID).value;

    if(isPaid == '1'){
        //display receipt for printing
    } else {
        $('#paymentModal').modal('show');
    }

}

</script>


