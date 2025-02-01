@extends('layouts.site')
@section('pageTitle',__('admin.inbox'))

@section('innerTitle')
    @lang('admin.view') @lang('admin.message')
@endsection

@section('breadcrumb')
    <li><a href="{{ url('/') }}">@lang('site.home')</a>
    </li>
    <li><a href="{{ route('user.emails.inbox') }}">@lang('admin.inbox')</a>
    </li>
    <li>@lang('admin.view') @lang('admin.message')</li>

@endsection

@section('content')




    <div class="card" id="mailContent">
        <div class="card-header">
            <h4>{{ $email->subject }}</h4>
        </div>
        <div class="card-body">

            <div class="tickets">
                <div class="ticket-content">
                    <div class="ticket-header">
                        <div class="ticket-sender-picture img-shadow">
                            <a href="{{ url('/admin/members/' . $email->user_id) }}"><img src="{{ profilePicture($email->user_id) }}" alt="{{ $email->user->name }}"></a>
                        </div>
                        <div class="ticket-detail">
                            <div class="ticket-title">
                                <h4>{{ $email->user->name }}</h4>
                            </div>
                            <div class="ticket-info">
                                <div class="font-weight-600">{{ $email->user->email }}</div>
                                <div class="bullet"></div>
                                <div class="text-primary font-weight-600">{{ \Illuminate\Support\Carbon::parse($email->created_at)->diffForHumans() }} ({{ \Illuminate\Support\Carbon::parse($email->created_at)->format('d.M.Y') }})</div>
                            </div>
                        </div>
                    </div>
                    <div class="ticket-description">

                        <p>{!! clean($email->message) !!}</p>
                        @if(!empty($email->notes))
                            <div class="ticket-divider"></div>
                            <div>
                                <strong>@lang('admin.comment'):</strong>  {{ $email->notes }}
                            </div>

                        @endif
                        @if($email->emailAttachments()->count()>0)
                            <div class="ticket-divider"></div>
                            <p class="m-b-md">
                                <span><i class="fa fa-paperclip"></i> {{ $email->emailAttachments()->count() }} @if($email->emailAttachments()->count()>1) @lang('admin.attachments') @else @lang('admin.attachment') @endif - </span>
                                <a href="{{ route('user.email.download-attachments',['email'=>$email->id]) }}" class="btn btn-default btn-xs">@lang('admin.download-all') <i class="fas fa-file-archive"></i> </a>
                            </p>
                            <div class="gallery">
                                @foreach($email->emailAttachments as $attachment)
                                    <div onclick="document.location.replace('{{ route('user.email.download-attachment',['emailAttachment'=>$attachment->id]) }}')" class="gallery-item"  data-toggle="tooltip" title="{{ $attachment->file_name }}" data-original-title="{{ $attachment->file_name }}"
                                         @if(isImage($attachment->file_path))
                                         data-image="{{ route('user.email.view-image',['emailAttachment'=>$attachment->id]) }}"
                                         style="background-image: url('{{ route('email.view-image',['emailAttachment'=>$attachment->id]) }}');"
                                         @else
                                         data-image="{{ asset('themes/admin/assets/img/file.png') }}"
                                         style="background-image: url('{{ asset('themes/admin/assets/img/file.png') }}');"
                                        @endif
                                    ></div>
                                @endforeach
                            </div>
                        @endif

                        <div class="ticket-divider"></div>

                        <div class="ticket-form">

                            <div class="form-group text-right">

                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <a href="{{ url('user/emails/create') }}?reply={{ $email->id }}" class="btn btn-primary"><i class="fa fa-reply"></i> @lang('admin.reply')</a>
                                    <button onclick="printPageArea('mailContent')" class="btn btn-success"><i class="fa fa-print"></i> @lang('admin.print')</button>

                                    <a onclick="return confirm('@lang('admin.delete-prompt')')"  class="btn btn-danger" href="{{ route('user.email.delete-inbox',['id'=>$email->id]) }}"><i class="fa fa-trash"></i> @lang('admin.delete')</a>




                                </div>



                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('footer')
    <script>
        "use strict";

        function printPageArea(areaID){
            var printContent = document.getElementById(areaID);
            var WinPrint = window.open('', '', 'width=900,height=650');
            WinPrint.document.write(printContent.innerHTML);
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            WinPrint.close();
        }


    </script>
@endsection

