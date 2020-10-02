<div class="table-responsive-sm">
    <table class="table table-striped" id="designations-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>Short Code</th>
        <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($designations as $designation)
            <tr>
                <td>{{ $designation->title }}</td>
            <td>{{ $designation->short_code }}</td>
            <td>{{ $designation->description }}</td>
                <td>
                    {!! Form::open(['route' => ['designations.destroy', $designation->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('designations.show', [$designation->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('designations.edit', [$designation->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>