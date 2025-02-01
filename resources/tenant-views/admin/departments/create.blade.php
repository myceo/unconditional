@extends('layouts.admin')
@section('pageTitle',__('admin.departments'))

@section('innerTitle')
    @lang('site.create-new')  {{  ucfirst(__('admin.department')) }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('/admin/groups') }}">@lang('admin.departments')</a>
    </li>
    <li class="breadcrumb-item"><span>@lang('site.create-new') {{  ucfirst(__('site.department')) }}</span>
    </li>
@endsection

@section('content')


    <div class="single-pro-review-area mt-t-30 mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form method="POST" action="{{ url('/admin/groups') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">

                    <div class="product-payment-inner-st">


                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab" aria-controls="home" aria-selected="true">@lang('admin.details')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">@lang('admin.categories')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">@lang('admin.cover-photo')</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="product-payment-inner-st">

                                            {{ csrf_field() }}

                                            @include ('admin.departments.form', ['formMode' => 'create'])



                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="review-content-section">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 50px">

                                                    @foreach(\App\Category::get() as $category)
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="cat_{{ $category->id }}" value="{{ $category->id }}"> {{ $category->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="review-content-section form-content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->has('picture') ? 'has-error' : ''}}">
                                                        <label for="picture" class="control-label">@lang('admin.picture')</label>

                                                        <input  class="form-control-file"  type="file" name="picture"/>

                                                        {!! $errors->first('picture', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-6">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <input class="btn btn-primary btn-block btn-lg" type="submit" value="@lang('admin.create')">

                    </div>

                    </form>

                </div>
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
