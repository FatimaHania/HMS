<!-- Short Code Field -->
<div class="form-group">
    {!! Form::label('short_code', 'Short Code:') !!}
    <p>{{ $room->short_code }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $room->description }}</p>
</div>

<!-- Sort Order Field -->
<div class="form-group">
    {!! Form::label('sort_order', 'Sort Order:') !!}
    <p>{{ $room->sort_order }}</p>
</div>

