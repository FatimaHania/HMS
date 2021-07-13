 <style>

@page { margin: 0px; }
body { margin: 0px; }

#header_div{
    margin-top:75px;
    margin-bottom:12px;
    background-color:#3973ac;
    padding:20px;
    padding-left:125px;
    padding-right:125px;
    color:white;
}

#footer_div{
    margin-top:12px;
    margin-bottom:75px;
    background-color:#3973ac;
    padding:5px;
    padding-left:125px;
    padding-right:125px;
    color:white;
    font-size:12px;
}

#content_div{
    padding:10px;
    padding-left:125px;
    padding-right:125px;
}

#phy_table{
    width:100%; 
    border-top:1px solid #CCC; 
    border-bottom:1px solid #CCC; 
    margin-bottom:40px; 
    margin-top:20px;
}

#phy_table td {
    padding:4px;
    font-size:12px;
}

#prescription_div{
    padding:4px;
    font-size:13px;
    white-space:pre-line;
    line-height: 2;
    
}

#patient_table {
    margin-bottom:20px; 
    margin-top:40px;
}

#patient_table td {
    padding:4px;
    font-size:13px;
}

#signature_table {
    margin-bottom:20px; 
    margin-top:250px;
    font-size:13px;
}

#hospital_name{
    font-size:25px;
    font-weight:bold;
}

#hospital_address{
    font-size:12px;
    line-height:1.6;
    letter-spacing: 1px;
}



</style>

<div id="header_div">
    <table style="width:100%;">
        <tr style="vertical-align:middle;">
            <td style="width:80%; vertical-align:middle;">
                <span id="hospital_name">{{ (session('user_details')[session('branch_id')]['hospitals']->hospital_name) }}, {{ (session('user_details')[session('branch_id')]['hospitals']->branch_name) }}</span><br>
                <span id="hospital_address">
                    {{ (session('user_details')[session('branch_id')]['hospitals']->address) }}<br>
                    {{ (session('user_details')[session('branch_id')]['hospitals']->telephone_code)."-".(session('user_details')[session('branch_id')]['hospitals']->telephone_2) }} / {{ (session('user_details')[session('branch_id')]['hospitals']->telephone_code)."-".(session('user_details')[session('branch_id')]['hospitals']->telephone_1) }}
                </span>
            </td>
            <td style="vertical-align:middle; text-align:right ;">
                <img id="hospital_logo" src="{{ URL::to('/').'/storage/'.session('user_details')[session('branch_id')]['hospitals']->logo }}" height="80px" width="80px" style="margin-bottom:-10px; border-radius:50%;">
            </td>
        </tr>
    </table>

</div>

<div id="content_div">

    @php $physician_specialization_array = array(); @endphp
    @foreach ($checkup->appointment->session->physician->specializations as $specialization)
        @php $physician_specialization_array[] = $specialization->description; @endphp
    @endforeach

    <table id="phy_table">
        <tr>
            <td style="width:50%; color:#3366cc;">{{$checkup->appointment->session->physician->title->short_code." ".$checkup->appointment->session->physician->physician_name}}</td>
            <td style="width:50%; text-align:right;">App No: {{$checkup->appointment->reference_code}}</td>
        </tr>
        <tr>
            <td style="width:50%;">[{{  join(" , ",$physician_specialization_array) }}]</td>
            <td style="width:50%; text-align:right;">{{ date("jS M, Y", strtotime($checkup->appointment->session->date)) }}</td>
        </tr>
    </table>

    <div id="prescription_div">
            {{ ($checkup->prescription) }}
    </div>

    <table id="patient_table">
        <tr>
            <td style="width:25%; color:#3366cc;">Name: </td>
            <td style="">{{$checkup->appointment->patient->patient_name}}</td>
        </tr>
        <tr>
            <td style="width:25%; color:#3366cc;">Age: </td>
            <td style="">{{\Carbon\Carbon::parse($checkup->appointment->patient->dob)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days')}}</td>
        </tr>
        <tr>
            <td style="width:25%; color:#3366cc;">Address: </td>
            <td style="">{{$checkup->appointment->patient->address}}</td>
        </tr>
        <tr>
            <td style="width:25%; color:#3366cc;">Contact Number: </td>
            <td style="">{{$checkup->appointment->patient->telephone}}</td>
        </tr>
    </table>

    <table id="signature_table" style="width:100%;">
        <tr>
            <td style="width:40%;"></td>
            <td style="width:20%;"></td>
            <td style="width:40%;"></td>
        </tr>
        <tr>
            <td style="width:40%; border-top:1px dotted; text-align:center;">Physician Signature</td>
            <td style="width:20%;"></td>
            <td style="width:40%; border-top:1px dotted; text-align:center;">Date</td>
        </tr>
    </table>

</div>


