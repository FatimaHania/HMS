<div class="form-row">
    <div class="col-md-8">
        <!-- Name Field -->
        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
        </div>

        <!-- Short Code Field -->
        <div class="form-group">
            {!! Form::label('short_code', 'Short Code:') !!}
            {!! Form::text('short_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
        </div>
    </div>

    <div class="col-md-4">
        <!-- Logo Field -->
        <div class="form-group">
        <x-inputs.image name="logo" height="125px" width="125px" class="picture" picture="logo_preview" default-image="sys_logo.png"></x-inputs.image>
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">Cancel</a>
</div>
