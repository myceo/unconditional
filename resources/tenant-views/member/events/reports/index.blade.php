@extends('layouts.member')

@section('pageTitle',__('admin.event-reports'))
@section('innerTitle',__('admin.event-reports'))

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/member/events') }}">@lang('admin.events')</a>
    </li>
    <li><span>@lang('admin.reports')</span>
    </li>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
<h4>{{ $event->name.(!empty(request()->get('search'))?' : '.request()->get('search'):'' ) }}</h4>
            <div class="card-header-form">
                <form method="GET" action="{{ route('member.events.reports',['event'=>$event->id]) }}">
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
            <table class="table">
                <thead>
                <tr>
                    <th></th><th>@lang('admin.member')</th><th>@lang('admin.added-on')</th><th>@lang('admin.actions')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($eventreports as $item)
                    <tr>
                        <td>
                            <figure class="avatar mr-2">
                                <a href="{{ url('admin/members/'.$item->user_id) }}"><img  src="{{ profilePicture($item->user_id) }}" ></a>
                            </figure>
                        </td>
                        <td>{{ $item->user->name }} @if($item->eventReportAttachments()->count()>0) <i class="fa fa-paperclip"></i> @endif</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ url('/member/event-reports/' . $item->id) }}?event={{ $event->id }}" title="@lang('admin.view')"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('admin.view')</button></a>
                            <a href="{{ url('/member/event-reports/' . $item->id . '/edit') }}?event={{ $event->id }}" title="@lang('admin.edit')"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('admin.edit')</button></a>

                            <form method="POST" action="{{ url('/member/event-reports' . '/' . $item->id) }}?event={{ $event->id }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="@lang('admin.delete')" onclick="return confirm(&quot;@lang('site.confirm-delete')&quot;)"><i class="fa fa-trash" aria-hidden="true"></i> @lang('admin.delete')</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination-wrapper"> {!! $eventreports->appends(['search' => request()->get('search')])->render() !!} </div>
        </div>
    </div>
    </div>

@endsection
