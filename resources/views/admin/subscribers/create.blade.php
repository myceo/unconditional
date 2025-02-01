@extends('layouts.admin-page')

@section('pageTitle',__('saas.create-new').' '.__('saas.subscriber'))
@section('page-title',__('saas.create-new').' '.__('saas.subscriber'))

@section('page-content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div  >
                    <div >
                        <a href="{{ url('/admin/subscribers') }}" title="@lang('saas.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('saas.back')</button></a>
                        <br />
                        <br />



                        <form method="POST" action="{{ url('/admin/subscribers') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('admin.subscribers.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
