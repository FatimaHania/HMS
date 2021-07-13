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
        <li class="breadcrumb-item">Patient Turnover</li>
    </ol>
    <div class="col-md-4 breadcrumb" style="text-align:right !important; display:inline;">
        <!--show filter button-->
        <x-filters.button filter-id="page_filter" button-id="page_filter_button"></x-filters.button>
    </div>
</div>

    <!--filters-->
    {!! Form::open(['route' => 'patientTurnover.pdf', 'id' => 'filter_form']) !!}
    <x-filters.filters filter-id="page_filter">
        <x-slot name="filters">
            <div class="form-row">
                <div class="col-md-5">
                    <label class="control-label" for="filter_date">Date Range:</label>
                    <input type="text" class="form-control" name="filter_date" id="filter_date">
                    <input type="hidden" class="form-control" name="filter_date_from" id="filter_date_from">
                    <input type="hidden" class="form-control" name="filter_date_to" id="filter_date_to">
                </div>
                <div class="col-md-6">
                    <label class="control-label" for="filter_type">Report Type:</label>
                    <select class="form-control selectpicker" id="filter_type" name="filter_type">
                        <option value="daily">Daily Report </option>
                        <option value="monthly">Monthly Report</option>
                        <option value="yearly">Annual Report</option>
                    </select>
                </div>
                <div class="col-md-3 d-none">
                    <label class="control-label" for="filter_department">Department:</label>
                    <select class="form-control selectpicker" id="filter_department" name="filter_department" onchange="updatePhysicianFilter()">
                        <option value="0">All Departments</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}">{{$department->short_code." - ".$department->description}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-none">
                    <label class="control-label" for="filter_physician">Physician:</label>
                    <select class="form-control selectpicker" id="filter_physician" name="filter_physician">
                        <option value="0">All Physicians</option>
                        @foreach($physicians as $physician)
                            <option value="{{$physician->id}}">{{$physician->physician_code." | ".$physician->physician_name}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-1">
                    <label class="control-label" style="visibility:hidden; margin-bottom:3px;">Filter Record:</label>
                    <button type="button" class="btn btn-sm btn-primary pull-right" onclick="getPatientTurnover()"><i class="fa fa-search"></i> Generate</button>
                </div>
            </div>
        </x-slot>
    </x-filters.filters>
    {!! Form::close() !!}

    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>
                    <strong><span id="card_title"> Patient Turnover </span></strong>
                    <a href="#" onclick="generatePatientTurnoverPDF()" id="download_report_btn" class='btn btn-xs btn-secondary pull-right'><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                </div>
                <div class="card-body">

                    <x-loader loader-id="tableLoader_div" min-height="200px"></x-loader>

                    <div id="table_div">
                        @include('reports.patient_turnover.table_daily')
                    </div>
                    
                </div>
            </div>

         </div>
    </div>
@stack('scripts')
<script>
    $(document).ready(function(){

        $('input[name="filter_date"]').daterangepicker({
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        });


    });

    function updatePhysicianFilter() {

        var department_id = document.getElementById('filter_department').value;

            $.ajax({
            type:'POST',
            url:"{{route('patientTurnover.updatePhysicianFilter')}}",
            data: {_token: "{{ csrf_token() }}", department_id: department_id},
            beforeSend: function () { 
                $('#filter_physician').attr('disabled',true).selectpicker('refresh');
            },
            success:function(data) {
                $("#filter_physician").html("<option value='0'>All Physicians</option>"+data);
                $('#filter_physician').attr('disabled',false).selectpicker('refresh');
            }
        });

    }


    function getPatientTurnover() {

        var type = document.getElementById('filter_type').value;
        var date_from = $('#filter_date').data('daterangepicker').startDate.format('YYYY-MM-DD');
        var date_to = $('#filter_date').data('daterangepicker').endDate.format('YYYY-MM-DD');
        var physician_id = document.getElementById('filter_physician').value;
        var department_id = document.getElementById('filter_department').value;

        $.ajax({
            type:'POST',
            url:"{{route('patientTurnover.getPatientTurnover')}}",
            data: {_token: "{{ csrf_token() }}", date_from: date_from, date_to: date_to, physician_id: physician_id, department_id: department_id, type: type},
            beforeSend: function () { 
                document.getElementById('table_div').style.display = "none";
                document.getElementById('tableLoader_div').style.display = "block";
            },
            success:function(data) {
                $("#table_div").html(data);
                document.getElementById('tableLoader_div').style.display = "none";
                document.getElementById('table_div').style.display = "block";
                $('[data-toggle="tooltip"]').tooltip();
            }
        });


    }


</script>

@endsection

