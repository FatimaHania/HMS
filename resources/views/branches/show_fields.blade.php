<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $branch->name }}</p>
</div>

<!-- Short Code Field -->
<div class="form-group">
    {!! Form::label('short_code', 'Short Code:') !!}
    <p>{{ $branch->short_code }}</p>
</div>

<!-- Telephone 1 Field -->
<div class="form-group">
    {!! Form::label('telephone_1', 'Telephone 1:') !!}
    <p>{{ $branch->telephone_1 }}</p>
</div>

<!-- Telephone 2 Field -->
<div class="form-group">
    {!! Form::label('telephone_2', 'Telephone 2:') !!}
    <p>{{ $branch->telephone_2 }}</p>
</div>

<!-- Telephone 3 Field -->
<div class="form-group">
    {!! Form::label('telephone_3', 'Telephone 3:') !!}
    <p>{{ $branch->telephone_3 }}</p>
</div>

<!-- Address Field -->
<div class="form-group">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $branch->address }}</p>
</div>

