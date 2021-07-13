<div class="table-responsive-sm">
    <table class="table table-striped" id="diseases-table">
        <thead>
            <tr>
                <th>Short Code</th>
        <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($diseases as $disease)
            <tr>
                <td>{{ $disease->short_code }}</td>
            <td>{{ $disease->description }}</td>
                <td>
                    {!! Form::open(['route' => ['diseases.destroy', $disease->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('diseases.show', [$disease->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-file-text-o"></i></a>
                        <a href="{{ route('diseases.edit', [$disease->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>