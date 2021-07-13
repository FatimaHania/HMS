
<div class="form-row">
    <div class="col-sm-6">
        <div class="form-row">
            <!-- Pharmacy Code Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('pharmacy_code', 'Pharmacy Code:') !!}
                {!! Form::text('pharmacy_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'readOnly' => true]) !!}
            </div>

            <!-- Pharmacy Number Field -->
            <div class="form-group col-sm-8">
                {!! Form::label('pharmacy_number', 'Pharmacy Number:') !!}
                {!! Form::number('pharmacy_number', null, ['class' => 'form-control']) !!}
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
    <div class="col-sm-6">
        <!-- Short Code Field -->
        <div class="form-group">
            {!! Form::label('short_code', 'Short Code:') !!}
            {!! Form::text('short_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <!-- Address Field -->
        <div class="form-group">
            {!! Form::label('address', 'Address:') !!}
            {!! Form::text('address', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-sm-6">
        <!-- Telephone 1 Field -->
        <div class="form-group">
            {!! Form::label('telephone_1', 'Contact Number 1:') !!}
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                <div class="input-group-text telephone-code">{{session('user_details')[session('branch_id')]['hospitals']->telephone_code}}</div>
                </div>
                {!! Form::text('telephone_1', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <!-- Telephone 2 Field -->
        <div class="form-group">
            {!! Form::label('telephone_2', 'Contact Number 2:') !!}
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                <div class="input-group-text telephone-code">{{session('user_details')[session('branch_id')]['hospitals']->telephone_code}}</div>
                </div>
                {!! Form::text('telephone_2', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-sm-6">
        <!-- Email Field -->
        <div class="form-group">
            {!! Form::label('email', 'Email:') !!}
            {!! Form::email('email', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <!-- Is Active Field -->
        <div class="form-group">
            {!! Form::label('is_active', 'Is Active:') !!}
            <label class="checkbox-inline">
                {!! Form::hidden('is_active', 0) !!}
                {!! Form::checkbox('is_active', '1', null) !!}
            </label>
        </div>
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
    <a href="{{ route('pharmacies.index') }}" class="btn btn-secondary">Cancel</a>
</div>
