<style>
.hospital_div{
    border-radius:4px;
    padding:6px;
    background-color:#ecf2f9;
    margin-bottom:18px;
}

.session_cards{
    padding:8px;
    border-radius:8px;
    background-color:#9ebde0;
    font-size:12px;
    margin-bottom:8px;
    margin-top:4px;
}
</style>

@if(empty($sessions))

<x-panel_messages>
    <x-slot name="icon">
        <i class="fa fa-search panel-icon" aria-hidden="true"></i>
    </x-slot>
    <x-slot name="message">
        <span>No records to display</span>
    </x-slot>
</x-panel_messages>

@else

    @foreach($sessions as $session)
        <h6>{{$session['hospital']}}</h6>
        <div class="hospital_div">
            <span style="font-size:13px;">{{$session['specialization']}}</span>
            @if(($session['records']->isEmpty()))
                <div style="padding:15px; text-align:center;">No sessions available!</div>
            @endif

            @foreach($session['records'] as $session_card)
                <div class="session_cards">
                    <table style="width:100%;">
                        <tr>
                            <td style="border-bottom:1px solid #CCC;"><b>{{$session_card->physician->title->short_code." ".$session_card->physician->physician_name}}</b></td>
                            <td style="border-bottom:1px solid #CCC;"></td>
                        </tr>
                        <tr>
                            <td style=""><span class="badge badge-light">{{date('d-m-Y',strtotime($session_card->date))}} [{{$session_card->start_time."-".$session_card->end_time}}]</span></td>
                            <td style="text-align:right;"><button type="button" class="btn btn-square btn-xs btn-danger">Book Now</button></td>
                        </tr>
                    </table>
                </div>
            @endforeach
        </div>
    @endforeach

@endif