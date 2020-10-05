<x-modals.basic modal-id="departmentRoomsModal">

    <x-slot name="title">
        <span id="roomModal_title">Rooms</span>
    </x-slot>

    <div id="departmentRooms_div">

    </div>


    <x-slot name="footer">
        <input type="hidden" id="department_description" name="department_description">
        <input type="hidden" id="department_id" name="department_id">
        <div class="input-group">
            <select class="selectpicker form-control" data-live-search="true" id="room_id" name="room_id">
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->description }}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="storeDepartmentRooms()">ADD</button>
            </div>
        </div>
    </x-slot>

</x-modals.basic>

@stack('scripts')
<script>

function getDepartmentRooms(department_id , department_description=0) {

    document.getElementById('department_id').value = department_id;

    if(department_description == "0"){} else {
        document.getElementById('roomModal_title').innerHTML = " Rooms - " + department_description;
    }

    $.ajax({
        type:'POST',
        url:"{{route('departmentRooms.getDepartmentRooms')}}",
        data: {_token: "{{ csrf_token() }}" , department_id: department_id},
        beforeSend: function () { 
            document.getElementById('departmentRooms_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
        },
        success:function(data) {
            $("#departmentRooms_div").html(data);
            document.getElementById('modalLoader_div').style.display = "none";
            document.getElementById('departmentRooms_div').style.display = "block";
        }
    });

}


function destroyDepartmentRooms(department_id , room_id) {

    $.ajax({
        type:'POST',
        url:"{{route('departmentRooms.destroyDepartmentRooms')}}",
        data: {_token: "{{ csrf_token() }}" , department_id : department_id , room_id : room_id},
        beforeSend: function () {
            document.getElementById('departmentRooms_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
         },
        success:function(data) {
            getDepartmentRooms(department_id);
        }
    });

}


function storeDepartmentRooms() {

    var department_id = document.getElementById('department_id').value;
    var room_id = document.getElementById('room_id').value;

    $.ajax({
        type:'POST',
        url:"{{route('departmentRooms.storeDepartmentRooms')}}",
        data: {_token: "{{ csrf_token() }}" , department_id : department_id , room_id : room_id},
        beforeSend: function () {
            document.getElementById('departmentRooms_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
         },
        success:function(data) {
            getDepartmentRooms(department_id);
            document.getElementById('room_id').reset();
        }
    });

}

</script>