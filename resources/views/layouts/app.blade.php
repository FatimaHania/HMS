<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{config('app.name')}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!--<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->

    <!-- Bootstrap 4.1.1 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/css/coreui.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/coreui-icons-free@1.0.1-alpha.1/coreui-icons-free.css">

    <link rel="shortcut icon" href="{{ asset('storage/images/sys_system_logo_favicon.png') }}">

     <!-- PRO version // if you have PRO version licence than remove comment and use it. -->
    {{--<link rel="stylesheet" href="https://unpkg.com/@coreui/icons@1.0.0/css/brand.min.css">--}}
    {{--<link rel="stylesheet" href="https://unpkg.com/@coreui/icons@1.0.0/css/flag.min.css">--}}
     <!-- PRO version -->

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">

    <!-- bootstrap select -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">

    <!-- toastr css - for notifications -->
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">

    <!-- icheck- for radio button and checkboxes -->
    <link rel="stylesheet" href="{{ asset('css/icheck/purple.css') }}">
    
    <!--daterange picker-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="{{asset('storage/images/sys_system_logo.png')}}" width="120" height="30"
             alt="HMS Logo">
        <img class="navbar-brand-minimized" src="{{asset('storage/images/sys_system_logo.png')}}" width="120"
             height="40" alt="HMS Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav pull-left" style="float:left;">
    <li class="nav-item dropdown">
            <a class="nav-link" style="margin-right: 10px" data-toggle="dropdown" href="#" role="button"
               aria-haspopup="true" aria-expanded="false">
               <img class="align-middle" id="session_card_logo_image" src="{{ URL::to('/').'/storage/'.session('user_details')[session('branch_id')]['hospitals']->logo }}"  width="45px" style="border-radius:50%; margin:5px; border:3px solid #f2f2f2;">
               <b>{{ strtoupper(session('user_details')[session('branch_id')]['hospitals']->hospital_name) }}, {{ strtoupper(session('user_details')[session('branch_id')]['hospitals']->branch_name) }}</b>
            </a>
        </li>
    </ul>

    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-hospital-o" aria-hidden="true" style="font-size:18px; color:#2d5986;"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
            @foreach (session('user_details') as $user_details)

                <a class="dropdown-item" href="#" onclick="shift_branch({{ $user_details['hospitals']->hospital_id }} , {{ $user_details['hospitals']->branch_id }})">
                    {{ $user_details['hospitals']->hospital_name.", ".$user_details['hospitals']->branch_name}}
                </a>

            @endforeach
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" style="margin-right: 10px" data-toggle="dropdown" href="#" role="button"
               aria-haspopup="true" aria-expanded="false">
               <img class="align-middle" id="session_card_logo_image" src="{{ URL::to('/').Auth::user()->userImage() }}"  width="45px" style="border-radius:50%; margin:5px; border:3px solid #f2f2f2;">
               <b>{{ Auth::user()->name }}</b>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ url('/logout') }}" class="dropdown-item btn btn-default btn-flat"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i>Logout
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</header>

<div class="app-body">
    @include('layouts.sidebar')
    <main class="main">
        @yield('content')
    </main>
</div>
<footer class="app-footer">
    <div>
        <a href="https://hms.com">Smart Medicare </a>
        <span>&copy; 2020 Hospital Management System.</span>
    </div>
    <div class="ml-auto">
        <span>Powered by</span>
        <a href="#">GEARS</a>
    </div>
</footer>

</body>

<script>

function shift_branch(hospital_id , branch_id) {

    $.ajax({
               type:'POST',
               url:"{{route('changeSession')}}",
               data: {_token: "{{ csrf_token() }}" , hospital_id: hospital_id , branch_id: branch_id},
               beforeSend: function () { },
               success:function(data) {
                window.location.href = "{{ route('home') }}";
               }
            });

}

    //confirm if logged in user is a hospital user
    @if(session('is_hospital') == '0')
        document.getElementById('logout-form').submit();
    @endif
</script>

<!-- jQuery 3.1.1 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Custom js -->
<script src="{{ asset('js/custom.js') }}"></script>

<!-- Bootstrap select -->
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

<!-- Toastr js - for notifications -->
<script src="{{ asset('js/toastr.min.js') }}"></script>

<!-- iCheck - for checkboxes and radio buttons -->
<script src="{{ asset('js/icheck.min.js') }}"></script>

<!-- Bootbox -->
<script src="{{ asset('js/bootbox.min.js') }}"></script>

<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>

@toastr_render

@stack('scripts')


</html>
