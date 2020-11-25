<x-modals.basic modal-id="cancelSessionModal">

    <x-slot name="title">
        <span id="cancelSessionModal_title">Cancel Session</span>
    </x-slot>
    {!! Form::open(['route' => 'sessions.cancelSession' , 'id' => 'cancel_session_form']) !!}
        <div id="cancelSession_div">
            {{csrf_field()}}
            <div class="form-row">
                <!-- Cancelled Date -->
                <div class="form-group col-sm-6">
                    {!! Form::label('cancelled_date', 'Cancelled On:') !!}
                    {!! Form::text('cancelled_date', date('Y-m-d'), ['class' => 'form-control','id'=>'cancelled_date' , 'readOnly'=>true]) !!}
                </div>

                <!-- Cancelled By -->
                <div class="form-group col-sm-6">
                    {!! Form::label('cancelled_by', 'Cancelled By:') !!}
                    {!! Form::text('cancelled_by', Auth::user()->name, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'readOnly'=>true]) !!}
                </div>

                <!-- Hidden Field -->
                <div>
                    {!! Form::hidden('cancel_session_id', null , ['class' => 'form-control' , 'id' => 'cancel_session_id']) !!}
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-sm-12">
                    <label for="cancelled_reason">Reason for cancellation: </label>
                    <textarea class="form-control" id="cancelled_reason" name="cancelled_reason" rows="3"></textarea>
                </div>
            </div>
        </div>


        <x-slot name="footer">
            <button type="button" class="btn btn-light" class="close" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="button" class="btn btn-primary" onclick="cancelSession()">Submit</button>
        </x-slot>
    {!! Form::close() !!}
</x-modals.basic>


@stack('scripts')
<script>

function cancelSession(){

    var session_id = document.getElementById('cancel_session_id').value;
    var cancelled_date = document.getElementById('cancelled_date').value;
    var cancelled_by = document.getElementById('cancelled_by').value;
    var cancelled_reason = document.getElementById('cancelled_reason').value;

    $.ajax({
        type:'POST',
        url:"{{route('sessions.cancelSession')}}",
        data: {_token: "{{ csrf_token() }}" , session_id: session_id , cancelled_date: cancelled_date , cancelled_by: cancelled_by , cancelled_reason: cancelled_reason},
        beforeSend: function () {
            document.getElementById('cancelSession_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
        },
        success:function(data) {
            $('#cancelSessionModal').modal('hide');
            document.getElementById('cancelled_reason').value = "";
            document.getElementById('modalLoader_div').style.display = "none";
            document.getElementById('cancelSession_div').style.display = "block";

            //styling the card
            $('#session_card'+session_id+' .card-header').attr('class','card-header text-dark bg-danger');
            $('#session_card'+session_id+' #card_status_span').html('<button type="button" class="btn btn-xs btn-danger disabled">Cancelled</button>');
            $('#session_card'+session_id+' #card_cancel_span').html('');
            $('#session_card'+session_id+' #card_start_span').html('');
            $('#session_card'+session_id+' #card_bookNow_span').html('');

        }
    });

}

</script>