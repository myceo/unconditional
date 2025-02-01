@extends('layouts.member')
@section('pageTitle',__('admin.roster'))

@section('innerTitle')
    <h4>
        @if(empty($start) && empty($end))
            @lang('admin.upcoming-events')
        @else
            @lang('admin.roster')
            @if(Request::get('start'))
                 : {{ Request::get('start') }}
            @endif
            @if(Request::get('end'))
                @lang('to')   {{ Request::get('end') }}
            @endif
        @endif
    </h4>
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.roster')</span>
    </li>
@endsection

@section('content')
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap">
                        <div style="margin-bottom: 20px">
                        <form  method="GET" action="{{ route('member.events.roster') }}" >
                            <div class="row">
                                <div class="col-md-3">
                                    <input placeholder="@lang('admin.from')" class="form-control date" type="text" name="start" value="{{ $start }}"/>
                                </div>
                                <div class="col-md-3">
                                    <input placeholder="@lang('admin.to')" class="form-control date" type="text" name="end" value="{{ $end }}"/>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-primary" type="submit">@lang('admin.filter')</button>
                                    <a class="btn btn-default" href="{{ route('member.events.roster') }}">@lang('admin.reset')</a>
                                </div>
                            </div>
                        </form>
                        </div>

                        @if($events->count()==0)
                            <div class="well">
                                @lang('admin.no-results')
                            </div>

                        @endif

                        @foreach($events as $event)

                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>{{ $event->name }} ({{ \Carbon\Carbon::parse($event->event_date)->format('D d/M/Y') }})</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('member.events.download',['event'=>$event->id]) }}" class="btn btn-primary">
                                            <i class="fa fa-download"></i> @lang('admin.download')
                                        </a>
                                        <a href="{{ route('member.event-comments.index',['event'=>$event->id]) }}" class="btn btn-info">
                                            <i class="fa fa-comments"></i> @lang('admin.comments') ({{ $event->eventComments()->count() }})
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <ul class="nav nav-pills" id="myTab{{ $event->id }}" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab{{ $event->id }}" data-toggle="tab" href="#home{{ $event->id }}" role="tab" aria-controls="home{{ $event->id }}" aria-selected="true">@lang('admin.info')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab{{ $event->id }}" data-toggle="tab" href="#profile{{ $event->id }}" role="tab" aria-controls="profile{{ $event->id }}" aria-selected="false">@lang('admin.shifts')</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent{{ $event->id }}">
                                        <div class="tab-pane fade show active" id="home{{ $event->id }}" role="tabpanel" aria-labelledby="home-tab{{ $event->id }}">
                                            <table class="table table-bordered table-striped" style="margin-top: 10px">
                                                <tbody>
                                                <tr>
                                                    <td style="border-top: none"><strong>@lang('admin.starts'):</strong></td>
                                                    <td style="border-top: none">{{ \Carbon\Carbon::parse($event->event_date)->format('D d/M/Y') }} ({{ \Carbon\Carbon::parse($event->event_date)->diffForHumans() }})</td>
                                                </tr>
                                                @if(!empty($event->venue))
                                                    <tr>
                                                        <td><strong>@lang('admin.venue'):</strong></td>
                                                        <td>{{ $event->venue }}</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td><strong>@lang('admin.shifts'):</strong></td>
                                                    <td>{{ $event->shifts()->count() }}</td>
                                                </tr>
                                                <?php
                                                $users = [];
                                                ?>
                                                @foreach($event->shifts as $shift)
                                                    @foreach($shift->users as $user)
                                                        <?php
                                                        $users[$user->id] = $user;
                                                        ?>
                                                    @endforeach
                                                @endforeach
                                                @if(!empty($users))
                                                    <tr>
                                                        <td><strong>@lang('admin.members'):</strong></td>
                                                        <td>

                                                            <ul class="comma-tags">
                                                                @foreach($users as $user)
                                                                    <li>{{ $user->name }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                            @if(!empty($event->description))
                                                <div class="alert alert-success" role="alert">{!! nl2br(clean($event->description)) !!}</div>
                                            @endif
                                        </div>
                                        <div class="tab-pane fade" id="profile{{ $event->id }}" role="tabpanel" aria-labelledby="profile-tab{{ $event->id }}">
                                            @foreach($event->shifts()->orderBy('starts')->get() as $shift)
                                                <div style="border: solid 1px #CCCCCC; padding-left: 15px; padding-right: 15px; margin-bottom: 30px">
                                                    <h4 style="margin-top: 20px">{{ \Illuminate\Support\Carbon::parse($shift->starts)->format('h:i A') }} to {{ \Illuminate\Support\Carbon::parse($shift->ends)->format('h:i A') }} <span class="float-right">{{ $shift->name }}</span></h4>

                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>@lang('admin.member')</th>
                                                            <th>@lang('admin.tasks')</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($shift->users()->orderBy('name')->get() as $user)
                                                            <tr>
                                                                <td>{{ $user->name }}</td>
                                                                <td>{{ $user->pivot->tasks }}</td>
                                                            </tr>

                                                        @endforeach
                                                        @if($shift->users()->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->first())
                                                            <tr>
                                                                <td colspan="2">
                                                                    <a style="color: white" class="btn btn-danger btn-lg" href="#"  data-toggle="modal" data-target="#myModal{{ $shift->id }}">@lang('admin.opt-out')</a>

                                                                    @section('footer')
                                                                        @parent
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="myModal{{ $shift->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{ $shift->id }}">
                                                                        <div class="modal-dialog" role="document">
                                                                            <form action="{{ route('member.events.opt-out',['shift'=>$shift->id]) }}" method="post">
                                                                                @csrf
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h4 class="modal-title" id="myModalLabel{{ $shift->id }}">@lang('admin.shift') {{ \Illuminate\Support\Carbon::parse($shift->starts)->format('h:i A') }} to {{ \Illuminate\Support\Carbon::parse($shift->ends)->format('h:i A') }} ({{ $shift->name }}) @lang('admin.opt-out')</h4>

                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="form-group">
                                                                                            <label for="message">@lang('admin.reject-reason')</label>
                                                                                            <textarea required class="form-control"
                                                                                                      name="message" id="message{{ $shift->id }}"
                                                                                                      rows="4"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.close')</button>
                                                                                        <button type="submit" class="btn btn-danger">@lang('admin.opt-out')</button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>

                                                                        </div>
                                                                    </div>
                                                                        @endsection




                                                                </td>
                                                            </tr>
                                                        @elseif($shift->event->accept_volunteers==1)
                                                            <tr>
                                                                <td colspan="2">
                                                                    <a style="color: white" class="btn btn-success btn-lg" href="{{ route('member.events.volunteer',['shift'=>$shift->id]) }}"  ><i class="fa fa-user-plus"></i> @lang('admin.volunteer')</a>



                                                                </td>
                                                            </tr>

                                                        @endif
                                                        </tbody>
                                                    </table>
                                                    @if(!empty($shift->description))
                                                        <div class="alert alert-success" role="alert">
                                                            {{ $shift->description }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach

                                        </div>

                                    </div>

                                </div>
                            </div>

                        @endforeach
                        <div class="custom-pagination">
                            {!! $events->appends(['start' => Request::get('start'),'end'=> Request::get('end')])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



@section('header')
    <link href="{{ asset('vendor/pickadate/themes/default.date.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/pickadate/themes/default.time.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/pickadate/themes/default.css') }}" rel="stylesheet">


@endsection


@section('footer')
    <script src="{{ asset('vendor/pickadate/picker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/pickadate/picker.date.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/pickadate/picker.time.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/pickadate/legacy.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('.date').pickadate({
            format: 'yyyy-mm-dd'
        });
    </script>
@endsection
