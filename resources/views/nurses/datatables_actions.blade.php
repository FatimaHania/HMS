{!! Form::open(['route' => ['nurses.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('nurses.show', $id) }}" class='btn btn-xs btn-ghost-success'>
       <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('nurses.edit', $id) }}" class='btn btn-xs btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-xs btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
