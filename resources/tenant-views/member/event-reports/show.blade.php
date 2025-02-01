@extends('layouts.member')

@section('pageTitle',__('admin.event-report').' : '.$eventreport->event->name)
@section('innerTitle',__('admin.event-report').' : '.$eventreport->event->name)

@php
    $backRoute = request()->has('event')?route('member.events.reports',['event'=>request()->get('event')]): url('member/event-reports');
@endphp

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>

    <li><a href="{{ $backRoute }}">@lang('admin.event-reports')</a></li>


    <li><span>{{ __('site.view').' '.__('admin.report') }}</span>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div>
                    <div>

                        <a href="{{ $backRoute }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('admin.back')</button></a>

                        @if(!request()->has('event'))
                        <a href="{{ url('/member/event-reports/' . $eventreport->id . '/edit') }}" title="Edit eventReport"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> @lang('admin.edit')</button></a>

                        <form method="POST" action="{{ url('member/eventreports' . '/' . $eventreport->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="@lang('admin.delete') eventReport" onclick="return confirm(&quot;@lang('admin.confirm-delete')?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('admin.delete')</button>
                        </form>

                        @endif
                        <br/>
                        <br/>

                        <div class="card" id="thread{{ $eventreport->id }}">
                            <div class="card-body">
                                <div class="tickets">
                                    <div class="ticket-content">
                                        <div class="ticket-header">
                                            <div class="ticket-sender-picture img-shadow">
                                                <img src="{{ profilePicture($eventreport->user_id) }}" >
                                            </div>
                                            <div class="ticket-detail">
                                                <div class="ticket-title">
                                                  <h4>{{ $eventreport->user->name }}</h4>
                                                </div>
                                                <div class="ticket-info">
                                                    <div class="font-weight-600">{{ \Carbon\Carbon::parse($eventreport->created_at)->format('D d/M/Y') }}</div>
                                                    <div class="bullet"></div>
                                                    <div class="text-primary font-weight-600">{{ \Carbon\Carbon::parse($eventreport->created_at)->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ticket-description thread-text">
                                            <p class="thread-text"> {!! clean(($eventreport->content)) !!}</p>

                                            @if($eventreport->eventReportAttachments()->count()>0)
                                                <div class="ticket-divider"></div>
                                                <p class="m-b-md">
                                    <span>
                                        <a  data-toggle="tooltip" title="@lang('admin.download-all')"  href="{{ route('member.event-reports.download-attachments',['eventReport'=>$eventreport->id]) }}">
                                        <i class="fa fa-paperclip"></i> {{ $eventreport->eventReportAttachments()->count() }} @if($eventreport->eventReportAttachments()->count()>1) @lang('admin.attachments') @else @lang('admin.attachment') @endif
                                        </a>
                                    </span>

                                                </p>
                                                <div class="gallery">

                                                    @foreach($eventreport->eventReportAttachments as $attachment)
                                                        <div onclick="document.location.replace('{{ route('member.event-reports.download-attachment',['eventReportAttachment'=>$attachment->id]) }}')" class="gallery-item"  data-toggle="tooltip" title="{{ $attachment->file_name }}" data-original-title="{{ basename($attachment->file_path) }}"
                                                             @if(isImage($attachment->file_path))
                                                             data-image="{{ route('member.event-reports.view-image',['eventReportAttachment'=>$attachment->id]) }}"
                                                             style="background-image: url('{{ route('member.event-reports.view-image',['eventReportAttachment'=>$attachment->id]) }}');"
                                                             @else
                                                             data-image="{{ asset('themes/admin/assets/img/file.png') }}"
                                                             style="background-image: url('{{ asset('themes/admin/assets/img/file.png') }}');"
                                                            @endif
                                                        ></div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
