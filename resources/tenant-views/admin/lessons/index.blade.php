@extends('layouts.admin')

@section('search-form',route('admin.courses.classes.index',['course'=>$course]))

@section('pageTitle',__('site.classes').': '.$course->name)
@section('innerTitle',__('site.classes').': '.$course->name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">@lang('site.courses')</a></li>
    <li class="breadcrumb-item"><a href="#">@lang('site.classes')</a></li>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">


            <div class="col-md-12">
                <div >
                    <div  >
                        <a href="{{ route('admin.courses.classes.create',['course'=>$course->id]) }}" class="btn btn-success btn-sm" title="@lang('site.add-new') lesson">
                            <i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')
                        </a> <span class="float-right"><small>@lang('site.drag-message')</small></span>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            @livewire('admin.lesson.lesson-list',['keyword' => $keyword,'courseId'=>$course->id])
                            <div class="pagination-wrapper"> {!! $lessons->appends(request()->input())->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('header')
    @livewireStyles
@endsection

@section('footer')
    @livewireScripts
    <script src="{{ asset('vendor/sortable/livewire-sortable.js') }}"></script>
@endsection
