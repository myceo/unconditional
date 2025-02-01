@extends('layouts.auth')
@section('pageTitle',__('site.login'))

@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>@lang('site.login')</h4></div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" class="needs-validation"  novalidate="" >
                @csrf
                <div class="form-group">
                    <label for="email">@lang('site.email')</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                        @lang('site.email-required-msg')
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">@lang('site.password')</label>
                        <div class="float-right">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-small">
                                    @lang('site.forgot-password')
                                </a>
                            @endif

                        </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                        @lang('auth.password-required-msg')
                    </div>
                    @error('password')
                    <p class="help-block" >
                        <strong>{{ $message }}</strong>
                    </p>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember-me">@lang('site.remember-me')</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        @lang('site.login')
                    </button>
                </div>
            </form>
            @if(setting('social_enable_facebook')==1 || setting('social_enable_google')==1)
            <div class="text-center mt-4 mb-3">
                <div class="text-job text-muted">@lang('auth.social-login')</div>
            </div>
            <div class="row sm-gutters">
                @if(setting('social_enable_facebook')==1)
                <div class="col-6">
                    <a  href="{{ route('social.login',['network'=>'facebook']) }}" class="btn btn-block btn-social btn-facebook">
                        <span class="fab fa-facebook"></span> Facebook
                    </a>
                </div>
                @endif
               @if(setting('social_enable_google')==1)
                <div class="col-6">
                    <a  href="{{ route('social.login',['network'=>'google']) }}"   class="btn btn-block btn-social btn-google">
                        <span class="fab fa-google"></span> Google
                    </a>
                </div>
               @endif
            </div>
            @endif

        </div>
    </div>
    @if(setting('general_enable_registration')==1)
    <div class="mt-5 text-muted text-center">
        @lang('auth.dont-have-account') <a href="{{ route('register') }}">@lang('auth.create-one')</a>
    </div>
    @endif

@endsection

