
<?php

$dataPoints1 = array();
$dataPoints2 = array();
foreach($patient_turnover_chart as $record){

    $date = $record['date'];

    $dataPoints2[] = array("label" => $date, "y" => $record['patient_attended_count']);
    $dataPoints1[] = array("label" => $date, "y" => $record['patient_count']);

}
 
 //Patient turnover for the day chart

 $patient_count_attended_percentage = 0;
 $patient_count_NA_percentage = 100;
if($patient_turnover_records[0]['patient_count'] != 0){
    $patient_count_attended_percentage = round((((int)$patient_turnover_records[0]['patient_attended_count']/(int)$patient_turnover_records[0]['patient_count'])*100),0);
    $patient_count_NA_percentage = round(((((int)$patient_turnover_records[0]['patient_count']-(int)$patient_turnover_records[0]['patient_attended_count'])/(int)$patient_turnover_records[0]['patient_count'])*100),0);
}

 $dataPoints = array( 
    array("label"=>"Not Attended", "symbol" => "NA","y"=>$patient_count_NA_percentage),
	array("label"=>"Attended", "symbol" => "A","y"=>$patient_count_attended_percentage)
)
 
?>

<style type="text/css">
    body,
    html {
      height: 100%;
    }
    /* workaround modal-open padding issue */
    
    body.modal-open {
      padding-right: 0 !important;
    }
    
    #sidebar {
      padding-left: 0;
    }
    /*
 * Off Canvas at medium breakpoint
 * --------------------------------------------------
 */
    
    @media screen and (max-width: 48em) {
      .row-offcanvas {
        position: relative;
        -webkit-transition: all 0.25s ease-out;
        -moz-transition: all 0.25s ease-out;
        transition: all 0.25s ease-out;
      }
      .row-offcanvas-left .sidebar-offcanvas {
        left: -33%;
      }
      .row-offcanvas-left.active {
        left: 33%;
        margin-left: -6px;
      }
      .sidebar-offcanvas {
        position: absolute;
        top: 0;
        width: 33%;
        height: 100%;
      }
    }
    /*
 * Off Canvas wider at sm breakpoint
 * --------------------------------------------------
 */
    
    @media screen and (max-width: 34em) {
      .row-offcanvas-left .sidebar-offcanvas {
        left: -45%;
      }
      .row-offcanvas-left.active {
        left: 45%;
        margin-left: -6px;
      }
      .sidebar-offcanvas {
        width: 45%;
      }
    }
    
    .card {
      overflow: hidden;
      border-radius:6px;
    }
    
    .card-block .rotate {
      z-index: 8;
      float: right;
      height: 100%;
    }
    
    .card-block .rotate i {
      color: rgba(20, 20, 20, 0.15);
      position: absolute;
      left: 0;
      left: auto;
      right: 10px;
      bottom: 0;
      display: block;
      -webkit-transform: rotate(-44deg);
      -moz-transform: rotate(-44deg);
      -o-transform: rotate(-44deg);
      -ms-transform: rotate(-44deg);
      transform: rotate(-44deg);
    }

    .demo-content {
        max-width: 1080px;
    }

    .demo-charts {
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
    }
    .demo-chart:nth-child(1) {
        color: #ACEC00;
    }
    .demo-chart:nth-child(2) {
        color: #00BBD6;
    }
    .demo-chart:nth-child(3) {
        color: #BA65C9;
    }
    .demo-chart:nth-child(4) {
        color: #EF3C79;
    }

  </style>

