<div class="table-responsive-sm">
    <table class="table table-striped" id="rooms-table">
        <thead>
            <tr>
                <th>Short Code</th>
        <th>Description</th>
        <th>Sort Order</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($rooms as $room)
            <tr>
                <td>{{ $room->short_code }}</td>
            <td>{{ $room->description }}</td>
            <td>{{ $room->sort_order }}</td>
                <td>
                    {!! Form::open(['route' => ['rooms.destroy', $room->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('rooms.show', [$room->id]) }}" class='btn btn-xs btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('rooms.edit', [$room->id]) }}" class='btn btn-xs btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>