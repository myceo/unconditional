
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h4>@lang('admin.roster')</h4>

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
                                        <h6 class="media-title"><a href="{{ route('user.event',['event'=>$event->id]) }}">{{ $event->name }} ({{ \Carbon\Carbon::parse($event->event_date)->diffForHumans() }})</a></h6>
                                        <small>{{ $event->department->name }}</small>
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
                                        <h6 class="media-title"><a href="{{ route('user.event',['event'=>$shift->event_id]) }}">{{ $shift->event->name }} ({{ \Carbon\Carbon::parse($event->event_date)->format('D d/M/Y') }})</a></h6>
                                        <small>{{ $shift->event->department->name }}</small>
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

            </div>
            <div class="card-body">
                <ul class="list-unstyled list-unstyled-border tickets-list" >
                    @foreach($announcements as $item)
                        <li class="media">
                            <img class="mr-3 rounded-circle" src="{{ profilePicture($item->user_id) }}" alt="avatar" width="50">
                            <div class="media-body">
                                <a href="{{ route('user.announcement',['announcement'=>$item->id]) }}" class="ticket-item" style="padding: 0px; border: none">
                                    <div class="ticket-title">
                                        <h4>{{ $item->title }}</h4>
                                    </div>
                                    <div class="ticket-info">
                                        <div>{{ $item->user->name }}</div>
                                        <div class="bullet"></div>
                                        <div class="text-primary">{{ $item->created_at->diffForHumans() }}</div>
                                        <div class="bullet"></div>
                                        <div>{{ $item->department->name }}</div>
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

        <div class="card card-info">
            <div class="card-header">
                <h4 class="d-inline">@lang('admin.recent-messages')</h4>

            </div>
            <div class="card-body">
                <ul class="list-unstyled list-unstyled-border">
                    @foreach($emails as $item)
                        <li class="media @if($item->pivot->read==0) unread @endif">

                            <img class="mr-3 rounded-circle" src="{{ profilePicture($item->user_id) }}" alt="avatar" width="50">
                            <div class="media-body">
                                 <h6 class="media-title"><a href="{{ route('user.email.view-inbox',['email'=>$item->id]) }}">{{ $item->subject }}</a> @if($item->emailAttachments()->count()>0)
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
        <div class="card card-warning">
            <div class="card-header">
                <h4 class="d-inline">@lang('admin.forum-topics')</h4>

            </div>
            <div class="card-body">
                <ul class="list-unstyled list-unstyled-border">
                    @foreach($forumTopics as $item)
                        <li class="media">

                            <img class="mr-3 rounded-circle" src="{{ profilePicture($item->user_id) }}" alt="avatar" width="50">
                            <div class="media-body">
                                <a href="{{ route('user.forum-topic',['forumTopic'=>$item->id]) }}" class="btn btn-sm btn-success mb-1 float-right btn-round">{{ $item->forumThreads()->count() -1 }} {{ strtolower(__('admin.replies')) }}</a>
                                <h6 class="media-title"><a href="{{ route('user.forum-topic',['forumTopic'=>$item->id]) }}">{{ $item->topic }}</a></h6>
                                <div class="text-small text-muted">{{ $item->user->name }} <div class="bullet"></div> <span class="text-primary">{{ \Illuminate\Support\Carbon::parse($item->crated_at)->format('D, M d, Y') }}</span>
                                    <div class="bullet"></div>
                                    <div>{{ $item->department->name }}</div>
                                </div>

                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>



    </div>
</div>

