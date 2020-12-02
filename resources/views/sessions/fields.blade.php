<div class="row">
    <!-- Physician Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('physician_id', 'Physician:') !!}
        {!! Form::select('physician_id', $physicians ,null, ['class' => 'selectpicker form-control' , 'title' => 'Select Physician']) !!}
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
                format: 'YYYY-MM-DD',
                useCurrent: true,
                icons: {
                    up: "icon-arrow-up-circle icons font-2xl",
                    down: "icon-arrow-down-circle icons font-2xl"
                },
                sideBySide: true
            })
        </script>
    @endpush

            <!-- Start Time Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('appointment_time', 'Time (start - end):') !!}
                <input type="text" class="form-control" name="appointment_time" id="appointment_time">

                {!! Form::hidden('start_time', null, ['class' => 'form-control' , 'id' => 'start_time']) !!}
                {!! Form::hidden('end_time', null, ['class' => 'form-control' , 'id' => 'end_time']) !!}
            </div> 
</div>

<div class="row">
    <!-- Number Of Slots Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('number_of_slots', 'Number Of Slots:') !!}
        {!! Form::number('number_of_slots', null, ['class' => 'form-control' , 'id' => 'number_of_slots' , 'onchange' => 'calculateDurationPerSlot()']) !!}
    </div>

    <!-- Duration Per Slot Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('duration_per_slot', 'Duration Per Slot (in minutes):') !!}
        {!! Form::number('duration_per_slot', null, ['class' => 'form-control' , 'id' => 'duration_per_slot']) !!}
    </div>
</div>

<div class="row">
    <!-- Department Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('department_id', 'Department:') !!}
        {!! Form::select('department_id', $departments ,null, ['class' => 'selectpicker form-control' , 'title' => 'Select Department']) !!}
    </div>

    <!-- Room Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('room_id', 'Room:') !!}
        {!! Form::select('room_id', $rooms, null, ['class' => 'selectpicker form-control' , 'title' => 'Select Room']) !!}
    </div>
</div>

<div class="row">
    <!-- Currency Id Field -->
    <div class="form-group col-md-6">
        {!! Form::label('amount_per_slot', 'Amount Per Slot:') !!}
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">{{session('user_details')[session('branch_id')]['hospitals']->branch_currency_short_code}}</div>
            </div>
            {!! Form::number('amount_per_slot', null, ['class' => 'form-control']) !!}
            {!! Form::hidden('currency_id', session('user_details')[session('branch_id')]['hospitals']->default_currency_id , null, ['class' => 'form-control']) !!}
        </div>
    </div>
    
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('sessions.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

@stack('scripts')
<script>
    $(document).ready(function(){

        $('input[name="appointment_time"]').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 1,
            locale: {
                format: 'HH:mm'
            }
        },
        function() {

            setStartEndTime();
            calculateDurationPerSlot();

        }).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".calendar-table").hide();
        });


    });

    function setStartEndTime() {

        var start_time = $('input[name="appointment_time"]').data('daterangepicker').startDate.format('HH:mm:ss');
        var end_time = $('input[name="appointment_time"]').data('daterangepicker').endDate.format('HH:mm:ss');

        document.getElementById('start_time').value = start_time;
        document.getElementById('end_time').value = end_time;

    }

    function calculateDurationPerSlot(){

        var start_time = document.getElementById('start_time').value;
        var end_time = document.getElementById('end_time').value;

        //calculate difference
        var diff = Math.abs(new Date('2011/10/09 '+end_time) - new Date('2011/10/09 '+start_time));
        var diff_minutes = Math.floor((diff/1000)/60);

        var number_of_slots = document.getElementById('number_of_slots').value;

        if(number_of_slots == "" || number_of_slots == null || number_of_slots == 0 || start_time == "" || start_time == null || end_time == "" || end_time == null) {
        } else {
            document.getElementById('duration_per_slot').value = Math.floor(diff_minutes/number_of_slots);
        }

    }

</script>
