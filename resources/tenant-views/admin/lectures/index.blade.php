@extends('layouts.admin')



@section('pageTitle',__('site.course').': '.$lesson->course->name)
@section('innerTitle',__('site.lectures').': '.$lesson->name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">@lang('site.courses')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.classes.index',['course'=>$lesson->course_id]) }}">@lang('site.classes')</a></li>
    <li class="breadcrumb-item"><a href="#">@lang('site.lectures')</a></li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div >
                    <div  >
                        <a href="{{ route('admin.classes.lectures.create',['lesson'=>$lesson->id]) }}" class="btn btn-success btn-sm" title="@lang('site.add-new') lecture">
                            <i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')
                        </a>

                        <span class="float-right"><small>@lang('site.drag-message')</small></span>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                          @livewire('admin.lecture.lecture-list',['lessonId' => $lesson->id])

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

