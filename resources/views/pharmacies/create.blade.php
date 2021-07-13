@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="{!! route('pharmacies.index') !!}">Pharmacy</a>
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
                                <strong>Create Pharmacy</strong>
                            </div>
                            <div class="card-body">

                                <!-- Generate Document Codes -->
                                @php
                                if (empty($lastPharmacyRecord)) {
                                    $lastSerialNo = ($documentCode->starting_no)-($documentCode->common_difference);
                                }else{
                                    $lastSerialNo = $lastPharmacyRecord->pharmacy_number;
                                }
                                @endphp
                                <x-inputs.document_code form-type="create" last-serial-no="{{$lastSerialNo}}" prefix="{{$documentCode->prefix}}" format-length="{{$documentCode->format_length}}" common-difference="{{$documentCode->common_difference}}" number-field-id="pharmacy_number" code-field-id="pharmacy_code"></x-inputs.document_code>

                                {!! Form::open(['route' => 'pharmacies.store']) !!}

                                   @include('pharmacies.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
