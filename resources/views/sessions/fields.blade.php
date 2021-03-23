<div class="row">
    <!-- Physician Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('physician_id', 'Physician:') !!}
        {!! Form::select('physician_id', $physicians ,null, ['class' => 'selectpicker form-control' , 'title' => 'Select Physician', 'onchange' => 'updatePhysicianDepartmentFilter(this)']) !!}
    </div>

    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div>

<div class="row">

    <!-- Dates -->
    <div class="form-group col-sm-6">
        {!! Form::label('session_dates', 'Date:') !!}
        {!! Form::text('session_dates', null, ['class' => 'form-control date','id'=>'session_dates']) !!}
        <div id="session_dates_container">
            <input type="hidden" name="session_dates_arr[]">
        </div>
    </div>

    <!-- Date Field -->
    <div class="form-group col-sm-6" style="display:none;">
        {!! Form::label('date', 'Date:') !!}
        {!! Form::text('date', null, ['class' => 'form-control','id'=>'date']) !!}
        {!! Form::text('start_date', null, ['class' => 'form-control','id'=>'start_date']) !!}
        {!! Form::text('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
    </div>


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
        {!! Form::select('department_id', $departments ,null, ['class' => 'selectpicker form-control' , 'title' => 'Select Department' , 'onchange' => 'updateDepartmentRoomFilter(this)']) !!}
    </div>

    <!-- Room Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('room_id', 'Room:') !!}
        {!! Form::select('room_id', $rooms, null, ['class' => 'selectpicker form-control' , 'title' => 'Select Room' , 'onchange' => 'checkRoomAvailablity(this)']) !!}
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

<!--hidden fields-->
{!! Form::hidden('id' , null, ['class' => 'form-control' , 'id' => 'id']) !!}

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

        $('input[name="date"]').daterangepicker({
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        }).on('apply.daterangepicker', (e, picker) => {
            var date_from = $('#date').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var date_to = $('#date').data('daterangepicker').endDate.format('YYYY-MM-DD');

            document.getElementById('start_date').value = date_from;
            document.getElementById('end_date').value = date_to;

        });

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
            resetRoomField();

        }).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".calendar-table").hide();
        });

        $('#session_dates').datepicker({
            <?php
                if(isset($session)){ //edit window
            ?>
                    multidate: false,
                    format: 'dd/mm/yyyy',
            <?php
                } else { //Add window
            ?>
                    multidate: true,
                    format: 'dd/mm/yyyy',
                    multidateSeparator: " - ",
            <?php
                }
            ?>
        }).on('changeDate', function(e) {

            var session_dates = $('#session_dates').datepicker('getDates');
            for (i=0 ; i<session_dates.length ; i++){

                document.getElementById('date').value = (session_dates[i].getFullYear())+"-"+((session_dates[i].getMonth())+1)+"-"+(session_dates[i].getDate())

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "session_dates_arr[]";
                input.value = (session_dates[i].getFullYear())+"-"+((session_dates[i].getMonth())+1)+"-"+(session_dates[i].getDate());
                if(i == 0){
                    $('#session_dates_container').html('').append(input);
                } else {
                    $('#session_dates_container').append(input);
                }
            }

            checkRoomAvailablity('');

        });

        <?php
            if(isset($session)){ //edit window
        ?>
                $('#session_dates').val('{{date("d/m/Y", strtotime($session->date))}}');
                
                $('input[name="date"]').data('daterangepicker').setStartDate('{{date("d/m/Y", strtotime($session->date))}}');
                $('input[name="date"]').data('daterangepicker').setEndDate('{{date("d/m/Y", strtotime($session->date))}}');

                $('input[name="start_date"]').val('{{date("d/m/Y", strtotime($session->date))}}');
                $('input[name="end_date"]').val('{{date("d/m/Y", strtotime($session->date))}}');

                $('input[name="appointment_time"]').data('daterangepicker').setStartDate('{{date("H:i", strtotime($session->start_time))}}');
                $('input[name="appointment_time"]').data('daterangepicker').setEndDate('{{date("H:i", strtotime($session->end_time))}}');

                $('input[name="session_dates_arr[]"]').val('{{date("Y-m-d", strtotime($session->date))}}');
                                
        <?php
            } 
        ?>
                

        


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

    function updatePhysicianDepartmentFilter(x){

        var physician_id = document.getElementById('physician_id').value;

        if(physician_id == '0' || physician_id == "" || physician_id == null){} else{

            $.ajax({
                type:'POST',
                url:"{{route('physicians.updatePhysicianDepartmentFilter')}}",
                data: {_token: "{{ csrf_token() }}" , physician_id: physician_id},
                beforeSend: function () { 
                    document.getElementById('department_id').readonly = true;
                },
                success:function(data) {
                    $("#department_id").html(data);
                    $("#department_id").selectpicker('refresh');
                    document.getElementById('department_id').readonly = false;

                }
            });

        }

    }

    function updateDepartmentRoomFilter(x){

        var department_id = document.getElementById('department_id').value;

        if(department_id == '0' || department_id == "" || department_id == null){} else{

            $.ajax({
                type:'POST',
                url:"{{route('departments.updateDepartmentRoomFilter')}}",
                data: {_token: "{{ csrf_token() }}" , department_id: department_id},
                beforeSend: function () { 
                    document.getElementById('room_id').readonly = true;
                },
                success:function(data) {
                    $("#room_id").html(data);
                    $("#room_id").selectpicker('refresh');
                    document.getElementById('room_id').readonly = false;

                }
            });

        }

    }

    function resetRoomField(){

        //reset room values
        $('#room_id').val('');
        $('#room_id').selectpicker('refresh');

    }

    function checkRoomAvailablity(x){

        var session_id = document.getElementById('id').value;
        var room_id = document.getElementById('room_id').value;
        var start_time = document.getElementById('start_time').value;
        var end_time = document.getElementById('end_time').value;
        var session_dates_arr = $('input[name="session_dates_arr[]"]').map(function(){
                                    return this.value;
                                }).get();

        if(room_id == '0' || room_id == "" || room_id == null){} else{

            $.ajax({
                type:'POST',
                url:"{{route('sessions.checkRoomAvailablity')}}",
                dataType:"json",
                data: {_token: "{{ csrf_token() }}", session_id: session_id , room_id: room_id , start_time: start_time , end_time: end_time , session_dates_arr: session_dates_arr},
                beforeSend: function () { 
                    document.getElementById('room_id').readonly = true;
                },
                success:function(data) {
                    if(data.status == 'unavailable'){
                        $("#room_id").selectpicker('val' , '');
                        toastr.error(data.message);
                    }
                    $("#room_id").selectpicker('refresh');
                    document.getElementById('room_id').readonly = false;

                }
            });

        }

    }

</script>
