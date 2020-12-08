<div class="table-responsive-sm">
    <table class="table table-striped" id="users-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>User Group</th>
                <th colspan="3" style="width:10% !important;">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            @php $usergroups_arr = array(); @endphp
            @foreach($user->usergroups as $usergroup)
                @php $usergroups_arr[] = $usergroup->description; @endphp
            @endforeach
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ join(' , ' , $usergroups_arr) }}</td>
                <td>
                    {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="#" type="button" class='btn btn-xs btn-ghost-info' data-toggle="modal" data-target="#usergroupModal"  onclick="getUserUsergroups({{$user->id}} , '{{$user->name}}' , '{{$user->email}}')"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                        <!--<a href="{{ route('users.edit', [$user->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>-->
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


@include('users.usergroups.usergroups')