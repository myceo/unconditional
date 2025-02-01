<div class="form-group">
    <label  >To:</label>
    <div  >
        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active"  href="#home" aria-controls="home" role="tab" data-toggle="tab">@lang('admin.members')</a></li>
                <li class="nav-item"><a  class="nav-link" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">@lang('admin.teams')</a></li>
                <li class="nav-item"><a class="nav-link"  href="#all" aria-controls="profile" role="tab" data-toggle="tab">@lang('admin.all-members')</a></li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content tab-bordered">
                <div role="tabpanel" class="tab-pane fade show active " id="home"  >
                    <div style="margin-top: 10px">
                        @can('dept_allows','show_members')
                        <select multiple name="members[]" id="members2" class="form-control member-select">
                            @foreach(getDepartment()->users()->orderBy('name')->get() as $user)
                                <option @if( (is_array(old('members')) && in_array(@$user->id,old('members'))) || ($replyUser && $replyUser->id==$user->id) ) selected @endif   value="{{ $user->id }}">{{ $user->name }} ({{ $user->telephone }}) </option>
                            @endforeach
                        </select>
                        @else
                            <select multiple name="members[]" id="members" class="form-control member-select">
                                @if($replyUser)
                                    <option selected value="{{ $replyUser->id }}">{{ $replyUser->name }} ({{ $replyUser->telephone }}) </option>
                                @endif
                            </select>
                            @endcan
                    </div>
                </div>

                @can('administer')
                <div role="tabpanel" class="tab-pane fade" id="profile">
                    <div style="margin-top: 10px">
                        <select multiple name="teams[]" id="teams" class="form-control select2">
                            <option></option>
                            @foreach($teams as $team)
                                <option @if(is_array(old('teams')) && in_array(@$team->id,old('teams'))) selected @endif value="{{ $team->id }}">{{ $team->name }} ({{ $team->users()->count() }})</option>
                            @endforeach
                        </select>


                    </div>


                </div>
                <div role="tabpanel" class="tab-pane fade" id="all">

                    <div style="margin-top: 10px" class="checkbox">
                        <label>
                            <input @if(old('all_members')==1) checked @endif type="checkbox" name="all_members" id="all_members" value="1"> @lang('admin.send-all-members')
                        </label>
                    </div>
                </div>
                @endcan
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

