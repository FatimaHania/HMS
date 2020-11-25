@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Patient Files</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card" style="margin-bottom:5px;">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             PatientFiles
                             <a class="pull-right" href="{{ route('patientFiles.create') }}"><i class="fa fa-plus-square fa-lg"></i></a>
                         </div>
                         <div class="card-body">
                         <div class="well well-sm">
                                <div class="row">
                                    <div class="col-sm-12">
                                        {!! Form::label('filter_patientFile_id', 'Session:') !!}
                                        <select class="selectpicker form-control" id="filter_patient_id" onchange="getPatientFiles(this)" data-live-search="true">
                                        <option value="0">Select Patient</option>
                                            @foreach($patients as $patient)
                                                <option value="{{$patient->id}}">
                                                    {{$patient->patient_code." | ".$patient->patient_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                             <!--@include('patient_files.table')-->
                              <div class="pull-right mr-3">
                                     
                              </div>
                         </div>
                     </div>
                  </div>
                  <div class="col-lg-12">
                        <x-loader loader-id="detailsLoader_div" min-height="200px"></x-loader>

                        <div id="patientFiles_div">

                        </div>
                    </div>
             </div>
         </div>
    </div>
    @stack('scripts')
<script>
    $(document).ready(function(){

        var editedPatientId = "{{ session('editedPatientId') }}";

        if(editedPatientId == "" || editedPatientId == null) {} else {
            $('#filter_patient_id').val(editedPatientId).trigger('change');
            $('#filter_patient_id').selectpicker('refresh');
            
        }

    })

function getPatientFiles(x) {

    var patientId = document.getElementById('filter_patient_id').value;

    if(patientId == "" || patientId == null || patientId == '0'){} else {

        $.ajax({
            type:'POST',
            url:"{{route('patientFiles.getPatientFiles')}}",
            data: {_token: "{{ csrf_token() }}" , patientId: patientId},
            beforeSend: function () {
                document.getElementById('patientFiles_div').style.display = "none";
                document.getElementById('detailsLoader_div').style.display = "block";
            },
            success:function(data) {
                $("#patientFiles_div").html(data);
                document.getElementById('detailsLoader_div').style.display = "none";
                document.getElementById('patientFiles_div').style.display = "block";

            }
        });

    } 

}

</script>
@endsection

