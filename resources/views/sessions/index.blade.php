@extends('layouts.app')

@section('content')
    
<div class="row">
    <ol class="breadcrumb col-md-8">
        <li class="breadcrumb-item">Sessions</li>
    </ol>
    <div class="col-md-4 breadcrumb" style="text-align:right !important; display:inline;">
        <!-- create session button-->
        <a class="btn btn-xs btn-primary" href="{{ route('sessions.create') }}"><i class="fa fa-plus-square"></i> create session</a>
        <!--show filter button-->
        <x-filters.button filter-id="page_filter" button-id="page_filter_button"></x-filters.button>
    </div>
</div>

<!--filters-->
<x-filters.filters filter-id="page_filter">
    <x-slot name="filters">
        <div class="form-row">
            <div class="col-md-6">
                {!! Form::label('filter_physician_id', 'Physician:') !!}
                <select class="form-control selectpicker" id="filter_physician_id" data-live-search="true" onchange="getSessionDates(this); getSessionDetails(this);">
                    <option value='0'>Select Physician</option>
                    @foreach($physicians as $physician)
                        <option value="{{$physician->id}}">{{$physician->physician_code." | ".$physician->physician_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                {!! Form::label('filter_session_date', 'Session Date:') !!}
                {!! Form::select('filter_session_date', ['Select Date'], null, ['class' => 'selectpicker form-control' , 'onchange' => 'scrollToSessionDate();' , 'data-live-search' => "true"]) !!}
            </div>
        </div>
    </x-slot>
</x-filters.filters>

<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        <x-loader loader-id="detailsLoader_div" min-height="200px"></x-loader>
        <div id="sessionDetails_div"></div>
    </div>
</div>

@stack('scripts')
<script>

    $(document).ready(function(){

        var editedPhysicianId = "{{ session('editedPhysicianId') }}";
        var editedSessionDate = "{{ session('editedSessionDate') }}";
        
        if(editedPhysicianId == "" || editedPhysicianId == null) {} else {
            $('#filter_physician_id').val(editedPhysicianId).trigger('change');
            $('#filter_physician_id').selectpicker('refresh');
            
        }

        //display filter on page load
        $('#page_filter_button').click();

    })

    function getSessionDates(x) {

        var physician_id = x.value;

        if(physician_id == "" || physician_id == null){} else {

            $.ajax({
                type:'POST',
                url:"{{route('sessions.getSessionDates')}}",
                data: {_token: "{{ csrf_token() }}" , physician_id: physician_id},
                beforeSend: function () { 
                    document.getElementById('filter_session_date').readonly = true;
                },
                success:function(data) {
                    $("#filter_session_date").html(data);
                    $("#filter_session_date").selectpicker('refresh');
                    document.getElementById('filter_session_date').readonly = false;

                }
            });

        } 

    }


    function getSessionDetails(x) {

        var filter_id = x.id;
        var physician_id = document.getElementById('filter_physician_id').value;

        if(filter_id == "filter_physician_id"){
            var session_date = '0';
        } else {
            session_date = document.getElementById('filter_session_date').value;
        }

        if(physician_id == "" || physician_id == null){} else {

            $.ajax({
                type:'POST',
                url:"{{route('sessions.getSessionDetails')}}",
                data: {_token: "{{ csrf_token() }}" , physician_id: physician_id , session_date: session_date},
                beforeSend: function () {
                    document.getElementById('sessionDetails_div').style.display = "none";
                    document.getElementById('detailsLoader_div').style.display = "block";
                },
                success:function(data) {
                    $("#sessionDetails_div").html(data);
                    $("#filter_session_date").selectpicker('refresh');
                    document.getElementById('detailsLoader_div').style.display = "none";
                    document.getElementById('sessionDetails_div').style.display = "block";

                    var editedSessionDate = "{{ session('editedSessionDate') }}";
        
                    if(editedSessionDate == "" || editedSessionDate == null) {} else {
                        $('#filter_session_date').val(editedSessionDate).trigger('change');
                        $('#filter_session_date').selectpicker('refresh');

                    }

                }
            });

        } 

    }

    function scrollToSessionDate(sess_date=0) {

        if(sess_date == "0"){
            var session_date = document.getElementById('filter_session_date').value;
        } else {
            var session_date = sess_date;
        }

        if(session_date == "" || session_date == null || session_date == 0){} else {
            var numb = session_date.match(/\d/g);
            numb = numb.join("");

            document.getElementById("physicianSessionListItem"+numb).scrollIntoView(true);
            // $('#physicianSessionListItem'+numb).css('background-color','red');
        }

    }

</script>

@endsection

