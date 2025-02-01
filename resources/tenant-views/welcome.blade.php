@extends('layouts.site')
@section('pageTitle',setting('general_homepage_title'))
@section('innerTitle',setting('general_homepage_title'))

@section('content')


        @guest
        <div class="row">
            <div   class="col-md-8 mb-5"  >

                @if(!empty(setting('general_homepage_intro')))
                    <div class="card">
                        <div class="card-body">
                            {!! setting('general_homepage_intro') !!}
                        </div>
                    </div>
                @endif


                <section class="section">
                    <div class="card card-success">
                        <div class="card-header">
                            <h4>@lang('site.departments') @if(request('search')): {{ request('search') }} @endif</h4>
                            <form class="card-header-form"  method="get" action="{{ route('site.departments') }}">
                                <input type="text" name="search" class="form-control" placeholder="{{ ucfirst(__('site.search')) }}">
                            </form>
                        </div>

                    </div>


                    <div class="section-body">
                        <h2 class="section-title">@lang('site.dept-info')</h2>
                        <div class="row">

                            @foreach($departments as $department)
                                @include('site.partials.department')
                            @endforeach
                        </div>
                        <div   class="text-center">
                            <a class="btn btn-lg btn-success" href="{{ route('site.departments') }}"><i class="fas fa-users"></i> @lang('site.all-departments')</a>
                        </div>


                    </div>


                </section>

            </div>
            <div class="col-md-4">

                @guest


                    <div class="card">

                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-sign-in-alt"></i> @lang('site.login')</a>
                                </li>
                                @if(setting('general_enable_registration')==1)
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="fa fa-user-plus"></i> @lang('site.register')</a>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <br>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="review-content-section">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="devit-card-custom">
                                                                <div class="form-group">
                                                                    <input id="login_email"  type="text" placeholder="@lang('site.email')" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                                    @error('email')
                                                                    <p class="help-block" >
                                                                        <strong>{{ $message }}</strong>
                                                                    </p>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <input id="login_password"  type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="@lang('site.password')">

                                                                    @error('password')
                                                                    <p class="help-block" >
                                                                        <strong>{{ $message }}</strong>
                                                                    </p>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-md-12">



                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                                            <label class="form-check-label" for="remember">
                                                                                @lang('site.remember-me')
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <button type="submit" class="btn btn-primary btn-block">@lang('site.login')</button>
                                                                <br/>
                                                                <div   >
                                                                    @if(setting('social_enable_facebook')==1)
                                                                        <div   style="margin-bottom: 20px">
                                                                            <a style="margin-top: 0px" class="btn social-btn btn-primary btn-sm btn-block  rounded" href="{{ route('social.login',['network'=>'facebook']) }}"><i class="fab fa-facebook-square"></i> @lang('site.login-facebook')</a>
                                                                        </div>
                                                                    @endif

                                                                    @if(setting('social_enable_google')==1)
                                                                        <div  >
                                                                            <a style="margin-top: 0px"  class="btn social-btn btn-danger  btn-sm  btn-block rounded" href="{{ route('social.login',['network'=>'google']) }}"><i class="fab fa-google"></i> @lang('site.login-google')</a>

                                                                        </div>
                                                                    @endif

                                                                </div>
                                                                @if (Route::has('password.request'))
                                                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                                                        @lang('site.forgot-password')
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>




                                </div>
                                @if(setting('general_enable_registration')==1)
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <br>
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="review-content-section">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="devit-card-custom">

                                                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                                                        <label for="name" class="control-label">@lang('admin.name')</label>
                                                                        <input required class="form-control" name="name" type="text" id="name" value="{{ old('name',isset($member->name) ? $member->name : '') }}" >
                                                                        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                                                                    </div>
                                                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                                                        <label for="email" class="control-label">@lang('admin.email')</label>
                                                                        <input  required class="form-control" name="email" type="text" id="email" value="{{ old('email',isset($member->email) ? $member->email : '') }}" >
                                                                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                                                    </div>
                                                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                                                                        <label for="password" class="control-label">@lang('admin.password')

                                                                        </label>
                                                                        <input  class="form-control" name="password" type="password" id="password" value="{{ old('password')  }}" >
                                                                        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                                                                    </div>

                                                                    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                                                                        <label for="password" class="control-label">@lang('admin.confirm-password')

                                                                        </label>
                                                                        <input  class="form-control" name="password_confirmation" type="password" id="password_confirmation" value="{{ old('password_confirmation')  }}" >
                                                                        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
                                                                    </div>


                                                                    <div class="form-group {{ $errors->has('telephone') ? 'has-error' : ''}}">
                                                                        <label for="telephone" class="control-label">@lang('admin.telephone')</label>
                                                                        <div>
                                                                            <input  class="form-control" name="telephone" type="text" id="telephone" value="{{ old('telephone',isset($member->telephone) ? $member->telephone : '') }}" >

                                                                        </div>
                                                                        {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
                                                                    </div>
                                                                    <div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
                                                                        <label for="gender" class="control-label">@lang('admin.gender')</label>
                                                                        <select required  name="gender" class="form-control" id="gender" required>
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
                                                                                <input  required  class="form-control date" name="date_of_birth" type="text" id="date_of_birth" value="{{ old('date_of_birth') }}" >

                                                                            </div>
                                                                            {!! $errors->first('date_of_birth', '<p class="help-block">:message</p>') !!}
                                                                        </div>
                                                                    @endif

                                                                    @if(setting('general_enable_anniversary')==1)

                                                                        <div class="form-group {{ $errors->has('wedding_anniversary') ? 'has-error' : ''}}">
                                                                            <label for="wedding_anniversary" class="control-label">@lang('admin.wedding-anniversary') ({{ strtolower(__('admin.optional')) }})</label>
                                                                            <div>
                                                                                <input  class="form-control date" name="wedding_anniversary" type="text" id="wedding_anniversary" value="{{ old('wedding_anniversary') }}" >

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
                                                                                <input placeholder="{{ $field->placeholder }}" @if(!empty($field->required))required @endif  type="text" class="form-control" id="{{ 'field_'.$field->id }}" name="{{ 'field_'.$field->id }}" value="{{ $value }}">
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
                                                                                $values = explode('<br />',$options);
                                                                                $selectOptions = [];
                                                                                foreach($values as $value2){
                                                                                    $selectOptions[$value2]=trim($value2);
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
                                                                            $values = explode('<br />',$options);
                                                                            $radioOptions = [];
                                                                            foreach($values as $value3){
                                                                                $radioOptions[$value3]=trim($value3);
                                                                            }
                                                                            ?>
                                                                            <h5><strong>{{ $field->name }}</strong></h5>
                                                                            @foreach($radioOptions as $value2)
                                                                                <div class="radio">
                                                                                    <label>
                                                                                        <input type="radio" @if($value==$value2) checked @endif  name="{{ 'field_'.$field->id }}" id="{{ 'field_'.$field->id }}-{{ $value2 }}" value="{{ $value2 }}" >
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


                                                                    <button type="submit" class="btn btn-primary  btn-block">@lang('site.register')</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                @endguest
            </div>
        </div>
        @else
            @include('site.includes.dashboard')
        @endauth


@endsection

@section('header')
    @if(setting('general_enable_birthday')==1 || setting('general_enable_anniversary')==1)
        <link href="{{ asset('vendor/pickadate/themes/default.date.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/pickadate/themes/default.css') }}" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="{{ asset('vendor/intl-tel-input/build/css/intlTelInput.css') }}">

    <style>
        .iti-flag {background-image: url("{{ asset('vendor/intl-tel-input/build/img/flags.png') }}");}

        @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
            .iti-flag {background-image: url("{{ asset('vendor/intl-tel-input/build/img/flags@2x.png') }}");}
        }



    </style>
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
            separateDialCode:true,
            hiddenInput:'f_telephone',
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
