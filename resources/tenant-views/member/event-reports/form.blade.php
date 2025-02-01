

<input type="hidden" name="msg_id" value="{{ $msgId }}"/>
<div class="form-group {{ $errors->has('event_id') ? 'has-error' : ''}}">
    <label for="event_id">@lang('admin.event')</label>
      <select name="event_id" id="event_id" class="form-control select2">
        @foreach($events as $event)
            <option @if(old('event_id',isset($eventreport->event_id)?$eventreport->event_id:null)==$event->id) selected @endif value="{{ $event->id }}">{{ $event->name }}</option>
        @endforeach
    </select>

    {!! $errors->first('event_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    <label for="content">@lang('admin.content')</label>
    <textarea required class="form-control  summernote6_" rows="5" name="content" type="textarea" id="content" >{{ old('content',isset($eventreport->content) ? clean(($eventreport->content)) : '') }}</textarea>
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>

@if(isset($eventreport))
    <div>
        @if($eventreport->eventReportAttachments()->count()>0)
            <div class="ticket-divider"></div>
            <p class="m-b-md">
                <span>
                    <a data-toggle="tooltip" title="@lang('admin.download-all')" href="{{ route('member.event-reports.download-attachments',['eventReport'=>$eventreport->id]) }}">
                    <i class="fa fa-paperclip"></i> {{ $eventreport->eventReportAttachments()->count() }} @if($eventreport->eventReportAttachments()->count()>1) @lang('admin.attachments') @else @lang('admin.attachment') @endif
                    </a>
                </span>

            </p>
            <div class="row mb-2">

                @foreach($eventreport->eventReportAttachments as $attachment)
                    <div class="col-md-2">
                        <div class="gallery">
                            <div onclick="document.location.replace('{{ route('member.event-reports.download-attachment',['eventReportAttachment'=>$attachment->id]) }}')" class="gallery-item"  data-toggle="tooltip" title="{{ $attachment->file_name }}" data-original-title="{{ basename($attachment->file_path) }}"
                                 @if(isImage($attachment->file_path))
                                 data-image="{{ route('member.event-reports.view-image',['eventReportAttachment'=>$attachment->id]) }}"
                                 style="background-image: url('{{ route('member.event-reports.view-image',['eventReportAttachment'=>$attachment->id]) }}');"
                                 @else
                                 data-image="{{ asset('themes/admin/assets/img/file.png') }}"
                                 style="background-image: url('{{ asset('themes/admin/assets/img/file.png') }}');"
                                @endif
                            ></div>
                            <a data-toggle="tooltip" title="@lang('admin.delete')" onclick="return confirm('{{ __('admin.delete-prompt') }}')" class="text-danger" href="{{ route('member.event-reports.delete-attachment',['eventReportAttachment'=>$attachment->id]) }}"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>



        @endif
    </div>

@endif

<a class="btn btn-primary float-right" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    <i class="fa fa-paperclip"></i>   @lang('admin.attach-files')
</a>
<div class="collapse" id="collapseExample">
    <div class="well">
        <div class="panel-body no-padding">
            <div id="dropzone" class="dropmail">

                <div class="dropzone dropzone-custom needsclick" id="my-dropzone">
                    <div class="dz-message needsclick download-custom">
                        <i class="fa fa-cloud-download" aria-hidden="true"></i>
                        <h1>@lang('admin.files')</h1>
                        <h2>@lang('admin.upload-info')</h2>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <br>
</div>


<div class="form-group">
    <button class="btn btn-success" type="submit">
        <i class="fa fa-save"></i> @lang('admin.save')
    </button>
</div>
