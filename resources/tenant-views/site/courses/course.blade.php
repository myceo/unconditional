@extends('layouts.site')

@section('pageTitle',$course->name)
@section('innerTitle',$course->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('site.courses') }}">@lang('site.courses')</a></li>
    <li class="breadcrumb-item">@lang('site.details')</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-3">



            <div class="card">
                <img class="card-img-top" src="{{ asset(!empty($course->picture)?$course->picture:'img/no_image.jpg') }}" alt="{{ $course->name }}">


                <ul class="list-group list-group-flush mt-0">
                    <li class="list-group-item"><strong>@lang('site.course-fee')</strong> <span class="float-right">@if(!empty($course->payment_required))
                                {{ price($course->fee) }}
                            @else
                                @lang('site.free')
                            @endif</span></li>
                    <li class="list-group-item"><strong>@lang('site.classes')</strong> <span class="float-right">{{ $course->lessons()->count()  }}</span></li>


                    @if(!empty($course->effort))
                        <li class="list-group-item"><strong>@lang('site.effort')</strong> <span class="float-right">{{ $course->effort }}</span></li>
                    @endif
                    @if(!empty($course->length))
                        <li class="list-group-item"><strong>@lang('site.length')</strong> <span class="float-right">{{ $course->length }}</span></li>
                    @endif
                    @if(!empty($course->start_date))
                        <li class="list-group-item"><strong>@lang('site.start-date')</strong> <span class="float-right">{{ dateString($course->start_date) }}</span></li>
                    @endif
                    @if(!empty($course->end_date))
                        <li class="list-group-item"><strong>@lang('site.end-date')</strong> <span class="float-right">{{ dateString($course->end_date) }}</span></li>
                    @endif
                    @if(!empty($course->closes_on))
                        <li class="list-group-item"><strong>@lang('site.enrollment-closes')</strong> <span class="float-right">{{ dateString($course->closes_on) }}</span></li>
                    @endif
                    @if(!empty($course->capacity))
                        <li class="list-group-item"><strong>@lang('site.seats')</strong> <span class="float-right">{{ $course->capacity }}</span></li>
                    @endif

                </ul>



            </div>



            <a href="{{ route('site.course-enroll',['course'=>$course->id]) }}" class="btn btn-success btn-block mt-3"><i class="fa fa-user-plus"></i> @lang('site.enroll')</a>



        </div>
        <div class="col-md-9">


            <div class="card bd-0 ">

                <div class="card-body bd bd-t-0 tab-content border-0 ">
                    <nav class="nav nav-pills">
                        <a class="nav-link active" data-toggle="tab" href="#tabCont1">@lang('site.details')</a>
                        <a class="nav-link" data-toggle="tab" href="#tabCont2">@lang('site.outline')</a>
                        <a class="nav-link" data-toggle="tab" href="#tabCont3">@lang('site.instructors')</a>
                    </nav>
                    <div id="tabCont1" class="tab-pane active show p-2">
                        {!! $course->description !!}
                    </div><!-- tab-pane -->
                    <div id="tabCont2" class="tab-pane p-2">


                        <ul class="list-group">
                            @foreach($course->lessons()->ordered()->get() as $lesson)
                                <li class="list-group-item d-flex justify-content-between align-items-center">

                                    <a  data-toggle="modal"
                                        data-target="#infoModal{{ $lesson->id }}" href="#">{{ $lesson->name }}</a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="infoModal{{ $lesson->id }}" tabindex="-1" role="dialog"
                                         aria-labelledby="infoModalLabel{{ $lesson->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $lesson->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        @if(!empty($lesson->picture))
                                                            <div class="col-md-4">

                                                                <img  class="rounded img-fluid"  src="{{ asset($lesson->picture) }}" alt="{{ $lesson->name }}">

                                                            </div>

                                                        @endif
                                                        <div class="col-md-{{ empty($lesson->picture)?'12':'8' }}">
                                                            {!! $lesson->description !!}
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                            data-dismiss="modal">@lang('site.close')
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="badge badge-success badge-pill">{{ $lesson->lectures()->count() }} @lang('site.lectures')</span>

                                </li>
                            @endforeach

                        </ul>


                    </div>
                    <div id="tabCont3" class="tab-pane p-2">

                        <div class="row">
                            @foreach($course->courseInstructors as $user)
                                <div class="col-md-3 mb-2 mt-2">
                                    <div class="card text-white  bg-light">
                                        <img class="card-img-top" src="{{ userPic($user->id) }}" alt="">
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $user->name }}</h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div><!-- card-body -->
            </div><!-- card -->

        </div>

    </div>



@endsection
