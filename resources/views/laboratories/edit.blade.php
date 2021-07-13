@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('laboratories.index') !!}">Laboratory</a>
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
                              <strong>Edit Laboratory</strong>
                          </div>
                          <div class="card-body">

                            <!-- Generate Document Codes -->
                            <x-inputs.document_code form-type="edit" last-serial-no="{{$lastLabRecord->lab_number}}" prefix="{{$documentCode->prefix}}" format-length="{{$documentCode->format_length}}" common-difference="{{$documentCode->common_difference}}" number-field-id="lab_number" code-field-id="lab_code"></x-inputs.document_code>


                              {!! Form::model($laboratory, ['route' => ['laboratories.update', $laboratory->id], 'method' => 'patch']) !!}

                              @include('laboratories.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection