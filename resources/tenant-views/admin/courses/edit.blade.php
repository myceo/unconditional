@extends('layouts.admin')


@section('pageTitle',__('site.courses'))
@section('innerTitle',__('site.edit').' '.__('site.course'))

@section('breadcrumb')
    @include('partials.breadcrumb',['crumbs'=>[
            [
                'link'=> route('admin.courses.index'),
                'page'=>__('site.courses')
            ],
            [
                'link'=>'#',
                'page'=>__('site.edit')
            ]
    ]])
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.courses.update',['course'=>$course->id]) }}" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        <div class="card">
            <div class="card-header row align-items-center">

                    <div class="col-8">
                        <!-- Title -->
                        <h5 class="h3 mb-0">{{ $course->name }}</h5>
                    </div>
                    <div class="col-4 text-right">
                        <button class="btn  rounded btn-primary float-right" type="submit"><i class="fa fa-save"></i> @lang('site.save')</button>
                    </div>


            </div>

            <div class="card-body">
                <ul class="nav nav-pills" id="myTab1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">@lang('site.info')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">@lang('site.options')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">@lang('site.scheduling')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">@lang('site.instructors')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab5-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="false">@lang('site.files')</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent1">
                    <div class="tab-pane fade show active pt-3" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <div class="form-group">
                            <label for="name"><span class="req">*</span> @lang('site.name')</label>
                            <input required value="{{ old('name',$course->name) }}" type="text" name="name" id="name" class="form-control" placeholder="@lang('site.course-name-hint')"
                                   aria-describedby="name">
                            {!! clean( $errors->first('name', '<p class="help-block">:message</p>') ) !!}
                        </div>

                        <div class="form-group">
                            <label for="short_description">@lang('site.short-description')</label>
                            <textarea class="form-control" name="short_description" id="short_description"
                                      rows="3">{{ old('short_description',$course->short_description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="description">@lang('site.description')</label>
                            <textarea class="form-control rte" name="description" id="description"
                                      rows="3">{{ old('description',$course->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="introduction">@lang('site.introduction')
                                <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top"
                                   title="@lang('site.introduction-hint')"></i>
                            </label>
                            <textarea class="form-control rte" name="introduction" id="introduction"
                                      rows="3">{{ old('introduction',$course->introduction) }}</textarea>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                @lang('site.cover-image')
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="picture">@lang('site.select-image')</label>
                                            <input type="file" class="form-control-file" name="picture" id="picture" placeholder="picture"
                                                   aria-describedby="fileHelpId">
                                        </div>
                                    </div>
                                    @if(!empty($course->picture))
                                    <div class="col-md-4">
                                        <div><img class="img-fluid" src="{{ asset(!empty($course->picture)?$course->picture:'img/no_image.jpg') }}" alt="Image placeholder">
                                    </div>
                                        <br>
                                        <a href="{{ route('admin.courses.remove-image',['course'=>$course->id]) }}" class="btn btn-danger"><i class="fa fa-trash"></i> @lang('site.remove-picture')</a>

                                    </div>
                                    @endif

                                </div>

                            </div>
                        </div>



                    </div>
                    <div class="tab-pane fade pt-3" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="effort">@lang('site.effort')</label>
                                    <input value="{{ old('effort',$course->effort) }}" type="text"
                                           class="form-control" name="effort" id="effort"
                                           placeholder="@lang('site.effort-hint')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="length">@lang('site.length')</label>
                                    <input value="{{ old('length',$course->length) }}" type="text"
                                           class="form-control" name="length" id="length"
                                           placeholder="@lang('site.length-hint')">
                                    {!! $errors->first('length', '<p class="help-block">:message</p>')  !!}

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="categories">@lang('site.categories')</label>
                                    <select class="form-control select2" multiple name="categories[]" id="categories">
                                        @foreach(\App\CourseCategory::limit(500)->orderBy('sort_order')->get() as $category)
                                            <option
                                                @if( (is_array(old('categories')) && in_array(@$category->id,old('categories')))  || (null === old('categories')  && $course->courseCategories()->where('id',$category->id)->first() ))
                                                selected
                                                @endif

                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tests">@lang('site.tests')
                                        <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top"
                                           title="@lang('site.tests-hint')"></i>
                                    </label>
                                    <select class="form-control select2" multiple name="tests[]" id="tests">
                                        @foreach(\App\Test::limit(500)->latest()->get() as $test)
                                            <option
                                                @if( (is_array(old('tests')) && in_array(@$test->id,old('tests')))  || (null === old('tests')  && $course->tests()->where('id',$test->id)->first() ))
                                                selected
                                                @endif

                                                value="{{ $test->id }}">{{ $test->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="enabled">@lang('site.status')
                                        <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top"
                                           title="@lang('site.status-hint')"></i>
                                    </label>
                                    <select class="form-control" name="enabled" id="enabled">
                                        @foreach(['1'=>__('site.enabled'),'0'=>__('site.disabled')] as $key=>$value)
                                            <option @if($key==old('enabled',$course->enabled)) selected @endif value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="row"  x-data="{all_users:{{ old('all_users',$course->all_users) }}}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="enforce_order">@lang('site.visibility')
                                        <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top"
                                           title="@lang('site.visibility-hint')"></i>
                                    </label>
                                    <select x-model="all_users" class="form-control" name="all_users" id="all_users">
                                        @foreach(['1'=>__('site.all-users'),'0'=>__('site.selected-groups')] as $key=>$value)
                                            <option @if($key==old('all_users',$course->all_users)) selected @endif value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6"  x-show="all_users==0" >

                                <div class="form-group">
                                    <label for="departments">@lang('site.departments')</label>

                                    <select class="form-control select2" multiple name="departments[]" id="departments">
                                        @foreach(\App\Department::limit(500)->latest()->get() as $department)
                                            <option
                                                @if( (is_array(old('departments')) && in_array(@$department->id,old('departments')))  || (null === old('departments')  && $course->departments()->where('id',$department->id)->first() ))

                                                    selected
                                                @endif
                                                value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('all_users', '<p class="help-block">:message</p>')  !!}
                                </div>


                            </div>
                        </div>





                        <div class="row"  x-data="{capacity:{{ old('enforce_capacity',$course->enforce_capacity) }}}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="enforce_capacity">@lang('site.enforce-capacity')
                                        <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top"
                                           title="@lang('site.capacity-hint')"></i>
                                    </label>
                                    <select  x-model="capacity"  class="form-control" name="enforce_capacity" id="enforce_capacity">

                                        @foreach(['0'=>__('site.no'),'1'=>__('site.yes')] as $key=>$value)
                                            <option @if($key==old('enforce_capacity',$course->enforce_capacity)) selected @endif value="{{ $key }}">{{ $value }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6"  x-show="capacity==1" >

                                <div class="form-group">
                                    <label for="capacity">@lang('site.capacity')</label>
                                    <input value="{{ old('capacity',$course->capacity) }}" type="text" class="form-control" name="capacity" id="capacity"  placeholder="@lang('site.numbers-only')">
                                    {!! $errors->first('capacity', '<p class="help-block">:message</p>')  !!}
                                </div>


                            </div>
                        </div>


                    </div>
                    <div class="tab-pane fade pt-3" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">@lang('site.start-date')
                                        <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top"
                                           title="@lang('site.start-date-hint')"></i>
                                    </label>
                                    <input value="{{ old('start_date',dateFieldString($course->start_date)) }}" type="text"
                                           class="form-control date" name="start_date" id="start_date"
                                           placeholder="@lang('site.date')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">@lang('site.end-date')
                                        <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top"
                                           title="@lang('site.end-date-hint')"></i>
                                    </label>
                                    <input value="{{ old('end_date',dateFieldString($course->end_date)) }}" type="text"
                                           class="form-control date" name="end_date" id="end_date"
                                           placeholder="@lang('site.date')">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="closes_on">@lang('site.enrollment-closes')
                                        <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top"
                                           title="@lang('site.enrollment-closes-hint')"></i>
                                    </label>
                                    <input value="{{ old('closes_on',dateFieldString($course->closes_on)) }}" type="text"
                                           class="form-control date" name="closes_on" id="closes_on"
                                           placeholder="@lang('site.date')">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade pt-4" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                        <div class="form-group">
                            <label for="instructors">@lang('site.instructors')</label>
                            <select multiple class="form-control select2" name="instructors[]" id="instructors">
                                @foreach(\App\User::orderBy('name')->where('role_id',1)->limit(500)->get() as $user)
                                    <option
                                        @if( (is_array(old('instructors')) && in_array(@$user->id,old('instructors')))  || (null === old('instructors')  && $course->courseInstructors()->where('id',$user->id)->first() ))
                                        selected
                                        @endif
                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade pt-5 pl-2" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">

                        <div class="row">
                            <div class="col-md-6">
                                <input type="file" multiple name="course_files[]" class="multi">
                            </div>
                            <div class="col-md-6">
                                    @livewire('admin.course.course-files',['course'=>$course])
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection

@section('header')

    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link href="{{ asset('vendor/pickadate/themes/default.date.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/pickadate/themes/default.css') }}" rel="stylesheet">
    @livewireStyles
@endsection

@section('footer')

    <script defer src="{{ asset('vendor/alpinejs/cdn.min.js') }}"></script>

    <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('vendor/pickadate/picker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/pickadate/picker.date.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/textrte.js') }}"></script>
    <script src="{{ asset('js/admin/pickadate.js') }}"></script>
    <script src="{{ asset('vendor/multifile/jquery.MultiFile.min.js') }}"></script>

    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/select.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $('#course_files').MultiFile();
        });
    </script>
    @livewireScripts
@endsection
