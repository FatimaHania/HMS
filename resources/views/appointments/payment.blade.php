<x-modals.basic modal-id="paymentModal" modal-size="modal-sm">

    <x-slot name="title">
        <span id="paymentModal_title">Payment</span>
    </x-slot>

        <x-loader loader-id="paymentLoader_div" min-height="150px"></x-loader>

    {!! Form::open(['route' => 'appointments.updatePaymentStatus' , 'id' => 'payment_form']) !!}
        <div id="payment_div">
            {{csrf_field()}}
            <div class="form-row">
                <!-- Cancelled Date -->
                <div class="form-group col-sm-12">
                    {!! Form::label('paid_at', 'Paid at:') !!}
                    {!! Form::text('paid_at', date('Y-m-d H:i:s'), ['class' => 'form-control','id'=>'paid_at' , 'readOnly'=>true]) !!}
                </div>

            </div>

            <div class="form-row">

                <!-- Cancelled By -->
                <div class="form-group col-sm-12">
                    {!! Form::label('received_by', 'Received By:') !!}
                    {!! Form::text('received_by', Auth::user()->name, ['class' => 'form-control', 'id'=>'received_by', 'maxlength' => 255,'maxlength' => 255,'maxlength' => 255, 'readOnly'=>true]) !!}
                </div>

            </div>

                <!-- Hidden Field -->
                <div>
                    {!! Form::hidden('payment_appointment_id', null , ['class' => 'form-control' , 'id' => 'payment_appointment_id']) !!}
                </div>

        </div>


        <x-slot name="footer">
            <button type="button" class="btn btn-light" class="close" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="button" class="btn btn-success" id="receive_payment_btn" onclick="updatePaymentStatus()">Receive Payment</button>
        </x-slot>
    {!! Form::close() !!}
</x-modals.basic>


@stack('scripts')
<script>

function updatePaymentStatus(){

    var appointment_id = document.getElementById('payment_appointment_id').value;
    var paid_at = document.getElementById('paid_at').value;
    var received_by = document.getElementById('received_by').value;

    $.ajax({
        type:'POST',
        url:"{{route('appointments.updatePaymentStatus')}}",
        data: {_token: "{{ csrf_token() }}" , appointment_id: appointment_id , paid_at: paid_at , received_by: received_by},
        beforeSend: function () {
            document.getElementById('payment_div').style.display = "none";
            document.getElementById('paymentLoader_div').style.display = "block";
        },
        success:function(data) {
            $('#paymentModal').modal('hide');
            document.getElementById('paymentLoader_div').style.display = "none";
            document.getElementById('payment_div').style.display = "block";

            document.getElementById('payment_status_div'+appointment_id).innerHTML = '<span class="badge badge-success">Settled</span>';
            document.getElementById('is_paid_value'+appointment_id).value = '1';

            toastr.success('Payment successfully received');

        }
    });

}

</script>