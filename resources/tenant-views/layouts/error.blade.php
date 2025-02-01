<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('code') &mdash; {{ setting('general_site_name') }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/css/components.css') }}">
    {!! setting('general_header_scripts') !!}
</head>

<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="page-error">
                <div class="page-inner">
                    <h1>@yield('code')</h1>
                    <div class="page-description">
                        @yield('message')
                    </div>
                    <div class="page-search">

                        <div class="mt-3">
                            <a href="{{ url('/') }}">@lang('site.back-home')</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-footer mt-5">
                {!! __('site.credits',['name'=>setting('general_site_name'),'year'=>date('Y')]) !!}
            </div>
        </div>
    </section>
</div>

<!-- General JS Scripts -->
<script src="{{ asset('themes/admin/assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('themes/admin/assets/modules/popper.js') }}"></script>
<script src="{{ asset('themes/admin/assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('themes/admin/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('themes/admin/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('themes/admin/assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('themes/admin/assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="{{ asset('themes/admin/assets/js/scripts.js') }}"></script>
<script src="{{ asset('themes/admin/assets/js/custom.js') }}"></script>
{!! setting('general_footer_scripts') !!}
</body>
</html>
