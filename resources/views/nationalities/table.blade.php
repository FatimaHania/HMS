<div class="table-responsive-sm">
    <table class="table table-striped" id="nationalities-table">
        <thead>
            <tr>
                <th>Short Code</th>
        <th>Description</th>
                <th colspan="3" class="th_action">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($nationalities as $nationality)
            <tr>
                <td>{{ $nationality->short_code }}</td>
            <td>{{ $nationality->description }}</td>
                <td>
                    {!! Form::open(['route' => ['nationalities.destroy', $nationality->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('nationalities.show', [$nationality->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-file-text-o"></i></a>
                        <a href="{{ route('nationalities.edit', [$nationality->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>