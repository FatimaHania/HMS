@if(Auth::user()->usertype_id == '1') <!--HOSPITAL DASHBOARD-->

    @include('home_hospital')

@elseif(Auth::user()->usertype_id == '2') <!--PATIENT/PHYSICIAN DASHBOARD-->

    @include('home_public')


@else

    No Dashboard to display

@endif
