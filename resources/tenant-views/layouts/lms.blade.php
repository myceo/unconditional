<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta-description')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="author" content="">

    <title>@yield('page-title')</title>
    @yield('pre-header')
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('themes/skydash/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('themes/skydash/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('themes/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/skydash/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('themes/skydash/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    @if(!empty(setting('image_icon')))
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset(setting('image_icon')) }}">
    @endif


    @yield('header')
    <link href="{{ asset('css/fix.css') }}" rel="stylesheet" />
    {!!  setting('general_header_scripts')  !!}

</head>
<body class="skydash">
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            @if(!empty(setting('image_logo')))
                <a class="navbar-brand brand-logo mr-5" href="{{ url('/') }}"><img src="{{ asset(setting('image_logo')) }}" class="mr-2" alt="{{ setting('general_site_name') }}"/></a>
                <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}"><img src="{{ asset(setting('image_logo')) }}" alt="{{ setting('general_site_name') }}"/></a>
            @else
                <a href="{{ url('/') }}">{{ setting('general_site_name') }}</a>
            @endif
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
            @section('search-form')
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-search d-none d-lg-block">
                        <form action="{{ route('site.courses') }}" method="get">
                            <div class="input-group">
                                <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                  <i class="icon-search"></i>
                </span>
                                </div>
                                <input type="text" name="search" value="{{ request()->search }}" class="form-control" id="navbar-search-input" placeholder="@lang('site.search')" aria-label="search" aria-describedby="search">
                            </div>
                        </form>
                    </li>
                </ul>
            @show
            <ul class="navbar-nav navbar-nav-right">

                @if(setting('candidate_set_visibility')==1)
                    <li class="nav-item">
                        @livewire('site.toggle-candidate-public')
                    </li>
                @endif

                @if(session()->has('invoice') && \App\Invoice::find(session()->get('invoice')))
                    <li class="nav-item">
                        <a class="nav-link count-indicator" id="notificationDropdown" href="{{ route('user.invoice.cart') }}" >
                            <i class="fa fa-cart-plus mx-0"></i>
                            <span class="count">{{ price(\App\Invoice::find(session()->get('invoice'))->amount) }}</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <img src="{{ profilePicture(Auth::user()->id) }}" alt="profile"/>
                    </a>



                    <div  class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <h5 class="dropdown-header text-primary">{{ Auth::user()->name }}</h5>

                        <a href="{{ route('account.profile') }}" class="dropdown-item"><i class="fa fa-user"></i>  {{ __('admin.profile') }}</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item"><i class="fa fa-sign-out-alt"></i> {{ __('admin.logout') }}</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="int_hide">
                            @csrf
                        </form>
                    </div>
                </li>

            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="icon-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">

        <!-- partial:partials/_sidebar.html -->
        @yield('sidebar')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12 @section('title-margin') grid-margin @show">
                        <div class="row">
                            @hasSection('page-title')
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h3 class="font-weight-bold">@yield('page-title')</h3>
                                    <h6 class="font-weight-normal mb-0">@yield('page-subtile')</h6>
                                </div>
                            @endif
                            @hasSection('breadcrumb')
                                <div class="col-12 col-xl-4">
                                    <div class="justify-content-end d-flex">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="{{ route('member.dashboard') }}"><i class="fas fa-home"></i></a></li>
                                                @yield('breadcrumb')
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="@yield('content-class')">
                    @include('partials.flash_message')
                    @yield('content')
                </div><!-- az-content-body -->
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">&copy; {{ date('Y') }} {{ setting('general_site_name') }}</span>
                </div>

            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{ asset('themes/skydash/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->

<!-- inject:js -->
<script src="{{ asset('themes/skydash/js/off-canvas.js') }}"></script>
<script src="{{ asset('themes/skydash/js/hoverable-collapse.js') }}"></script>
@section('nav-script')
    <script src="{{ asset('js/lms-template.js') }}"></script>
@show
<script src="{{ asset('themes/skydash/js/settings.js') }}"></script>
<script src="{{ asset('themes/skydash/js/todolist.js') }}"></script>


@yield('footer')
{!!  setting('general_footer_scripts')  !!}
</body>

</html>

