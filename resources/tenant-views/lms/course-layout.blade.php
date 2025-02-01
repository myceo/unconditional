@extends('layouts.lms')
@section('search-form','')
@section('title-margin','mb-2')
@section('sidebar')

    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav icon-data-list mb-0 pb-0 hidden-text">
            <li class="pl-3">
                <div class="d-flex">
                    @if(!empty($course->picture))
                        <a href="#" data-toggle="modal"
                           data-target="#courseImageModal"><img src="{{ asset($course->picture) }}" alt="{{ $course->name }}"></a>
                        @section('footer')
                            @parent
                        <div class="modal fade" id="courseImageModal" tabindex="-1" role="dialog"
                             aria-labelledby="couresImageModalTitle"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $course->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <img class="img-fluid" src="{{ asset($course->picture) }}" alt="{{ $course->name }}">
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endsection
                    @endif
                    <div>
                        <p class="mb-0"><strong>{{ limitLength($course->name,35) }}</strong></p>
                        <small>@lang('site.course')</small>
                    </div>
                </div>
            </li>
        </ul>
        <ul class="nav pt-0 mt-0 mb-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('lms.landing',['course'=>$course->id]) }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">@lang('site.introduction')</span>
                </a>
            </li>

            @foreach($course->lessons()->ordered()->get() as $lesson)
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#lesson-menu-{{ $lesson->id }}" aria-expanded="false" aria-controls="lesson-menu-{{ $lesson->id }}">
                    @if($user->completedLesson($lesson))
                        <i class="fa fa-check-circle text-success menu-icon"></i>
                    @else
                        <i class="fa fa-desktop menu-icon"></i>
                        @endif

                    <span class="menu-title">{{ limitLength($lesson->name,20) }}</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="lesson-menu-{{ $lesson->id }}">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"  > <a class="nav-link" href="{{ route('lms.lesson',['course'=>$course->id,'lesson'=>$lesson->id]) }}">@lang('site.overview')</a></li>
                        @foreach($lesson->lectures()->ordered()->get() as $lecture)
                        <li class="nav-item @if($user->completedLecture($lecture)) completed-lesson @endif"><a class="nav-link" href="{{ route('lms.lecture',['course'=>$course->id,'lecture'=>$lecture->id]) }}">
                                @if($user->completedLecture($lecture))<i class="fa fa-check-circle text-success mr-1" aria-hidden="true"></i> @endif @if(Route::current()->hasParameter('lecture') && Route::current()->parameter('lecture')->id == $lecture->id) <strong class="text-success">@endif{{ limitLength($lecture->title,25) }}@if(Route::current()->hasParameter('lecture') && Route::current()->parameter('lecture')->id == $lecture->id)</strong>@endif</a></li>
                        @endforeach
                    </ul>
                </div>
            </li>
            @endforeach


        </ul>

        <div class="ml-2 mr-2 mt-1 "><a href="{{ route('site.my-courses') }}" class="btn btn-sm btn-success btn-block  "><i class="fa fa-sign-out-alt"></i> <span class="hidden-text">@lang('site.exit-course')</span></a></div>
    </nav>
@endsection
@section('nav-script')
    <script src="{{ asset('js/lms-template.js') }}"></script>
@endsection
