<div class="table-responsive-sm">
    <table class="table table-striped" id="laboratories-table">
        <thead>
            <tr>
                <th>SN</th>
                <th>Lab</th>
                <th>Short Code</th>
                <th>Address</th>
                <th>Telephone 1</th>
                <th>Telephone 2</th>
                <th>Email</th>
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @php $a = 1; @endphp
        @foreach($laboratories as $laboratory)
            <tr>
                <td class="text-center">{{ $a }}</td>
                <td>{{ $laboratory->lab_code." | ".$laboratory->name }}</td>
                <td>{{ $laboratory->short_code }}</td>
                <td>{{ $laboratory->address }}</td>
                <td>{{ $laboratory->telephone_1 }}</td>
                <td>{{ $laboratory->telephone_2 }}</td>
                <td>{{ $laboratory->email }}</td>
                <td>
                        @if($laboratory->is_active == '1')
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                </td>
                <td>
                    {!! Form::open(['route' => ['laboratories.destroy', $laboratory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('laboratories.show', [$laboratory->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-file-text-o"></i></a>
                        <a href="{{ route('laboratories.edit', [$laboratory->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            @php $a++; @endphp
        @endforeach
        </tbody>
    </table>
</div>