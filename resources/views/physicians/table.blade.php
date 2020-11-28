<div class="table-responsive-sm">
    <table class="table table-striped" id="physicians-table">
        <thead>
            <tr>
                <th>Physician</th>
                <th>Passport Number</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($physicians as $physician)
            @if($physician->country_id == "" || $physician->country_id == null)
                @php $telephone_code = "000"; @endphp
            @else
                @php $telephone_code = $physician->country->telephone_code; @endphp
            @endif
            <tr>
                <td>{{ $physician->physician_code." | ".$physician->title->short_code." ".$physician->physician_name }}</td>
                <td>{{ $physician->passport_no }}</td>
                <td>{{ join(' / ' , [$telephone_code."-".$physician->mobile , $telephone_code."-".$physician->telephone]) }}</td>
                <td>{{ $physician->email }}</td>
                <td>
                    {!! Form::open(['route' => ['physicians.destroy', $physician->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('physicians.show', [$physician->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('physicians.edit', [$physician->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        <a href="#" type="button" class='btn btn-xs btn-ghost-warning' data-toggle="modal" data-target="#physicianSpecializationModal" onclick="getPhysicianSpecializations({{$physician->id}} , '{{$physician->physician_code}}' , '{{$physician->physician_name}}')"><i class="fa fa-shield"></i></a>
                        <a href="#" type="button" class='btn btn-xs btn-ghost-primary' data-toggle="modal" data-target="#physicianDepartmentModal" onclick="getPhysicianDepartments({{$physician->id}} , '{{$physician->physician_code}}' , '{{$physician->physician_name}}')"><i class="fa fa-building"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@include('physicians.specializations.specializations')
@include('physicians.departments.departments')