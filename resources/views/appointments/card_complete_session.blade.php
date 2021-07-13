<x-modals.basic modal-id="completeSessionModal" modal-size="modal-sm">

    <x-slot name="title">
        <span id="completeSessionModal_title">Complete Session</span>
    </x-slot>
    {!! Form::open(['route' => 'sessions.completeSession' , 'id' => 'complete_session_form']) !!}
        <div id="completeSession_div">
            {{csrf_field()}}
            <div class="form-row">
                <!-- Cancelled Date -->
                <div class="form-group col-sm-12">
                    {!! Form::label('completed_at', 'Completed at:') !!}
                    {!! Form::text('completed_at', date('Y-m-d H:i:s'), ['class' => 'form-control','id'=>'completed_at' , 'readOnly'=>true]) !!}
                </div>

            </div>

            <div class="form-row">

                <!-- Cancelled By -->
                <div class="form-group col-sm-12">
                    {!! Form::label('completed_by', 'Completed By:') !!}
                    {!! Form::text('completed_by', Auth::user()->name, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'readOnly'=>true]) !!}
                </div>

            </div>

                <!-- Hidden Field -->
                <div>
                    {!! Form::hidden('complete_session_id', null , ['class' => 'form-control' , 'id' => 'complete_session_id']) !!}
                </div>

        </div>


        <x-slot name="footer">
            <button type="button" class="btn btn-light" class="close" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="button" class="btn btn-primary" onclick="completeSession()">Complete Session</button>
        </x-slot>
    {!! Form::close() !!}
</x-modals.basic>


@stack('scripts')
<script>

function completeSession(){

    var session_id = document.getElementById('complete_session_id').value;
    var completed_at = document.getElementById('completed_at').value;
    var completed_by = document.getElementById('completed_by').value;
    
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
        url:"{{route('sessions.completeSession')}}",
        data: {_token: "{{ csrf_token() }}" , session_id: session_id , completed_at: completed_at , completed_by: completed_by},
        beforeSend: function () {
            document.getElementById('completeSession_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
        },
        success:function(data) {
            $('#completeSessionModal').modal('hide');
            document.getElementById('modalLoader_div').style.display = "none";
            document.getElementById('completeSession_div').style.display = "block";

            //styling the card
            $('#session_card'+session_id+' .card-header').attr('class','card-header text-dark ' + bg_prefix + 'info');
            $('#session_card'+session_id+' #card_status_span').html('<button type="button" class="btn ' + btn_type + ' btn-primary disabled">Completed</button>');
            $('#session_card'+session_id+' #card_complete_span').html('');

        }
    });

}

</script>