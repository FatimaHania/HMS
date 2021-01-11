@extends('layouts.app')
    @section('content')
    <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    @include('dashboards.admin_dashboard')
                </div>
            </div>
        </div>
    </div>
    @endsection