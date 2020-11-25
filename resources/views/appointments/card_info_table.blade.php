    @if($session->is_cancelled == "1")
        @php
            $status = '<button type="button" class="btn btn-xs btn-danger disabled">Cancelled</button>';
            $background_color = 'bg-danger';
        @endphp
    @else 
        @if($session->completed_at == null || $session->completed_at == "")
            @php
                $status = '<button type="button" class="btn btn-xs btn-light disabled">Pending</button>';
                $background_color = 'bg-secondary';
            @endphp
        @else
            @php
                $status = '<button type="button" class="btn btn-xs btn-primary disabled">Completed</button>';
                $background_color = 'bg-info';
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
                            <tr><td><div class="bg-light text-dark" style="padding:2px; font-weight:bold; font-size:16px; width:100px; margin:6px; border-radius:4px;">{{ count($session->appointment)}} <small class="text-muted">Booked</small></div></td></tr>
                            <tr><td><div class="bg-light text-dark" style="padding:2px; font-weight:bold; font-size:16px; width:100px; margin:6px; border-radius:4px;">{{ $session->number_of_slots }} <small class="text-muted">Total slots</small></div></td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr style="margin:2px;">
@if(!($session->appointment)->isEmpty())
<table width="100%" class="table table-borderless table-striped">
    <tr>
        <th>#Slot</th>
        <th>Reference No.</th>
        <th style="width:75%;">Patient</th>
        <th>Time</th>
    </tr>
    @foreach($session->appointment->sortBy('appointment_number') as $appointment)
    <tr>
            <td>{{ $appointment->appointment_number }}</td>
            <td>{{ $appointment->reference_code }}</td>
            <td>{{ $appointment->patient->patient_code." | ".$appointment->patient->patient_name }}</td>
            <td>
                @if($appointment->appointment_time  == "" || $appointment->appointment_time == null || $appointment->appointment_time == "00:00:00")
                   @php 
                        $start_time = strtotime($session->start_time);
                        $difference = ($session->duration_per_slot)*(($appointment->appointment_number)-1);
                   @endphp

                   {{ date("H:i:s", strtotime('+'.$difference.' minutes', $start_time)) }}
                @else
                    {{ $appointment->appointment_time }}
                @endif
            </td>
    </tr>
    @endforeach
</table>
@else
    <br>
    <div class="text-center">
        <span class="badge badge-secondary">
            No Appointments
        </span>
    </div>
@endif