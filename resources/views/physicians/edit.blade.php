@if(session('is_hospital') == '1')<!--edit profile as a patient from public portal-->
    @php $layout = 'layouts.app'; @endphp
@else
    @php $layout = 'public_portal.layouts.app'; @endphp
@endif

@extends($layout)

@section('content')
    @if(session('is_hospital') == '1')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{!! route('physicians.index') !!}">Physician</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
    @endif
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Physician</strong>
                          </div>
                          <div class="card-body">

                                <!-- Generate Document Codes -->
                                <x-inputs.document_code form-type="edit" last-serial-no="{{$lastPhysicianRecord->physician_number}}" prefix="{{$documentCode->prefix}}" format-length="{{$documentCode->format_length}}" common-difference="{{$documentCode->common_difference}}" number-field-id="physician_number" code-field-id="physician_code"></x-inputs.document_code>

                                {!! Form::model($physician, ['route' => ['physicians.update', $physician->id], 'method' => 'patch' , 'files' => true]) !!}

                                @include('physicians.fields')

                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>

@stack('scripts')
<script>

$(document).ready(function(){

    @if(session('is_physician') == '1')//accessing through pubic portal - disable editing physician number field
        $('[name="physician_number"]').prop('readonly', true);
    @endif

})

</script>

@endsection