@extends('layouts.member')
@section('pageTitle',__('admin.department-settings'))

@section('innerTitle')
    @lang('admin.department-settings')
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.department-settings')</span>
    </li>
@endsection

@section('content')

    <form method="POST" action="{{ route('member.settings.save-settings') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">

        {{ csrf_field() }}


        <ul class="nav nav-pills" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab" aria-controls="home" aria-selected="true">@lang('admin.details')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">@lang('admin.cover-photo')</a>
        </li>

    </ul>
    <div class="tab-content pt-3" id="myTab3Content">
        <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
            @include ('member.settings.form', ['formMode' => 'create'])


        </div>
        <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('picture') ? 'has-error' : ''}}">
                        <label for="picture" class="control-label">@lang('admin.change') @lang('admin.picture')</label>

                        <input  class="form-control-file"  type="file" name="picture"/>

                        {!! $errors->first('picture', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="col-md-6">
                    @if($department->picture)
                        <div>
                            <img class="img-fluid" src="{{ asset($department->picture) }}" alt=""/>
                        </div><br/>
                        <a class="btn btn-danger" href="{{ route('member.settings.remove-picture') }}"><i class="fa fa-trash"></i> @lang('admin.delete') @lang('admin.picture')</a>
                    @endif
                </div>
            </div>
        </div>

    </div>










        <div class="form-group form-content">
            <input class="btn btn-primary btn-block btn-lg" type="submit" value="@lang('admin.update')">
        </div>
                    </form>



@endsection

@section('footer')
    <script src="{{ asset('themes/admin/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('themes/admin/assets/modules/summernote/summernote-active.js') }}"></script>

@endsection


@section('header')
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/modules/summernote/summernote-bs4.css') }}">
@endsection
