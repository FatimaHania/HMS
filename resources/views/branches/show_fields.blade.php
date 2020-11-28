            @if(isset($branch))
                @if($branch->country_id == "" || $branch->country_id == null)
                    @php $telephone_code = "000"; @endphp
                @else
                    @php $telephone_code = $branch->country->telephone_code; @endphp
                @endif
            @else
                @php $telephone_code = "000"; @endphp
            @endif
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
    <p>{{ $telephone_code."-".$branch->telephone_1 }}</p>
</div>

<!-- Telephone 2 Field -->
<div class="form-group">
    {!! Form::label('telephone_2', 'Telephone 2:') !!}
    <p>{{ $telephone_code."-".$branch->telephone_2 }}</p>
</div>

<!-- Telephone 3 Field -->
<div class="form-group">
    {!! Form::label('telephone_3', 'Telephone 3:') !!}
    <p>{{ $telephone_code."-".$branch->telephone_3 }}</p>
</div>

<!-- Address Field -->
<div class="form-group">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $branch->address }}</p>
</div>

<!-- Default Currency -->
<div class="form-group">
    {!! Form::label('default_currency', 'Default Currency:') !!}
    <p>{{ $branch->default_currency->short_code }}</p>
</div>

<!-- Reporting Currency -->
<div class="form-group">
    {!! Form::label('reporting_currency', 'Reporting Currency:') !!}
    <p>{{ $branch->reporting_currency->short_code }}</p>
</div>


