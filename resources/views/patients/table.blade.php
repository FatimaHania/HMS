<div class="table-responsive-sm">
    <table class="table table-striped" id="patients-table">
        <thead>
            <tr>
                <th>SN</th>
                <th>Patient</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>Country</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Bloodgroup</th>
                <th colspan="3" class="th_action">Action</th>
            </tr>
        </thead>
        <tbody>
            @php $a = 1; @endphp
            @foreach($patients as $patient)
                @if($patient->country_id == "" || $patient->country_id == null)
                    @php $telephone_code = "000"; @endphp
                @else
                    @php $telephone_code = $patient->country->telephone_code; @endphp
                @endif
                <tr>
                    <td class="text-center">{{$a}}</td>
                    <td><img class="user_thumbnail" src="{{asset($patient->patientImage())}}" alt="Patient Image"> {{ $patient->patient_code." | ".$patient->title->short_code." ".$patient->patient_name }}</td>
                    <td>{{ $patient->gender->description }}</td>
                    <td>{{ Carbon::parse($patient->dob)->format(config('app.date_format'))}}</td>
                    <td>{{ $patient->country->description }}</td>
                    <td>{{ join(' / ' , [$telephone_code."-".$patient->mobile , $telephone_code."-".$patient->telephone]) }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->bloodgroup->description }}</td>
                    <td>
                        {!! Form::open(['route' => ['patients.destroy', $patient->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('patients.show', [$patient->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                            <a href="#" onclick="redirect_to_history({{$patient->id}},'0')" class='btn btn-xs btn-ghost-warning'><i class="fa fa-history" aria-hidden="true"></i></a>
                            <a href="{{ route('patients.edit', [$patient->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
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

@stack('scripts')
<script>

function redirect_to_history(patient_id, appointment_id){

    $.ajax({
        type:'POST',
        url:"{{route('patients.redirectToHistory')}}",
        data: {_token: "{{ csrf_token() }}" , patient_id: patient_id , appointment_id: appointment_id},
        beforeSend: function () {
            
        },
        success:function(data) {
            window.location.href = "{{route('checkup.history' , '0')}}";
        }
    });

}

</script>