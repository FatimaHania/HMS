<x-modals.basic modal-id="cardBookingModal" modal-size="modal-lg">

    <x-slot name="title">
        <span id="cardBookingModal_title">Book appointments</span>
    </x-slot>

    <div id="cardBooking_div">

    </div>


    <x-slot name="footer">
        <button type="button" class="btn btn-light" class="close" data-dismiss="modal" aria-label="Close">Close</button>
    </x-slot>

</x-modals.basic>


@stack('scripts')
<script>
    //get the booking details (session details & appointments)
    function getBookingDetails(session_id){

        $.ajax({
        type:'POST',
        url:"{{route('appointments.getBookingDetails')}}",
        data: {_token: "{{ csrf_token() }}" , session_id: session_id},
        beforeSend: function () { 
            document.getElementById('cardBooking_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
        },
        success:function(data) {
            $("#cardBooking_div").html(data);
            document.getElementById('modalLoader_div').style.display = "none";
            document.getElementById('cardBooking_div').style.display = "block";
        }
    });

    }
</script>