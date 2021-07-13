@extends('public_portal.layouts.app')
<style>

    .panel{
        margin-top:10px;
    }

    
</style>


    @section('content')

    <div class="card panel">
        <div class="card-header">
            @if(!empty($patient))
            <img id="patient_img" src="{{ URL::to('/').$patient->patientImage() }}" height="35px" width="35px" style="border-radius:50%; border:2px solid #f2f2f2; margin-left:-8px; margin-top:-8px; margin-bottom:-8px;"><b> {{ $patient->patient_name }} - Checkup History</b>
            <span class="pull-right">
                @if(session('history_back_page') == 'physician_appointments') <!--Physician portal - appointments page-->
                    <button type="button" class="btn btn-square btn-xs btn-danger" onclick="redirect_to_appointments('{{ $appointment->session_id }}')"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</button>
                @elseif(session('history_back_page') == 'create_medical_record')  <!--Physician portal - create medical page page-->
                    <button type="button" class="btn btn-square btn-xs btn-danger" onclick="redirect_to_checkups('{{ $appointment->id }}')"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</button>
                @elseif(session('history_back_page') == 'dashboard')  <!--Patient or Physician portal - dashboard-->
                    <button type="button" class="btn btn-square btn-xs btn-danger" onclick="redirect_to_dashboard()"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</button>
                @elseif(session('history_back_page') == 'patients')  <!--hospital portal - patients page-->
                    <button type="button" class="btn btn-square btn-xs btn-danger" onclick="redirect_to_patients()"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</button>
                @endif
            </span>
            @endif
        </div>
        <div class="card-body">

        @if($checkup_history->isEmpty()) <!--if no records-->
            <x-panel_messages>
                <x-slot name="icon">
                    <i class="fa fa-exclamation-triangle panel-icon" aria-hidden="true"></i>
                </x-slot>
                <x-slot name="message">
                    <span>No medical records available</span>
                </x-slot>
            </x-panel_messages>
        @endif


        @foreach($checkup_history as $history)

            <table style="width:100%; font-size:12px;">
                <tr>  
                    <td style="width:20%;">
                        <b style="margin:0px; padding:0px; margin-left:-10px;"> <span class="badge badge-info text-white" style="padding:6px;"><i class="fa fa-calendar-check-o" style="font-weight:bold;" aria-hidden="true"></i> {{ date("jS M, Y l" , strtotime($history->appointment->session->date)) }}</span></b>
                    </td>
                    <td style="width:80%; background-color:#e6e6e6; border-radius: 15px 0px 0px 0px; text-align:left; padding:4px; padding-left:18px; padding-right:10px; font-weight:500; color:#8c8c8c; vertical-align;middle;">
                        {{$history->appointment->session->physician->title->short_code}} {{ $history->appointment->session->physician->physician_name }} @ {{ $history->appointment->hospital->name.", ".$history->appointment->branch->name }}
                        <span class="pull-right">
                            {!! Form::open(['route' => ['checkup.printPrescription'], 'method' => 'post' , 'style' => 'margin-bottom:0px;' , 'target' => '_blank']) !!}
                                <input type="hidden" name="checkup_id" value="{{$history->checkup_id}}">
                                <button type="submit" class="btn btn-primary btn-xs"><b><i class="fa fa-print" aria-hidden="true"></i> Print</b></button>
                                <a type="button" class="btn btn-success btn-xs" target="_blank" href="{{ URL::to('/').$history->attachment() }}"><b><i class="fa fa-paperclip" aria-hidden="true"></i></b></a>
                            {!! Form::close() !!}
                        </span>
                    </td>
                </tr>
                <tr>  
                    <td style="padding:1px; border-left:3px solid #cccccc;"></td>
                    <td style="background-color:#e6e6e6; background-color:#e6e6e6;"></td>
                </tr>
                <tr>
                    <td colspan="2" style="border-left:3px solid #cccccc; padding-left:10px; padding-bottom:30px;">
                        <div class="row" style="border:2px solid #e6e6e6; padding:5px; min-height:75px;">
                            <div class="col-md-4" style="border-radius:5px; background-color:#e6f7ff;">
                                <b>Prescription: </b><br>
                                <pre>{{ $history->prescription }}</pre>
                            </div>
                            <div class="col-md-2">
                                <b>Complains: </b><br>
                                <pre>{{ $history->complains }}</pre>
                            </div>
                            <div class="col-md-2">
                                <b>Observations: </b><br>
                                <pre>{{ $history->observations }}</pre>
                            </div>
                            <div class="col-md-2">
                                <b>Diagnosis: </b><br>
                                <pre>{{ $history->diagnosis }}</pre>
                            </div>
                            <div class="col-md-2">
                                <b>Treatment: </b><br>
                                <pre>{{ $history->treatment }}</pre>
                            </div>
                            
                        </div>
                    </td>
                </tr>
            </table>

        @endforeach

        </div>
    </div>

    @stack('scripts')
    <script>

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

        function redirect_to_checkups(appointment_id){

            $.ajax({
                    type:'POST',
                    url:"{{route('publicPortal.redirectToCheckups')}}",
                    data: {_token: "{{ csrf_token() }}" , appointment_id: appointment_id},
                    beforeSend: function () {
                        
                    },
                    success:function(data) {
                        window.location.href = "{{route('checkup.create' , '0')}}";
                    }
                });

        }

        function redirect_to_patients(){
            window.location.href = "{{route('patients.index')}}";
        }


        function redirect_to_dashboard(){
            window.location.href = "{{route('home')}}";
        }


    </script>

    

    @endsection

    @stack('scripts')
    
    


