@extends('layouts.admin-page')

@section('pageTitle',__('saas.create-new').' '.__('saas.help-category'))
@section('page-title',__('saas.create-new').' '.__('saas.help-category'))

@section('page-content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div  >
                    <div >
                        <a href="{{ url('/admin/help-categories') }}" title="@lang('saas.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('saas.back')</button></a>
                        <br />
                        <br />


                        <form method="POST" action="{{ url('/admin/help-categories') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('admin.help-categories.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
