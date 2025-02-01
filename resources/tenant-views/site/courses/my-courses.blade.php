@extends('layouts.site')

@section('pageTitle',__('site.my-courses'))
@section('innerTitle',__('site.my-courses').' ('.$total.')')

@section('content')
    <div class="row">
        @if(empty($total))
            @lang('admin.no-records')
        @endif
        @foreach($courses as $course)

            <div class="col-md-12 mb-2">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('lms.landing',['course'=>$course->id]) }}"><img class="img-fluid img-thumbnail" src="{{ asset(!empty($course->picture)?$course->picture:'img/no_image.jpg') }}" ></a>

                    </div>
                    <div class="col-md-9 card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $course->name }}</h4>
                            <p class="card-text">{{ $course->short_description }}</p>
                            @if(!empty($course->start_date))
                                <p><span class="text-primary">@lang('site.start-date'):</span> {{ dateString($course->start_date) }}</p>
                            @endif
                            @if(!empty($course->end_date))
                                <p><span class="text-primary">@lang('site.end-date'):</span> {{ dateString($course->end_date) }}</p>
                            @endif
                            <div>
                                <table class="table mt-2">
                                    <thead>
                                    <tr>


                                        <th style="width: 120px;" class="text-center">@lang('site.classes')</th>
                                        <th  style="width: 120px;" class="text-center">@lang('site.tests')</th>
                                        <th class="text-center">@lang('site.completed')</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>



                                        <td>
                                            @if($course->lessons()->count()>0)
                                                @php
                                                    $attended = $user->lessons()->where('course_id',$course->id)->count();
                                                    $totalLessons = $course->lessons()->count();
                                                    $percent = 100 * @($attended/($totalLessons));
                                                @endphp
                                                <div class="text-center">
                                                    {{ $attended }} / {{ $totalLessons  }}
                                                </div>
                                                <div class="text-center">

                                                    <div class="progress progress_sm"  >
                                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="{{ $percent }}" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}"></div>
                                                    </div>

                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($course->tests()->count()>0)
                                                @php
                                                    $passed = totalUserCourseTests($user,$course);
                                                    $totalTests = $course->tests()->count();
                                                    $percent = 100 * @($passed/($totalTests));
                                                @endphp
                                                <div class="text-center">
                                                    {{ $passed }} / {{ $totalTests  }}
                                                </div>
                                                <div class="text-center">

                                                    <div class="progress progress_sm"  >
                                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="{{ $percent }}" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}"></div>
                                                    </div>

                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ boolToString(courseCompleted($user,$course)) }}</td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <div class="row">
                                <div class="col-md-{{ courseCompleted(\Illuminate\Support\Facades\Auth::user(),$course)? '8':'4' }}">
                                    <a href="{{ route('lms.landing',['course'=>$course->id]) }}" class="btn btn-primary btn-block"><i class="fa fa-info-circle"></i> @lang('site.view')</a>
                                </div>
                                @if(!courseCompleted(\Illuminate\Support\Facades\Auth::user(),$course))
                                    <div class="col-md-4">
                                        <a href="{{ route('lms.resume',['course'=>$course->id]) }}" class="btn btn-success btn-block"><i class="fa fa-play-circle"></i> @lang('site.resume')</a>

                                    </div>
                                @endif
                                <div class="col-md-4">
                                    <a onclick="return confirm('{{ __('site.confirm-delete') }}')" href="{{ route('site.remove-course',['course'=>$course->id]) }}" class="btn btn-danger btn-block"><i class="fa fa-trash"></i> @lang('site.delete')</a>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        @endforeach
    </div>
    <div class="mt-2">
        {!! $courses->links() !!}
    </div>
@endsection
