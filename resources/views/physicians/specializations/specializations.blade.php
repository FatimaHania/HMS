<x-modals.basic modal-id="physicianSpecializationModal" modal-size="">

    <x-slot name="title">
        <span id="specializationModal_title">Specialization</span>
    </x-slot>

    <div id="physicianSpecializations_div">

    </div>


    <x-slot name="footer">
        <input type="hidden" id="physician_code" name="physician_code">
        <input type="hidden" id="physician_name" name="physician_name">
        <input type="hidden" id="physician_id" name="physician_id">
        <div class="input-group">
            <select class="selectpicker form-control" data-live-search="true" id="specialization_id" name="specialization_id">
                @foreach($specializations as $specialization)
                    <option value="{{ $specialization->id }}">{{ $specialization->description }}</option>
                @endforeach
            </select><div class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="storePhysicianSpecializations()">ADD</button>
            </div>
        </div>
    </x-slot>

</x-modals.basic>

@stack('scripts')
<script>

function getPhysicianSpecializations(physician_id , physician_code=0 , physician_name=0) {

    document.getElementById('physician_id').value = physician_id;

    if(physician_code == "0"){} else {
        document.getElementById('specializationModal_title').innerHTML = " Specializations - " + physician_code + " | " + physician_name;
    }

    $.ajax({
        type:'POST',
        url:"{{route('physicians.getPhysicianSpecializations')}}",
        data: {_token: "{{ csrf_token() }}" , physician_id: physician_id},
        beforeSend: function () { 
            document.getElementById('physicianSpecializations_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
        },
        success:function(data) {
            $("#physicianSpecializations_div").html(data);
            document.getElementById('modalLoader_div').style.display = "none";
            document.getElementById('physicianSpecializations_div').style.display = "block";
        }
    });

}


function destroyPhysicianSpecializations(physician_id , specialization_id) {

    $.ajax({
        type:'POST',
        url:"{{route('physicians.destroyPhysicianSpecializations')}}",
        data: {_token: "{{ csrf_token() }}" , physician_id : physician_id , specialization_id : specialization_id},
        beforeSend: function () {
            document.getElementById('physicianSpecializations_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
         },
        success:function(data) {
            getPhysicianSpecializations(physician_id);
        }
    });

}


function storePhysicianSpecializations() {

    var physician_id = document.getElementById('physician_id').value;
    var specialization_id = document.getElementById('specialization_id').value;

    $.ajax({
        type:'POST',
        url:"{{route('physicians.storePhysicianSpecializations')}}",
        data: {_token: "{{ csrf_token() }}" , physician_id : physician_id , specialization_id : specialization_id},
        beforeSend: function () {
            document.getElementById('physicianSpecializations_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
         },
        success:function(data) {
            getPhysicianSpecializations(physician_id);
            document.getElementById('specialization_id').reset();
        }
    });

}

</script>
            