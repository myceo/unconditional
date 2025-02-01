<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">@lang('admin.event') @lang('admin.name')</label>
    <input placeholder="" class="form-control" name="name" type="text" id="name" value="{{ old('event',isset($event->name) ? $event->name : '') }}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('event_date') ? 'has-error' : ''}}">
    <label for="event_date" class="control-label">@lang('admin.event') @lang('admin.date')</label>
    <input   class="form-control date" name="event_date" type="text" id="event_date" value="{{ old('event_date',isset($event->event_date) ? \Illuminate\Support\Carbon::parse($event->event_date)->format('Y-m-d') : '') }}" >
    {!! $errors->first('event_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('venue') ? 'has-error' : ''}}">
    <label for="venue" class="control-label">@lang('admin.venue') (@lang('admin.optional'))</label>
    <textarea class="form-control" rows="5" name="venue" type="textarea" id="venue" >{{ old('venue',isset($event->venue) ? $event->venue : '') }}</textarea>
    {!! $errors->first('venue', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">@lang('admin.description') (@lang('admin.optional'))</label>
    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ old('description',isset($event->description) ? $event->description : '') }}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div  class="checkbox">
    <label>
        <input type="hidden" name="notifications" value="0">
        <input @if(old('notifications',isset($event->notifications) ? $event->notifications : ''))==1) checked @endif type="checkbox" name="notifications" id="notifications" value="1"> @lang('admin.enable-notifications') <i  data-toggle="tooltip" data-placement="top" title="@lang('admin.enable-notifications-hint')" class="fa fa-question-circle"></i>
    </label>
</div>

<div  class="checkbox">
    <label>
        <input type="hidden" name="accept_volunteers" value="0">
        <input @if(old('accept_volunteers',isset($event->accept_volunteers) ? $event->accept_volunteers : ''))==1) checked @endif type="checkbox" name="accept_volunteers" id="accept_volunteers" value="1"> @lang('admin.accept-volunteers') <i  data-toggle="tooltip" data-placement="top" title="@lang('admin.accept-volunteers-hint')" class="fa fa-question-circle"></i>
    </label>
</div>


<div  class="checkbox">
    <label>
        <input type="hidden" name="enable_comments" value="0">
        <input @if(old('enable_comments',isset($event->enable_comments) ? $event->enable_comments : ''))==1) checked @endif type="checkbox" name="enable_comments" id="enable_comments" value="1"> @lang('admin.enable-comments') <i  data-toggle="tooltip" data-placement="top" title="@lang('admin.enable-comments-hint')" class="fa fa-question-circle"></i>
    </label>
</div>

<div  class="checkbox">
    <label>
        <input type="hidden" name="enable_reports" value="0">
        <input @if(old('enable_reports',isset($event->enable_reports) ? $event->enable_reports : ''))==1) checked @endif type="checkbox" name="enable_reports" id="enable_reports" value="1"> @lang('admin.enable-reports') <i  data-toggle="tooltip" data-placement="top" title="@lang('admin.enable-reports-hint')" class="fa fa-question-circle"></i>
    </label>
</div>


<div class="form-group mt-2">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? __('site.update') : __('site.create') }}">
</div>
