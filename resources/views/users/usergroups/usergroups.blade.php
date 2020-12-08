<x-modals.basic modal-id="usergroupModal">

    <x-slot name="title">
        <span id="usergroupModal_title">User Groups</span>
    </x-slot>

    <div id="usergroups_div" style="min-height:200px;">

    </div>


    <x-slot name="footer">
        <input type="hidden" id="user_email" name="user_email">
        <input type="hidden" id="user_name" name="user_name">
        <input type="hidden" id="user_id" name="user_id">
        <div class="input-group">
            <select class="selectpicker form-control" data-live-search="true" id="usergroup_id" name="usergroup_id">
                @foreach($usergroups as $usergroup)
                    <option value="{{ $usergroup->id }}">{{ $usergroup->description }}</option>
                @endforeach
            </select><div class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="storeUserUsergroups()">ADD</button>
            </div>
        </div>
    </x-slot>

</x-modals.basic>

@stack('scripts')
<script>
$(document).ready(function() {

    $('#usergroupModal').on('hidden.bs.modal', function () {

        location.reload();

    })

})

function getUserUsergroups(user_id , user_name='' , user_email='') {


    document.getElementById('user_id').value = user_id;

    if(user_name == ""){} else {
        document.getElementById('usergroupModal_title').innerHTML = " User Groups - " + user_name;
    }

    $.ajax({
        type:'POST',
        url:"{{route('users.getUserUsergroups')}}",
        data: {_token: "{{ csrf_token() }}" , user_id: user_id},
        beforeSend: function () { 
            document.getElementById('usergroups_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
        },
        success:function(data) {
            $("#usergroups_div").html(data);
            document.getElementById('modalLoader_div').style.display = "none";
            document.getElementById('usergroups_div').style.display = "block";
        }
    });

}


function destroyUserUsergroups(user_id , usergroup_id) {

    $.ajax({
        type:'POST',
        url:"{{route('users.destroyUserUsergroups')}}",
        data: {_token: "{{ csrf_token() }}" , user_id : user_id , usergroup_id : usergroup_id},
        beforeSend: function () {
            document.getElementById('usergroups_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
         },
        success:function(data) {
            getUserUsergroups(user_id);
        }
    });

}


function storeUserUsergroups() {

    var user_id = document.getElementById('user_id').value;
    var usergroup_id = document.getElementById('usergroup_id').value;

    $.ajax({
        type:'POST',
        url:"{{route('users.storeUserUsergroups')}}",
        data: {_token: "{{ csrf_token() }}" , user_id : user_id , usergroup_id : usergroup_id},
        beforeSend: function () {
            document.getElementById('usergroups_div').style.display = "none";
            document.getElementById('modalLoader_div').style.display = "block";
         },
        success:function(data) {
            getUserUsergroups(user_id);
            document.getElementById('user_id').reset();
        }
    });

}

</script>
            