<!-- File Name Field -->
<div class="form-group">
    {!! Form::label('file_name', 'File Name:') !!}
    <p>{{ $patientFile->file_name }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $patientFile->description }}</p>
</div>

<!-- Patient Id Field -->
<div class="form-group">
    {!! Form::label('patient_id', 'Patient:') !!}
    <p>{{ $patientFile->patient->patient_code." | ".$patientFile->patient->patient_name }}</p>
</div>

<!-- Department Id Field -->
<div class="form-group">
    {!! Form::label('department_id', 'Department:') !!}
    <p>{{ $patientFile->department->description }}</p>
</div>

<!-- Disease Id Field -->
<div class="form-group">
    {!! Form::label('disease_id', 'Disease:') !!}
    <p>{{ $patientFile->disease->description }}</p>
</div>

<!-- Is Active Field -->
<div class="form-group">
    {!! Form::label('is_active', 'Is Active:') !!}
    <p>
        @if($patientFile->is_active == '1')
            <span class="badge badge-success">Active</span>
        @else 
            <span class="badge badge-success">Closed</span>
        @endif
    </p>
</div>

