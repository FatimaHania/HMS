    <div class="form-row">
        <!-- Name Field -->
        <div class="form-group col-md-6">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
        </div>

        <!-- Short Code Field -->
        <div class="form-group col-md-6">
            {!! Form::label('short_code', 'Short Code:') !!}
            {!! Form::text('short_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>

    <div class="form-row">
        <!-- Country Field -->
        <div class="form-group col-md-6">
            {!! Form::label('country_id', 'Country:') !!}
            {!! Form::select('country_id', $countries ,null, ['class' => 'form-control selectpicker' , 'onchange' => 'getTelephoneCode(); getCountryCurrency()']) !!}
        </div>

        <!-- Address Field -->
        <div class="form-group col-md-6">
            {!! Form::label('address', 'Address:') !!}
            {!! Form::text('address', null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-row">

    @if(isset($branch))
        @if($branch->country_id == "" || $branch->country_id == null)
            @php $telephone_code = "000"; @endphp
        @else
            @php $telephone_code = $branch->country->telephone_code; @endphp
        @endif
    @else
        @php $telephone_code = "000"; @endphp
    @endif

    <!-- Telephone 1 Field -->
    <div class="form-group col-md-4">
        {!! Form::label('telephone_1', 'Telephone:') !!}
        <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text telephone-code">{{$telephone_code}}</div>
            </div>
            {!! Form::number('telephone_1', null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <!-- Telephone 2 Field -->
    <div class="form-group col-md-4">
        {!! Form::label('telephone_2', 'Telephone:', ['style' => 'visibility:hidden;']) !!}
        <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text telephone-code">{{$telephone_code}}</div>
            </div>
            {!! Form::text('telephone_2', null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <!-- Telephone 3 Field -->
    <div class="form-group col-md-4">
        {!! Form::label('telephone_3', 'Telephone:', ['style' => 'visibility:hidden;']) !!}
        <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text telephone-code">{{$telephone_code}}</div>
            </div>
            {!! Form::text('telephone_3', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


    <div class="form-row">
        <!-- Default Currency Field -->
        <div class="form-group col-md-6">
            {!! Form::label('default_currency_id', 'Default Currency:') !!}
            {!! Form::select('default_currency_id', $currencies ,null, ['class' => 'form-control selectpicker']) !!}
        </div>

        <!-- Reporting Currency Field -->
        <div class="form-group col-md-6">
            {!! Form::label('reporting_currency_id', 'Reporting Currency:') !!}
            {!! Form::select('reporting_currency_id', $currencies ,null, ['class' => 'form-control selectpicker']) !!}
        </div>
    </div>


<!-- hidden Fields -->
<div>
    {!! Form::hidden('hospital_id', session('hospital_id') , ['class' => 'form-control']) !!}
    {!! Form::hidden('hospital_id', session('hospital_id') , ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
</div>

@stack('scripts')
<script>

function getTelephoneCode(){

    var country_id = document.getElementById('country_id').value;

    $.ajax({
        type:'POST',
        url:"{{route('countries.getTelephoneCode')}}",
        data: {_token: "{{ csrf_token() }}" , country_id: country_id},
        beforeSend: function () { 
        },
        success:function(data) {
            $(".telephone-code").html(data);
        }
    });
}


function getCountryCurrency(){

    var country_id = document.getElementById('country_id').value;

    $.ajax({
        type:'POST',
        url:"{{route('countries.getCountryCurrency')}}",
        data: {_token: "{{ csrf_token() }}" , country_id: country_id},
        beforeSend: function () { 
        },
        success:function(data) {
            $("#default_currency_id").val(data);
            $("#reporting_currency_id").val(data);
            $('.selectpicker').selectpicker('refresh');
        }
    });

}

</script>
