@extends('public_portal.layouts.app')
    @section('content')
    <div class="container-fluid" style="padding-top:6px !important;">
            <div class="animated fadeIn">
                <div class="row">
                    @include('public_portal.dashboard')
                </div>
            </div>
        </div>
    </div>
    @endsection