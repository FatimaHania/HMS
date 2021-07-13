<style>
    .card{
        margin-bottom:4px;
    }

    .card-body {
        padding:6px !important;
    }

    .session-card-container {
        padding:0px;
    }
    
</style>
<div class="row col-md-12" style="padding:0px;">
    <div class="col-md-3" style="padding:3px;">
        <!--User Profile-->
        <div class="card text-center">
            <div class="card-body">
                <img id="dashboard_user_img" src="{{ URL::to('/').Auth::user()->userImage() }}" height="150px" width="150px" style="border-radius:50%; margin:12px; border:2px solid #f2f2f2;">
                <h5 class="card-title" style="margin-bottom:2px;">{{Auth::user()->name}}</h5>
                <p class="card-text">{{Auth::user()->email}}</p>
            </div>
            <div class="card-footer text-muted">
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editProfileModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Profile</a> 
                <a href="#" class="btn btn-youtube btn-sm" data-toggle="modal" data-target="#linkHospitalModal">Link Hospital</a>
                <a href="#" class="btn btn-dribbble btn-sm" onclick="redirect_to_history('{{Auth::user()->id}}','1')"><i class="fa fa-history" aria-hidden="true"></i></a>
            </div>
        </div>

        <!--Linked Hospitals-->

        @php

            $linked_hospital_array = array();
            foreach($physicianHospitals as $physicianHospital){
                $linked_hospital_array[$physicianHospital->branch_id][0] =  $physicianHospital;
            }

            foreach($patientHospitals as $patientHospital){
                if(array_key_exists($patientHospital->branch_id, $linked_hospital_array)){
                    $linked_hospital_array[$patientHospital->branch_id][1] = $patientHospital;
                } else {
                    $linked_hospital_array[$patientHospital->branch_id][0] = $patientHospital;
                }
            }

        @endphp

        @foreach($linked_hospital_array as $linked_hospital)
            <div class="card-header" style="margin-bottom:4px;">
                    <div class="row" style="padding:0px;">
                        <div class="col-sm-12 text-center" style="padding:4px; background-color:#ffffff; border-radius:4px;">
                            <img class="align-middle" src="{{ URL::to('/').'/storage/'.$linked_hospital[0]->logo }}"  width="40px" style="border-radius:50%; border:3px solid #f2f2f2;"><br>
                            <span class="badge" style="width:100% !important; padding:5px;">{{ $linked_hospital[0]->hospital_name.", ".$linked_hospital[0]->branch_name }}</span>

                            @foreach($linked_hospital as $user_hospital)

                                @php $link_status = ""; @endphp
                                @php $btn_class_physician = "btn-primary"; @endphp
                                @php $btn_class_patient = "btn-info"; @endphp
                                @php $btn_disabled = ""; @endphp
                                @php $link_physician = route('physicians.edit', [$user_hospital->user_link_id]); @endphp
                                @php $link_patient = route('patients.edit', [$user_hospital->user_link_id]); @endphp
                                @if($user_hospital->link_verified_at == null || $user_hospital->link_verified_at == '' || $user_hospital->link_verified_at == '0' )
                                    @php $link_status = " <span class='badge bg-secondary'>Pending verification</span>"; @endphp
                                    @php $btn_class_physician = "btn-warning"; @endphp
                                    @php $btn_class_patient = "btn-warning"; @endphp
                                    @php $btn_disabled = "disabled"; @endphp
                                    @php $link_physician = "#"; @endphp
                                    @php $link_patient = "#"; @endphp
                                @else
                                    @if($user_hospital->is_approved_by_hospital == '0')
                                        @php $link_status = " <span class='badge bg-secondary'>Awaiting hospital approval</span>"; @endphp
                                        @php $btn_class_physician = "btn-warning"; @endphp
                                        @php $btn_class_patient = "btn-warning"; @endphp
                                        @php $btn_disabled = "disabled"; @endphp
                                        @php $link_physician = "#"; @endphp
                                        @php $link_patient = "#"; @endphp
                                    @endif
                                @endif


                                @if($user_hospital->is_physician == '1')
                                    <a href="{{ $link_physician }}" class='btn btn-square btn-xs btn-block {{$btn_class_physician}}' {{$btn_disabled}}>Physician Profile @php echo $link_status @endphp</a>
                                @else
                                    <a href="{{ $link_patient }}" class='btn btn-square btn-xs btn-block {{$btn_class_patient}}' {{$btn_disabled}}>Patient Profile @php echo $link_status @endphp</a>
                                @endif
                            @endforeach

                        </div>
                    </div>
            </div>
        @endforeach
    </div>

    <div class="col-md-9" style="padding:3px;">

        <!--User Profile-->
        @if(session('is_physician') == '1')
        <div class="card">
            <div class="card-header text-muted">
                <span class="pull-left" id="sessions_title"><b>Today's Sessions </b></span>
                <div class="pull-right" style="width:1px; height:1px; overflow:hidden;">
                    <input type="text" name="filter_session_date" id="filter_session_date">
                </div>
                <button class="btn btn-xs btn-light pull-right" onclick="openSessionDatePicker()"><i class="fa fa-calendar" aria-hidden="true"></i></button>
            </div>
            <div class="card-body" style="max-height:400px; overflow-x:auto;">
                <x-loader loader-id="sessionsLoader_div" min-height="200px"></x-loader>

                <div id="sessions_div">
                    
                </div>
            </div>
        </div>
        @endif

        <!--Book Appointments-->
        <div class="card">
            <div class="card-body">
                <!--Filters-->
                <div class="form-row">
                    <!--<div class="col-md-3">
                        <label class="control-label" for="filter_physician">Physician:</label>
                        <select class="form-control selectpicker"  data-style="btn-instagram btn-sm" id="filter_physician" name="filter_physician" onchange="updatePhysicianFilter()">
                            <option value="0">All Physicians</option>
                            
                        </select>
                    </div>-->
                    <div class="col-md-4">
                        <label class="control-label" for="filter_hospital">Hospital:</label>
                        <select class="form-control selectpicker"  data-live-search="true"  data-style="btn-instagram btn-sm" id="filter_hospital" name="filter_hospital">
                            <option value="0">All Hospitals</option>
                            @foreach($branches as $branch)
                                <option value="{{$branch->id}}">{{$branch->hospital->name.", ".$branch->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label" for="filter_specialization">Specialization:</label>
                        <select class="form-control selectpicker"  data-live-search="true"  data-style="btn-instagram btn-sm" id="filter_specialization" name="filter_specialization">
                            <option value="0">All Specializations</option>
                            @foreach($specializations as $specialization)
                                <option value="{{$specialization->id}}">{{$specialization->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label" for="filter_date">Date:</label>
                        {!! Form::text('filter_date', null, ['class' => 'form-control form-control-sm date btn-instagram btn-sm','id'=>'filter_date' , 'autocomplete' => 'off']) !!}
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-xs btn-block" style="margin-top:8px;" onclick="getSessionsForBookingPP()"><i class="fa fa-search" aria-hidden="true"></i> Search Sessions</button>
                <hr style="margin-top:10px; margin-bottom:8px;">
                <div id="app_sessions_div">
                    <x-panel_messages>
                        <x-slot name="icon">
                            <i class="fa fa-search panel-icon" aria-hidden="true"></i>
                        </x-slot>
                        <x-slot name="message">
                            <span>Search Sessions to Book Appointments</span>
                        </x-slot>
                    </x-panel_messages>
                </div>
            </div>
        </div>
    </div>
</div>

@stack('scripts')
<script>
    $(function() {
        $('input[name="filter_session_date"]').daterangepicker({
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        }).on('change', function(e) {
                getPhysicianSessions();
            });

        getPhysicianSessions("{{date('Y-m-d')}}","{{date('Y-m-d')}}");

        $('#filter_date').datepicker({
            multidate: false,
            format: 'yyyy-mm-dd',
        })


    })

    function openSessionDatePicker(){
        $('#filter_session_date').data('daterangepicker').toggle();
    }

    function getPhysicianSessions(startDate=0, endDate=0){
        if(startDate == '0' || endDate == '0'){
            var date_from = $('#filter_session_date').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var date_to = $('#filter_session_date').data('daterangepicker').endDate.format('YYYY-MM-DD');
        } else {
            date_from = startDate;
            date_to = endDate;
        }

        var fromDate = new Date(date_from);
        var ToDate = new Date(date_to);
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        if(date_from == date_to){ //single date
            var todaysDate = new Date();
            if(fromDate.setHours(0,0,0,0) == todaysDate.setHours(0,0,0,0)) { // today
               document.getElementById('sessions_title').innerHTML = "<b>Today's Sessions</b>";
            } else { 
                document.getElementById('sessions_title').innerHTML = "<b>Sessions</b> - "+fromDate.getDate()+" "+months[fromDate.getMonth()]+", "+fromDate.getFullYear();
            }
        } else {
            document.getElementById('sessions_title').innerHTML = "<b>Sessions</b> - ["+(fromDate.getDate()+" "+months[fromDate.getMonth()]+", "+fromDate.getFullYear())+ " - " + (ToDate.getDate()+" "+months[ToDate.getMonth()]+", "+ToDate.getFullYear()) +"}";
        }

        $.ajax({
            type:'POST',
            url:"{{route('sessions.getSessionsPP')}}",
            data: {_token: "{{ csrf_token() }}", date_from: date_from, date_to: date_to},
            beforeSend: function () { 
                document.getElementById('sessions_div').style.display = "none";
                document.getElementById('sessionsLoader_div').style.display = "block";
            },
            success:function(data) {
                $("#sessions_div").html(data);
                document.getElementById('sessionsLoader_div').style.display = "none";
                document.getElementById('sessions_div').style.display = "block";
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }

    function updateHospitalProfile(userType, user_link_id){

        if(userType == 'physician'){ //physician

        } else { //patient

        }

    }

    function redirect_to_history(user_id, isPublicUser){

        $.ajax({
            type:'POST',
            url:"{{route('publicPortal.redirectToHistoryFromDashboard')}}",
            data: {_token: "{{ csrf_token() }}" , user_id: user_id , isPublicUser: isPublicUser},
            beforeSend: function () {
                
            },
            success:function(data) {
                window.location.href = "{{route('checkup.history' , '0')}}";
            }
        });

    }

    function getSessionsForBookingPP(){

        var branch_id = document.getElementById('filter_hospital').value;
        var specialization_id = document.getElementById('filter_specialization').value;
        var date = document.getElementById('filter_date').value;

        if((branch_id == "0") && (specialization_id == "0") && (date == "0" || date == null || date == "")){

            bootbox.alert("Please select a specific hospital or a specialization");

        } else {

            $.ajax({
                type:'POST',
                url:"{{route('publicPortal.getSessionsForBookingPP')}}",
                data: {_token: "{{ csrf_token() }}" , branch_id: branch_id , specialization_id: specialization_id , date:date},
                beforeSend: function () {
                    
                },
                success:function(data) {
                    $('#app_sessions_div').html(data);
                }
            });

        }

    }

</script>

<!--Edit Profile-->
@include('public_portal.profile_edit') 

<!--Link Hospital-->
@include('public_portal.hospital_link') 
