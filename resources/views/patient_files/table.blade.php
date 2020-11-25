<div class="table-responsive-sm">
    <table class="table table-striped" id="patientFiles-table">
        <thead>
            <tr>
                <th>File Name</th>
                <th>Description</th>
                <th>Department</th>
                <th>Disease</th>
                <th>Is Active</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($patientFiles as $patientFile)
            <tr>
                <td>{{ $patientFile->file_name }}</td>
            <td>{{ $patientFile->description }}</td>
            <td>{{ $patientFile->department->description }}</td>
            <td>{{ $patientFile->disease->description }}</td>
            <td>
                @if($patientFile->is_active == '1')
                    <span class="badge badge-success">Active</span>
                @else 
                    <span class="badge badge-danger">Closed</span>
                @endif
            </td>
                <td>
                    {!! Form::open(['route' => ['patientFiles.destroy', $patientFile->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('patientFiles.show', [$patientFile->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('patientFiles.edit', [$patientFile->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>