@section('css')
    @include('layouts.datatables_css')
@endsection

<div class="table-responsive">

{!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped ']) !!}

</div>

@push('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush
