@extends('layouts.auth')
@section('pageTitle',__('site.register'))

@section('header')
@if(setting('general_enable_birthday')==1 || setting('general_enable_anniversary')==1)
<link href="{{ asset('vendor/pickadate/themes/default.date.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/pickadate/themes/default.css') }}" rel="stylesheet">
@endif
<link rel="stylesheet" href="{{ asset('vendor/intl-tel-input/build/css/intlTelInput.css') }}">

<style>
    .iti-flag {
        background-image: url("{{ asset('vendor/intl-tel-input/build/img/flags.png') }}");
    }

    @media only screen and (-webkit-min-device-pixel-ratio: 2),
    only screen and (min--moz-device-pixel-ratio: 2),
    only screen and (-o-min-device-pixel-ratio: 2 / 1),
    only screen and (min-device-pixel-ratio: 2),
    only screen and (min-resolution: 192dpi),
    only screen and (min-resolution: 2dppx) {
        .iti-flag {
            background-image: url("{{ asset('vendor/intl-tel-input/build/img/flags@2x.png') }}");
        }
    }
</style>

{!! setting('general_header_scripts') !!}
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h4>@lang('site.register')</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('register') }}" id="loginForm">
            @csrf

            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                <label for="name" class="control-label">@lang('admin.name')</label>
                <input required class="form-control" name="name" type="text" id="name" value="{{ old('name',isset($member->name) ? $member->name : '') }}">
                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                <label for="email" class="control-label">@lang('admin.email')</label>
                <input required class="form-control" name="email" type="text" id="email" value="{{ old('email',isset($member->email) ? $member->email : '') }}">
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                <label for="password" class="control-label">@lang('admin.password')

                </label>
                <input class="form-control" name="password" type="password" id="password" value="{{ old('password')  }}">
                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                <label for="password" class="control-label">@lang('admin.confirm-password')

                </label>
                <input class="form-control" name="password_confirmation" type="password" id="password_confirmation" value="{{ old('password_confirmation')  }}">
                {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
            </div>


            <div class="form-group {{ $errors->has('telephone') ? 'has-error' : ''}}">
                <label for="telephone" class="control-label">@lang('admin.telephone')</label>
                <div>
                    <input class="form-control" name="telephone" type="text" id="telephone" value="{{ old('telephone',isset($member->telephone) ? $member->telephone : '') }}">

                </div>

                {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
                <label for="gender" class="control-label">@lang('admin.gender')</label>
                <select required name="gender" class="form-control" id="gender" required>
                    <option></option>
                    @foreach (getGenders() as $optionKey => $optionValue)
                    <option value="{{ $optionKey }}" {{ ((null !== old('gender',@$member->gender)) && old('gender',@$member->gender) == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
                    @endforeach
                </select>
                {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
            </div>


            @if(setting('general_enable_birthday')==1)

            <div class="form-group {{ $errors->has('date_of_birth') ? 'has-error' : ''}}">
                <label for="telephone" class="control-label">@lang('admin.date-of-birth')</label>
                <div>
                    <input required class="form-control date" name="date_of_birth" type="text" id="date_of_birth" value="{{ old('date_of_birth') }}">

                </div>
                {!! $errors->first('date_of_birth', '<p class="help-block">:message</p>') !!}
            </div>
            @endif

            @if(setting('general_enable_anniversary')==1)

            <div class="form-group {{ $errors->has('wedding_anniversary') ? 'has-error' : ''}}">
                <label for="wedding_anniversary" class="control-label">@lang('admin.wedding-anniversary') ({{ strtolower(__('admin.optional')) }})</label>
                <div>
                    <input class="form-control date" name="wedding_anniversary" type="text" id="wedding_anniversary" value="{{ old('wedding_anniversary') }}">

                </div>
                {!! $errors->first('wedding_anniversary', '<p class="help-block">:message</p>') !!}
            </div>

            @endif

            @foreach(\App\Field::where('enabled',1)->orderBy('sort_order','asc')->get() as $field)
            @php
            if(isset($member)){
            $value = old($field->id,($member->fields()->where('field_id',$field->id)->first()) ? $member->fields()->where('field_id',$field->id)->first()->pivot->value:'');

            }
            else{
            $value='';
            }
            @endphp
            @if($field->type=='text')
            <div class="form-group{{ $errors->has('field_'.$field->id) ? ' has-error' : '' }}">
                <label for="{{ 'field_'.$field->id }}">{{ $field->name }}:</label>
                <input placeholder="{{ $field->placeholder }}" @if(!empty($field->required))required @endif type="text" class="form-control" id="{{ 'field_'.$field->id }}" name="{{ 'field_'.$field->id }}" value="{{ $value }}">
                @if ($errors->has('field_'.$field->id))
                <span class="help-block">
                    <strong>{{ $errors->first('field_'.$field->id) }}</strong>
                </span>
                @endif
            </div>
            @elseif($field->type=='select')
            <div class="form-group{{ $errors->has('field_'.$field->id) ? ' has-error' : '' }}">
                <label for="{{ 'field_'.$field->id }}">{{ $field->name }}:</label>
                <?php
                $options = nl2br($field->options);
                $values = explode('<br />', $options);
                $selectOptions = [];
                foreach ($values as $value2) {
                    $selectOptions[$value2] = trim($value2);
                }
                ?>
                {{ Form::select('field_'.$field->id, $selectOptions,$value,['placeholder' => $field->placeholder,'class'=>'form-control']) }}
                @if ($errors->has('field_'.$field->id))
                <span class="help-block">
                    <strong>{{ $errors->first('field_'.$field->id) }}</strong>
                </span>

                @endif
            </div>
            @elseif($field->type=='textarea')
            <div class="form-group{{ $errors->has('field_'.$field->id) ? ' has-error' : '' }}">
                <label for="{{ 'field_'.$field->id }}">{{ $field->name }}:</label>
                <textarea placeholder="{{ $field->placeholder }}" class="form-control" name="{{ 'field_'.$field->id }}" id="{{ 'field_'.$field->id }}" @if(!empty($field->required))required @endif  >{{ $value }}</textarea>
                @if ($errors->has('field_'.$field->id))
                <span class="help-block">
                    <strong>{{ $errors->first('field_'.$field->id) }}</strong>
                </span>
                @endif
            </div>
            @elseif($field->type=='checkbox')
            <div class="checkbox">
                <label>
                    <input name="{{ 'field_'.$field->id }}" type="checkbox" value="1" @if($value==1) checked @endif> {{ $field->name }}
                </label>
            </div>

            @elseif($field->type=='radio')
            <?php
            $options = nl2br($field->options);
            $values = explode('<br />', $options);
            $radioOptions = [];
            foreach ($values as $value3) {
                $radioOptions[$value3] = trim($value3);
            }
            ?>
            <h5><strong>{{ $field->name }}</strong></h5>
            @foreach($radioOptions as $value2)
            <div class="radio">
                <label>
                    <input type="radio" @if($value==$value2) checked @endif name="{{ 'field_'.$field->id }}" id="{{ 'field_'.$field->id }}-{{ $value2 }}" value="{{ $value2 }}">
                    {{ $value2 }}
                </label>
            </div>
            @endforeach
            @endif


            @endforeach

            @if(setting('general_captcha')==1)
            <div class="row mb-3 mt-3">
                <div class="col-md-5">
                    {!! captcha_img() !!}
                </div>
                <div class="col-md-7  ">
                    <input type="text" name="captcha" class="form-control" placeholder="@lang('site.enter-code')" value="{{ old('captcha') }}">
                </div>
            </div>
            @endif

            <button class="btn btn-primary btn-block loginbtn" type="submit">@lang('site.register')</button>

        </form>

        @if(setting('social_enable_facebook')==1 || setting('social_enable_google')==1)
        <div class="text-center mt-4 mb-3">
            <div class="text-job text-muted">@lang('auth.social-login')</div>
        </div>
        <div class="row sm-gutters">
            @if(setting('social_enable_facebook')==1)
            <div class="col-6">
                <a href="{{ route('social.login',['network'=>'facebook']) }}" class="btn btn-block btn-social btn-facebook">
                    <span class="fab fa-facebook"></span> Facebook
                </a>
            </div>
            @endif
            @if(setting('social_enable_google')==1)
            <div class="col-6">
                <a class="btn btn-block btn-social btn-google">
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
    @lang('auth.already-account') <a href="{{ route('login') }}">@lang('site.login')</a>
</div>
@endif

@endsection

@section('footer')
@if(setting('general_enable_birthday')==1 || setting('general_enable_anniversary')==1)
<script src="{{ asset('vendor/pickadate/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/pickadate/picker.date.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/pickadate/legacy.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('js/dates.js') }}"></script>
@endif
<script src="{{ asset('vendor/intl-tel-input/build/js/intlTelInput.js') }}"></script>

<script>
    $("input[name=telephone]").intlTelInput({
        initialCountry: "auto",
        separateDialCode: true,
        hiddenInput: 'f_telephone',
        geoIpLookup: function(callback) {
            $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "{{ asset('vendor/intl-tel-input/build/js/utils.js') }}" // just for formatting/placeholders etc
    });
</script>

@endsection
