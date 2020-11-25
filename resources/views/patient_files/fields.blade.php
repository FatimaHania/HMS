<!-- Patient Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('patient_id', 'Patient:') !!}
    <select class="selectpicker form-control" id="patient_id" name="patient_id" data-live-search="true">
        @foreach($patients as $patient)
            <option value="{{$patient->id}}">
            {{$patient->patient_code." | ".$patient->patient_name}}
            </option>
        @endforeach
    </select>
</div>

<!-- File Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('file_name', 'File Name:') !!}
    {!! Form::text('file_name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Department Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('department_id', 'Department:') !!}
    {!! Form::select('department_id', $departments, null, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) !!}
</div>

<!-- Disease Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('disease_id', 'Disease:') !!}
    {!! Form::select('disease_id', $diseases, null, ['class' => 'form-control selectpicker', 'data-live-search' => 'true']) !!}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_active', 'Is Active:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', '1', null) !!}
    </label>
</div>


<!-- Hidden Field -->
<div>
    {!! Form::hidden('hospital_id', session('hospital_id') , ['class' => 'form-control']) !!}
    {!! Form::hidden('branch_id', session('branch_id') , ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('patientFiles.index') }}" class="btn btn-secondary">Cancel</a>
</div>
