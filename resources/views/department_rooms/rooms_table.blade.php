<div class="table-responsive-sm">
    <table class="table table-striped" id="department-rooms-table">
        <thead>
            <tr>
        <th>SN</th>
        <th>Room</th>
        <th colspan="3" class="th_action">Action</th>
            </tr>
        </thead>
        <tbody>
        @php $a = 1; @endphp
        @foreach($rooms as $room)
            <tr>
            <td>{{ $a }}</td>
            <td>{{ $room->short_code." | ".$room->description }}</td>
            <td>
                <div class='btn-group'>
                    <a href="#" type="button" class='btn btn-xs btn-ghost-danger' onclick="destroyDepartmentRooms({{$room->pivot->department_id}} , {{$room->pivot->room_id}})"><i class="fa fa-trash"></i></a>
                </div>
            </td>
            </tr>
        @php $a++ @endphp
        @endforeach
        </tbody>
    </table>
</div>