@extends('layouts.site')
@section('pageTitle',__('site.contact'))
@section('innerTitle',__('site.contact'))

@section('breadcrumb')
     <li class="breadcrumb-item"><a href="{{ route('site.home') }}">@lang('site.home')</a>
    </li>
    <li class="breadcrumb-item">{{ ucfirst(__('site.contact')) }}
    </li>
@endsection

@section('content')



    <form action="{{ route('site.process-contact') }}" method="post">
        @csrf
    <div class="row">

        <div class="col-md-6 offset-3">
            <p>
                @lang('site.send-us-message')
            </p>

            <div class="row">
                <div class="form-group col-md-6">
                    <input type="text" required value="{{ old('name') }}"
                           class="form-control" name="name" id="name" aria-describedby="name"
                           placeholder="@lang('site.name')">
                </div>

                <div class="form-group col-md-6">
                    <input type="email" required value="{{ old('email') }}"
                           class="form-control" name="email" id="email" aria-describedby="email"
                           placeholder="@lang('site.email')">
                </div>
            </div>

            <div class="form-group">
                <input type="text" required  value="{{ old('subject') }}"
                       class="form-control" name="subject" id="subject" aria-describedby="helpId" placeholder="@lang('admin.subject')">

            </div>

            <div class="form-group">
                <textarea class="form-control" name="message" id="message" rows="3" placeholder="@lang('admin.message')">{{ old('message') }}</textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    {!! captcha_img() !!}
                </div>
                <div class="col-md-9">
                    <input type="text" name="captcha" class="form-control" placeholder="@lang('site.enter-code')" value="{{ old('captcha') }}">
                </div>
            </div>

            <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-envelope"></i> @lang('site.send-message')</button>

        </div>

    </div>
    </form>
@endsection
