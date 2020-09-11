<div class="form-row">
    <!-- Short Code Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('short_code', 'Short Code:') !!}
        {!! Form::text('short_code', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Description Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('description', 'Description:') !!}
        {!! Form::text('description', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Hidden Fields -->
<div>
    {!! Form::hidden('hospital_id',  session('hospital_id') , ['class' => 'form-control']) !!}
    {!! Form::hidden('branch_id', session('branch_id') , ['class' => 'form-control']) !!}
</div>

<div class="form-row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('nationalities.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>
