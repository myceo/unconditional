@extends('layouts.admin')
@section('pageTitle',__('admin.messages'))

@section('innerTitle')
    @lang('site.create-new') @lang('admin.message')
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/admin/emails') }}">@lang('admin.messages')</a>
    </li>
    <li><span>@lang('site.create-new') @lang('admin.message')</span>
    </li>
@endsection

@section('content')


    <form id="sendForm" method="post" action="{{ url('/admin/emails') }}" class="form-horizontal" enctype="multipart/form-data">
        @csrf
    <div class="card">
        <div class="card-header">
            @lang('admin.new-message')
        </div>
        <div class="card-body">

                <input type="hidden" name="msg_id" value="{{ $msgId }}"/>
                <div class="panel-heading hbuilt">
                    <div class="p-xs">

                        <div class="form-group">
                                    <label class="col-lg-1 control-label text-left">@lang('admin.to'):</label>
                                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab" aria-controls="home" aria-selected="true">@lang('admin.members')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">@lang('admin.departments')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">@lang('admin.all-members')</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content tab-bordered" id="myTab3Content">
                                        <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">

                                                <select multiple name="members[]" id="members" class="form-control">
                                                    @if($replyUser)
                                                        <option selected value="{{ $replyUser->id }}">{{ $replyUser->name }} &lt;{{ $replyUser->email }}&gt; </option>
                                                    @endif
                                                </select>

                                        </div>
                                        <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                                            <select multiple name="departments[]" id="departments" class="form-control select2">
                                                <option></option>
                                                @foreach($departments as $department)
                                                    <option @if(is_array(old('departments')) && in_array(@$department->id,old('departments'))) selected @endif value="{{ $department->id }}">{{ $department->name }} ({{ $department->users()->count() }})</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">
                                            <label>
                                                <input @if(old('all_members')==1) checked @endif type="checkbox" name="all_members" id="all_members" value="1"> @lang('admin.send-all')
                                            </label>

                                        </div>
                                    </div>
                        </div>

                        <div class="form-group">
                            <label >@lang('admin.subject'):</label>

                                <input  value="{{ old('subject',$subject) }}" required type="text" name="subject" class="form-control input-sm" placeholder="@lang('admin.subject')">

                        </div>

                    </div>
                </div>
                <div class="panel-body no-padding">
<textarea name="message" required id="message" cols="30" class="form-control summernote6">{{ old('message') }}
    @if($replyEmail)
        <br/> <br/>
        @lang('admin.reply-content',['date'=>\Illuminate\Support\Carbon::parse($replyEmail->created_at)->format('d M Y'),'name'=>$replyEmail->user->name])
        <br/>
        {!! $replyEmail->message !!}
    @endif
</textarea>

                </div>

                <div class="form-group" >
                    <label>@lang('admin.comment'):</label>
                  <input value="{{ old('notes') }}"  type="text" name="notes" class="form-control input-sm" placeholder="@lang('admin.optional')">

                </div>

                <div class="panel-body no-padding">
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
                <div class="panel-footer">
                    @if(false)
                        <div class="float-right">
                            <div class="btn-group active-hook">
                                <button  class="btn btn-default"><i class="fa fa-edit"></i> Save</button>
                                <button class="btn btn-default"><i class="fa fa-trash"></i> Discard</button>
                            </div>
                        </div>
                    @endif


                </div>


        </div>

        <div class="card-footer">
            <button id="sendBtn" class="btn btn-primary btn-lg btn-block ft-compse">@lang('admin.send-message')</button>
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


        $('#sendForm').submit(function(e){

            console.log($('#members').val());

            if( !$('#members').val() && !$('#departments').val() && !$('#all_members').prop("checked") ){
                e.preventDefault();
                alert('@lang('admin.recipient-error')');
            }
        });


        $(function(){
            $('#departments').select2();

            $('#members').select2({
                placeholder: "@lang('admin.search-members')...",
                minimumInputLength: 3,
                ajax: {
                    url: '{{ route('members.search') }}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            term: $.trim(params.term)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }

            });
        });



        Dropzone.autoDiscover = false;
        jQuery(document).ready(function() {

            $("div#my-dropzone").dropzone({
                url: "{{ route('emails.upload',['id'=>$msgId]) }}",
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
                        url: '{{ route('emails.remove-upload',['id'=>$msgId]) }}',
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
