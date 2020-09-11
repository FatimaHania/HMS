<!-- Physician Code Field -->
<div class="form-group">
    {!! Form::label('physician_code', 'Physician Code:') !!}
    <p>{{ $physician->physician_code }}</p>
</div>

<!-- Physician Name Field -->
<div class="form-group">
    {!! Form::label('physician_name', 'Physician Name:') !!}
    <p>{{ $physician->physician_name }}</p>
</div>

<!-- Physician Image Field -->
<div class="form-group">
    {!! Form::label('physician_image', 'Physician Image:') !!}
    <p><div class="avatar"><img class="avatar-lg" src="{{asset('storage/'.$physician->physician_image)}}" alt="user@email.com"></div></p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title_id', 'Title Id:') !!}
    <p>{{ $physician->title->description }}</p>
</div>

<!-- Gender Field -->
<div class="form-group">
    {!! Form::label('gender_id', 'Gender Id:') !!}
    <p>{{ $physician->gender->description }}</p>
</div>

<!-- Dob Field -->
<div class="form-group">
    {!! Form::label('dob', 'Dob:') !!}
    <p>{{ Carbon::parse($physician->dob)->format(config('app.date_format')) }}</p>
</div>

<!-- Country Field -->
<div class="form-group">
    {!! Form::label('country_id', 'Country Id:') !!}
    <p>{{ $physician->country->description }}</p>
</div>

<!-- Nationality Field -->
<div class="form-group">
    {!! Form::label('nationality_id', 'Nationality Id:') !!}
    <p>{{ $physician->nationality->description }}</p>
</div>

<!-- Passport No Field -->
<div class="form-group">
    {!! Form::label('passport_no', 'Passport No:') !!}
    <p>{{ $physician->passport_no }}</p>
</div>

<!-- Mobile Field -->
<div class="form-group">
    {!! Form::label('mobile', 'Mobile:') !!}
    <p>{{ $physician->mobile }}</p>
</div>

<!-- Telephone Field -->
<div class="form-group">
    {!! Form::label('telephone', 'Telephone:') !!}
    <p>{{ $physician->telephone }}</p>
</div>

<!-- Address Field -->
<div class="form-group">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $physician->address }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $physician->email }}</p>
</div>

