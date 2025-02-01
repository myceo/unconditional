
<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    <textarea required class="form-control  summernote6_" rows="5" name="content" type="textarea" id="content" >{{ old('content',isset($forumtopic->content) ? clean(($forumtopic->content)) : '') }}</textarea>
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>

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
