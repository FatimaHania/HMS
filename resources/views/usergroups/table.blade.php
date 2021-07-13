<div class="table-responsive-sm">
    <table class="table table-striped" id="usergroups-table">
        <thead>
            <tr>
                <th>Description</th>
                <th colspan="3" style="width:12% !important;">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($usergroups as $usergroup)
            <tr>
                <td>{{ $usergroup->description }}</td>
                <td>
                    {!! Form::open(['route' => ['usergroups.destroy', $usergroup->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>

                        <a href="{{ route('usergroups.show', [$usergroup->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-file-text-o"></i></a>
                        <a href="{{ route('usergroups.edit', [$usergroup->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        <a href="#" type="button" class='btn btn-xs btn-ghost-info' data-toggle="modal" data-target="#modulesModal"  onclick="getUsergroupModules({{$usergroup->id}} , '{{$usergroup->description}}')"><i class="fa fa-th-list" aria-hidden="true"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<!--Codes for Action Buttons- show,edit and delete-->

@include('usergroups.modules.modules')