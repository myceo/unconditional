@extends('layouts.member')
@section('pageTitle',__('admin.events'))
@section('innerTitle',__('admin.events'))



@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.events')</span>
    </li>
@endsection

@section('content')




    <div class="card">
        <div class="card-header">
            <h4><a class="btn btn-primary" title="@lang('site.create-new') @lang('admin.event')" href="{{ url('/member/events/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a></h4>
            <div class="card-header-form">
                <form method="GET" action="{{ url('/member/events') }}">
                    <div class="input-group">
                        <input type="text"  name="search" value="{{ request('search') }}"  class="form-control" placeholder="{{ ucfirst(__('site.search')) }}...">
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">


                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>@lang('admin.event') @lang('admin.date')</th><th>@lang('admin.name')</th><th>@lang('admin.shifts')</th><th>@lang('admin.members')</th><th>@lang('admin.opt-outs')</th><th>@lang('site.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $item)
                            <tr>
                                <td>{{  \Illuminate\Support\Carbon::parse($item->event_date)->format('D d/M/Y') }}</td>
                                <td>{{ $item->name }}</td><td>{{ $item->shifts()->count() }}</td>
                                <td>{{ $controller->getTotalUsers($item) }}</td>
                                <td>{{ $item->rejections()->count() }} @if($item->rejections()->count() > 0) (<a href="#"  data-toggle="modal" data-target="#myModal{{ $item->id }}" >@lang('admin.view')</a>) @endif



                                </td>
                                <td>
                                    <a href="{{ route('member.shifts.index',['event'=>$item->id]) }}" ><button class="btn btn-success btn-sm"><i class="fa fa-clock" aria-hidden="true"></i> @lang('admin.manage-shifts')</button></a>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                           <i class="fa fa-cogs"></i> @lang('admin.options')
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ url('/member/events/' . $item->id) }}">@lang('site.view')</a>
                                            <a class="dropdown-item" href="{{ url('/member/events/' . $item->id . '/edit') }}">@lang('site.edit')</a>
                                            <a class="dropdown-item"  data-toggle="modal" data-target="#duplicateModal{{ $item->id }}"  href="#">@lang('admin.duplicate')</a>
                                            <a class="dropdown-item" href="{{ route('member.events.reports',['event'=>$item->id]) }}">@lang('admin.reports') ({{ $item->eventReports()->count() }})</a>
                                            @section('footer')

                                            <div class="modal fade" tabindex="-1" role="dialog" id="duplicateModal{{ $item->id }}">
                                                      <div class="modal-dialog" role="document">
                                                          <form action="{{ route('member.events.duplicate',['event'=>$item->id]) }}" method="post">
                                                              @csrf
                                                              <div class="modal-content">
                                                                  <div class="modal-header">
                                                                      <h5 class="modal-title">@lang('admin.duplicate') {{ $item->name }}</h5>
                                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                          <span aria-hidden="true">&times;</span>
                                                                      </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                      <div class="form-group">
                                                                          <label for="event_date" class="control-label">@lang('admin.event') @lang('admin.date')</label>
                                                                          <input required class="form-control date" name="date" type="text" id="event_date" value="" >

                                                                      </div>
                                                                  </div>
                                                                  <div class="modal-footer bg-whitesmoke br">
                                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('admin.close')</button>
                                                                      <button type="submit" class="btn btn-primary">@lang('admin.duplicate')</button>
                                                                  </div>
                                                              </div>
                                                          </form>

                                                      </div>
                                                    </div>
                                                @parent
                                            @endsection
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">@lang('site.delete')</a>
                                        </div>
                                    </div>


                                    <form onsubmit="return confirm('@lang('site.confirm-delete')')" id="delform{{ $item->id }}" method="POST" action="{{ url('/member/events' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                     </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

            </div>
            <div class="custom-pagination">
                {!! $events->appends(['search' => Request::get('search')])->render() !!}
            </div>
        </div>
    </div>


@endsection

@section('footer')
    <script src="{{ asset('vendor/pickadate/picker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/pickadate/picker.date.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/pickadate/legacy.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('.date').pickadate({
            format: 'yyyy-mm-dd',
            'container':'body'
        });

    </script>


    @foreach($events as $item)

                <div class="modal fade" tabindex="-1" role="dialog" id="myModal{{ $item->id }}">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">@lang('admin.opt-outs'): {{ $item->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>@lang('admin.member')</th>
                                        <th>@lang('admin.shift')</th>
                                        <th>@lang('admin.opt-out') @lang('admin.date')</th>

                                        <th>@lang('admin.reason')</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($item->rejections as $rejection)
                                        <tr>
                                            <td>{{ $rejection->user->name }}</td>
                                            <td>
                                                {{ \Illuminate\Support\Carbon::parse($rejection->shift->starts)->format('h:i A') }} @lang('admin.to') {{ \Illuminate\Support\Carbon::parse($rejection->shift->ends)->format('h:i A') }} ({{ $rejection->shift->name }})
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($rejection->created_at)->format('D d/m/Y') }}</td>
                                            <td>{{ $rejection->message }}</td>
                                            <td>
                                                <a target="_blank" href="{{ url('/member/shifts/' . $rejection->shift->id . '/edit') }}" title="@lang('site.edit') shift"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('site.edit') @lang('admin.shift')</button></a>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>



                                </table>
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('admin.close')</button>
                            </div>
                        </div>
                    </div>
                </div>


    @endforeach

@endsection

@section('header')
    <link href="{{ asset('vendor/pickadate/themes/default.date.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/pickadate/themes/default.css') }}" rel="stylesheet">

@endsection


