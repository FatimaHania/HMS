<div class="table-responsive-sm">
    <table class="table table-striped" id="pharmacies-table">
        <thead>
            <tr>
                <th>SN</th>
                <th>Pharmacy</th>
                <th>Short Code</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @php $a = 1; @endphp
        @foreach($pharmacies as $pharmacy)
            <tr>
                <td class="text-center">{{ $a }}</td>
                <td>{{ $pharmacy->pharmacy_code." | ".$pharmacy->name }}</td>
                <td>{{ $pharmacy->short_code }}</td>
                <td>{{ $pharmacy->address }}</td>
                <td>{{ join(', ',[$pharmacy->telephone_1,$pharmacy->telephone_2]) }}</td>
                <td>{{ $pharmacy->email }}</td>
                <td>
                    @if($pharmacy->is_active == '1')
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    {!! Form::open(['route' => ['pharmacies.destroy', $pharmacy->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('pharmacies.show', [$pharmacy->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-file-text-o"></i></a>
                        <a href="{{ route('pharmacies.edit', [$pharmacy->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
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