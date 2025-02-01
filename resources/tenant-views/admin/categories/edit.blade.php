@extends('layouts.admin')
@section('pageTitle','Categories')

@section('innerTitle')
    @lang('site.edit') @lang('admin.category'): {{ $category->name }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/admin/categories') }}">@lang('admin.categories')</a>
    </li>
    <li><span>@lang('site.edit') @lang('admin.category')</span>
    </li>
@endsection

@section('content')
    <div class="single-pro-review-area mt-t-30 mg-b-15">


        <div class="container-fluid">
            <div class="product-payment-inner-st form-content">


            <form method="POST" action="{{ url('/admin/categories/' . $category->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}

                @include ('admin.categories.form', ['formMode' => 'edit'])

            </form>




        </div>
    </div>


    </div>

@endsection


@section('footer')
    <script src="{{ asset('themes/admin/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('themes/admin/assets/modules/summernote/summernote-active.js') }}"></script>

@endsection


@section('header')
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/modules/summernote/summernote-bs4.css') }}">
@endsection
