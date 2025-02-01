@extends('layouts.site')
@section('pageTitle',$department->name)
@section('innerTitle',$department->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('site.home') }}">@lang('site.home')</a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('site.departments') }}">@lang('site.departments')</a>
    </li>
    <li class="breadcrumb-item">{{ ucfirst(__('site.details')) }}
    </li>
@endsection

@section('content')
    <section class="section">
        <div class="section-body">


            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">

                    <div class="card profile-widget">
                        <div class="profile-widget-header">

                            @if(!empty($department->picture) && file_exists($department->picture))
                                <img src="{{ asset($department->picture) }}"  class="rounded-circle profile-widget-picture"  />
                            @else
                                <img src="{{ asset('themes/admin/assets/img/avatar/group2.jpg') }}" class="rounded-circle profile-widget-picture" />
                            @endif


                            <div class="profile-widget-items">
                                @if(setting('general_member_count')==1)
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">@lang('site.members')</div>
                                    <div class="profile-widget-item-value"><small>{{ $department->users()->count() }}</small></div>
                                </div>
                                @endif
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">@lang('site.registration')</div>
                                    <div class="profile-widget-item-value"><small>@if($department->enroll_open==1) @lang('site.open') @else @lang('site.closed') @endif</small></div>
                                </div>
                                    @if($department->enroll_open==1)
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">@lang('site.enrollment')</div>
                                    <div class="profile-widget-item-value">
                                        @if($department->approval_required==1)
                                          <small>@lang('site.approval-required')</small>
                                        @else
                                            <small>@lang('site.instant')</small>
                                        @endif
                                    </div>
                                </div>
                                    @endif
                            </div>
                        </div>
                        <div class="profile-widget-description">

                            @if($department->enroll_open==1)

                                @if($department->approval_required==1)
                                    <a class="btn btn-success btn-lg btn-block" href="{{ route('site.apply',['department'=>$department->id]) }}">@lang('site.apply')</a>
                                @else
                                    <a class="btn btn-success btn-lg btn-block" href="{{ route('site.join-department',['department'=>$department->id]) }}">@lang('site.join')</a>
                                @endif

                            @endif

                        </div>

                    </div>
                        @if(false)
                         <div class="card author-box card-primary">
                            <div class="card-body">
                                <div class="author-box-left">

                                    @if(!empty($department->picture) && file_exists($department->picture))
                                        <img src="{{ asset($department->picture) }}"  class=" author-box-picture"  />
                                    @else
                                        <img src="{{ asset('themes/admin/assets/img/avatar/group2.jpg') }}" class="rounded-circle author-box-picture" />
                                    @endif

                                    <div class="clearfix"></div>
                                    <a href="#" class="btn btn-primary mt-3 follow-btn" data-follow-action="alert('follow clicked');" data-unfollow-action="alert('unfollow clicked');">Follow</a>
                                </div>
                                <div class="author-box-details">
                                    <div class="author-box-name">
                                        <a href="#">Hasan Basri</a>
                                    </div>
                                    <div class="author-box-job">Web Developer</div>
                                    <div class="author-box-description">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat.</p>
                                    </div>
                                    <div class="mb-2 mt-3"><div class="text-small font-weight-bold">Follow Hasan On</div></div>
                                    <a href="#" class="btn btn-social-icon mr-1 btn-facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="btn btn-social-icon mr-1 btn-twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="btn btn-social-icon mr-1 btn-github">
                                        <i class="fab fa-github"></i>
                                    </a>
                                    <a href="#" class="btn btn-social-icon mr-1 btn-instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <div class="w-100 d-sm-none"></div>
                                    <div class="float-right mt-sm-0 mt-3">
                                        <a href="#" class="btn">View Posts <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate="">

                            <div class="card-body">
                                <ul class="nav nav-pills" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">@lang('site.about-us')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">@lang('site.gallery')</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade active show" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                                        {!! clean($department->description) !!}
                                    </div>
                                    <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                                        <div class="row">
                                            @foreach($gallery as $image)
                                                <div class="col-md-3" style="text-align: center; " >

                                                    <a data-toggle="modal" data-target="#myModal{{ $image->id }}" href="#"><img src="{{ asset($image->file_path) }}"  class="img-fluid img-thumbnail" style="max-height: 200px"></a>
                                                    <p>
                                                        {{ $image->name }}
                                                    </p>


                                                </div>

                                                @section('footer')
                                                    @parent
                                                <!-- Modal -->
                                                <div class="modal fade" id="myModal{{ $image->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{ $image->id }}">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel{{ $image->id }}">{{ $image->name }}</h4>

                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="{{ asset($image->file_path) }}"  class="img-fluid" >
                                                                @if(!empty($image->description))
                                                                    <br/>
                                                                    <div class="well">
                                                                        {!! nl2br(clean($image->description)) !!}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endsection

                                            @endforeach



                                        </div>
                                        {{ $gallery->links() }}


                                    </div>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
