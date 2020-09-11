<div class="table-responsive-sm">
    <table class="table table-striped" id="titles-table">
        <thead>
            <tr>
                <th>Short Code</th>
                <th>Description</th>
                <th colspan="3" class="th_action">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($titles as $title)
            <tr>
                <td>{{ $title->short_code }}</td>
            <td>{{ $title->description }}</td>
                <td>
                    {!! Form::open(['route' => ['titles.destroy', $title->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('titles.show', [$title->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('titles.edit', [$title->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>