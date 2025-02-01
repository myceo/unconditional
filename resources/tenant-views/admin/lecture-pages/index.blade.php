@extends('layouts.admin')

@section('pageTitle',__('site.class').': '.$lecture->lesson->name)
@section('innerTitle',__('site.lecture').': '.limitLength($lecture->title,50))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">@lang('site.courses')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.classes.index',['course'=>$lecture->lesson->course_id]) }}">@lang('site.classes')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.classes.lectures.index',['lesson'=>$lecture->lesson_id]) }}">@lang('site.lectures')</a></li>
    <li class="breadcrumb-item"><a href="#">@lang('site.content')</a></li>
@endsection


@section('content')
    <div class="container-fluid">


            @livewire('admin.lecture.lecture-pages',['lectureId' => $lecture->id])



    </div>
@endsection


@section('header')
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/slickquiz/css/slickQuiz.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/slickquiz/css/custom.css') }}">
    @livewireStyles
@endsection

@section('footer')
    @livewireScripts
    <script src="{{ asset('vendor/sortable/livewire-sortable.js') }}"></script>
    <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('js/admin/textrte.js') }}"></script>
    <script src="{{ asset('js/email.js') }}" type="text/javascript" ></script>
    <script type="text/javascript" src="{{ asset('vendor/slickquiz/js/slickQuiz.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jquery-fullsizable-2.1.0/js/jquery-fullsizable.min.js') }}"></script>
@endsection
