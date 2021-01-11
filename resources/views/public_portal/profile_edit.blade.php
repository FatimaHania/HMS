
<!--Edit profile modal-->
<x-modals.basic modal-id="editProfileModal" modal-size="modal-sm">
    <x-slot name="title">
        <span id="editProfileModal_title">Edit Profile</span>
    </x-slot>

    <div id="editProfile_div">
    {!! Form::model(Auth::user(), ['route' => ['users.updateUserProfile', Auth::user()->id], 'method' => 'post', 'id' => 'editProfile_form', 'files' => true]) !!}

        <!-- user image Field -->
        <div class="col-sm-12">
            <x-inputs.image name="user_image" height="140px" width="140px" class="picture" picture="user_preview" default-image="sys_public_user.png"></x-inputs.image>
        </div>

        <!-- User name -->
        <div class="form-group col-sm-12">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', Auth::user()->name, ['class' => 'form-control']) !!}
        </div>

        <!-- Email -->
        <div class="form-group col-sm-12">
            {!! Form::label('email', 'Email:') !!}
            {!! Form::email('email', Auth::user()->email, ['class' => 'form-control']) !!}
        </div>

        <!-- Hidden Field -->
        <div>
            {!! Form::hidden('password','****', ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
            {!! Form::hidden('usertype_id', '2' , ['class' => 'form-control']) !!}
            {!! Form::hidden('hospital_id', null , ['class' => 'form-control']) !!}
            {!! Form::hidden('branch_id', null , ['class' => 'form-control']) !!}
        </div>

        {!! Form::close() !!}
    </div>



    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" type="button" onclick="submitEditProfileForm()">Submit</button> 
    </x-slot>
</x-modals.basic>

@stack('scripts')
<script>

function submitEditProfileForm() {

    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;

    if(name == "" || name == null){
        toastr.error('Please enter your name.', 'Name required!')
    } else {
        if(email == "" || email == null){
            toastr.error('Please enter an email address.', 'Email required!')
        } else {
            $('#editProfile_form').submit();
        }
    }

}

</script>