<div class="form-group">
    <label class="col-lg-1 control-label text-left">@lang('admin.to'):</label>
    <div class="col-lg-11 col-md-12 col-sm-12 col-xs-12">
        <div>


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
                            <option selected value="{{ $replyUser->id }}">{{ $replyUser->name }} ({{ $replyUser->telephone }}) </option>
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
                    <div style="margin-top: 10px" class="checkbox">
                        <label>
                            <input @if(old('all_members')==1) checked @endif type="checkbox" name="all_members" id="all_members" value="1"> @lang('admin.send-all')
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('message') ? 'has-error' : ''}}">
    <label for="message" class="control-label">@lang('admin.message')</label>
    <textarea maxlength="{{ $max }}" required class="form-control" rows="5" name="message" type="textarea" id="message" >{{ old('message',isset($sms->message) ? $sms->message : '') }}</textarea>
    {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
    <p>
        <span id="remaining">160 @lang('admin.characters-remaining').</span>
        <span id="messages">1 @lang('admin.message_s')</span>
    </p>
</div>

<div class="form-group {{ $errors->has('notes') ? 'has-error' : ''}}">
    <label for="notes" class="control-label">@lang('admin.comment') (@lang('admin.optional'))</label>
    <input class="form-control" name="notes" type="text" id="notes" value="{{ old('notes',isset($sms->notes) ? $sms->notes : '') }}" >
    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? __('site.update') : __('admin.send-message') }}">
</div>

