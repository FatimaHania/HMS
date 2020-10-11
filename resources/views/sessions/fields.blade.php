<div class="row">
    <!-- Physician Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('physician_id', 'Physician:') !!}
        {!! Form::select('physician_id', $physicians, null, ['class' => 'selectpicker myClass form-control']) !!}
    </div>

    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div>

<div class="row">
    <!-- Date Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('date', 'Date:') !!}
        {!! Form::text('date', null, ['class' => 'form-control','id'=>'date']) !!}
    </div>

    @push('scripts')
    <script type="text/javascript">
            $('#date').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                useCurrent: true,
                icons: {
                    up: "icon-arrow-up-circle icons font-2xl",
                    down: "icon-arrow-down-circle icons font-2xl"
                },
                sideBySide: true
            })
        </script>
    @endpush

    <div class="col-sm-6">
        <div class="row">
            <!-- Start Time Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('start_time', 'Start Time:') !!}
                {!! Form::text('start_time', null, ['class' => 'form-control']) !!}
            </div>

            <!-- End Time Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('end_time', 'End Time:') !!}
                {!! Form::text('end_time', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Number Of Slots Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('number_of_slots', 'Number Of Slots:') !!}
        {!! Form::number('number_of_slots', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Duration Per Slot Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('duration_per_slot', 'Duration Per Slot:') !!}
        {!! Form::number('duration_per_slot', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <!-- Department Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('department_id', 'Department:') !!}
        {!! Form::select('department_id', $departments ,null, ['class' => 'selectpicker form-control']) !!}
    </div>

    <!-- Room Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('room_id', 'Room:') !!}
        {!! Form::select('room_id', $rooms, null, ['class' => 'selectpicker form-control']) !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <!-- Currency Id Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('currency_id', 'Currency:') !!}
                {!! Form::select('currency_id', $currencies, null, ['class' => 'selectpicker form-control']) !!}
            </div>

            <!-- Amount Per Slot Field -->
            <div class="form-group col-sm-8">
                {!! Form::label('amount_per_slot', 'Amount Per Slot:') !!}
                {!! Form::number('amount_per_slot', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>                      

    <!-- Starts At Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('starts_at', 'Starts At:') !!}
        {!! Form::text('starts_at', null, ['class' => 'form-control','id'=>'starts_at']) !!}
    </div>

    @push('scripts')
    <script type="text/javascript">
            $('#starts_at').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                useCurrent: true,
                icons: {
                    up: "icon-arrow-up-circle icons font-2xl",
                    down: "icon-arrow-down-circle icons font-2xl"
                },
                sideBySide: true
            })
        </script>
    @endpush
</div>

<div class="row">
    <!-- Completed At Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('completed_at', 'Completed At:') !!}
        {!! Form::text('completed_at', null, ['class' => 'form-control','id'=>'completed_at']) !!}
    </div>

    @push('scripts')
    <script type="text/javascript">
            $('#completed_at').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                useCurrent: true,
                icons: {
                    up: "icon-arrow-up-circle icons font-2xl",
                    down: "icon-arrow-down-circle icons font-2xl"
                },
                sideBySide: true
            })
        </script>
    @endpush


    <!-- Is Cancelled Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('is_cancelled', 'Is Cancelled:') !!}
        <label class="checkbox-inline">
            {!! Form::hidden('is_cancelled', 0) !!}
            {!! Form::checkbox('is_cancelled', '1', null) !!}
        </label>
    </div>


</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('sessions.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>
