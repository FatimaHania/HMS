<!-- Reference Code Field -->
<div class="form-row">
    <div class="form-group col-sm-6">
        {!! Form::label('reference_code', 'Reference Code:') !!}
        {!! Form::text('reference_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'readOnly'=>true]) !!}
    </div>

    <!-- Patient Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('patient_id', 'Patient:') !!}
        {!! Form::select('patient_id', $patient, null, ['class' => 'form-control selectpicker']) !!}
    </div>
</div>

<div class="form-row">
    <div class="col-sm-6">
        <!-- Appointment Number Field -->
        @php $taken_appointment_slots = array(); @endphp
        @foreach($session_detail->appointment as $session_appointment)
            @php $taken_appointment_slots[] = $session_appointment->appointment_number; @endphp
        @endforeach
        <div class="form-row">
            <div class="form-group col-sm-6">
                {!! Form::label('appointment_number', 'Appointment Number:') !!}
                <select class="form-control selectpicker" id="appointment_number" name="appointment_number" onchange="changeAppointmentTime(this)">
                    @for($i=1; $i<=($session_detail->number_of_slots); $i++)
                        @if(in_array($i,$taken_appointment_slots))
                            @if($i == $appointment->appointment_number)
                                <option value="{{$i}}" selected="selected">{{$i}}</option>
                            @endif
                        @else
                            <option value="{{$i}}">{{$i}}</option>
                        @endif
                    @endfor
                </select>
            </div>

            <!-- Appointment Time Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('appointment_time', 'Appointment Time:') !!}
                {!! Form::text('appointment_time', null, ['class' => 'form-control timepicker']) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="col-auto">
        {!! Form::label('amount', 'Amount:') !!}
        <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text">{{$appointment->currency->short_code}}</div>
            </div>
            {!! Form::number('amount', null, ['class' => 'form-control' , 'min' => '0' , 'step' => '0.01' , 'id' => 'amount']) !!}
        </div>
        </div>
    </div>
</div>

<!-- Is Paid Field -->
<div class="form-row">
    <div class="form-group col-sm-6">
        {!! Form::label('is_paid', 'Is Paid:') !!}
        <label class="checkbox-inline">
            {!! Form::hidden('is_paid', 0) !!}
            {!! Form::checkbox('is_paid', '1', null) !!}
        </label>
    </div>
</div>

<!-- Hidden Fields -->
<div>
    {!! Form::hidden('reference_number', null, ['class' => 'form-control']) !!}
    {!! Form::hidden('session_id', null, ['class' => 'form-control']) !!}
    {!! Form::hidden('currency_id', null, ['class' => 'form-control']) !!}
    {!! Form::hidden('hospital_id',  session('hospital_id') , ['class' => 'form-control']) !!}
    {!! Form::hidden('branch_id', session('branch_id') , ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
</div>

@stack('scripts')
<script>

    $(document).ready(function(){

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

    function changeAppointmentTime(x){

        var appointment_number = document.getElementById('appointment_number').value;
        var duration_per_slot = "{{$session_detail->duration_per_slot}}";
        var start_time = "{{$session_detail->start_time}}";
        var session_date = "{{date('Y-m-d', strtotime($session_detail->date))}}";
        var new_appointment_time = new Date(new Date(session_date+" "+start_time).getTime() + (duration_per_slot*(appointment_number-1))*60000);

        document.getElementById('appointment_time').value = (("0"+(new_appointment_time.getHours())).slice(-2)) + ":" + (("0"+(new_appointment_time.getMinutes())).slice(-2)) + ":" + (("0"+(new_appointment_time.getSeconds())).slice(-2));

        
    }

</script>
