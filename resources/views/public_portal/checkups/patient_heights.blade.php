<x-modals.basic modal-id="patientHeightModal" modal-size="modal-sm">

    <x-slot name="title">
        <span id="patientHeightModal_title">Height</span>
    </x-slot>

    <div id="patientHeight_div">

        <input type="hidden" id="height_patient_id" name="height_patient_id">
        <input type="hidden" id="height_hospital_id" name="height_patient_id">
        <input type="hidden" id="height_branch_id" name="height_patient_id">
        <input type="hidden" id="height_unit" name="height_unit" value="cm">

        <div class="form-row">
            <!-- Date Field -->
            <div class="form-group col-md-12">
                {!! Form::label('height_date', 'Date:') !!}
                {!! Form::date('height_date', null, ['class' => 'form-control','id'=>'height_date']) !!}
            </div>
        </div>

        <div class="form-row">
            <!-- Height Field -->
            <div class="form-group col-md-12">
                {!! Form::label('height_value', 'Height (cm):') !!}
                {!! Form::number('height_value', null, ['class' => 'form-control','id'=>'height_value']) !!}
            </div>
        </div>

    </div>

    <x-loader loader-id="patientHeightLoader_div" min-height="150px"></x-loader>


    <x-slot name="footer">
        <button class="btn btn-sm btn-primary" onclick="insertPatientHeight()">Submit</button>
    </x-slot>

</x-modals.basic>

@stack('scripts')
<script>

$('#height_date').datepicker({
    format: 'dd/mm/yyyy'
})

function insertPatientHeight() {

    var patient_id = document.getElementById('height_patient_id').value;
    var hospital_id = document.getElementById('height_hospital_id').value;
    var branch_id = document.getElementById('height_branch_id').value;
    var height_unit = document.getElementById('height_unit').value;
    var height_value = document.getElementById('height_value').value;
    var height_date = document.getElementById('height_date').value;

    if(height_value == "" || height_value == null || height_date == "" || height_date == null){
        toastr.error('Please enter a valid height and date', 'Submission Failed!')
    } else {


        $.ajax({
            type:'POST',
            url:"{{route('checkup.insertPatientHeight')}}",
            data: {_token: "{{ csrf_token() }}" , patient_id: patient_id , hospital_id: hospital_id , branch_id: branch_id , height_value: height_value , height_date: height_date , height_unit: height_unit},
            beforeSend: function () { 
                document.getElementById('patientHeight_div').style.display = "none";
                document.getElementById('patientHeightLoader_div').style.display = "block";
            },
            success:function(data) {
                $("#patientHeightModal").modal('hide');
                document.getElementById('height_tag').innerText = height_value+height_unit;
                document.getElementById('patientHeightLoader_div').style.display = "none";
                document.getElementById('patientHeight_div').style.display = "block";
            }
        });

    }

}


</script>