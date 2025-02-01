@extends('layouts.admin')
@section('pageTitle',__('admin.member').': '.$member->name)

@section('innerTitle')
     @lang('admin.members') : {{ $member->name }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/admin/members') }}">@lang('admin.members')</a>
    </li>
    <li><span>@lang('admin.member')</span>
    </li>
@endsection

@section('content')

    <a class="float-right" href="{{ prevPage() }}" title="@lang('admin.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('admin.back')</button></a>

    <ul class="nav nav-pills" id="myTab1" role="tablist">
                                            <li class="nav-item">
                                              <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">@lang('site.details')</a>
                                            </li>
                                            <li class="nav-item">
                                              <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">@lang('site.courses')</a>
                                            </li>
                                            <li class="nav-item">
                                              <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">@lang('site.tests')</a>
                                            </li>
                                          </ul>
                                          <div class="tab-content" id="myTabContent1">
                                            <div class="tab-pane fade show active pt-3" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                                <div class="card author-box card-primary">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-5">
                                                                <div class="author-box-left"  >
                                                                    <div class="gallery gallery-fw" data-item-height="250">
                                                                        <div class="gallery-item" style="width: 250px; float: none;" data-image="{{ profilePicture($member->id) }}" data-title="Image 1"></div>
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                    <a href="{{ url('/admin/members/' . $member->id . '/edit') }}" class="btn btn-primary mt-3"><i class="fas fa-edit"></i> @lang('admin.edit')</a>
                                                                    <a  onclick="$('#delform').submit()" href="#" class="btn btn-danger mt-3"><i class="fa fa-trash"></i> @lang('admin.delete')</a>

                                                                    <form onsubmit="return confirm('@lang('site.confirm-delete')')" id="delform" method="POST" action="{{ url('admin/members' . '/' . $member->id) }}" accept-charset="UTF-8" style="display:inline">
                                                                        {{ method_field('DELETE') }}
                                                                        {{ csrf_field() }}
                                                                    </form>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-7">
                                                                <div class="author-box-details_">
                                                                    <div class="author-box-name">
                                                                        <a href="#">{{ $member->name }}</a>
                                                                    </div>
                                                                    <div class="author-box-job">{{ gender($member->gender) }}</div>
                                                                    <div class="author-box-description">
                                                                        <p>{!! linkify(nl2br(clean($member->about))) !!}</p>
                                                                    </div>

                                                                    <div >

                                                                        <div class="mb-2 mt-3"><div class="text-small font-weight-bold">@lang('admin.email')</div>
                                                                            {{ $member->email }}
                                                                        </div>

                                                                        <div class="mb-2 mt-3"><div class="text-small font-weight-bold">@lang('admin.departments')</div>
                                                                            <ul class="comma-tags">
                                                                                @foreach($member->departments as $department)
                                                                                    <li>{{ $department->name }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>

                                                                        <div class="mb-2 mt-3"><div class="text-small font-weight-bold">@lang('admin.telephone')</div>
                                                                            {{ $member->telephone }}
                                                                        </div>

                                                                        <div class="mb-2 mt-3"><div class="text-small font-weight-bold">@lang('admin.gender')</div>
                                                                            {{ gender($member->gender) }}
                                                                        </div>

                                                                        @if(setting('general_enable_birthday')==1 && !empty($member->date_of_birth))
                                                                            <div class="mb-2 mt-3"><div class="text-small font-weight-bold">@lang('admin.birthday')</div>

                                                                                {{  \Illuminate\Support\Carbon::parse($member->date_of_birth)->format('dS F Y') }} ({{ getAge($member->date_of_birth) }})

                                                                            </div>
                                                                        @endif

                                                                        @if(setting('general_enable_anniversary')==1 && !empty($member->wedding_anniversary))
                                                                            <div class="mb-2 mt-3"><div class="text-small font-weight-bold">@lang('admin.wedding-anniversary')</div>

                                                                                {{  \Illuminate\Support\Carbon::parse($member->wedding_anniversary)->format('jS F Y') }}


                                                                            </div>
                                                                        @endif
                                                                        @foreach(\App\Field::orderBy('sort_order','asc')->get() as $field)

                                                                            <div class="mb-2 mt-3"><div class="text-small font-weight-bold"> {{ $field->name }}</div>


                                                                                    <?php
                                                                                    $value = $member->fields()->where('field_id',$field->id)->first() ? $member->fields()->where('field_id',$field->id)->first()->pivot->value:'';

                                                                                    ?>
                                                                                @if($field->type=='checkbox')
                                                                                    {{ boolToString($value) }}
                                                                                @else
                                                                                    {!! linkify(nl2br(clean($value ))) !!}
                                                                                @endif

                                                                            </div>
                                                                        @endforeach



                                                                    </div>




                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade pt-3" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                                <table class="table mt-2 dtable">
                                                    <thead>
                                                    <tr>
                                                        <th>@lang('site.course')</th>
                                                        <th style="width: 120px;" class="text-center">@lang('site.classes')</th>
                                                        <th  style="width: 120px;" class="text-center">@lang('site.tests')</th>
                                                        <th class="text-center">@lang('site.completed')</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($member->courses()->latest()->get() as $course)
                                                        <tr>
                                                            <td>{{ $course->name }}</td>
                                                            <td>
                                                                @if($course->lessons()->count()>0)
                                                                    @php
                                                                        $attended = $member->lessons()->where('course_id',$course->id)->count();
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
                                                                        $passed = totalUserCourseTests($member,$course);
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
                                                            <td class="text-center">{{ boolToString(courseCompleted($member,$course)) }}</td>

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade pt-3" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                                <div class="table-responsive">
                                                    <table class="table dtable">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>@lang('site.name')</th>
                                                            <th>@lang('site.status')</th>
                                                            <th>@lang('site.score')</th>
                                                            <th>@lang('site.passmark')</th>
                                                            <th>@lang('site.date')</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($member->userTests()->latest()->get() as $userTest)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $userTest->test->name }}</td>
                                                                <td>
                                                                    @if($member->testPassed($userTest->test))
                                                                        <span class="text-success">@lang('site.passed')</span>
                                                                    @else
                                                                        <span class="text-danger">@lang('site.failed')</span>
                                                                    @endif


                                                                </td>
                                                                <td>{{ $userTest->score }}</td>
                                                                <td>{{ $userTest->test->passmark }}%</td>
                                                                <td>
                                                                    {{ dateString($userTest->created_at) }}
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                          </div>






@endsection

@section('header')

 <link rel="stylesheet" href="{{ asset('themes/admin/assets/modules/chocolat/dist/css/chocolat.css') }}">
 <link rel="stylesheet" href="{{ asset('vendor/datatables/media/css/jquery.dataTables.min.css') }}">
@endsection

@section('footer')
    <script src="{{ asset('themes/admin/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script>
        "use strict";
        $(function(){
            $('.dtable').DataTable({
                language: {
                    search: "@lang('site.search'):",
                    info: "@lang('site.table-info')",
                    emptyTable: "@lang('site.empty-table')",
                    lengthMenu:    "@lang('site.table-length')",
                    paginate: {
                        first:      "@lang('site.first')",
                        previous:   "@lang('site.previous')",
                        next:       "@lang('site.next')",
                        last:       "@lang('site.last')"
                    }
                }
            });
        });
    </script>
@endsection
