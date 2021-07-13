<div class="table-responsive-sm">
    <table class="table table-striped" id="rooms-table">
        <thead>
            <tr>
                <th>SN</th>
                <th>User</th>
                <th>Activate link</th>
            </tr>
        </thead>
        <tbody>
        @php $a = 1; @endphp
            @foreach($linked_users as $linked_user)
            <tr>
                <td style="width:5%;">{{$a}}</td>
                <td>{{$linked_user->linked_user_code." | ".$linked_user->linked_user_name}}</td>
                <td style="width:10%;">
                    <div class="spinner-grow text-primary" id="activateLoader_div{{$linked_user->user_hospital_id}}" role="status" style="display:none; width:22px; height:22px;">
                        <span class="sr-only">Loading...</span>
                    </div>
                    @if($linked_user->is_approved_by_hospital == '1')
                        <div id="activateCB_div{{$linked_user->user_hospital_id}}"><input type="checkbox" class="icheck-checkbox" data-user-hospital-id="{{$linked_user->user_hospital_id}}" checked></div>
                    @else
                        <div id="activateCB_div{{$linked_user->user_hospital_id}}"><input type="checkbox" class="icheck-checkbox" data-user-hospital-id="{{$linked_user->user_hospital_id}}"></div>
                    @endif
                </td>
               
            </tr>
            @php $a++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

@stack('scripts')
<script>

    $(document).ready(function(){
        $('.icheck-checkbox').iCheck({
            checkboxClass: 'icheckbox_square-purple',
            radioClass: 'iradio_square-purple',
            increaseArea: '20%' // optional
        });

        //oncheck event on checkbox
        $('.icheck-checkbox').on('ifChecked', function(event){
            var user_hospital_id = $(this).attr('data-user-hospital-id');
            updateLinkApprovalStatus(user_hospital_id, '1')
        });

        //on uncheck event on checkbox
        $('.icheck-checkbox').on('ifUnchecked', function(event){
            var user_hospital_id = $(this).attr('data-user-hospital-id');
            updateLinkApprovalStatus(user_hospital_id, '0')
        });

    })

    function updateLinkApprovalStatus(user_hospital_id, value){

        $.ajax({
            type:'POST',
            url:"{{route('publicUsers.updateLinkApprovalStatus')}}",
            data: {_token: "{{ csrf_token() }}" , user_hospital_id: user_hospital_id, value: value},
            beforeSend: function () { 
                document.getElementById('activateCB_div'+user_hospital_id).style.display = "none";
                document.getElementById('activateLoader_div'+user_hospital_id).style.display = "block";
            },
            success:function(data) {
                if(data == '1'){
                    if(value == '1'){
                        toastr.success('Link successfully activated!');
                    } else {
                        toastr.success('Link successfully deactivated!');
                    }
                } else {
                    toastr.error('Failed to activate link. Please try again.');
                }
                document.getElementById('activateLoader_div'+user_hospital_id).style.display = "none";
                document.getElementById('activateCB_div'+user_hospital_id).style.display = "block";
            }
        });

    }

</script>