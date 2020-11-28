<div class="table-responsive-sm">
    <table class="table table-striped" id="branches-table">
        <thead>
            <tr>
        <th>Name</th>
        <th>Short Code</th>
        <th>Telephone</th>
        <th>Address</th>
        <th>Default Currency</th>
        <th>Reporting Currency</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($branches as $branch)
                @if($branch->country_id == "" || $branch->country_id == null)
                    @php $telephone_code = "000"; @endphp
                @else
                    @php $telephone_code = $branch->country->telephone_code; @endphp
                @endif
            
            <tr>
            <td>{{ $branch->name }}</td>
            <td>{{ $branch->short_code }}</td>
            <td>{{ join(" / " , array($telephone_code."-".$branch->telephone_1 , $telephone_code."-".$branch->telephone_2 , $telephone_code."-".$branch->telephone_3)) }}</td>
            <td>{{ $branch->address }}</td>
            <td>{{ $branch->default_currency->short_code }}</td>
            <td>{{ $branch->reporting_currency->short_code }}</td>
                <td>
                    <div class='btn-group'>
                        <a href="{{ route('branches.show', [$branch->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('branches.edit', [$branch->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>