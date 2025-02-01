@extends('layouts.admin')
@section('pageTitle','Fields')

@section('innerTitle')
    @lang('site.create-new') @lang('admin.field')
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/admin/fields') }}">@lang('admin.fields')</a>
    </li>
    <li><span>@lang('site.create-new') @lang('admin.field')</span>
    </li>
@endsection

@section('content')
    <div class="single-pro-review-area mt-t-30 mg-b-15">


        <div class="container-fluid">
            <div class="product-payment-inner-st form-content">


            <form method="POST" action="{{ url('/admin/fields') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}

                @include ('admin.fields.form', ['formMode' => 'create'])

            </form>




            </div>
        </div>


    </div>

@endsection

@include('admin.fields.formlogic')
