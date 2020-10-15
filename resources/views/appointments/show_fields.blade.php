<!-- Reference Number Field -->
<div class="form-group">
    {!! Form::label('reference_number', 'Reference Number:') !!}
    <p>{{ $appointment->reference_number }}</p>
</div>

<!-- Reference Code Field -->
<div class="form-group">
    {!! Form::label('reference_code', 'Reference Code:') !!}
    <p>{{ $appointment->reference_code }}</p>
</div>

<!-- Session Field -->
<div class="form-group">
    {!! Form::label('session_id', 'Session:') !!}
    <p>{{ $appointment->session->name." [".(date("jS M, Y", strtotime($appointment->session->date))). (date("g:i A",(strtotime($appointment->session->start_time))))." - ".(date("g:i A", (strtotime($appointment->session->end_time))))." ]" }}</p>
</div>

<!-- Patient Field -->
<div class="form-group">
    {!! Form::label('patient_id', 'Patient:') !!}
    <p>{{ $appointment->patient->patient_code." | ".$appointment->patient->patient_name }}</p>
</div>

<!-- Appointment Number Field -->
<div class="form-group">
    {!! Form::label('appointment_number', 'Appointment Number:') !!}
    <p>{{ $appointment->appointment_number }}</p>
</div>

<!-- Appointment Time Field -->
<div class="form-group">
    {!! Form::label('appointment_time', 'Appointment Time:') !!}
    <p>{{ $appointment->appointment_time }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $appointment->currency_id." ".$appointment->amount }}</p>
</div>

<!-- Is Paid Field -->
<div class="form-group">
    {!! Form::label('is_paid', 'Is Paid:') !!}
    <p>{{ $appointment->is_paid }}</p>
</div>

<!-- Attended At Field -->
<div class="form-group">
    {!! Form::label('attended_at', 'Attended At:') !!}
    <p>{{ $appointment->attended_at }}</p>
</div>

<!-- Cancelled At Field -->
<div class="form-group">
    {!! Form::label('cancelled_at', 'Cancelled At:') !!}
    <p>{{ $appointment->cancelled_at }}</p>
</div>

