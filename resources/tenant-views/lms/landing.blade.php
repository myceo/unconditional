@extends('lms.course-layout')

@section('page-title',$course->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('site.my-courses') }}">@lang('site.my-courses')</a></li>
    <li class="breadcrumb-item">@lang('site.introduction')</li>

@endsection

@section('content')
    <ul class="nav nav-pills border-0 mt-0"   id="myTab1" role="tablist">
                                               <li class="nav-item mb-1">
                                                 <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-info-circle"></i> @lang('site.introduction')</a>
                                               </li>
                                                <li class="nav-item mb-1">
                                                    <a class="nav-link" id="tab6-tab" data-toggle="tab" href="#tab6" role="tab" aria-controls="tab6" aria-selected="false"><i class="fa fa-chart-line"></i> @lang('site.progress')</a>
                                                </li>
                                               <li class="nav-item mb-1">
                                                 <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"><i class="fa fa-desktop"></i> @lang('site.classes')</a>
                                               </li>
                                               <li class="nav-item mb-1">
                                                 <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false"><i class="fa fa-download"></i> @lang('site.resources')</a>
                                               </li>
                                                <li class="nav-item mb-1">
                                                    <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false"><i class="fa fa-question-circle"></i> @lang('site.tests')</a>
                                                </li>
                                                @if(!empty($course->certificate_enabled))
                                                <li class="nav-item mb-1">
                                                    <a class="nav-link" id="tab5-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="false"><i class="fa fa-certificate"></i> @lang('site.certificate')</a>
                                                </li>
                                                 @endif

                                             </ul>
                                             <div class="tab-content card border-0"   id="myTabContent1">
                                               <div class="tab-pane fade show active  " id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                                 {!! $course->introduction !!}
                                               </div>
                                                 <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="tab6-tab">

                                                     <div class="p-1 mb-2 text-center">
                                                         @if($course->lessons()->count()>0)
                                                             @php
                                                                 $attended = $user->lessons()->where('course_id',$course->id)->count();
                                                                 $totalLessons = $course->lessons()->count();
                                                                 $percent = 100 * @($attended/($totalLessons));
                                                             @endphp
                                                             <div class="text-center">
                                                                 {{ $percent }}%
                                                             </div>
                                                             <div class="text-center">

                                                                 <div class="progress progress_sm"  >
                                                                     <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="{{ $percent }}" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}"></div>
                                                                 </div>

                                                             </div>
                                                         @endif

                                                         @if(courseCompleted($user,$course))
                                                                 <div class="mt-3">
                                                                     <h1><i class="fa fa-check-circle"></i></h1>
                                                                     <h3 class="text-success">@lang('site.course-completed')</h3>
                                                                 </div>
                                                             @else
                                                                 <div class="mt-3 row">
                                                                     <div class="col-md-4 offset-md-4">
                                                                         <h1><i class="fa fa-exclamation-circle"></i></h1>
                                                                         <h3 class="text-danger">@lang('site.course-incomplete')</h3>
                                                                         <ul class="list-group">
                                                                             @if(!lessonsCompleted($user,$course))
                                                                             <li class="list-group-item"><i
                                                                                     class="fa fa-desktop"
                                                                                     aria-hidden="true"></i> @lang('site.pending-classes')
                                                                                 <a href="{{ route('lms.resume',['course'=>$course->id]) }}"
                                                                                    class="btn btn-success btn-sm  "><i class="fa fa-play"></i> @lang('site.resume')</a>
                                                                             </li>
                                                                                 @endif
                                                                                 @if(!testsCompleted($user,$course))
                                                                                     <li class="list-group-item"><i
                                                                                             class="fa fa-check-circle"
                                                                                             aria-hidden="true"></i> @lang('site.pending-tests')
                                                                                         <a  class="btn btn-primary btn-sm" href="#" onclick="$('#tab4-tab').trigger('click')"  ><i class="fa fa-question-circle"></i> @lang('site.tests')</a>
                                                                                     </li>
                                                                                 @endif
                                                                         </ul>
                                                                     </div>
                                                                 </div>
                                                         @endif
                                                     </div>

                                                 </div>
                                               <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                                   <div id="accordianId" role="tablist" aria-multiselectable="true">
                                                       @foreach($course->lessons()->ordered()->get() as $lesson )
                                                       <div class="card">
                                                           <div class="card-header flat-border" role="tab" id="section1HeaderId">
                                                               <h5 class="mb-0">
                                                                   @if($user->lessons()->find($lesson->id))
                                                                   <i class="fa fa-check-circle"></i>
                                                                   @endif
                                                                   <a class="text-dark" data-toggle="collapse" data-parent="#accordianId"
                                                                      href="#lessonContent-{{ $lesson->id }}" aria-expanded="true"
                                                                      aria-controls="lessonContent-{{ $lesson->id }}">
                                                                       {{ $lesson->name }}
                                                                   </a>
                                                                   <span class="badge badge-secondary badge-pill text-white float-right">{{ $lesson->lectures()->count() }} @lang('site.lectures')</span>
                                                               </h5>

                                                           </div>
                                                           <div id="lessonContent-{{ $lesson->id }}" class="collapse in"
                                                                role="tabpanel" aria-labelledby="section1HeaderId">
                                                               <div class="card-body">
                                                                   <div class="list-group">
                                                                       <a href="{{ route('lms.lesson',['course'=>$course->id,'lesson'=>$lesson->id]) }}" class="list-group-item list-group-item-action">@lang('site.overview')</a>
                                                                       @foreach($lesson->lectures()->ordered()->get() as $lecture)
                                                                             <a href="{{ route('lms.lecture',['course'=>$course->id,'lecture'=>$lecture->id]) }}" class="list-group-item list-group-item-action">@if($user->lectures()->find($lecture->id))
                                                                                     <i class="fa fa-check-circle"></i>
                                                                                 @endif{{ $lecture->title }}</a>
                                                                       @endforeach

                                                                   </div>


                                                               </div>
                                                           </div>
                                                       </div>
                                                       @endforeach
                                                   </div>
                                               </div>
                                               <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                                  @livewire('admin.course.course-files',['course' => $course,'showDelete' => false])
                                               </div>
                                                 <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                                                     @include('site.test.test-list',['tests'=>$course->tests()->get(),'perPage'=>1000])
                                                 </div>
                                                  @if(!empty($course->certificate_enabled))
                                                 <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
                                                     @if(courseCompleted($user,$course))
                                                     <div class="text-center">
                                                         <a href="{{ route('lms.certificate',['course'=>$course->id]) }}" class="btn btn-primary"><i class="fa fa-download"></i> @lang('site.download')</a>
                                                     </div>
                                                     @else
                                                         <div class="mt-3 row">
                                                             <div class="col-md-4 offset-md-4 text-center">
                                                                 <h1><i class="fa fa-exclamation-circle"></i></h1>
                                                                 <h3 class="text-danger">@lang('site.course-incomplete')</h3>
                                                                 <ul class="list-group">
                                                                     @if(!lessonsCompleted($user,$course))
                                                                         <li class="list-group-item"><i
                                                                                 class="fa fa-desktop"
                                                                                 aria-hidden="true"></i> @lang('site.pending-classes')
                                                                             <a href="{{ route('lms.resume',['course'=>$course->id]) }}"
                                                                                class="btn btn-success btn-sm  "><i class="fa fa-play"></i> @lang('site.resume')</a>

                                                                         </li>
                                                                     @endif
                                                                     @if(!testsCompleted($user,$course))
                                                                         <li class="list-group-item"><i
                                                                                 class="fa fa-check-circle"
                                                                                 aria-hidden="true"></i> @lang('site.pending-tests')
                                                                             <a  class="btn btn-primary btn-sm" href="#" onclick="$('#tab4-tab').trigger('click')"  ><i class="fa fa-question-circle"></i> @lang('site.tests')</a>
                                                                         </li>
                                                                     @endif

                                                                 </ul>
                                                             </div>

                                                         </div>
                                                     @endif

                                                 </div>
                                                      @endif

                                             </div>

    <div class="mt-3 text-center row">
        <div class="col-md-4 offset-md-4">
            <a  href="{{ route('lms.start',['course'=>$course->id]) }}" class="btn btn-success btn-block  "><i class="fa fa-play-circle" aria-hidden="true"></i> @lang('site.start-course')</a>
        </div>
    </div>

@endsection

@section('header')
    @parent
    @livewireStyles
@endsection

@section('footer')
    @parent
    @livewireScripts

        @if(request()->get('test'))
        <script>
        $('#tab4-tab').trigger('click');
    </script>
            @endif

@endsection
