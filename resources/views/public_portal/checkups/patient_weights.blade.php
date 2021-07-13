<x-modals.basic modal-id="patientWeightModal" modal-size="modal-sm">

    <x-slot name="title">
        <span id="patientWeightModal_title">Height</span>
    </x-slot>

    <div id="patientWeight_div">

        <input type="hidden" id="weight_patient_id" name="weight_patient_id">
        <input type="hidden" id="weight_hospital_id" name="weight_hospital_id">
        <input type="hidden" id="weight_branch_id" name="weight_branch_id">
        <input type="hidden" id="weight_unit" name="weight_unit" value="kg">

        <div class="form-row">
            <!-- Date Field -->
            <div class="form-group col-md-12">
                {!! Form::label('weight_date', 'Date:') !!}
                {!! Form::date('weight_date', null, ['class' => 'form-control','id'=>'weight_date']) !!}
            </div>
        </div>

        <div class="form-row">
            <!-- Weight Field -->
            <div class="form-group col-md-12">
                {!! Form::label('weight_value', 'Weight (Kg):') !!}
                {!! Form::number('weight_value', null, ['class' => 'form-control','id'=>'weight_value']) !!}
            </div>
        </div>

    </div>

    <x-loader loader-id="patientWeightLoader_div" min-height="150px"></x-loader>


    <x-slot name="footer">
        <button class="btn btn-sm btn-primary" onclick="insertPatientWeight()">Submit</button>
    </x-slot>

</x-modals.basic>

@stack('scripts')
<script>

$('#height_date').datepicker({
    format: 'dd/mm/yyyy'
})

function insertPatientWeight() {

    var patient_id = document.getElementById('weight_patient_id').value;
    var hospital_id = document.getElementById('weight_hospital_id').value;
    var branch_id = document.getElementById('weight_branch_id').value;
    var weight_unit = document.getElementById('weight_unit').value;
    var weight_value = document.getElementById('weight_value').value;
    var weight_date = document.getElementById('weight_date').value;

    if(weight_value == "" || weight_value == null || weight_date == "" || weight_date == null){
        toastr.error('Please enter a valid weight and date', 'Submission Failed!')
    } else {

        $.ajax({
            type:'POST',
            url:"{{route('checkup.insertPatientWeight')}}",
            data: {_token: "{{ csrf_token() }}" , patient_id: patient_id , hospital_id: hospital_id , branch_id: branch_id , weight_value: weight_value , weight_date: weight_date , weight_unit: weight_unit},
            beforeSend: function () { 
                document.getElementById('patientWeight_div').style.display = "none";
                document.getElementById('patientWeightLoader_div').style.display = "block";
            },
            success:function(data) {
                $("#patientWeightModal").modal('hide');
                document.getElementById('weight_tag').innerText = weight_value+weight_unit;
                document.getElementById('patientWeightLoader_div').style.display = "none";
                document.getElementById('patientWeight_div').style.display = "block";
            }
        });

    }

}


</script>