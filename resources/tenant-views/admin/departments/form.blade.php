<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">@lang('admin.name')</label>
    <input required class="form-control" name="name" type="text" id="name" value="{{ isset($department->name) ? $department->name : ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">@lang('admin.description')</label>
    <textarea class="form-control summernote6"    rows="5" name="description" type="textarea" id="description" >{{ isset($department->description) ? clean($department->description) : ''}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('enroll_open') ? 'has-error' : ''}}">
    <label for="enroll_open" class="control-label">@lang('admin.enroll-open')</label>
    <select name="enroll_open" class="form-control" id="enroll_open" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->enroll_open) && $department->enroll_open == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('enroll_open', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('enable_sms') ? 'has-error' : ''}}">
    <label for="enable_sms" class="control-label">@lang('admin.enable-sms')</label>
    <select name="enable_sms" class="form-control" id="enable_sms" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->enable_sms) && $department->enable_sms == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('enable_sms', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('approval_required') ? 'has-error' : ''}}">
    <label for="approval_required" class="control-label">@lang('admin.approval-required')</label>
    <select name="approval_required" class="form-control" id="approval_required" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->approval_required) && $department->approval_required == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('approval_required', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('show_members') ? 'has-error' : ''}}">
    <label for="show_members" class="control-label">@lang('admin.show-members')</label>
    <select name="show_members" class="form-control" id="show_members" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->show_members) && $department->show_members == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('show_members', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('allow_members_communicate') ? 'has-error' : ''}}">
    <label for="allow_members_communicate" class="control-label">@lang('admin.allow-communicate')</label>
    <select name="allow_members_communicate" class="form-control" id="allow_members_communicate" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->allow_members_communicate) && $department->allow_members_communicate == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('allow_members_communicate', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('enable_forum') ? 'has-error' : ''}}">
    <label for="enable_forum" class="control-label">@lang('admin.enable-forum')</label>
    <select name="enable_forum" class="form-control" id="enable_forum" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->enable_forum) && $department->enable_forum == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('enable_forum', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('allow_members_create_topics') ? 'has-error' : ''}}">
    <label for="allow_members_create_topics" class="control-label">@lang('admin.allow-create-topics')</label>
    <select name="allow_members_create_topics" class="form-control" id="allow_members_create_topics" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->allow_members_create_topics) && $department->allow_members_create_topics == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('allow_members_create_topics', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('enable_roster') ? 'has-error' : ''}}">
    <label for="enable_roster" class="control-label">@lang('admin.enable-roster')</label>
    <select name="enable_roster" class="form-control" id="enable_roster" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->enable_roster) && $department->enable_roster == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('enable_roster', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('enable_announcements') ? 'has-error' : ''}}">
    <label for="enable_announcements" class="control-label">@lang('admin.enable-announcements')</label>
    <select name="enable_announcements" class="form-control" id="enable_announcements" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->enable_announcements) && $department->enable_announcements == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('enable_announcements', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('enable_resources') ? 'has-error' : ''}}">
    <label for="enable_resources" class="control-label">@lang('admin.enable-resources')</label>
    <select name="enable_resources" class="form-control" id="enable_resources" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->enable_resources) && $department->enable_resources == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('enable_resources', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('allow_members_upload') ? 'has-error' : ''}}">
    <label for="allow_members_upload" class="control-label">@lang('admin.allow-members-upload')</label>
    <select name="allow_members_upload" class="form-control" id="allow_members_upload" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->allow_members_upload) && $department->allow_members_upload == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('allow_members_upload', '<p class="help-block">:message</p>') !!}
</div>




<div class="form-group {{ $errors->has('visible') ? 'has-error' : ''}}">
    <label for="visible" class="control-label">@lang('admin.visibility')</label>
    <select name="visible" class="form-control" id="visible" >
        @foreach (json_decode('{"1":"'.__('admin.public').'","0":"'.__('admin.private').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->visible) && $department->visible == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('visible', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('enabled') ? 'has-error' : ''}}">
    <label for="enabled" class="control-label">@lang('admin.enabled')</label>
    <select name="enabled" class="form-control" id="enabled" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->enabled) && $department->enabled == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('enabled', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group {{ $errors->has('anniversary_notifications') ? 'has-error' : ''}}">
    <label for="anniversary_notifications" class="control-label">@lang('admin.enable-birthday-notifications')</label>
    <select name="anniversary_notifications" class="form-control" id="anniversary_notifications" >
        @foreach (json_decode('{"1":"'.__('admin.yes').'","0":"'.__('admin.no').'"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($department->anniversary_notifications) && $department->anniversary_notifications == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('anniversary_notifications', '<p class="help-block">:message</p>') !!}
</div>
