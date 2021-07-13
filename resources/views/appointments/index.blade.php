@extends('layouts.app')

@section('content')
<style>
    ol {
        -webkit-columns: 3 !important;
        -moz-columns: 3 !important;
        columns: 3 !important;
    }
    
</style>

<div class="row">
    <ol class="breadcrumb col-md-8">
        <li class="breadcrumb-item">Appointments</li>
    </ol>
    <div class="col-md-4 breadcrumb" style="text-align:right !important; display:inline;">
        <!--show filter button-->
        <x-filters.button filter-id="page_filter" button-id="page_filter_button"></x-filters.button>
        <!--back to index button-->
        <a class="btn btn-xs btn-danger" id="back_btn" href="#" style="display:none;" onclick="displayView('summary_view')"><i class="fa fa-arrow-circle-o-left fa-lg" aria-hidden="true"></i> Back</a>
    </div>
</div>

    <!--filters-->
    <x-filters.filters filter-id="page_filter">
        <x-slot name="filters">
            <div class="form-row">
                <div class="col-md-3">
                    <label class="control-label" for="filter_date">Date:</label>
                    <input type="text" class="form-control" name="filter_date" id="filter_date">
                </div>
                <div class="col-md-2">
                    <label class="control-label" for="filter_room">Room:</label>
                    <select class="form-control selectpicker" id="filter_room" name="filter_room">
                        <option value="0">All Rooms</option>
                        @foreach($rooms as $room)
                            <option value="{{$room->id}}">{{$room->short_code." - ".$room->description}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="control-label" for="filter_specialization">Specialization:</label>
                    <select class="form-control selectpicker" id="filter_specialization" name="filter_specialization" onchange="updatePhysicianFilter()">
                        <option value="0">All Specializations</option>
                        @foreach($specializations as $specialization)
                            <option value="{{$specialization->id}}">{{$specialization->short_code." - ".$specialization->description}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="control-label" for="filter_physician">Physician:</label>
                    <select class="form-control selectpicker" id="filter_physician" name="filter_physician">
                        <option value="0">All Physicians</option>
                        @foreach($physicians as $physician)
                            <option value="{{$physician->id}}">{{$physician->physician_code." | ".$physician->physician_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="control-label" for="filter_status">Status:</label>
                    <select class="form-control selectpicker" id="filter_status" name="filter_status">
                        <option value="0">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="ongoing">On-going</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="control-label" style="visibility:hidden;">Filter Record:</label>
                    <button class="btn btn-sm btn-secondary pull-right" onclick="getCards()"><i class="fa fa-search"></i> Search</button>
                </div>
            </div>
        </x-slot>
    </x-filters.filters>

    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
                <!--Summary view-->
                <div id="summary_view">

                    <x-loader loader-id="cardsLoader_div" min-height="200px"></x-loader>

                    <div id="cards_div">
                        @include('appointments.cards')
                    </div>
                </div>
                
                <!--Detail view-->
                <div id="detail_view" style="display:none;">
                        <div class="row">
                        <div class="col-lg-12">
                            
                                <x-loader loader-id="detailsLoader_div" min-height="200px"></x-loader>

                                <div id="appointmentDetails_div">

                                </div>
                            </div>
                    </div>
                </div>
         </div>
    </div>
@stack('scripts')
<script>
    $(document).ready(function(){

        var editedSessionId = "{{ session('editedSessionId') }}";
        var editedAppointmentId = "{{ session('editedAppointmentId') }}";

        if(editedSessionId == "" || editedSessionId == null) {} else {
            getAppointmentDetails(editedAppointmentId, editedSessionId) //function in card.blade.php
        }

        $('input[name="filter_date"]').daterangepicker({
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        });


    });



    function displayView(view){

        if(view == "detail_view"){
            document.getElementById('summary_view').style.display = "none";
            document.getElementById('detail_view').style.display = "block";
            document.getElementById('page_filter').style.display = "none";
            document.getElementById('page_filter_button').style.display = "none";
            document.getElementById('back_btn').style.display = "inline-block";
        } else { //summary_view
            document.getElementById('summary_view').style.display = "block";
            document.getElementById('detail_view').style.display = "none";
            document.getElementById('page_filter').style.display = "block";
            document.getElementById('page_filter_button').style.display = "inline-block";
            document.getElementById('back_btn').style.display = "none";
        }

    }


    function updatePhysicianFilter() {

        var specialization_id = document.getElementById('filter_specialization').value;

            $.ajax({
            type:'POST',
            url:"{{route('appointments.updatePhysicianFilter')}}",
            data: {_token: "{{ csrf_token() }}", specialization_id: specialization_id},
            beforeSend: function () { 
                $('#filter_physician').attr('disabled',true).selectpicker('refresh');
            },
            success:function(data) {
                $("#filter_physician").html("<option value='0'>All Physicians</option>"+data);
                $('#filter_physician').attr('disabled',false).selectpicker('refresh');
            }
        });

    }


    function getCards() {

        var date_from = $('#filter_date').data('daterangepicker').startDate.format('YYYY-MM-DD');
        var date_to = $('#filter_date').data('daterangepicker').endDate.format('YYYY-MM-DD');
        var physician_id = document.getElementById('filter_physician').value;
        var specialization_id = document.getElementById('filter_specialization').value;
        var room_id = document.getElementById('filter_room').value;
        var status = document.getElementById('filter_status').value;

        $.ajax({
            type:'POST',
            url:"{{route('appointments.getCards')}}",
            data: {_token: "{{ csrf_token() }}", date_from: date_from, date_to: date_to, physician_id: physician_id, room_id: room_id, specialization_id: specialization_id, status: status},
            beforeSend: function () { 
                document.getElementById('cards_div').style.display = "none";
                document.getElementById('cardsLoader_div').style.display = "block";
            },
            success:function(data) {
                $("#cards_div").html(data);
                document.getElementById('cardsLoader_div').style.display = "none";
                document.getElementById('cards_div').style.display = "block";
                $('[data-toggle="tooltip"]').tooltip();
            }
        });


    }


</script>

@endsection

