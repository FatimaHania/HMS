@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('physicians.index') !!}">Physician</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
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
@endsection