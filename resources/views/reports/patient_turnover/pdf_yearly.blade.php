<x-report_header>
    <x-slot name="report_title">
        Patient Turnover - Annual Report ({{ $records[0]['date']." to ".$records[(count($records)-1)]['date'] }})
    </x-slot>
</x-report_header>
@include('reports.patient_turnover.table_yearly')
