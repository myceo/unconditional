@extends('layouts.admin')

@section('search-form',route('admin.courses.index'))

@section('pageTitle',__('site.courses'))

@section('innerTitle')
    {{ __('site.courses') }} ({{ $courses->count() }})
    @if(Request::get('search'))
        : {{ Request::get('search') }}
    @endif
@endsection

@section('content')

    <a href="{{ route('admin.courses.create') }}" class="btn btn-success btn-sm" title="@lang('site.add-new')">
        <i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')
    </a>


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#filterModal">
        <i class="fa fa-filter" aria-hidden="true"></i> @lang('site.filter')
    </button>

    <!-- Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.courses.index') }}" method="get">
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
                        <div class="col-md-6">
                            <select type="select" name="status" class="form-control">
                                @foreach([
                                     ''=>__('site.status'),
                                     '1'=>__('site.enabled'),
                                     '0'=>__('site.disabled'),
                                        ] as $key=>$value)
                                    <option @if(request()->status=="$key") selected @endif  value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">


                        <div class="col-md-6">
                            <select type="select" name="visibility" class="form-control">
                                @foreach([
                                     ''=>__('site.visibility'),
                                     '1'=>__('site.all-users'),
                                     '0'=>__('site.selected-groups'),
                                        ] as $key=>$value)
                                    <option @if(request()->public=="$key") selected @endif  value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">@lang('site.reset')</a>
                     <button type="submit" class="btn btn-primary">@lang('site.filter')</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        @foreach($courses as $course)
        <div class="col-md-4" style="position: relative">
                @livewire('admin.course.pinned-course',['course'=>$course])
                <div class="card">
                    <!-- Card image -->
                    <img class="card-img-top" src="{{ asset(!empty($course->picture)?$course->picture:'img/no_image.jpg') }}" alt="Image placeholder">
                    <!-- Card body -->
                    <div class="card-body">
                        <h5 class="card-title mb-0">{{ $course->name }}</h5>

                        <div class="pt-1">
                            <span class="pr-3">
                                           <i class="fa fa-desktop" aria-hidden="true"></i>
                                <small class="text-muted">{{ $course->lessons()->count() }}</small>
                            </span>
                            <span class="pr-3">
                                              <i class="fa fa-users" aria-hidden="true"></i>
                                <small class="text-muted">{{ $course->users()->nonAdmins()->count() }}</small>
                            </span>

                            <span >
                                  @if(empty($course->enabled))
                                    <small class="text-danger">@lang('site.disabled')</small>
                                @else
                                    <small class="text-success">@lang('site.enabled')</small>
                                @endif
                            </span>

                        </div>

                        <p class="card-text mt-4">{{ limitLength($course->short_description,300) }}</p>
                         <div class="dropup d-inline  ">
                                               <button class="btn btn-block btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                   <i class="fa fa-cogs"
                                                      aria-hidden="true"></i> {{ __('site.options') }}
                                               </button>
                                               <div class="dropdown-menu">

                                                   <a class="dropdown-item" href="#" data-toggle="modal"
                                                      data-target="#infoModal{{ $course->id }}" ><i class="fa fa-info-circle"></i> @lang('site.details')</a>
                                                       <a target="_blank" class="dropdown-item" href="{{ route('admin.courses.play',['course'=>$course->id]) }}"><i class="fa fa-play-circle" ></i> <span>{{ __('site.try-course') }}</span></a>

                                                 <a class="dropdown-item" href="{{ route('admin.courses.edit',['course'=>$course->id]) }}"><i class="fa fa-edit" ></i> <span>{{ __('site.edit') }}</span></a>
                                                 <a class="dropdown-item" href="{{ route('admin.courses.classes.index',['course'=>$course->id]) }}"><i class="fa fa-desktop"></i> @lang('site.classes')</a>

                                                  <a class="dropdown-item" href="{{ route('admin.courses.students',['course'=>$course->id]) }}"><i class="fa fa-users" ></i> @lang('site.students')</a>

                                                   <a class="dropdown-item" href="{{ route('admin.courses.certificate',['course'=>$course->id]) }}"><i
                                                           class="fa fa-certificate"
                                                           aria-hidden="true"></i> @lang('site.certificate')</a>

                                                   <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" onclick="return confirm('@lang('site.duplicate-prompt')')" href="{{ route('admin.courses.duplicate',['course'=>$course->id]) }}"><i
                                                           class="fa fa-copy"
                                                           aria-hidden="true"></i> @lang('site.duplicate')</a>

                                                   <form onsubmit="return confirm('@lang('site.delete-prompt')')" method="post" action="{{ route('admin.courses.destroy',['course'=>$course->id]) }}">
                                                      @csrf
                                                       @method('delete')
                                                       <button class="dropdown-item" type="submit"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                   </form>


                                               </div>
                                             </div>
                    </div>
                </div>

        </div>

            @section('footer')
                @parent

                <!-- Modal -->
                <div class="modal fade" id="infoModal{{ $course->id }}" tabindex="-1" role="dialog"
                     aria-labelledby="modalTitle{{ $course->id }}"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $course->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                   <ul class="nav nav-pills" id="myTab{{ $course->id }}" role="tablist">
                                                                           <li class="nav-item">
                                                                             <a class="nav-link active" id="tab-tab{{ $course->id }}" data-toggle="tab" href="#tab1{{ $course->id }}" role="tab" aria-controls="home{{ $course->id }}" aria-selected="true">@lang('site.details')</a>
                                                                           </li>
                                                                           <li class="nav-item">
                                                                             <a class="nav-link" id="tab2-tab{{ $course->id }}" data-toggle="tab" href="#tab2{{ $course->id }}" role="tab" aria-controls="tab2{{ $course->id }}" aria-selected="false">@lang('site.classes')</a>
                                                                           </li>
                                                                           <li class="nav-item">
                                                                               <a class="nav-link" id="tab4-tab{{ $course->id }}" data-toggle="tab" href="#tab4{{ $course->id }}" role="tab" aria-controls="tab4{{ $course->id }}" aria-selected="false">@lang('site.tests')</a>
                                                                           </li>

                                                                           <li class="nav-item">
                                                                               <a class="nav-link" id="tab5-tab{{ $course->id }}" data-toggle="tab" href="#tab5{{ $course->id }}" role="tab" aria-controls="tab5{{ $course->id }}" aria-selected="false">@lang('site.files')</a>
                                                                           </li>

                                                                           <li class="nav-item">
                                                                             <a class="nav-link" id="tab3-tab{{ $course->id }}" data-toggle="tab" href="#tab3{{ $course->id }}" role="tab{{ $course->id }}" aria-controls="tab3{{ $course->id }}" aria-selected="false">@lang('site.totals')</a>
                                                                           </li>
                                                                         </ul>
                                                                         <div class="tab-content" id="myTabContent1{{ $course->id }}">
                                                                           <div class="tab-pane fade show active pt-3" id="tab1{{ $course->id }}" role="tabpanel" aria-labelledby="tab1-tab{{ $course->id }}">

                                                                               <div class="row">
                                                                                   <div class="col">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.name')</span>
                                                                                       <span class="d-block">{{ $course->name }}</span>
                                                                                   </div>
                                                                               </div>
                                                                               <div class="row">
                                                                                   <div class="col">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.short-description')</span>
                                                                                       <p>{!! $course->short_description !!}</p>
                                                                                   </div>
                                                                               </div>
                                                                               <div class="row">
                                                                                   <div class="col">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.description')</span>
                                                                                       <p>{!! $course->description !!}</p>
                                                                                   </div>
                                                                               </div>

                                                                               <div class="row">
                                                                                   <div class="col">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.introduction')</span>
                                                                                       <p>{!! $course->introduction !!}</p>
                                                                                   </div>
                                                                               </div>


                                                                               <div class="row">
                                                                                   <div class="col-md-6">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.effort')</span>
                                                                                       <span class="d-block">{{ $course->effort }}</span>
                                                                                   </div>
                                                                                   <div class="col-md-6">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.length')</span>
                                                                                       <span class="d-block">{{ $course->length }}</span>
                                                                                   </div>
                                                                               </div>

                                                                               <div class="row">
                                                                                   <div class="col-md-6">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.enabled')</span>
                                                                                       <span class="d-block">{{ boolToString($course->enabled) }}</span>
                                                                                   </div>
                                                                                   <div class="col-md-6">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.start-date')</span>
                                                                                       <span class="d-block">{{ dateString($course->start_date) }}</span>
                                                                                   </div>
                                                                               </div>


                                                                               <div class="row">
                                                                                   <div class="col-md-6">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.end-date')</span>
                                                                                       <span class="d-block">{{ dateString($course->end_date) }}</span>
                                                                                   </div>
                                                                                   <div class="col-md-6">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.enrollment-closes')</span>
                                                                                       <span class="d-block">{{ dateString($course->closes_on) }}</span>
                                                                                   </div>
                                                                               </div>


                                                                               <div class="row">
                                                                                   <div class="col-md-6">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.enforce-capacity')</span>
                                                                                       <span class="d-block">{{ boolToString($course->enforce_capacity) }}</span>
                                                                                   </div>
                                                                                   <div class="col-md-6">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.capacity')</span>
                                                                                       <span class="d-block">{{ $course->capacity }}</span>
                                                                                   </div>

                                                                               </div>


                                                                               <div class="row">
                                                                                   <div class="col-md-6">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.visibility')</span>
                                                                                       <span class="d-block">{{ $course->all_users==1? __('site.all-users'):__('site.selected-groups') }}</span>
                                                                                   </div>
                                                                                   @if($course->all_users==0)
                                                                                   <div class="col-md-6">
                                                                                       <span class="h6 surtitle text-muted">@lang('site.departments')</span>
                                                                                       <span class="d-block">
                                                                                             @foreach($course->departments as $department)
                                                                                                  <span class="badge badge-primary">{{ $department->name }}</span>
                                                                                             @endforeach
                                                                                       </span>
                                                                                   </div>
                                                                                   @endif
                                                                               </div>


                                                                           </div>
                                                                           <div class="tab-pane fade pt-3" id="tab2{{ $course->id }}" role="tabpanel" aria-labelledby="tab2-tab{{ $course->id }}">
                                                                            @livewire('admin.lesson.lesson-list',['courseId' => $course->id])
                                                                           </div>
                                                                           <div class="tab-pane fade pt-3" id="tab4{{ $course->id }}" role="tabpanel" aria-labelledby="tab4-tab{{ $course->id }}">
                                                                               <ul class="list-group">
                                                                                    @foreach($course->tests as $test)
                                                                                   <li class="list-group-item">{{ $test->name }}</li>
                                                                                   @endforeach
                                                                               </ul>
                                                                           </div>

                                                                             <div class="tab-pane fade pt-3" id="tab5{{ $course->id }}" role="tabpanel" aria-labelledby="tab5-tab{{ $course->id }}">
                                                                                           @livewire('admin.course.course-files',['course' => $course])
                                                                             </div>

                                                                             <div class="tab-pane fade pt-3" id="tab3{{ $course->id }}" role="tabpanel" aria-labelledby="tab3-tab{{ $course->id }}">
                                                                               <table class="table">

                                                                                   <tbody>
                                                                                   <tr>
                                                                                       <th>@lang('site.students')</th>
                                                                                       <td>{{ $course->users()->nonAdmins()->count() }}</td>
                                                                                   </tr>
                                                                                   <tr>
                                                                                       <th>@lang('site.classes')</th>
                                                                                       <td>{{ $course->lessons()->count() }}</td>
                                                                                   </tr>
                                                                                   <tr>
                                                                                       <th>@lang('site.files')</th>
                                                                                       <td>{{ $course->courseFiles()->count() }}</td>
                                                                                   </tr>
                                                                                   <tr>
                                                                                       <th>@lang('site.tests')</th>
                                                                                       <td>{{ $course->tests()->count() }}</td>
                                                                                   </tr>
                                                                                   </tbody>
                                                                               </table>
                                                                           </div>
                                                                         </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('site.close')</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection

        @endforeach
    </div>
<div>
    {!! $courses->links() !!}
</div>

@endsection
@section('header')
    @livewireStyles
@endsection

@section('footer')
    @livewireScripts
    <script src="{{ asset('vendor/sortable/livewire-sortable.js') }}"></script>
@endsection

