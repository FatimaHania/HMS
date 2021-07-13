
@if(empty($records))

<x-panel_messages>
    <x-slot name="icon">
        <i class="fa fa-exclamation-triangle panel-icon" aria-hidden="true"></i>
    </x-slot>
    <x-slot name="message">
        <span>No records found</span>
    </x-slot>
</x-panel_messages>

@else
        <div class="table-responsive-sm table-report">
            <table class="table table-striped" id="titles-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        @foreach($records[0]['department_total_collection'] as $department)
                            <th style="text-align:center;">{{$department['department']->short_code}}</th>
                        @endforeach
                        <th style="text-align:center;">Total ({{$records[0]['default_currency_short_code']}})</th>
                    </tr>
                </thead>
                <tbody>
                @php $total_for_the_department = array(); @endphp
                @foreach($records as $record)
                    <tr>
                        <td>{{ $record['date'] }}</td>

                        @php $total_for_the_day = 0; @endphp
                        @foreach($record['department_total_collection'] as $department_total_collection)

                            <td style="text-align:center;">{{ number_format((float)$department_total_collection['total_collection'], $records[0]['default_currency_decimal_places'], '.', '') }}</td>

                            @if(array_key_exists($department_total_collection['department']->id, $total_for_the_department))
                                @php $total_for_the_department[$department_total_collection['department']->id] = ($total_for_the_department[$department_total_collection['department']->id])+($department_total_collection['total_collection']); @endphp
                            @else
                                @php $total_for_the_department[$department_total_collection['department']->id] = ($department_total_collection['total_collection']); @endphp
                            @endif

                            @php $total_for_the_day = ($total_for_the_day)+($department_total_collection['total_collection']); @endphp
                        @endforeach

                        <td style="text-align:center;"><b>{{ number_format((float)$total_for_the_day, $records[0]['default_currency_decimal_places'], '.', '') }}</b></td>
                    </tr>

                    
                @endforeach
                    <tr>
                        <td><b>Total ({{$records[0]['default_currency_short_code']}})<b></td>
                        @php $total = 0; @endphp
                        @foreach($records[0]['department_total_collection'] as $department)
                            <td style="text-align:center;"><b>{{ number_format((float)$total_for_the_department[$department['department']->id], $records[0]['default_currency_decimal_places'], '.', '')}}</b></td>
                            @php $total = ($total)+($total_for_the_department[$department['department']->id]); @endphp
                        @endforeach
                        <td style="text-align:center;"><b>{{ number_format((float)$total, $records[0]['default_currency_decimal_places'], '.', '') }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>


@endif

@stack('scripts')
<script>

    $(document).ready(function(){

        @if($records[0]['date'] == $records[(count($records)-1)]['date'])
            var date_range = "{{$records[0]['date']}}";
        @else
            var date_range = "{{ $records[0]['date']}}" + " to " + "{{$records[(count($records)-1)]['date']}}";
        @endif

        $('#card_title').html('Collections - Monthly Report (' + date_range + ')');
    })

    function generateCollectionReportPDF() {

        document.getElementById('filter_date_from').value = $('#filter_date').data('daterangepicker').startDate.format('YYYY-MM-DD');
        document.getElementById('filter_date_to').value = $('#filter_date').data('daterangepicker').endDate.format('YYYY-MM-DD');

        $('#filter_form').submit();


    }

</script>
