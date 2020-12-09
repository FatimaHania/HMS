<x-modals.basic modal-id="cardInfoModal" modal-size="">

    <x-slot name="title">
        <span id="cardInfoModal_title">Session Details</span>
    </x-slot>

    <div id="cardInfo_div">

    </div>


    <x-slot name="footer">
        <button type="button" class="btn btn-light" class="close" data-dismiss="modal" aria-label="Close">Close</button>
    </x-slot>

</x-modals.basic>


@stack('scripts')
<script>
    //get the card details (session details)
    function getCardDetails(session_id){

        $.ajax({
        type:'POST',
        url:"{{route('appointments.getCardDetails')}}",
        data: {_token: "{{ csrf_token() }}" , session_id: session_id},
        beforeSend: function () { 
            document.getElementById('cardInfo_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
        },
        success:function(data) {
            $("#cardInfo_div").html(data);
            document.getElementById('modalLoader_div').style.display = "none";
            document.getElementById('cardInfo_div').style.display = "block";
        }
    });

    }
</script>