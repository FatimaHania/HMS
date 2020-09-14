<!-- Short Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('short_code', 'Short Code:') !!}
    {!! Form::text('short_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Decimal Places Field -->
<div class="form-group col-sm-6">
    {!! Form::label('decimal_places', 'Decimal Places:') !!}
    {!! Form::number('decimal_places', null, ['class' => 'form-control']) !!}
</div>

<!-- Exchange Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('exchange_rate', 'Exchange Rate:') !!}
    {!! Form::number('exchange_rate', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Default Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_default', 'Is Default:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_default', 0 , ['class' => 'is_default']) !!}
        {!! Form::checkbox('is_default', '1', null) !!}
    </label>
</div>

<!-- Hidden Fields -->
<div>
    {!! Form::hidden('hospital_id',  session('hospital_id') , ['class' => 'form-control']) !!}
    {!! Form::hidden('branch_id', session('branch_id') , ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Cancel</a>
</div>

@stack('scripts')
<script>

    $(document).ready(function () {

        $("[name='is_default']input:checkbox").change(function() {
            var ischecked= $(this).is(':checked');
            if(!ischecked) {
                document.getElementsByClassName('is_default')[0].value = '0';
            } else {
                document.getElementsByClassName('is_default')[0].value = '1';
            }
         }); 

    });

</script>
