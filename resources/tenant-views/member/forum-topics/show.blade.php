@extends('layouts.member')
@section('pageTitle',$forumtopic->topic)

@section('innerTitle')
     {{ $forumtopic->topic }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/member/forum-topics') }}">@lang('admin.forum-topics')</a>
    </li>
    <li><span>@lang('admin.topic')</span>
    </li>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <figure class="avatar mr-2 ">
                <img src="{{ profilePicture($forumtopic->user_id) }}" >
            </figure>
            <h4>@lang('admin.by') {{ $forumtopic->user->name }} @lang('admin.on') {{ \Carbon\Carbon::parse($forumtopic->created_at)->format('D d/M/Y') }}
                @if(empty($forumtopic->enabled))
                    <div class="bullet"></div> <span class="text-danger">@lang('admin.closed')</span>
                @endif
            </h4>
            @if($forumtopic->enabled==1)
            <div class="card-header-form">
                <form>
                    <div class="input-group">
                        <a class="btn btn-primary btn-round float-right" href="#replybox"><i class="fa fa-reply"></i> @lang('admin.reply')</a>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>

    @foreach($threads as $thread)
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
                                <h4>{{ $thread->user->name }}</h4>
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

                        @if($thread->forumAttachments()->count()>0)
                            <div class="ticket-divider"></div>
                            <p class="m-b-md">
                                <span><i class="fa fa-paperclip"></i> {{ $thread->forumAttachments()->count() }} @if($thread->forumAttachments()->count()>1) @lang('admin.attachments') @else @lang('admin.attachment') @endif</span>

                            </p>
                        <div class="gallery">

                            @foreach($thread->forumAttachments as $attachment)
                                <div onclick="document.location.replace('{{ route('member.forum.download-attachment',['forumAttachment'=>$attachment->id]) }}')" class="gallery-item"  data-toggle="tooltip" title="{{ $attachment->file_name }}" data-original-title="{{ basename($attachment->file_path) }}"
                                     @if(isImage($attachment->file_path))
                                     data-image="{{ route('member.forum.view-image',['forumAttachment'=>$attachment->id]) }}"
                                     style="background-image: url('{{ route('member.forum.view-image',['forumAttachment'=>$attachment->id]) }}');"
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

    @if ($threads->hasPages())
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    {{ $threads->links() }}
                </div>
              </div>

        </div>
    </div>
    @endif
    @if($forumtopic->enabled==1)
    <div class="card" id="replybox">
        <div class="card-header">
            <h4>@lang('admin.reply')</h4>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ url('/member/forum-topics/' . $forumtopic->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <input type="hidden" name="msg_id" value="{{ $msgId }}"/>
                @include ('member.forum-topics.form', ['formMode' => 'edit'])

            </form>

        </div>
    </div>

    <a class="arrow-top btn btn-success" href="#"><i class="fa fa-reply"></i> @lang('admin.reply')</a>
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
