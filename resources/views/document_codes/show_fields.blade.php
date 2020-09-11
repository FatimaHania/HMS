<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $documentCode->description }}</p>
</div>

<!-- Prefix Field -->
<div class="form-group">
    {!! Form::label('prefix', 'Prefix:') !!}
    <p>{{ $documentCode->prefix }}</p>
</div>

<!-- Starting No Field -->
<div class="form-group">
    {!! Form::label('starting_no', 'Starting No:') !!}
    <p>{{ $documentCode->starting_no }}</p>
</div>

<!-- Format Length Field -->
<div class="form-group">
    {!! Form::label('format_length', 'Format Length:') !!}
    <p>{{ $documentCode->format_length }}</p>
</div>

<!-- Common Difference Field -->
<div class="form-group">
    {!! Form::label('common_difference', 'Common Difference:') !!}
    <p>{{ $documentCode->common_difference }}</p>
</div>

