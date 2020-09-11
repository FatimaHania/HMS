<div class="form-row">
    <!-- Description Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('description', 'Description:') !!}
        {!! Form::text('description', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255,'readOnly'=>true]) !!}
    </div>
</div>

<div class="form-row">

    <!-- Prefix Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('prefix', 'Prefix:') !!}
        {!! Form::text('prefix', null, ['class' => 'form-control','maxlength' => 10,'maxlength' => 10,'maxlength' => 10]) !!}
    </div>

    <!-- Starting No Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('starting_no', 'Starting No:') !!}
        {!! Form::number('starting_no', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-row">

    <!-- Format Length Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('format_length', 'Format Length:') !!}
        {!! Form::number('format_length', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Common Difference Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('common_difference', 'Common Difference:') !!}
        {!! Form::number('common_difference', null, ['class' => 'form-control']) !!}
    </div>
</div>



<!-- Hidden Feilds -->
<div>
    {!! Form::hidden('hospital_id', null, ['class' => 'form-control']) !!}
    {!! Form::hidden('branch_id', null, ['class' => 'form-control']) !!}
    {!! Form::hidden('documentcode_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('documentCodes.index') }}" class="btn btn-secondary">Cancel</a>
</div>
