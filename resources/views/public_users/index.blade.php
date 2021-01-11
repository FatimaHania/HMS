@extends('layouts.app')

@section('content')
<div class="row">
    <ol class="breadcrumb col-md-8">
        <li class="breadcrumb-item page-title">Patients</li>
    </ol>
    <div class="col-md-4 breadcrumb" style="text-align:right !important; display:inline;">
        <!--show filter button-->
        <x-filters.button filter-id="page_filter" button-id="page_filter_button"></x-filters.button>
    </div>
</div>

    <!--filters-->
    <x-filters.filters filter-id="page_filter">
        <x-slot name="filters">
            <div class="form-row">
                <div class="col-md-5">
                    <label class="control-label" for="filter_user_type">User Type:</label>
                    <select class="form-control selectpicker" id="filter_user_type" name="filter_user_type" onchange="updateUserFilter()">
                        <option value="0">Patient</option>
                        <option value="1">Physician</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="control-label" for="filter_user">User:</label>
                    <select class="form-control selectpicker" id="filter_user" name="filter_user">
                        <option value="0">All Users</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="control-label" style="visibility:hidden;">Filter Record:</label>
                    <button class="btn btn-sm btn-secondary pull-right" onclick="getLinkedUsers()"><i class="fa fa-search"></i> Search</button>
                </div>
            </div>
        </x-slot>
    </x-filters.filters>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             <span class="page-title">Patients</span>
                         </div>
                         <div class="card-body">
                            <x-loader loader-id="usersLoader_div" min-height="200px"></x-loader>

                            <div id="users_div">
                                @include('public_users.table')
                            </div>
                             
                              <div class="pull-right mr-3">
                                     
                              </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>

@stack('scripts')
<script>

function updateUserFilter() {

    var user_type = document.getElementById('filter_user_type').value;

    if(user_type == '0'){//patients
        $('.page-title').text('Patients');
    } else { //Physicians
        $('.page-title').text('Physicians');
    }

        $.ajax({
        type:'POST',
        url:"{{route('publicUsers.updateUsersFilter')}}",
        data: {_token: "{{ csrf_token() }}", user_type: user_type},
        beforeSend: function () { 
            $('#filter_user').attr('disabled',true).selectpicker('refresh');
        },
        success:function(data) {
            $("#filter_user").html("<option value='0'>All Users</option>"+data);
            $('#filter_user').attr('disabled',false).selectpicker('refresh');
        }
    });

}

function getLinkedUsers() {

    var user_type = document.getElementById('filter_user_type').value;
    var user = document.getElementById('filter_user').value;

    $.ajax({
        type:'POST',
        url:"{{route('publicUsers.getLinkedUsers')}}",
        data: {_token: "{{ csrf_token() }}", user_type: user_type, user: user},
        beforeSend: function () { 
            document.getElementById('users_div').style.display = "none";
            document.getElementById('usersLoader_div').style.display = "block";
        },
        success:function(data) {
            $("#users_div").html(data);
            document.getElementById('usersLoader_div').style.display = "none";
            document.getElementById('users_div').style.display = "block";
            $('[data-toggle="tooltip"]').tooltip();
        }
    });


}

</script>
@endsection

