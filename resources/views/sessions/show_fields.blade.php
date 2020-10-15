<!-- Physician Id Field -->
<div class="form-group">
    {!! Form::label('physician_id', 'Physician:') !!}
    <p>{{ $session->physician->physician_name }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $session->name }}</p>
</div>

<!-- Date Field -->
<div class="form-group">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $session->date }}</p>
</div>

<!-- Start Time Field -->
<div class="form-group">
    {!! Form::label('start_time', 'Start Time:') !!}
    <p>{{ $session->start_time }}</p>
</div>

<!-- End Time Field -->
<div class="form-group">
    {!! Form::label('end_time', 'End Time:') !!}
    <p>{{ $session->end_time }}</p>
</div>

<!-- Number Of Slots Field -->
<div class="form-group">
    {!! Form::label('number_of_slots', 'Number Of Slots:') !!}
    <p>{{ $session->number_of_slots }}</p>
</div>

<!-- Duration Per Slot Field -->
<div class="form-group">
    {!! Form::label('duration_per_slot', 'Duration Per Slot:') !!}
    <p>{{ $session->duration_per_slot }}</p>
</div>

<!-- Department Id Field -->
<div class="form-group">
    {!! Form::label('department_id', 'Department:') !!}
    <p>{{ $session->department->description }}</p>
</div>

<!-- Room Field -->
<div class="form-group">
    {!! Form::label('room_id', 'Room:') !!}
    <p>{{ $session->room->description }}</p>
</div>

<!-- Amount Per Slot Field -->
<div class="form-group">
    {!! Form::label('amount_per_slot', 'Amount Per Slot:') !!}
    <p>{{ $session->currency->description." ".$session->amount_per_slot }}</p>
</div>

<!-- Starts At Field -->
<div class="form-group">
    {!! Form::label('starts_at', 'Starts At:') !!}
    <p>{{ $session->starts_at }}</p>
</div>

<!-- Completed At Field -->
<div class="form-group">
    {!! Form::label('completed_at', 'Completed At:') !!}
    <p>{{ $session->completed_at }}</p>
</div>

<!-- Is Cancelled Field -->
<div class="form-group">
    {!! Form::label('is_cancelled', 'Is Cancelled:') !!}
    <p>{{ $session->is_cancelled }}</p>
</div>

