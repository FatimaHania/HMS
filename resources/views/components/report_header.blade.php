<!-- Bootstrap 4.1.1 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<style>
    .table-report{
        font-size:13px;
    }

    .table-report table{
        border:1px solid #CCC;
    }

    .table-report table th{
        padding:2px !important;
        padding-left:5px;
        background-color:#f2f2f2;
        border:1px solid #f2f2f2;
    }

    .table-report table td{
        background-color:white;
        padding:2px !important;
        padding-left:5px;
        border:1px solid #f2f2f2;
    }
</style>
@php $telephone_code = session('user_details')[session('branch_id')]['hospitals']->telephone_code; @endphp
<table width="100%">
    <tr>
        <td style="width:12%; vertical-align:center;">
            <img class="align-middle" id="session_card_logo_image" src="{{ URL::to('/').'/storage/'.session('user_details')[session('branch_id')]['hospitals']->logo }}"  width="65px" style="border-radius:50%; margin:5px; border:3px solid #f2f2f2;">
        </td>
        <td style="width:88%; vertical-align:center;">
            <div style="font-size:20px; margin-bottom:0px;"><b>{{ (session('user_details')[session('branch_id')]['hospitals']->hospital_name) }}, {{ (session('user_details')[session('branch_id')]['hospitals']->branch_name) }}</b></div>
            <div style="font-size:12px;">{{ (session('user_details')[session('branch_id')]['hospitals']->address) }}</div>
            <div style="font-size:12px;">{{ $telephone_code.(session('user_details')[session('branch_id')]['hospitals']->telephone_1." / ".$telephone_code.session('user_details')[session('branch_id')]['hospitals']->telephone_2) }}</div>
        </td>
    </tr>
</table>
<hr style="margin-bottom:5px; margin-top:2px;">
<table width="100%" style="font-size:13px; margin-bottom:4px;">
    <tr>
        <td style="width:50%;">
            <span>
                {{$report_title}}
            </span>
        </td>
        <td style="width:50%; text-align:right;">
            Report Date: {{date("jS M, Y")}}
        </td>
    </tr>
</table>