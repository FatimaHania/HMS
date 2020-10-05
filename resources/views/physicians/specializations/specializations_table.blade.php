<div class="table-responsive-sm">
    <table class="table table-striped" id="physician-specializations-table">
        <thead>
            <tr>
        <th>SN</th>
        <th>Specializations</th>
        <th colspan="3" class="th_action">Action</th>
            </tr>
        </thead>
        <tbody>
        @php $a = 1; @endphp
        @foreach($specializations as $specialization)
            <tr>
            <td>{{ $a }}</td>
            <td>{{ $specialization->description }}</td>
            <td>
                <div class='btn-group'>
                    <a href="#" type="button" class='btn btn-xs btn-ghost-danger' onclick="destroyPhysicianSpecializations({{$specialization->pivot->physician_id}} , {{$specialization->pivot->specialization_id}})"><i class="fa fa-trash"></i></a>
                </div>
            </td>
            </tr>
        @php $a++ @endphp
        @endforeach
        </tbody>
    </table>
</div>