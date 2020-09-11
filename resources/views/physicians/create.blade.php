@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="{!! route('physicians.index') !!}">Physician</a>
      </li>
      <li class="breadcrumb-item active">Create</li>
    </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('coreui-templates::common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Create Physician</strong>
                            </div>
                            <div class="card-body">

                                <!-- Generate Document Codes -->
                                @php
                                if (empty($lastPhysicianRecord)) {
                                    $lastSerialNo = $documentCode->starting_no;
                                }else{
                                    $lastSerialNo = $lastPhysicianRecord->physician_number;
                                }
                                @endphp
                                <x-inputs.document_code form-type="create" last-serial-no="{{$lastSerialNo}}" prefix="{{$documentCode->prefix}}" format-length="{{$documentCode->format_length}}" common-difference="{{$documentCode->common_difference}}" number-field-id="physician_number" code-field-id="physician_code"></x-inputs.document_code>


                                {!! Form::open(['route' => 'physicians.store' , 'files' => true]) !!}

                                   @include('physicians.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
