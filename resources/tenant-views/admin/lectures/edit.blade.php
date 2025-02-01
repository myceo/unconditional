@extends('layouts.admin')

@section('pageTitle',__('site.edit-lecture'))
@section('innerTitle',__('site.class').': '.$lesson->name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">@lang('site.courses')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.classes.index',['course'=>$lesson->course_id]) }}">@lang('site.classes')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.classes.lectures.index',['lesson'=>$lesson->id]) }}">@lang('site.lectures')</a></li>
    <li class="breadcrumb-item"><a href="#">{{ __('site.edit') }}</a></li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div  >
                    <div  >
                        <a href="{{ route('admin.classes.lectures.index',['lesson'=>$lesson->id]) }}" title="@lang('site.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('site.back')</button></a>
                        <br />
                        <br />



                        <form method="POST" action="{{ route('admin.classes.lectures.update',['lesson'=>$lesson->id,'lecture'=>$lecture->id])  }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('admin.lectures.form', ['formMode' => 'edit'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
