<div class="form-row">
    <!-- Name Field -->
    <div class="form-group col-md-6">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
    </div>

    <!-- Short Code Field -->
    <div class="form-group col-md-6">
        {!! Form::label('short_code', 'Short Code:') !!}
        {!! Form::text('short_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div>

    <div class="form-row">

    <!-- Telephone 1 Field -->
    <div class="form-group col-md-4">
        {!! Form::label('telephone_1', 'Telephone:') !!}
        {!! Form::text('telephone_1', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Telephone 2 Field -->
    <div class="form-group col-md-4">
        {!! Form::label('telephone_2', 'Telephone:', ['style' => 'visibility:hidden;']) !!}
        {!! Form::text('telephone_2', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Telephone 3 Field -->
    <div class="form-group col-md-4">
        {!! Form::label('telephone_3', 'Telephone:', ['style' => 'visibility:hidden;']) !!}
        {!! Form::text('telephone_3', null, ['class' => 'form-control']) !!}
    </div>

</div>

<div class="form-row">
<!-- Address Field -->
<div class="form-group col-md-12">
    {!! Form::label('address', 'Address:') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>
</div>

<!-- hidden Fields -->
<div>
    {!! Form::hidden('hospital_id', session('hospital_id') , ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
</div>
