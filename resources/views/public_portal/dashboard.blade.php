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
            </div>
        </div>
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
                    <div class="col-md-3">
                        <label class="control-label" for="filter_physician">Physician:</label>
                        <select class="form-control selectpicker"  data-style="btn-instagram btn-sm" id="filter_physician" name="filter_physician" onchange="updatePhysicianFilter()">
                            <option value="0">All Physicians</option>
                            
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label" for="filter_hospital">Hospital:</label>
                        <select class="form-control selectpicker"  data-style="btn-instagram btn-sm" id="filter_hospital" name="filter_hospital" onchange="updatePhysicianFilter()">
                            <option value="0">All Hospitals</option>
                            
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label" for="filter_specialization">Specialization:</label>
                        <select class="form-control selectpicker"  data-style="btn-instagram btn-sm" id="filter_specialization" name="filter_specialization" onchange="updatePhysicianFilter()">
                            <option value="0">All Specializations</option>
                            
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label" for="filter_date">Date:</label>
                        <select class="form-control selectpicker"  data-style="btn-instagram btn-sm" id="filter_date" name="filter_date" onchange="updatePhysicianFilter()">
                            <option value="0">Any dates</option>
                            
                        </select>
                    </div>
                </div>

                <hr style="margin-top:10px; margin-bottom:8px;">
                
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
</script>

<!--Edit Profile-->
@include('public_portal.profile_edit') 

<!--Link Hospital-->
@include('public_portal.hospital_link') 
