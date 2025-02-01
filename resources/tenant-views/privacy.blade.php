@extends('layouts.site')
@section('pageTitle',ucfirst(__('site.privacy-policy')))
@section('innerTitle',ucfirst(__('site.privacy-policy')))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('site.home') }}">@lang('site.home')</a>
    </li>
    <li class="breadcrumb-item"><span>{{ ucfirst(__('site.privacy-policy')) }}</span>
    </li>
@endsection

@section('content')

        <div class="container-fluid">
            <p>
                {!! setting('general_privacy_policy') !!}
            </p>
        </div>

@endsection
