<!-- Nurse Number Field -->
<div class="form-group">
    {!! Form::label('nurse_number', 'Nurse Number:') !!}
    <p>{{ $nurse->nurse_number }}</p>
</div>

<!-- Nurse Code Field -->
<div class="form-group">
    {!! Form::label('nurse_code', 'Nurse Code:') !!}
    <p>{{ $nurse->nurse_code }}</p>
</div>

<!-- Nurse Name Field -->
<div class="form-group">
    {!! Form::label('nurse_name', 'Nurse Name:') !!}
    <p>{{ $nurse->nurse_name }}</p>
</div>

<!-- Nurse Image Field -->
<div class="form-group">
    {!! Form::label('nurse_image', 'Nurse Image:') !!}
    <p><div class="avatar"><img class="avatar-lg" src="{{asset('storage/'.$nurse->nurse_image)}}" alt="user@email.com"></div></p>
</div>

<!-- Title Id Field -->
<div class="form-group">
    {!! Form::label('title_id', 'Title Id:') !!}
    <p>{{ $nurse->title->description }}</p>
</div>

<!-- Gender Id Field -->
<div class="form-group">
    {!! Form::label('gender_id', 'Gender Id:') !!}
    <p>{{ $nurse->gender->description }}</p>
</div>

<!-- Dob Field -->
<div class="form-group">
    {!! Form::label('dob', 'Dob:') !!}
    <p>{{ $nurse->dob }}</p>
</div>

<!-- Country Id Field -->
<div class="form-group">
    {!! Form::label('country_id', 'Country Id:') !!}
    <p>{{ $nurse->country->description }}</p>
</div>

<!-- Nationality Id Field -->
<div class="form-group">
    {!! Form::label('nationality_id', 'Nationality Id:') !!}
    <p>{{ $nurse->nationality->description }}</p>
</div>

<!-- Passport No Field -->
<div class="form-group">
    {!! Form::label('passport_no', 'Passport No:') !!}
    <p>{{ $nurse->passport_no }}</p>
</div>

<!-- Mobile Field -->
<div class="form-group">
    {!! Form::label('mobile', 'Mobile:') !!}
    <p>{{ $nurse->mobile }}</p>
</div>

<!-- Telephone Field -->
<div class="form-group">
    {!! Form::label('telephone', 'Telephone:') !!}
    <p>{{ $nurse->telephone }}</p>
</div>

<!-- Address Field -->
<div class="form-group">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $nurse->address }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $nurse->email }}</p>
</div>

