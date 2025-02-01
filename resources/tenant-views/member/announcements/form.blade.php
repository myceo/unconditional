<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ __('admin.title') }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ old('announcement',isset($announcement->title) ? $announcement->title : '') }}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    <label for="content" class="control-label">{{ __('admin.content') }}</label>
    <textarea class="form-control summernote6" rows="5" name="content" type="textarea" id="content" >{{ old('announcement',isset($announcement->content) ? clean(($announcement->content)) : '') }}</textarea>
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>

<div   class="checkbox">
    <label for="send">
        <input type="checkbox" name="send" id="send" value="1"/> @lang('admin.send-all-members')
    </label>
</div>

<div  class="checkbox">
    <label for="enable_comments">
        <input type="hidden" name="enable_comments" value="0">
        <input @if(old('enable_comments',isset($announcement->enable_comments) ? $announcement->enable_comments : ''))==1) checked @endif type="checkbox" name="enable_comments" id="enable_comments" value="1"> @lang('admin.enable-comments') <i  data-toggle="tooltip" data-placement="top" title="@lang('admin.enable-comments-hint')" class="fa fa-question-circle"></i>
    </label>
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? __('site.update') : __('site.create') }}">

</div>

