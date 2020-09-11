
<div class="form-row">
<div class="col-sm-6">

    <div class="form-row">
        <!-- Patient Code Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('patient_code', 'Patient Code:') !!}
            {!! Form::text('patient_code', null, ['class' => 'form-control','readOnly'=>true]) !!}
        </div>
        <!-- Patient Number Field -->
        <div class="form-group col-sm-8">
            {!! Form::label('patient_number', 'Patient Number:') !!}
            {!! Form::number('patient_number', null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-row">
        <!-- Title Id Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('title_id', 'Title:') !!}
            {!! Form::select('title_id' , $titles , null, ['class' => 'form-control']) !!}
        </div>
        <!-- Patient Name Field -->
        <div class="form-group col-sm-8">
            {!! Form::label('patient_name', 'Patient Name:') !!}
            {!! Form::text('patient_name', null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <!-- Gender Id Field -->
    <div class="form-group">
        {!! Form::label('gender_id', 'Gender:') !!}
        {!! Form::select('gender_id' , $genders , null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Patient Image Field -->
<div class="col-sm-6">
    <x-inputs.image name="patient_image" height="200px" width="220px" class="picture" picture="user_preview" default-image="sys_user.png"></x-inputs.image>
</div>

</div>

<div class="form-row">

<!-- Dob Field -->
<div class="form-group col-sm-6">
        {!! Form::label('dob', 'DOB:') !!}
        {!! Form::date('dob', null, ['class' => 'form-control','id'=>'dob']) !!}
    </div>

    @stack('scripts')
    <script type="text/javascript">
            $('#dob').datetimepicker({
                format: "{{ config('app.date_format_javascript') }}",
                useCurrent: true,
                icons: {
                    up: "icon-arrow-up-circle icons font-2xl",
                    down: "icon-arrow-down-circle icons font-2xl"
                },
                sideBySide: true
            })
        </script>

<!-- Dod Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dod', 'DOD:') !!}
    {!! Form::date('dod', null, ['class' => 'form-control','id'=>'dod']) !!}
</div>

@stack('scripts')
   <script type="text/javascript">
           $('#dod').datetimepicker({
               format: "{{ config('app.date_format_javascript') }}",
               useCurrent: true,
               icons: {
                   up: "icon-arrow-up-circle icons font-2xl",
                   down: "icon-arrow-down-circle icons font-2xl"
               },
               sideBySide: true
           })
       </script>


</div>


<div class="form-row">
    <!-- Country Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('country_id', 'Country:') !!}
        {!! Form::select('country_id' , $countries , null, ['class' => 'form-control']) !!}
    </div>

    <!-- Nationality Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('nationality_id', 'Nationality:') !!}
        {!! Form::select('nationality_id' , $nationalities , null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-row">
    <!-- Passport No Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('passport_no', 'Passport No:') !!}
        {!! Form::text('passport_no', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Bloodgroup Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('bloodgroup_id', 'Bloodgroup:') !!}
        {!! Form::select('bloodgroup_id' , $bloodgroups , null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-row">
    <!-- Mobile Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('mobile', 'Mobile:') !!}
        {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Telephone Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('telephone', 'Telephone:') !!}
        {!! Form::text('telephone', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-row">
    <!-- Address Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('address', 'Address:') !!}
        {!! Form::text('address', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Email Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
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
    <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
</div>
