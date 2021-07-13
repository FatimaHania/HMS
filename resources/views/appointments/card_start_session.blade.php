<x-modals.basic modal-id="startSessionModal" modal-size="modal-sm">

    <x-slot name="title">
        <span id="startSessionModal_title">Start Session</span>
    </x-slot>
    {!! Form::open(['route' => 'sessions.startSession' , 'id' => 'start_session_form']) !!}
        <div id="startSession_div">
            {{csrf_field()}}
            <div class="form-row">
                <!-- Cancelled Date -->
                <div class="form-group col-sm-12">
                    {!! Form::label('started_at', 'Started at:') !!}
                    {!! Form::text('started_at', date('Y-m-d H:i:s'), ['class' => 'form-control','id'=>'started_at' , 'readOnly'=>true]) !!}
                </div>

            </div>

            <div class="form-row">

                <!-- Cancelled By -->
                <div class="form-group col-sm-12">
                    {!! Form::label('started_by', 'Started By:') !!}
                    {!! Form::text('started_by', Auth::user()->name, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'readOnly'=>true]) !!}
                </div>

            </div>

                <!-- Hidden Field -->
                <div>
                    {!! Form::hidden('start_session_id', null , ['class' => 'form-control' , 'id' => 'start_session_id']) !!}
                </div>

        </div>


        <x-slot name="footer">
            <button type="button" class="btn btn-light" class="close" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="button" class="btn btn-success" onclick="startSession()">Start Session</button>
        </x-slot>
    {!! Form::close() !!}
</x-modals.basic>


@stack('scripts')
<script>

function startSession(){

    var session_id = document.getElementById('start_session_id').value;
    var started_at = document.getElementById('started_at').value;
    var started_by = document.getElementById('started_by').value;

    var is_physician_login = "{{session('is_physician')}}";
    if(is_physician_login == '1'){
        var btn_type = "";
        var bg_prefix = "table-";
    } else {
        btn_type = "btn-xs";
        bg_prefix = "bg-";
    }

    $.ajax({
        type:'POST',
        url:"{{route('sessions.startSession')}}",
        data: {_token: "{{ csrf_token() }}" , session_id: session_id , started_at: started_at , started_by: started_by},
        beforeSend: function () {
            document.getElementById('startSession_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
        },
        success:function(data) {
            $('#startSessionModal').modal('hide');
            document.getElementById('modalLoader_div').style.display = "none";
            document.getElementById('startSession_div').style.display = "block";

            //styling the card
            $('#session_card'+session_id+' .card-header').attr('class','card-header text-dark ' + bg_prefix + 'success');
            $('#session_card'+session_id+' #card_status_span').html('<button type="button" class="btn ' + btn_type + ' btn-xing disabled">On-going</button>');
            $('#session_card'+session_id+' #card_cancel_span').html('');
            $('#session_card'+session_id+' #card_start_span').html('');
            $('#session_card'+session_id+' #card_complete_span').html('<button type="button" class="btn ' + btn_type + ' btn-danger" id="complete_session_btn'+session_id+'" data-toggle="modal" data-target="#completeSessionModal" data-toggle="tooltip" data-placement="top" title="Complete Session" onclick="displaySessionCompleteForm('+session_id+')"><i class="fa fa-stop-circle" aria-hidden="true"></i></button>');


            //display appointments button in public portal - physician login (physician_session.blade.php)
            if(is_physician_login == '1'){
                $('#session_card'+session_id+' #card_start_span').html('');
                $('#session_card'+session_id+' #card_appointment_span').html('<a type="button" class="btn ' + btn_type + ' btn-github" id="channel_session_btn' + session_id + '" data-toggle="tooltip" title="Appointments" href="#" onclick="redirect_to_appointments(' + session_id + ')"><i class="fa fa-user-plus" aria-hidden="true"></i></a>');
            }

        }
    });

}

</script>