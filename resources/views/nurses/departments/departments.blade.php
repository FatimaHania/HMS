<x-modals.basic modal-id="nurseDepartmentModal">

    <x-slot name="title">
        <span id="departmentModal_title">Department</span>
    </x-slot>

    <div id="nurseDepartments_div">

    </div>


    <x-slot name="footer">
        <input type="hidden" id="nurse_code" name="nurse_code">
        <input type="hidden" id="nurse_name" name="nurse_name">
        <input type="hidden" id="nurse_id" name="nurse_id">
        <div class="input-group">
            <select class="selectpicker form-control" data-live-search="true" id="department_id" name="department_id">
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->description }}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="storeNurseDepartments()">ADD</button>
            </div>
        </div>
    </x-slot>

</x-modals.basic>

@stack('scripts')
<script>

function getNurseDepartments(nurse_id , nurse_code=0 , nurse_name=0) {

    document.getElementById('nurse_id').value = nurse_id;

    if(nurse_code == "0"){} else {
        document.getElementById('departmentModal_title').innerHTML = " Departments - " + nurse_code + " | " + nurse_name;
    }

    $.ajax({
        type:'POST',
        url:"{{route('nurses.getNurseDepartments')}}",
        data: {_token: "{{ csrf_token() }}" , nurse_id: nurse_id},
        beforeSend: function () { 
            document.getElementById('nurseDepartments_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
        },
        success:function(data) {
            $("#nurseDepartments_div").html(data);
            document.getElementById('modalLoader_div').style.display = "none";
            document.getElementById('nurseDepartments_div').style.display = "block";
        }
    });

}


function destroyNurseDepartments(nurse_id , department_id) {

    $.ajax({
        type:'POST',
        url:"{{route('nurses.destroyNurseDepartments')}}",
        data: {_token: "{{ csrf_token() }}" , nurse_id : nurse_id , department_id : department_id},
        beforeSend: function () {
            document.getElementById('nurseDepartments_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
         },
        success:function(data) {
            getNurseDepartments(nurse_id);
        }
    });

}


function storeNurseDepartments() {

    var nurse_id = document.getElementById('nurse_id').value;
    var department_id = document.getElementById('department_id').value;

    $.ajax({
        type:'POST',
        url:"{{route('nurses.storeNurseDepartments')}}",
        data: {_token: "{{ csrf_token() }}" , nurse_id : nurse_id , department_id : department_id},
        beforeSend: function () {
            document.getElementById('nurseDepartments_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
         },
        success:function(data) {
            getNurseDepartments(nurse_id);
            document.getElementById('department_id').reset();
        }
    });

}

</script>