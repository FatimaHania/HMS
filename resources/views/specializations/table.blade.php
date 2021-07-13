<div class="table-responsive-sm">
    <table class="table table-striped" id="specializations-table">
        <thead>
            <tr>
                <th>Short Code</th>
        <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($specializations as $specialization)
            <tr>
                <td>{{ $specialization->short_code }}</td>
            <td>{{ $specialization->description }}</td>
                <td>
                    {!! Form::open(['route' => ['specializations.destroy', $specialization->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('specializations.show', [$specialization->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-file-text-o"></i></a>
                        <a href="{{ route('specializations.edit', [$specialization->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>