<div class="col-xl-9" style="padding:0px;">
    <div class="row">
        <!--Patient Count-->
        <div class="col-xl-4 col-lg-6">
            <div class="card card-inverse card-success">
                <div class="card-block bg-success" style="padding:15px;">
                    <div class="rotate">
                        <i class="fa fa-user fa-5x" style="font-size:150px;"></i>
                    </div>
                    <h6 class="text-uppercase">Patients</h6>
                    <h2 class="" style="font-size:50px;"><b>{{$patient_count}}</b></h2>
                </div>
            </div>
        </div>

        <!--Physician Count-->
        <div class="col-xl-4 col-lg-6">
            <div class="card card-inverse card-danger">
                <div class="card-block bg-danger" style="padding:15px;">
                    <div class="rotate">
                        <i class="fa fa-stethoscope fa-5x" style="font-size:150px;"></i>
                    </div>
                    <h6 class="text-uppercase">Physician</h6>
                    <h2 class="" style="font-size:50px;"><b>{{$physician_count}}</b></h2>
                </div>
            </div>
        </div>

        <!--Nurse Count-->
        <div class="col-xl-4 col-lg-6">
            <div class="card card-inverse card-info">
                <div class="card-block bg-info" style="padding:15px;">
                    <div class="rotate">
                        <i class="fa fa-medkit fa-5x" style="font-size:150px;"></i>
                    </div>
                    <h6 class="text-uppercase">Nurses</h6>
                    <h2 class="" style="font-size:50px;"><b>{{$nurse_count}}</b></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-12" id="chartContainer" style="height: 370px; width: 96%; padding:10px;"></div>
</div>
<div class="col-xl-3" style="padding:0px;">
    <div class="col-xl-12 col-lg-6">
        <!--Patient Turnover for the day-->
        <div style="text-align:center; padding:5px; background-color:white; margin-bottom:20px; border-radius:5px; border:1px solid #CCC;">
            <span class="badge badge-light">Patient Turnover For The Day</span>
            <div id="chartContainer_todayCount" style="height: 180px; width: 100%;"></div>
        </div>
        <!--Upcoming Sessions-->
        <div class="card card-inverse">
            <div class="card-block" style="padding:8px;">
                <div class="text-center"><span class="badge">Upcoming Sessions</span></div>
                <style>
                    .upcoming-session-cards{
                        text-align:center;
                        font-size:10px;
                        border:2px solid #CCC;
                        border-radius:6px;
                        padding:6px;
                        background-color:#cce5ff;
                        margin-top:8px;
                    }
                </style>
                @foreach($upcoming_sessions as $records)
                    @foreach($records['sessions'] as $upcoming_session)
                        @if($upcoming_session->started_by == null)
                            @php $bg_color = "#cce5ff"; @endphp
                        @else
                            @php $bg_color = "#c6ecc6"; @endphp
                        @endif
                        <div class="upcoming-session-cards" style="background-color:{{$bg_color}};">
                            <b><span>{{ $upcoming_session->physician->title->short_code." ".$upcoming_session->physician->physician_name }}</span></b><br>
                            <span>{{$upcoming_session->start_time}} - {{$upcoming_session->end_time}} [{{$upcoming_session->room->short_code}}]</span><br>
                            <span>Patients - {{count($upcoming_session->appointment)}}</span><br>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
    
@stack('scripts')
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Patient Turnover Chart",
        fontSize: 18
	},
	subtitles: [{
		text: "{{date('d-m-Y', strtotime('-7 days'))}} to {{date('d-m-Y')}}",
		fontSize: 14,
        fontColor:"#CCC"
	}],
	axisY:{
		suffix: "#"
	},
	legend:{
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	toolTip: {
		shared: true,
		reversed: true
	},
	data: [
        {
			type: "area",
			name: "Expected Patients",
			showInLegend: true,
			yValueFormatString: "#0.0#\"#\"",
			dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
		},
		{
			type: "area",
			name: "Patient Turnover",
			showInLegend: true,
			yValueFormatString: "#0.0#\"#\"",
			dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
		}
	]
});
 
chart.render();
 
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}

 
 var chart = new CanvasJS.Chart("chartContainer_todayCount", {
     theme: "light2",
     animationEnabled: true,
     title: {
         text: ""
     },
     data: [{
         type: "doughnut",
         indexLabel: "{symbol} - {y}",
         yValueFormatString: "#,##0.0\"%\"",
         showInLegend: true,
         legendText: "{label} : {y}",
         dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
     }]
 });
 chart.render();
 
}
</script>



    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>