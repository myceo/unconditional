@extends('layouts.member')
@section('pageTitle',$event->name)

@section('innerTitle')
    {{ __('admin.event-comments')}}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/member/events/roster') }}">@lang('admin.roster')</a>
    </li>
    <li><span>@lang('admin.comments')</span>
    </li>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">

            <h4>{{ $event->name }} : {{ \Carbon\Carbon::parse($event->event_date)->format('D d/M/Y') }}
                @if(empty($event->enable_comments))
                    <div class="bullet"></div> <span class="text-danger">@lang('admin.closed')</span>
                @endif
            </h4>
            @if($event->enable_comments==1)
                <div class="card-header-form">
                    <form>
                        <div class="input-group">
                            <a class="btn btn-primary btn-round float-right" href="#replybox"><i class="fa fa-edit"></i> @lang('admin.add-comment')</a>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    @foreach($eventComments as $thread)
        <div class="card" id="thread{{ $thread->id }}">
            <div class="card-body">
                <div class="tickets">
                    <div class="ticket-content">
                        <div class="ticket-header">
                            <div class="ticket-sender-picture img-shadow">
                                <img src="{{ profilePicture($thread->user_id) }}" >
                            </div>
                            <div class="ticket-detail">
                                <div class="ticket-title">
                                    <a href="{{ url('admin/members/'.$thread->user_id) }}"><h4>{{ $thread->user->name }}</h4></a>
                                </div>
                                <div class="ticket-info">
                                    <div class="font-weight-600">{{ \Carbon\Carbon::parse($thread->created_at)->format('D d/M/Y') }}</div>
                                    <div class="bullet"></div>
                                    <div class="text-primary font-weight-600">{{ \Carbon\Carbon::parse($thread->created_at)->diffForHumans() }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="ticket-description thread-text">
                            <p class="thread-text"> {!! clean(($thread->content)) !!}</p>

                            @if($thread->eventCommentAttachments()->count()>0)
                                <div class="ticket-divider"></div>
                                <p class="m-b-md">
                                    <span>
                                        <a  data-toggle="tooltip" title="@lang('admin.download-all')"  href="{{ route('member.event-comments.download-attachments',['eventComment'=>$thread->id]) }}">
                                        <i class="fa fa-paperclip"></i> {{ $thread->eventCommentAttachments()->count() }} @if($thread->eventCommentAttachments()->count()>1) @lang('admin.attachments') @else @lang('admin.attachment') @endif
                                        </a>
                                    </span>

                                </p>
                                <div class="gallery">

                                    @foreach($thread->eventCommentAttachments as $attachment)
                                        <div onclick="document.location.replace('{{ route('member.event-comments.download-attachment',['eventCommentAttachment'=>$attachment->id]) }}')" class="gallery-item"  data-toggle="tooltip" title="{{ $attachment->file_name }}" data-original-title="{{ basename($attachment->file_path) }}"
                                             @if(isImage($attachment->file_path))
                                             data-image="{{ route('member.event-comments.view-image',['eventCommentAttachment'=>$attachment->id]) }}"
                                             style="background-image: url('{{ route('member.event-comments.view-image',['eventCommentAttachment'=>$attachment->id]) }}');"
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
    @endforeach

    @if ($eventComments->hasPages())
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        {{ $eventComments->links() }}
                    </div>
                </div>

            </div>
        </div>
    @endif
    @if($event->enable_comments==1)
        <div class="card" id="replybox">
            <div class="card-header">
                <h4>@lang('admin.add-comment')</h4>
            </div>
            <div class="card-body">

                <form method="POST" action="{{ route('member.event-comments.store',['event'=>$event->id]) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="msg_id" value="{{ $msgId }}"/>
                    @include ('member.event-comments.form', ['formMode' => 'edit'])

                </form>

            </div>
        </div>

        <a class="arrow-top btn btn-success" href="#"><i class="fa fa-save"></i> @lang('admin.submit')</a>
    @endif

@endsection


@section('footer')
    <script src="{{ asset('themes/admin/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('themes/admin/assets/modules/summernote/summernote-active.js') }}"></script>

    <script src="{{ asset('themes/main/js/multiple-email/multiple-email-active.js') }}"></script>
    <!-- dropzone JS
		============================================ -->
    <script src="{{ asset('themes/main/js/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote-emoji-master/tam-emoji/js/config.js') }}"></script>
    <script src="{{ asset('vendor/summernote-emoji-master/tam-emoji/js/tam-emoji.min.js?v=1.1') }}"></script>
    <script>
        $(document).ready(function () {
//      document.emojiType = 'unicode'; // default: image
            document.emojiSource = '{{ asset('vendor/summernote-emoji-master/tam-emoji/img') }}';
            document.emojiButton = 'fas fa-smile';
            $("#content").summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                    ['insert', ['emoji']]
                ]
            });
        });
    </script>
    <script>

        Dropzone.autoDiscover = false;
        jQuery(document).ready(function() {

            $("div#my-dropzone").dropzone({
                url: "{{ route('member.emails.upload',['id'=>$msgId]) }}",
                acceptedFiles: "{{ '.'.str_replace(',',',.',config('app.upload_files')).',' }}.jpeg,.jpg,.png,.gif,.pdf,.doc,.docx,.ppt,.pptx,.zip,.mp3,.mp4",
                maxFilesize: 10, // MB
                success: function (file, response) {
                    console.log("Sucesso");
                    console.log(response);
                },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                addRemoveLinks: true,
                removedfile: function(file) {
                    var name = file.name;
                    console.log(name);

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('member.emails.remove-upload',['id'=>$msgId]) }}',
                        data: {name: name,request: 2},
                        sucess: function(data){
                            console.log('success: ' + data);
                        }
                    });
                    var _ref;
                    return (_ref = file.previewElement) != null? _ref.parentNode.removeChild(file.previewElement) : void 0;
                },
                dictRemoveFile: '@lang('admin.remove-file')',
                dictCancelUpload: '@lang('admin.cancel-upload')',
                dictCancelUploadConfirmation: '@lang('admin.cancel-confirm')'
            });

        });
        var showReply = true;
        $(document).scroll(function() {
            var y = $(this).scrollTop();

            console.log(y);
            if (y > 100 && showReply) {
                $('.arrow-top').fadeIn();
            } else {
                $('.arrow-top').fadeOut();
            }

        });

        window.addEventListener('scroll', function() {
            var element = document.querySelector('#replybox');
            var position = element.getBoundingClientRect();

            // checking for partial visibility
            if(position.top < window.innerHeight && position.bottom >= 0) {
                showReply =false;
            }
            else{
                showReply =true;
            }
        });

        $(".arrow-top").click(function() {
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#replybox").offset().top
            }, 500);
        });

        $(function () {
            $(document).trigger('scroll');
        })
    </script>
@endsection


@section('header')
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/main/css/dropzone/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link href="{{ asset('vendor/summernote-emoji-master/tam-emoji/css/emoji.css') }}" rel="stylesheet">
    <style>
        .tickets .ticket-content {
            width: 100%;
        }

    </style>
@endsection
