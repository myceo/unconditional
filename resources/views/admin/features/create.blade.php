@extends('layouts.admin-page')

@section('pageTitle',__('saas.create-new').' '.__('saas.feature'))
@section('page-title',__('saas.create-new').' '.__('saas.feature'))

@section('page-content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div  >
                    <div >
                        <a href="{{ url('/admin/features') }}" title="@lang('saas.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('saas.back')</button></a>
                        <br />
                        <br />


                        <form method="POST" action="{{ url('/admin/features') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('admin.features.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('header')
    <link rel="stylesheet" href="{{ asset('themes/main/css/summernote/summernote.css') }}">

@endsection

@section('footer')
    <script src="{{ asset('themes/main/js/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('themes/main/js/summernote/summernote-active.js') }}"></script>
    <script>
        $('textarea#content').summernote();
    </script>
@endsection