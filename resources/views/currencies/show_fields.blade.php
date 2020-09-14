<!-- Short Code Field -->
<div class="form-group">
    {!! Form::label('short_code', 'Short Code:') !!}
    <p>{{ $currency->short_code }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $currency->description }}</p>
</div>

<!-- Decimal Places Field -->
<div class="form-group">
    {!! Form::label('decimal_places', 'Decimal Places:') !!}
    <p>{{ $currency->decimal_places }}</p>
</div>

<!-- Exchange Rate Field -->
<div class="form-group">
    {!! Form::label('exchange_rate', 'Exchange Rate:') !!}
    <p>{{ $currency->exchange_rate }}</p>
</div>

<!-- Is Default Field -->
<div class="form-group">
    {!! Form::label('is_default', 'Is Default:') !!}
    <p>{{ $currency->is_default }}</p>
</div>


