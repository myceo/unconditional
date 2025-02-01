@extends('layouts.member')
@section('pageTitle',__('admin.dashboard'))
@section('innerTitle',__('admin.dashboard'))

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('member.events.roster') }}">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>@lang('admin.upcoming-events')</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalEvents }}
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            @can('dept_allows','show_members')
            <a href="{{ url('member/members') }}">
                @endcan
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>@lang('admin.members')</h4>
                        </div>
                        <div class="card-body">
                            {{ $members }}
                        </div>
                    </div>
                </div>
                @can('dept_allows','show_members')
            </a>
            @endcan
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('member.emails.inbox') }}">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>@lang('admin.messages')</h4>
                        </div>
                        <div class="card-body">
                            {{ $messages }}
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ url('member/announcements') }}">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4 style="padding-right: 0px;">@lang('admin.announcements')</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalAnnouncements }}
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>@lang('admin.events')</h4>
                    <div class="card-header-action">
                        <a href="{{ route('member.events.roster') }}" class="btn btn-primary">
                            @lang('admin.view-all')
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills" id="myTab3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">@lang('admin.upcoming-events')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">@lang('admin.my-shifts')</a>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent2">
                        <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">

                            <ul class="list-unstyled list-unstyled-border mt-2">
                                @foreach($events as $event)
                                <li class="media">
                                    <div class="media-body">
                                        <div class="badge badge-pill badge-primary mb-1 float-right">{{ \Carbon\Carbon::parse($event->event_date)->format('D d/M/Y') }}</div>
                                        <h6 class="media-title"><a href="{{ route('member.events.view-roster',['event'=>$event->id]) }}">{{ $event->name }} ({{ \Carbon\Carbon::parse($event->event_date)->diffForHumans() }})</a></h6>
                                    </div>
                                </li>
                                @endforeach
                            </ul>


                        </div>
                        <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">

                            <ul class="list-unstyled list-unstyled-border mt-2">
                                @foreach($shifts as $shift)
                                <li class="media">
                                        <div class="media-body">
                                            <div class="badge badge-pill badge-primary mb-1 float-right">{{ \Illuminate\Support\Carbon::parse($shift->starts)->format('h:i A') }} @lang('admin.to') {{ \Illuminate\Support\Carbon::parse($shift->ends)->format('h:i A') }}</div>
                                            <h6 class="media-title"><a href="{{ route('member.events.view-roster',['event'=>$shift->event->id]) }}">{{ $shift->event->name }} ({{ \Carbon\Carbon::parse($event->event_date)->format('D d/M/Y') }})</a></h6>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                        </div>

                    </div>
                </div>
            </div>


        </div>
        <div class="col-md-6">

            <div class="card card-success">
                <div class="card-header">
                    <h4>@lang('admin.announcements')</h4>
                    <div class="card-header-action">
                        <a href="{{ url('member/announcements') }}" class="btn btn-primary">
                            @lang('admin.view-all')
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border tickets-list" >
                        @foreach($announcements as $item)
                        <li class="media">
                            <img class="mr-3 rounded-circle" src="{{ profilePicture($item->user_id) }}" alt="avatar" width="50">
                            <div class="media-body">
                                <a href="{{ url('/member/announcements/' . $item->id) }}" class="ticket-item" style="padding: 0px; border: none">
                                    <div class="ticket-title">
                                        <h4>{{ $item->title }} @if($item->pinned==1)

                                            <i class="fa fa-thumbtack text-primary float-right"></i>
                                        @endif</h4>
                                    </div>
                                    <div class="ticket-info">
                                        <div>{{ $item->user->name }}</div>
                                        <div class="bullet"></div>
                                        <div class="text-primary">{{ $item->created_at->diffForHumans() }}</div>
                                        <div class="bullet"></div>
                                        <div class="text-success">
                                            <i class="fa fa-comments"></i> {{ $item->announcementComments()->count() }}
                                            @if($item->announcementComments()->count() == 1)
                                            @lang('admin.comment')
                                            @else
                                                @lang('admin.comments')
                                            @endif

                                        </div>
                                    </div>
                                </a>


                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>





        </div>
    </div>

    <div class="row">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <h4 class="d-inline">@lang('admin.recent-messages')</h4>
                    <div class="card-header-action">
                        <a href="{{ url('admin/emails') }}" class="btn btn-primary">@lang('admin.view-all')</a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border">
                        @foreach($emails as $item)
                        <li class="media @if($item->pivot->read==0) unread @endif">

                            <img class="mr-3 rounded-circle" src="{{ profilePicture($item->user_id) }}" alt="avatar" width="50">
                            <div class="media-body">
                                <div class=" mb-1 float-right"><a class="btn btn-danger btn-sm"  href="{{ route('email.delete-inbox',['id'=>$item->id]) }}"  title="@lang('site.delete')" onclick="return confirm('@lang('admin.delete-prompt')')" ><i class="fa fa-trash" aria-hidden="true"></i></a></div>
                                <h6 class="media-title"><a href="{{ route('member.email.view-inbox',['email'=>$item->id]) }}">{{ $item->subject }}</a> @if($item->emailAttachments()->count()>0)
                                        <i class="fa fa-paperclip"></i>
                                    @endif</h6>
                                <div class="text-small text-muted">{{ $item->user->name }} <div class="bullet"></div> <span class="text-primary">{{ \Illuminate\Support\Carbon::parse($item->crated_at)->format('D, M d, Y') }}</span></div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>





        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="d-inline">@lang('admin.forum-topics')</h4>
                    <div class="card-header-action">
                        <a href="{{ url('member/forum-topics') }}" class="btn btn-primary">@lang('admin.view-all')</a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border">
                        @foreach($forumTopics as $item)
                            <li class="media">

                                <img class="mr-3 rounded-circle" src="{{ profilePicture($item->user_id) }}" alt="avatar" width="50">
                                <div class="media-body">
                                     <a href="{{ url('/member/forum-topics/' . $item->id) }}" class="btn btn-sm btn-success mb-1 float-right btn-round">{{ $item->forumThreads()->count() -1 }} {{ strtolower(__('admin.replies')) }}</a>
                                    <h6 class="media-title"><a href="{{ url('/member/forum-topics/' . $item->id) }}">{{ $item->topic }}</a>  @if($item->pinned==1)

                                            <i class="fa fa-thumbtack text-primary ml-1"></i>
                                        @endif</h6>
                                    <div class="text-small text-muted">{{ $item->user->name }} <div class="bullet"></div> <span class="text-primary">{{ \Illuminate\Support\Carbon::parse($item->crated_at)->format('d M, Y') }}</span>
                                    @if(empty($item->enabled))

                                            <div class="bullet"></div> <span class="text-danger">@lang('admin.closed')</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>



        </div>
    </div>


@endsection
