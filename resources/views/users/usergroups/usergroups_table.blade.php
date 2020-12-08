<div class="table-responsive-sm">
    <table class="table table-striped" id="user-usergoups-table">
        <thead>
            <tr>
        <th>SN</th>
        <th>User Group</th>
        <th colspan="3" class="th_action">Action</th>
            </tr>
        </thead>
        <tbody>
        @php $a = 1; @endphp
        @foreach($usergroups as $usergroup)
            <tr>
            <td>{{ $a }}</td>
            <td>{{ $usergroup->description }}</td>
            <td>
                <div class='btn-group'>
                    <a href="#" type="button" class='btn btn-xs btn-ghost-danger' onclick="destroyUserUsergroups({{$usergroup->pivot->user_id}} , {{$usergroup->pivot->usergroup_id}})"><i class="fa fa-trash"></i></a>
                </div>
            </td>
            </tr>
        @php $a++ @endphp
        @endforeach
        </tbody>
    </table>
</div>