<div class="table-responsive-sm">
    <table class="table table-striped" id="documentCodes-table">
        <thead>
            <tr>
        <th>Description</th>
        <th>Prefix</th>
        <th>Starting No</th>
        <th>Format Length</th>
        <th>Common Difference</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($documentCodes as $documentCode)
            <tr>
            <td>{{ $documentCode->description }}</td>
            <td>{{ $documentCode->prefix }}</td>
            <td>{{ $documentCode->starting_no }}</td>
            <td>{{ $documentCode->format_length }}</td>
            <td>{{ $documentCode->common_difference }}</td>
                <td>
                    {!! Form::open(['route' => ['documentCodes.destroy', $documentCode->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('documentCodes.show', [$documentCode->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('documentCodes.edit', [$documentCode->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>