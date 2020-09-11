<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $hospital->name }}</p>
</div>

<!-- Short Code Field -->
<div class="form-group">
    {!! Form::label('short_code', 'Short Code:') !!}
    <p>{{ $hospital->short_code }}</p>
</div>

<!-- Logo Field -->
<div class="form-group">
    {!! Form::label('logo', 'Logo:') !!}
    <p>{{ $hospital->logo }}</p>
</div>

