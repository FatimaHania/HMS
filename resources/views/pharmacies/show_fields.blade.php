<!-- Pharmacy Number Field -->
<div class="form-group">
    {!! Form::label('pharmacy_number', 'Pharmacy Number:') !!}
    <p>{{ $pharmacy->pharmacy_number }}</p>
</div>

<!-- Pharmacy Code Field -->
<div class="form-group">
    {!! Form::label('pharmacy_code', 'Pharmacy Code:') !!}
    <p>{{ $pharmacy->pharmacy_code }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $pharmacy->name }}</p>
</div>

<!-- Short Code Field -->
<div class="form-group">
    {!! Form::label('short_code', 'Short Code:') !!}
    <p>{{ $pharmacy->short_code }}</p>
</div>

<!-- Address Field -->
<div class="form-group">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $pharmacy->address }}</p>
</div>

<!-- Telephone 1 Field -->
<div class="form-group">
    {!! Form::label('telephone_1', 'Telephone 1:') !!}
    <p>{{ $pharmacy->telephone_1 }}</p>
</div>

<!-- Telephone 2 Field -->
<div class="form-group">
    {!! Form::label('telephone_2', 'Telephone 2:') !!}
    <p>{{ $pharmacy->telephone_2 }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $pharmacy->email }}</p>
</div>

<!-- Is Active Field -->
<div class="form-group">
    {!! Form::label('is_active', 'Is Active:') !!}
    <p>
        @if($pharmacy->is_active == '1')
            <span class="badge badge-success">Active</span>
        @else
            <span class="badge badge-danger">Inactive</span>
        @endif
    </p>
</div>
