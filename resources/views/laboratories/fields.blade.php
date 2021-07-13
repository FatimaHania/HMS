<div class="form-row">
    <div class="col-sm-6">
        <div class="form-row">
            <!-- Lab Code Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('lab_code', 'Lab Code:') !!}
                {!! Form::text('lab_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'readOnly' => true]) !!}
            </div>

            <!-- Lab Number Field -->
            <div class="form-group col-sm-8">
                {!! Form::label('lab_number', 'Lab Number:') !!}
                {!! Form::number('lab_number', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <!-- Name Field -->
        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<div class="form-row">
    <!-- Short Code Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('short_code', 'Short Code:') !!}
        {!! Form::text('short_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
    </div>

    <!-- Address Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('address', 'Address:') !!}
        {!! Form::text('address', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div>

<div class="form-row">
    <!-- Telephone 1 Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('telephone_1', 'Contact Number 1:') !!}
        <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text telephone-code">{{session('user_details')[session('branch_id')]['hospitals']->telephone_code}}</div>
            </div>
            {!! Form::text('telephone_1', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>

    <!-- Telephone 2 Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('telephone_2', 'Contact Number 2:') !!}
        <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text telephone-code">{{session('user_details')[session('branch_id')]['hospitals']->telephone_code}}</div>
            </div>
            {!! Form::text('telephone_2', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<div class="form-row">
    <!-- Email Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::email('email', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
    </div>

    <!-- Is Active Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('is_active', 'Is Active:') !!}
        <label class="checkbox-inline">
            {!! Form::hidden('is_active', 0) !!}
            {!! Form::checkbox('is_active', '1', null) !!}
        </label>
    </div>
</div>

<!-- Hidden Field -->
<div>
    {!! Form::hidden('hospital_id', session('hospital_id') , ['class' => 'form-control']) !!}
    {!! Form::hidden('branch_id', session('branch_id') , ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('laboratories.index') }}" class="btn btn-secondary">Cancel</a>
</div>
