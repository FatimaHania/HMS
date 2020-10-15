<!-- Reference Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reference_number', 'Reference Number:') !!}
    {!! Form::number('reference_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Reference Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reference_code', 'Reference Code:') !!}
    {!! Form::text('reference_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'readOnly'=>true]) !!}
</div>

<!-- Session Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('session_id', 'Session:') !!}
    {!! Form::select('session_id', $session, null, ['class' => 'form-control selectpicker']) !!}
</div>

<!-- Patient Field -->
<div class="form-group col-sm-6">
    {!! Form::label('patient_id', 'Patient:') !!}
    {!! Form::select('patient_id', $patient, null, ['class' => 'form-control selectpicker']) !!}
</div>

<!-- Appointment Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('appointment_number', 'Appointment Number:') !!}
    {!! Form::number('appointment_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Appointment Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('appointment_time', 'Appointment Time:') !!}
    {!! Form::text('appointment_time', null, ['class' => 'form-control']) !!}
</div>

<!-- Currency Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('currency_id', 'Currency:') !!}
    {!! Form::select('currency_id', $currency, null, ['class' => 'form-control selectpicker']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control' , 'min' => '0' , 'step' => '0.01']) !!}
</div>

<!-- Is Paid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_paid', 'Is Paid:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_paid', 0) !!}
        {!! Form::checkbox('is_paid', '1', null) !!}
    </label>
</div>


<!-- Attended At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('attended_at', 'Attended At:') !!}
    {!! Form::text('attended_at', null, ['class' => 'form-control','id'=>'attended_at']) !!}
</div>

@push('scripts')
   <script type="text/javascript">
           $('#attended_at').datetimepicker({
               format: 'YYYY-MM-DD HH:mm:ss',
               useCurrent: true,
               icons: {
                   up: "icon-arrow-up-circle icons font-2xl",
                   down: "icon-arrow-down-circle icons font-2xl"
               },
               sideBySide: true
           })
       </script>
@endpush


<!-- Cancelled At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cancelled_at', 'Cancelled At:') !!}
    {!! Form::text('cancelled_at', null, ['class' => 'form-control','id'=>'cancelled_at']) !!}
</div>

@push('scripts')
   <script type="text/javascript">
           $('#cancelled_at').datetimepicker({
               format: 'YYYY-MM-DD HH:mm:ss',
               useCurrent: true,
               icons: {
                   up: "icon-arrow-up-circle icons font-2xl",
                   down: "icon-arrow-down-circle icons font-2xl"
               },
               sideBySide: true
           })
       </script>
@endpush

<!-- Hidden Fields -->
<div>
    {!! Form::hidden('hospital_id',  session('hospital_id') , ['class' => 'form-control']) !!}
    {!! Form::hidden('branch_id', session('branch_id') , ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
</div>
