@extends('public_portal.layouts.app')
<style>
    .panel{
        margin-top:10px;
        padding:6px !important;
    }

    .list-info > li{
        padding:6px;
        font-size:12px;
    }

    .list-info > li > span{
        color:#bfbfbf;
        font-size:11px;
        font-weight:bold;
    }

    .update-button{
        cursor :pointer;
    }

    .main-container{
        
    }
</style>


    @section('content')

    <div class="row">

            <div class="col-md-3"> <!--Info-->
                <div class="card-header bg-primary text-center panel">
                    <span><b>Appointment No 01</b></span>
                </div>

                <div class="card-header panel text-center">
                    <b>Patient</b>
                    <br>
                    <img id="checkup_patient_img" src="{{ URL::to('/').$appointment->patient->patientImage() }}" height="150px" width="150px" style="border-radius:50%; margin:12px; border:2px solid #f2f2f2;">
                    <h6 class="card-title" style="margin-bottom:8px;">{{$appointment->patient->patient_code." | ".$appointment->patient->patient_name}}</h6>
                    <button type="button" class="btn btn-dribbble btn-sm btn-block"  onclick="redirect_to_history({{$appointment->patient_id}},{{$appointment->id}})"  style="margin-bottom:8px;"><i class="fa fa-history" aria-hidden="true"></i> Medical History</button>
                    <ul class="list-group list-group-flush list-info">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Age
                            <span>{{\Carbon\Carbon::parse($appointment->patient->dob)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days')}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Gender
                            <span>{{$appointment->patient->gender->description}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Blood Group
                            <span>{{$appointment->patient->bloodgroup->description}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Height
                            <span><a class="badge badge-primary badge-pill update-button" href="#" onclick="openPatientHeightsModal('{{$appointment->patient_id}}', '{{$appointment->hospital_id}}', '{{$appointment->branch_id}}')">Update</a> <span id="height_tag">@if(!empty($last_height)) {{$last_height->height.$last_height->unit}} @endif</span></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Weight
                            <span><a class="badge badge-primary badge-pill update-button" href="#" onclick="openPatientWeightsModal('{{$appointment->patient_id}}', '{{$appointment->hospital_id}}', '{{$appointment->branch_id}}')">Update</a> <span id="weight_tag">@if(!empty($last_height)) {{$last_weight->weight.$last_weight->unit}} @endif</span></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Country
                            <span>{{$appointment->patient->country->description}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Email
                            <span>{{$appointment->patient->email}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Address
                            <span>{{$appointment->patient->address}}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9"> <!--Treatment-->
                {!! Form::open(['route' => 'checkups.store' , 'files' => true]) !!}
                <div class="card panel" style="padding:0px !important;">
                    @include('flash::message')

                    <div class="card-header">
                        <b>Medical Examination {{date('d-m-Y')}}</b>
                        <span class="pull-right">
                            <button class="btn btn-primary btn-xs" type="submit">Save</button>
                            <button type="button" class="btn btn-square btn-xs btn-danger" onclick="redirect_to_appointments('{{ $appointment->session_id }}')"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</button>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="complains">Complains: </label>
                                <textarea class="form-control" id="complains" name="complains" rows="2"></textarea>
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="observations">Observations: </label>
                                <textarea class="form-control" id="observations" name="observations" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="diagnosis">Diagnosis: </label>
                                <textarea class="form-control" id="diagnosis" name="diagnosis" rows="2"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="treatment">Treatment: </label>
                                <textarea class="form-control" id="treatment" name="treatment" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="prescription">Prescription: </label>
                            <textarea class="form-control" id="prescription" name="prescription" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="medical_tests">Medical Tests: </label>
                            <textarea class="form-control" id="medical_tests" name="medical_tests" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="attachment">Attachment</label>
                            <input type="file" class="form-control-file" id="attachment" name="attachment">
                        </div>
                        <!--Hidden fields-->
                        <input type="hidden" name="patient_id" value="{{$appointment->patient_id}}">
                        <input type="hidden" name="appointment_id" value="{{session('phy_appointment_id')}}">
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

    </div>
    

    @stack('scripts')
    <script>

        function openPatientHeightsModal(patient_id, hospital_id, branch_id){

            document.getElementById('height_patient_id').value = patient_id;
            document.getElementById('height_hospital_id').value = hospital_id;
            document.getElementById('height_branch_id').value = branch_id;

            $('#patientHeightModal').modal('show');

        }


        function openPatientWeightsModal(patient_id, hospital_id, branch_id){

            document.getElementById('weight_patient_id').value = patient_id;
            document.getElementById('weight_hospital_id').value = hospital_id;
            document.getElementById('weight_branch_id').value = branch_id;

            $('#patientWeightModal').modal('show');

        }


        function redirect_to_appointments(session_id){

            $.ajax({
                type:'POST',
                url:"{{route('publicPortal.redirectToAppointments')}}",
                data: {_token: "{{ csrf_token() }}" , session_id: session_id},
                beforeSend: function () {
                    
                },
                success:function(data) {
                    window.location.href = "{{route('appointments.getAppointmentsPP' , '0')}}";
                }
            });

        }

        function redirect_to_history(patient_id, appointment_id){

            $.ajax({
                type:'POST',
                url:"{{route('checkup.redirectToHistory')}}",
                data: {_token: "{{ csrf_token() }}" , patient_id: patient_id , appointment_id: appointment_id},
                beforeSend: function () {
                    
                },
                success:function(data) {
                    window.location.href = "{{route('checkup.history' , '0')}}";
                }
            });

        }

    </script>

    @include('public_portal.checkups.patient_heights')
    @include('public_portal.checkups.patient_weights')
    

    @endsection

