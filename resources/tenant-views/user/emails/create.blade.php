@extends('layouts.site')
@section('pageTitle',__('admin.messages'))

@section('innerTitle')
    @lang('site.create-new') @lang('admin.message')
@endsection

@section('breadcrumb')
    <span><a href="{{ url('/') }}">@lang('site.home')</a>
    </span>
    <span><a href="{{ url('/user/emails') }}">@lang('admin.messages')</a>
    </span>
    <span><span>@lang('site.create-new') @lang('admin.message')</span>
    </span>
@endsection

@section('content')
    <form id="sendForm" method="post" action="{{ url('/user/emails') }}" class="form-horizontal" enctype="multipart/form-data">
        @csrf
            <div class="card">
                <div class="card-header">
                    <h4>
                        @lang('admin.new-message')
                        </h4>
                </div>


                <div class="card-body">

                    <input type="hidden" name="msg_id" value="{{ $msgId }}"/>
                <div class="panel-heading hbuilt">
                    <div class="p-xs">

                            <div class="form-group">
                                <label >@lang('admin.to'): {{ $replyUser->name }}</label>
                                <div >
                                    <div>



                                        <!-- Tab panes -->
                                        <div class="tab-content tab-bordered" style="display: none">
                                            <div role="tabpanel" class="tab-pane fade show active" id="home"  >
                                                <div style="margin-top: 10px">

                                                        <select  name="members[]" id="members" class="form-control">
                                                            @if($replyUser)
                                                                <option selected value="{{ $replyUser->id }}">{{ $replyUser->name }} &lt;{{ $replyUser->email }}&gt; </option>
                                                            @endif
                                                        </select>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                 </div>
                            </div>

                            <div class="form-group">
                                <label >@lang('admin.subject'):</label>
                                <div >

                                    <input  value="{{ old('subject',$subject) }}" required type="text" name="subject" class="form-control input-sm" placeholder="@lang('admin.subject')">
                                </div>
                            </div>

                    </div>
                </div>
                <div class="panel-body no-padding">
<textarea name="message" required id="message" cols="30" class="form-control summernote6">{{ old('message') }}
@if($replyEmail)
    <br/> <br/>
@lang('admin.reply-content',['date'=>\Illuminate\Support\Carbon::parse($replyEmail->created_at)->format('d M Y'),'name'=>$replyEmail->user->name])
        <br/>
{!! clean($replyEmail->message) !!}
@endif
</textarea>

                </div>

                    <div class="form-group" style="padding-top: 20px; display: none">
                        <label class=" control-label text-left">@lang('admin.comment'):</label>
                        <div >
                            <input value="{{ old('notes') }}"  type="text" name="notes" class="form-control input-sm" placeholder="@lang('admin.optional')">
                        </div>
                    </div>

                <div class="panel-body no-padding mt-3">
                    <div id="dropzone" class="dropmail">

                        <div class="dropzone dropzone-custom needsclick" id="my-dropzone">
                            <div class="dz-message needsclick download-custom">
                                <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                <h1>@lang('admin.attachments')</h1>
                                <h2>@lang('admin.upload-info')</h2>

                            </div>
                        </div>


                    </div>
                </div>


                </div>
            <div class="card-footer">
                <button id="sendBtn" class="btn btn-primary btn-block btn-lg">@lang('admin.send-message')</button>

            </div>
            </div>

    </form>
@endsection

@section('footer')
    <script src="{{ asset('themes/admin/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('themes/admin/assets/modules/summernote/summernote-active.js') }}"></script>

    <script src="{{ asset('themes/main/js/multiple-email/multiple-email-active.js') }}"></script>
    <!-- dropzone JS
		============================================ -->
    <script src="{{ asset('themes/main/js/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script>

 /*       $('#sendForm').submit(function(e){

            console.log($('.member-select').val());

            if( !$('.member-select').val() && !$('#departments').val() && !$('#all_members').prop("checked") ){
                e.preventDefault();
                alert('@lang('admin.recipient-error')');
            }
        });*/


        Dropzone.autoDiscover = false;
        jQuery(document).ready(function() {

            $("div#my-dropzone").dropzone({
                url: "{{ route('user.emails.upload',['id'=>$msgId]) }}",
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
                        url: '{{ route('user.emails.remove-upload',['id'=>$msgId]) }}',
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

    </script>
@endsection


@section('header')
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/main/css/dropzone/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">

@endsection
