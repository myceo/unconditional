@extends('lms.course-layout')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('site.my-courses') }}">@lang('site.my-courses')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('lms.landing',['course'=>$course->id]) }}">@lang('site.introduction')</a></li>
    <li class="breadcrumb-item">@lang('site.class')</li>
@endsection
@section('page-title',$lesson->name)
@section('page-subtile',$course->name)

@section('content')

   <ul class="nav nav-pills mt-2 border-0" id="myTab1" role="tablist">
                                           <li class="nav-item">
                                             <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true"><i
                                                     class="fa fa-info-circle" aria-hidden="true"></i> @lang('site.details')</a>
                                           </li>
                                           <li class="nav-item">
                                             <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"><i
                                                     class="fa fa-chalkboard-teacher" aria-hidden="true"></i> @lang('site.lectures')</a>
                                           </li>
                                         </ul>
                                         <div class="tab-content card border-0" id="myTabContent1">
                                           <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                             @if(!empty($lesson->picture))
                                                 <div class="row">
                                                     <div class="col-md-3"><img src="{{ asset($lesson->picture) }}"
                                                                                class="img-fluid img-thumbnail"
                                                                                alt="{{ $lesson->name }}"></div>
                                                     <div class="col-md-9">
                                                         {!! $lesson->description !!}
                                                     </div>
                                                 </div>
                                               @else
                                                   {!! $lesson->description !!}
                                             @endif


                                           </div>
                                           <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">

                                               @foreach($lesson->lectures()->ordered()->get() as $lecture)

                                                   <div class="list-group mb-3">
                                                       <a href="{{ route('lms.lecture',['course'=>$course->id,'lecture'=>$lecture->id]) }}" class="list-group-item active text-decoration-none">{{ $lecture->title }} <span class="float-right text-white"><i class="fa fa-play-circle"></i></span></a>
                                                      @foreach($lecture->lecturePages()->ordered()->get() as $lecturePage)
                                                       <div class="list-group-item pl-5">{{$lecturePage->title}}           <span class="badge badge-pill badge-primary float-right">

                                                               @php
                                                                   switch($lecturePage->type){
                                                                       case 't':
                                                                           echo __('site.text');
                                                                       break;
                                                                       case 'v':
                                                                           echo  __('site.video');
                                                                       break;
                                                                       case 'c':
                                                                           echo __('site.html-code');
                                                                       break;
                                                                       case 'i':
                                                                           echo __('site.image');
                                                                           break;
                                                                       case 'q':
                                                                           echo __('site.quiz');
                                                                           break;
                                                                       case 'l':
                                                                           echo __('site.video');
                                                                           break;
                                                                       case 'z':
                                                                           echo __('site.zoom-meeting');
                                                                           break;
                                                                   } @endphp
                                                           </span></div>
                                                        @endforeach

                                                   </div>



                                               @endforeach

                                           </div>

                                         </div>

   <div class="mt-3 text-center row">
       <div class="col-md-4 offset-md-4">
           <a  href="{{ route('lms.lecture',['course'=>$course->id,'lecture'=>$firstLecture->id]) }}" class="btn btn-success btn-block  "><i class="fa fa-play-circle" aria-hidden="true"></i> @lang('site.start-class')</a>
       </div>
   </div>

@endsection
