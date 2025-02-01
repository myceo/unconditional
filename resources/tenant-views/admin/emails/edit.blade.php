@extends('layouts.admin')
@section('pageTitle','Emails')

@section('innerTitle')
    @lang('site.edit') @lang('admin.message'): {{ $email->subject }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/admin/emails') }}">@lang('admin.messages')</a>
    </li>
    <li><span>@lang('site.edit') @lang('admin.message')</span>
    </li>
@endsection

@section('content')
    <div class="single-pro-review-area mt-t-30 mg-b-15">


        <div class="container-fluid">
            <div class="product-payment-inner-st form-content">


            <form method="POST" action="{{ url('/admin/emails/' . $email->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}

                @include ('admin.emails.form', ['formMode' => 'edit'])

            </form>




        </div>
    </div>


    </div>

@endsection
