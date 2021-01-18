<div class="table-responsive-sm">
    <table class="table table-striped" id="nurses-table">
        <thead>
            <tr>
                <th>SN</th>
                <th>Nurse</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>Country</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th colspan="3" class="th_action">Action</th>
            </tr>
        </thead>
        <tbody>
        @php $a = 1; @endphp
        @foreach($nurses as $nurse)
            @if($nurse->country_id == "" || $nurse->country_id == null)
                @php $telephone_code = "000"; @endphp
            @else
                @php $telephone_code = $nurse->country->telephone_code; @endphp
            @endif
            <tr>
                <td class="text-center">{{$a}}</td>
                <td><img class="user_thumbnail" src="{{asset($nurse->nurseImage())}}" alt="Nurse Image"> {{$nurse->nurse_code." | ".$nurse->title->short_code." ".$nurse->nurse_name }}</td>
                <td>{{ $nurse->gender->description }}</td>
                <td>{{ Carbon::parse($nurse->dob)->format(config('app.date_format'))}}</td>
                <td>{{ $nurse->country->description }}</td>
                <td>{{ join(' / ' , [$telephone_code."-".$nurse->mobile , $telephone_code."-".$nurse->telephone]) }}</td>
                <td>{{ $nurse->email }}</td>
                <td>
                    {!! Form::open(['route' => ['nurses.destroy', $nurse->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('nurses.show', [$nurse->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                        <a href="{{ route('nurses.edit', [$nurse->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        <a href="#" type="button" class='btn btn-xs btn-ghost-primary' data-toggle="modal" data-target="#nurseDepartmentModal" onclick="getNurseDepartments({{$nurse->id}} , '{{$nurse->nurse_code}}' , '{{$nurse->nurse_name}}')"><i class="fa fa-building"></i></a>
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

@include('nurses.departments.departments')