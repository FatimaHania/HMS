<x-report_header>
    <x-slot name="report_title">
        Collections - Annual Report ({{ $records[0]['date']." to ".$records[(count($records)-1)]['date'] }})
    </x-slot>
</x-report_header>
@include('reports.collection_reports.table_yearly')
