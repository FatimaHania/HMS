<div class="table-responsive-sm">
    <table class="table table-striped" id="nurse-departments-table">
        <thead>
            <tr>
        <th>SN</th>
        <th>Department</th>
        <th colspan="3" class="th_action">Action</th>
            </tr>
        </thead>
        <tbody>
        @php $a = 1; @endphp
        @foreach($departments as $department)
            <tr>
            <td>{{ $a }}</td>
            <td>{{ $department->description }}</td>
            <td>
                <div class='btn-group'>
                    <a href="#" type="button" class='btn btn-xs btn-ghost-danger' onclick="destroyNurseDepartments({{$department->pivot->nurse_id}} , {{$department->pivot->department_id}})"><i class="fa fa-trash"></i></a>
                </div>
            </td>
            </tr>
        @php $a++ @endphp
        @endforeach
        </tbody>
    </table>
</div>