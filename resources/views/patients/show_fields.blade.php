<!-- Patient Code Field -->
<div class="form-group">
    {!! Form::label('patient_code', 'Patient Code:') !!}
    <p>{{ $patient->patient_code }}</p>
</div>

<!-- Patient Name Field -->
<div class="form-group">
    {!! Form::label('patient_name', 'Patient Name:') !!}
    <p>{{ $patient->patient_name }}</p>
</div>

<!-- Patient Image Field -->
<div class="form-group">
    {!! Form::label('patient_image', 'Patient Image:') !!}
    <p><div class="avatar"><img class="avatar-lg" src="{{asset('storage/'.$patient->patient_image)}}" alt="user@email.com"></div></p>
</div>

<!-- Title Id Field -->
<div class="form-group">
    {!! Form::label('title_id', 'Title:') !!}
    <p>{{ $patient->title->description }}</p>
</div>

<!-- Gender Id Field -->
<div class="form-group">
    {!! Form::label('gender_id', 'Gender:') !!}
    <p>{{ $patient->gender->description }}</p>
</div>

<!-- Dob Field -->
<div class="form-group">
    {!! Form::label('dob', 'DOB:') !!}
    <p>{{ Carbon::parse($patient->dob)->format(config('app.date_format')) }}</p>
</div>

<!-- Dod Field -->
<div class="form-group">
    {!! Form::label('dod', 'DOD:') !!}
    <p>{{ Carbon::parse($patient->dod)->format(config('app.date_format')) }}</p>
</div>

<!-- Country Id Field -->
<div class="form-group">
    {!! Form::label('country_id', 'Country:') !!}
    <p>{{ $patient->country->description }}</p>
</div>

<!-- Nationality Id Field -->
<div class="form-group">
    {!! Form::label('nationality_id', 'Nationality:') !!}
    <p>{{ $patient->nationality->description }}</p>
</div>

<!-- Passport No Field -->
<div class="form-group">
    {!! Form::label('passport_no', 'Passport No:') !!}
    <p>{{ $patient->passport_no }}</p>
</div>

<!-- Mobile Field -->
<div class="form-group">
    {!! Form::label('mobile', 'Mobile:') !!}
    <p>{{ $patient->mobile }}</p>
</div>

<!-- Telephone Field -->
<div class="form-group">
    {!! Form::label('telephone', 'Telephone:') !!}
    <p>{{ $patient->telephone }}</p>
</div>

<!-- Address Field -->
<div class="form-group">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $patient->address }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $patient->email }}</p>
</div>

<!-- Bloodgroup Id Field -->
<div class="form-group">
    {!! Form::label('bloodgroup_id', 'Bloodgroup:') !!}
    <p>{{ $patient->bloodgroup->description }}</p>
</div>
