@extends('layouts.site')

@section('pageTitle',__('site.courses'))
@section('innerTitle',__('site.courses'))
@section('content')

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#filterModal">
        <i class="fa fa-filter" aria-hidden="true"></i> @lang('site.filter')
    </button>

    @section('footer')
        @parent
        <!-- Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModal"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('site.courses') }}" method="get">
                        <div class="modal-header">
                            <h5 class="modal-title">@lang('site.filter')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input  type="text" value="{{ request()->search }}"
                                                class="form-control" name="search" id="courseSearch"
                                                aria-describedby="courseSearch"
                                                placeholder="@lang('site.search')">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" name="category" id="category">
                                            <option value="">@lang('site.category')</option>

                                            @foreach(\App\CourseCategory::limit(500)->orderBy('sort_order')->get() as $category)
                                                <option @if(request()->category==$category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select type="select" name="sort" class="form-control">
                                            @foreach([
                                                 ''=>__('site.sort-order'),
                                                 'recent'=>__('site.recently-added'),
                                                 'asc'=>__('site.asc'),
                                                  'desc'=>__('site.desc'),
                                                    ] as $key=>$value)
                                                <option @if(request()->sort==$key) selected @endif  value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>



                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('site.courses') }}" class="btn btn-secondary">@lang('site.reset')</a>
                            <button type="submit" class="btn btn-primary">@lang('site.filter')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection



    <div class="row mt-3">
        @foreach($courses as $course)
            <div class="col-md-4 mb-4" style="position: relative">

                @if($course->pinned==1)
                    <div style="position: absolute;z-index:1;right: 20px">
                        <i class="fa fa-thumbtack"></i>
                    </div>
                @endif
                <div class="card">
                    <!-- Card image -->
                    <a href="{{ route('site.course-details',['course'=>$course->id]) }}"><img class="card-img-top" src="{{ asset(!empty($course->picture)?$course->picture:'img/no_image.jpg') }}" ></a>
                    <!-- Card body -->
                    <div class="card-body">
                        <h5 class="card-title mb-0">{{ $course->name }}</h5>

                        <div class="pt-1">
                            <span class="pr-3" data-toggle="tooltip" data-placement="top" title="{{ $course->lessons()->count() }} @lang('site.classes')" >
                                           <i class="fa fa-desktop" aria-hidden="true"></i>
                                <span class="text-muted">{{ $course->lessons()->count() }}</span>
                            </span>

                        </div>

                        <p class="card-text mt-4">{{ limitLength($course->short_description,300) }}</p>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('site.course-enroll',['course'=>$course->id]) }}" class="btn btn-success btn-block"><i class="fa fa-user-plus"></i> @lang('site.enroll')</a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('site.course-details',['course'=>$course->id]) }}" class="btn btn-primary btn-block"><i class="fa fa-info-circle"></i> @lang('site.details')</a>
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
