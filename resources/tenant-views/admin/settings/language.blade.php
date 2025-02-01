@extends('layouts.admin')
@section('pageTitle',__('admin.localization'))

@section('innerTitle')
    @lang("admin.localization")
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.localization')</span>
    </li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-payment-inner-st">

                    <div class="panel panel-default">

                        <div class="panel-body">



                            <form class="form-inline_" method="post" action="{{ route('settings.save-language') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="config_language">@lang('admin.language')</label>
                                    <select class="form-control" name="config_language" required  >
                                        @foreach($languages as $value)
                                            <option @if(old('config_language',setting('config_language'))==$value) selected @endif value="{{ $value }}">{{ $controller->languageName($value) }} ({{ $value }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="config_timezone">@lang('admin.timezone')</label>
                                    <select class="form-control" name="config_timezone" required  >
                                        <option></option>
                                        @foreach($timezones as $key=>$value)
                                            <option @if(old('config_timezone',setting('config_timezone'))==$key) selected @endif value="{{ $key}}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-lg btn-primary">@lang('admin.save')</button>
                            </form>


                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">

@endsection

@section('footer')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $('select').select2();
        });
    </script>
@endsection

