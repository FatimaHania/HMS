
<!--Edit profile modal-->
<x-modals.basic modal-id="linkHospitalModal" modal-size="">
    <x-slot name="title">
        <span id="linkHospitalModal_title">Link Hospital</span>
    </x-slot>

    <div id="editProfile_div">
    {!! Form::model(Auth::user(), ['route' => ['users.linkHospital', Auth::user()->id], 'method' => 'post', 'id' => 'linkHospital_form']) !!}

        <div class="form-row">
            <div class="form-group col-md-12">
                <label class="control-label" for="link_type">Link Type:</label>
                <select class="form-control selectpicker" id="link_type" name="link_type">
                    <option value="" selected="selected" disabled="disabled">Select Type</option>
                    <option value="0">Patient</option>
                    <option value="1">Physician</option>   
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label class="control-label" for="link_hospital">Hospital:</label>
                <select class="form-control selectpicker" id="link_hospital" name="link_hospital">
                    <option value="" selected="selected" disabled="disabled">Select Hospital</option>
                    @foreach($branches as $branch)
                        <option value="{{$branch->id}}">{{$branch->hospital->name.", ".$branch->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Identity_number -->
        <div class="form-row">
            <div class="form-group col-sm-12">
                {!! Form::label('passport_no', 'Identity/Passport Number:') !!}
                {!! Form::text('passport_no', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- Email -->
        <div class="form-row">
            <div class="form-group col-sm-12">
                {!! Form::label('registered_email', 'Registered Email:') !!}
                {!! Form::email('registered_email', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>



    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" type="button" onclick="submitLinkHospitalForm()">Submit</button> 
    </x-slot>
</x-modals.basic>

@stack('scripts')
<script>

function submitLinkHospitalForm() {

    var link_hospital = document.getElementById('link_hospital').value;
    var registered_email = document.getElementById('registered_email').value;

    if(link_hospital == "" || link_hospital == null){
        toastr.error('Please select a hospital.', 'Hospital required!')
    } else {
        if(registered_email == "" || registered_email == null){
            toastr.error('Please enter the email registered with the hospital.', 'Email required!')
        } else {
            $('#linkHospital_form').submit();
        }
    }

}

</script>