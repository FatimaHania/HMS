<x-modals.basic modal-id="physicianDepartmentModal">

    <x-slot name="title">
        <span id="departmentModal_title">Department</span>
    </x-slot>

    <div id="physicianDepartments_div">

    </div>


    <x-slot name="footer">
        <input type="hidden" id="physician_code" name="physician_code">
        <input type="hidden" id="physician_name" name="physician_name">
        <input type="hidden" id="physician_id" name="physician_id">
        <div class="input-group">
            <select class="selectpicker form-control" data-live-search="true" id="department_id" name="department_id">
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->description }}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="storePhysicianDepartments()">ADD</button>
            </div>
        </div>
    </x-slot>

</x-modals.basic>

@stack('scripts')
<script>

function getPhysicianDepartments(physician_id , physician_code=0 , physician_name=0) {

    document.getElementById('physician_id').value = physician_id;

    if(physician_code == "0"){} else {
        document.getElementById('departmentModal_title').innerHTML = " Departments - " + physician_code + " | " + physician_name;
    }

    $.ajax({
        type:'POST',
        url:"{{route('physicians.getPhysicianDepartments')}}",
        data: {_token: "{{ csrf_token() }}" , physician_id: physician_id},
        beforeSend: function () { 
            document.getElementById('physicianDepartments_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
        },
        success:function(data) {
            $("#physicianDepartments_div").html(data);
            document.getElementById('modalLoader_div').style.display = "none";
            document.getElementById('physicianDepartments_div').style.display = "block";
        }
    });

}


function destroyPhysicianDepartments(physician_id , department_id) {

    $.ajax({
        type:'POST',
        url:"{{route('physicians.destroyPhysicianDepartments')}}",
        data: {_token: "{{ csrf_token() }}" , physician_id : physician_id , department_id : department_id},
        beforeSend: function () {
            document.getElementById('physicianDepartments_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
         },
        success:function(data) {
            getPhysicianDepartments(physician_id);
        }
    });

}


function storePhysicianDepartments() {

    var physician_id = document.getElementById('physician_id').value;
    var department_id = document.getElementById('department_id').value;

    $.ajax({
        type:'POST',
        url:"{{route('physicians.storePhysicianDepartments')}}",
        data: {_token: "{{ csrf_token() }}" , physician_id : physician_id , department_id : department_id},
        beforeSend: function () {
            document.getElementById('physicianDepartments_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
         },
        success:function(data) {
            getPhysicianDepartments(physician_id);
            document.getElementById('department_id').reset();
        }
    });

}

</script>