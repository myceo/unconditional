<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">@lang('site.name')</label>
    <input required class="form-control" name="name" type="text" id="name" value="{{ old('name',isset($lesson->name) ? $lesson->name : '') }}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">@lang('site.description')</label>
    <textarea class="form-control rte" rows="5" name="description" type="textarea" id="description" >{!!  old('description',isset($lesson->description) ? $lesson->description : '') !!}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('picture') ? 'has-error' : ''}}">
            <label for="picture" class="control-label">@lang('site.cover-image')</label>
            <input class="form-control" name="picture" type="file" id="picture" value="{{ old('picture',isset($lesson->picture) ? $lesson->picture : '') }}" >
            {!! $errors->first('picture', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    @if(isset($lesson) && !empty($lesson->picture))
    <div class="col-md-6">
        <div><img class="img-fluid" src="{{ asset(!empty($lesson->picture)?$lesson->picture:'img/no_image.jpg') }}" alt="Image placeholder">
        </div>
        <br>
        <a href="{{ route('admin.lessons.remove-image',['lesson'=>$lesson->id]) }}" class="btn btn-danger"><i class="fa fa-trash"></i> @lang('site.remove-picture')</a>

    </div>
     @endif
</div>

@if(false)
<div class="form-group {{ $errors->has('enforce_lecture_order') ? 'has-error' : ''}}">
    <label for="enforce_lecture_order" class="control-label">@lang('site.enforce-lecture-order')</label>
    <select name="enforce_lecture_order" class="form-control" id="enforce_lecture_order" >
    @foreach (['1'=>__('site.yes'),'0'=>__('site.no')] as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ ((null !== old('enforce_lecture_order',@$lesson->enforce_lecture_order)) && old('enforce_lecture_order',@$lesson->enforce_lecture_order) == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('enforce_lecture_order', '<p class="help-block">:message</p>') !!}
</div>
@endif



<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? __('site.update') : __('site.create') }}">
</div>
