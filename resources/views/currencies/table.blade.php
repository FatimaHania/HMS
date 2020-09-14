<div class="table-responsive-sm">
    <table class="table table-striped" id="currencies-table">
        <thead>
            <tr>
                <th>Short Code</th>
        <th>Description</th>
        <th>Decimal Places</th>
        <th>Exchange Rate</th>
        <th>Default</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($currencies as $currency)
            <tr>
                <td>{{ $currency->short_code }}</td>
            <td>{{ $currency->description }}</td>
            <td>{{ $currency->decimal_places }}</td>
            <td>{{ $currency->exchange_rate }}</td>
            <td>
            @if($currency->is_default == 1)
            <i class="fa fa-check"></i>
            @endif
            
            
            
            </td>
                <td>
                    {!! Form::open(['route' => ['currencies.destroy', $currency->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('currencies.show', [$currency->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('currencies.edit', [$currency->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>