@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('pharmacies.index') !!}">Pharmacy</a>
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
                              <strong>Edit Pharmacy</strong>
                          </div>
                          <div class="card-body">

                                <!-- Generate Document Codes -->
                                <x-inputs.document_code form-type="edit" last-serial-no="{{$lastPharmacyRecord->pharmacy_number}}" prefix="{{$documentCode->prefix}}" format-length="{{$documentCode->format_length}}" common-difference="{{$documentCode->common_difference}}" number-field-id="pharmacy_number" code-field-id="pharmacy_code"></x-inputs.document_code>


                              {!! Form::model($pharmacy, ['route' => ['pharmacies.update', $pharmacy->id], 'method' => 'patch']) !!}

                              @include('pharmacies.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection