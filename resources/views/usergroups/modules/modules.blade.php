<x-modals.basic modal-id="modulesModal">

    <x-slot name="title">
        <span id="modulesModal_title">Modules</span>
    </x-slot>

    <div id="modules_div" style="min-height:200px;">

    </div>

    <x-slot name="footer">
        <input type="hidden" id="usergroup_description" name="usergroup_description">
        <input type="hidden" id="usergroup_id" name="usergroup_id">

        <button type="button" class="btn btn-light" class="close" data-dismiss="modal" aria-label="Close">Close</button>
        <button class="btn btn-primary" type="button" onclick="storeUsergroupModules()">Save</button>
    </x-slot>

</x-modals.basic>

@stack('scripts')
<script>
function getUsergroupModules(usergroup_id , usergroup_description='') {


    document.getElementById('usergroup_id').value = usergroup_id;

    if(usergroup_description == ""){} else {
        document.getElementById('modulesModal_title').innerHTML = " Modules - " + usergroup_description;
    }

    $.ajax({
        type:'POST',
        url:"{{route('usergroups.getUsergroupModules')}}",
        data: {_token: "{{ csrf_token() }}" , usergroup_id: usergroup_id},
        beforeSend: function () { 
            document.getElementById('modules_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
        },
        success:function(data) {
            $("#modules_div").html(data);
            document.getElementById('modalLoader_div').style.display = "none";
            document.getElementById('modules_div').style.display = "block";
        }
    });

}



function storeUsergroupModules() {

    var usergroup_id = document.getElementById('usergroup_id').value;
    var module_id = $('input[name="module_id[]"]').val();
    var selected_value = $('input[name="selected_value[]"]').serialize();

    $.ajax({
        type:'POST',
        url:"{{route('usergroups.storeUsergroupModules')}}",
        data: {_token: "{{ csrf_token() }}" , usergroup_id : usergroup_id , 'module_id' : module_id , 'selected_value' : selected_value},
        beforeSend: function () {
            document.getElementById('modules_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
         },
        success:function(data) {
            getUsergroupModules(usergroup_id);
            document.getElementById('usergroup_id').reset();
        }
    });

}

</script>
            