<style>

    .session_list {
        font-size :12px;
    }

    .session_list_td {
        padding:5px;
    }

    .session_date {
        text-align:center;
        border-radius : 75px ;
        padding: 8px ;
        min-height :65px;
        border:2px solid #f2f2f2;
        background-color:white;
    }

    .session_detail {
        border-radius : 5px ;
        padding: 5px ;
        padding-left:10px;
        border:1px solid #f2f2f2;
        min-height :65px;
    }

    .session_list > div > table {
        margin-bottom: 4px;
        background-color:#f2f2f2;
    }

    .session_list {
        max-height:350px;
        overflow-y: auto ;
        overflow-x: hidden ;
    }

</style>

<div class="session_list">

@foreach($sessions as $session)

    @if($session->is_cancelled == "1")
        @php
            $status = '<span class="badge badge-danger">Cancelled</span>';
            $background_color = 'bg-danger';
        @endphp
    @else 
        @if($session->completed_at == null || $session->completed_at == "")
            @php
                $status = '<span class="badge badge-warning">Pending</span>';
                $background_color = 'bg-secondary';
            @endphp
        @else
            @php
                $status = '<span class="badge badge-info">Completed</span>';
                $background_color = 'bg-info';
            @endphp
        @endif
    @endif

<div id="physicianSessionListItem{{(intval(preg_replace('/[^0-9]+/', '', $session->date), 10))}}">
<table width="100%">
    <tr>
        <td width="15%" class="session_list_td align-middle">
            <div class="session_date text-dark {{$background_color}}">
                <b>{{ date('l', strtotime($session->date)) }}</b><br>
                <span class="badge badge-secondary">{{ date("jS M, Y", strtotime($session->date)) }}</span><br>
            </div>
        </td>
        <td class="session_list_td align-middle">
            <div class="session_detail text-dark">
            <b>{{ $session->name }}</b> | <span class="badge badge-light"> {{ (date("g:i A",(strtotime($session->start_time))))." - ".(date("g:i A", (strtotime($session->end_time)))) }}</span>
                <span class="pull-right">
                    {!! Form::open(['route' => ['sessions.destroy', $session->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('sessions.show', [$session->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-eye"></i></a>
                            <a href="{{ route('sessions.edit', [$session->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                            {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                    {!! Form::close() !!}
                </span>
                <hr style="margin-top:6px; margin-bottom: 6px;">
                <div class="row">
                    <div class="col-md-2">Room <span class="badge badge-secondary">{{ $session->room->short_code }}</span></div>
                    <div class="col-md-2">#Slots <span class="badge badge-info">{{ $session->number_of_slots }}</span></div>
                    <div class="col-md-2">Booked <span class="badge badge-success">
                        @php $a = 0; @endphp
                        @foreach($session->appointment as $appointment)
                            @if($appointment->is_cancelled == '1')
                            @else 
                                @php $a++; @endphp
                            @endif
                        @endforeach
                        {{$a}}
                        
                    </span></div>
                    <div class="col-md-3">Amount <span class="badge badge-secondary">{{ $session->currency->short_code." ".$session->amount_per_slot }}</span></div>
                    <div class="col-md-3" style="text-align:right;">
                        @php echo $status; @endphp
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>
</div>

@endforeach

</div>

