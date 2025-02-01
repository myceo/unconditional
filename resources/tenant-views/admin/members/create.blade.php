@extends('layouts.admin')
@section('pageTitle',__('admin.members'))

@section('innerTitle')
    @lang('site.create-new')  {{ ucfirst(__('admin.member')) }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/admin/members') }}">@lang('admin.members')</a>
    </li>
    <li><span>@lang('site.create-new') @lang('admin.member')</span>
    </li>
@endsection

@section('content')
    <div class="single-pro-review-area mt-t-30 mg-b-15">


        <div class="container-fluid">
            <div class="product-payment-inner-st form-content">


            <form method="POST" action="{{ url('/admin/members') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}

                @include ('admin.members.form', ['formMode' => 'create'])

            </form>




            </div>
        </div>


    </div>

@endsection

@section('header')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
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
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(function(){
            $('.select2').select2();
        });
    </script>
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
