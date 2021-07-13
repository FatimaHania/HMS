<!-- Lab Number Field -->
<div class="form-group">
    {!! Form::label('lab_number', 'Lab Number:') !!}
    <p>{{ $laboratory->lab_number }}</p>
</div>

<!-- Lab Code Field -->
<div class="form-group">
    {!! Form::label('lab_code', 'Lab Code:') !!}
    <p>{{ $laboratory->lab_code }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $laboratory->name }}</p>
</div>

<!-- Short Code Field -->
<div class="form-group">
    {!! Form::label('short_code', 'Short Code:') !!}
    <p>{{ $laboratory->short_code }}</p>
</div>

<!-- Address Field -->
<div class="form-group">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $laboratory->address }}</p>
</div>

<!-- Telephone 1 Field -->
<div class="form-group">
    {!! Form::label('telephone_1', 'Telephone 1:') !!}
    <p>{{ $laboratory->telephone_1 }}</p>
</div>

<!-- Telephone 2 Field -->
<div class="form-group">
    {!! Form::label('telephone_2', 'Telephone 2:') !!}
    <p>{{ $laboratory->telephone_2 }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $laboratory->email }}</p>
</div>

<!-- Is Active Field -->
<div class="form-group">
    {!! Form::label('is_active', 'Is Active:') !!}
    <p>
        @if($laboratory->is_active == '1')
            <span class="badge badge-success">Active</span>
        @else
            <span class="badge badge-danger">Inactive</span>
        @endif
    </p>
</div>

