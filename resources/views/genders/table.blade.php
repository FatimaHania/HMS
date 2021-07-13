<div class="table-responsive-sm">
    <table class="table table-striped" id="genders-table">
        <thead>
            <tr>
                <th>Short Code</th>
        <th>Description</th>
                <th colspan="3" class="th_action">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($genders as $gender)
            <tr>
                <td>{{ $gender->short_code }}</td>
            <td>{{ $gender->description }}</td>
                <td>
                    {!! Form::open(['route' => ['genders.destroy', $gender->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('genders.show', [$gender->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-file-text-o"></i></a>
                        <a href="{{ route('genders.edit', [$gender->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>