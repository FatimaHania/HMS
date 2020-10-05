<div class="table-responsive-sm">
    <table class="table table-striped" id="departmentRooms-table">
        <thead>
            <tr>
                <th>SN</th>
                <th>Short Code</th>
                <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($departmentRooms as $departmentRoom)
            <tr>
                <td>{{ $loop->iteration }} </td>
                <td>{{ $departmentRoom->short_code }}</td>
                <td>{{ $departmentRoom->description }}</td>
                <td>
                    
                    <div class='btn-group'>
                    <a href="#" type="button" class='btn btn-xs btn-primary' data-toggle="modal" data-toggle="tooltip" title="Rooms" data-target="#departmentRoomsModal" onclick="getDepartmentRooms({{$departmentRoom->id}} , '{{$departmentRoom->description}}')"><i class="fa fa-caret-square-o-right"></i> Rooms</a>
                    </div>
                    
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@include('department_rooms.rooms')