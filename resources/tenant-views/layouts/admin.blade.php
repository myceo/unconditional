<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('pageTitle',setting('general_site_name'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if($icon)
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset($icon) }}">
@endif
    @yield('header-top')
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('header')
    {!! setting('general_header_scripts') !!}

</head>


<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar int_adminnav">

            @hasSection('titleForm')
                @yield('titleForm')
            @else

                <form class="form-inline mr-auto"  method="GET" @section('t-form-action') action="{{ url('/admin/members') }}" @show >
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>

                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>

                    </ul>
                    <div class="search-element">
                        <input  name="search"  class="form-control" type="search" @section('t-form-value') value="{{ request('search') }}" @show  @section('t-form-placeholder') placeholder="@lang('site.search-members')" @show aria-label="@lang('site.search')" data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>

                        @section('t-form-extra')

                            @endsection
                    </div>
                </form>

            @endif



            <ul class="navbar-nav navbar-right">

                <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i class="fa fa-users"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">@lang('site.my-departments')</div>

                        @if($userDepartments->count()>0)
                        <a class="dropdown-item" href="{{ route('site.select-department') }}">@lang('site.view-all')</a>
                            @foreach($userDepartments as $department)
                        <a class="dropdown-item" href="{{ route('site.department-login',['department'=>$department]) }}">{{ $department->name }}</a>
                            @endforeach
                        @endif
                @if(\Illuminate\Support\Facades\Auth::user()->role_id==2)
                    @if($userDepartments->count()>0)
                                <div class="dropdown-divider"></div>
                    @endif
                     <a class="dropdown-item" href="{{ route('site.my-applications') }}">@lang('site.my-applications')</a>

                @endif

                    </div>
                </li>
                <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle @if($unread) beep @endif"><i class="far fa-envelope"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">@lang('admin.messages') </div>
                        <div class="dropdown-list-content dropdown-list-message">
                        @foreach($emails as $email)

                            <a href="{{ route('email.view-inbox',['email'=>$email->id]) }}" class="dropdown-item @if($email->pivot->read==0) dropdown-item-unread @endif">
                                <div class="dropdown-item-avatar">
                                    <img alt="image" src="{{ asset(userPic($email->user_id)) }}" class="rounded-circle">

                                </div>
                                <div class="dropdown-item-desc">
                                    <b>{{ $email->user->name }}</b>
                                    <p>{{ $email->subject }}</p>
                                    <div class="time">{{ \Illuminate\Support\Carbon::parse($email->created_at)->diffForHumans() }}</div>
                                </div>
                            </a>


                        @endforeach
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="{{ route('emails.inbox') }}">@lang('admin.all-messages') <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </li>

                <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep_"><i class="fas fa-comment-alt"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">@lang('admin.sms')  </div>
                        <div class="dropdown-list-content dropdown-list-icons">
                            @foreach($sms as $msg)
                            <a href="#" class="dropdown-item">
                                <div class="dropdown-item-avatar">
                                    <img alt="image" src="{{ asset(userPic($msg->user_id)) }}" class="rounded-circle">

                                </div>
                                <div class="dropdown-item-desc">
                                    <strong>{{ $msg->user->name }}</strong><br>
                                    {{ $msg->message }}
                                    <div class="time text-primary">{{ \Illuminate\Support\Carbon::parse($msg->created_at)->diffForHumans() }}</div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="{{ route('sms.inbox') }}">@lang('admin.all-sms') <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </li>

                <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{ asset($picture) }}" class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">{{ $name }}</div></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-title">@lang('site.my-account')</div>

                        <a href="{{ route('account.profile') }}" class="dropdown-item has-icon">
                            <i class="far fa-user"></i> @lang('admin.profile')
                        </a>
                        <a href="{{ route('account.password') }}" class="dropdown-item has-icon">
                            <i class="fas fa-cog"></i> @lang('admin.change-password')
                        </a>
                        <div class="dropdown-divider"></div>
                        <a  href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
                            <i class="fas fa-sign-out-alt"></i> @lang('admin.logout')
                        </a>
                    </div>
                </li>
            </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
        </nav>
        <div class="main-sidebar sidebar-style-2">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="{{ route('home') }}">
                        @if($logo)
                            <img  class="int_dashlogo" src="{{ asset($logo) }}"  />
                        @else
                             {{ $siteName }}
                        @endif

                    </a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="{{ route('admin.dashboard') }}">

                            {{ substr($siteName,0,2) }}


                    </a>
                </div>
                <ul class="sidebar-menu">
                    <li class="menu-header">@lang('site.admin-section')</li>

                    <li><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i> <span>@lang('admin.dashboard')</span></a></li>

                    <li id="groups-link" class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-users"></i><span>@lang('admin.departments')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ url('admin/groups/create') }}">@lang('admin.add-new')</a></li>
                            <li><a class="nav-link" href="{{ url('admin/groups') }}">@lang('admin.view-all')</a></li>
                            <li><a class="nav-link" href="{{ url('admin/categories') }}">@lang('admin.manage-categories')</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-user-circle"></i><span>@lang('admin.members')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ url('admin/members/create') }}">@lang('admin.add-new')</a></li>
                            <li><a class="nav-link" href="{{ url('admin/members') }}">@lang('admin.view-all')</a></li>
                            <li><a class="nav-link" href="{{ route('members.import') }}">@lang('admin.import')</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-envelope"></i><span>@lang('admin.messages')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ url('admin/emails/create') }}">@lang('admin.new-message')</a></li>
                            <li><a class="nav-link" href="{{ route('emails.inbox') }}">@lang('admin.inbox')</a></li>
                            <li><a class="nav-link" href="{{ url('admin/emails') }}">@lang('admin.sent-messages')</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-comment-alt"></i><span>@lang('admin.sms')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ url('admin/sms/create') }}">@lang('admin.new-message')</a></li>
                            <li><a class="nav-link" href="{{ route('sms.inbox') }}">@lang('admin.inbox')</a></li>
                            <li><a class="nav-link" href="{{ url('admin/sms') }}">@lang('admin.sent-messages')</a></li>


                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-desktop"></i><span>@lang('site.training')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('admin.courses.index') }}">@lang('site.courses')</a></li>
                            <li><a class="nav-link" href="{{ route('admin.tests.index') }}">@lang('site.tests')</a></li>
                            <li><a class="nav-link" href="{{ route('admin.course-categories.index') }}">@lang('site.course-categories')</a></li>


                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-cogs"></i><span>@lang('admin.settings')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('admin.settings',['group'=>'general'])  }}">@lang('admin.general')</a></li>
                            <li><a class="nav-link" href="{{ route('settings.language') }}">@lang('admin.localization')</a></li>

                            <li><a class="nav-link" href="{{ url('admin/fields') }}">@lang('admin.member-fields')</a></li>
                            <li><a class="nav-link" href="{{ route('admin.settings',['group'=>'image'])  }}">@lang('admin.logo-icon')</a></li>

                            <li><a class="nav-link" href="{{ route('admin.settings',['group'=>'social'])  }}">@lang('admin.social-login')</a></li>
                            <li><a class="nav-link" href="{{ route('admin.settings',['group'=>'mail'])  }}">@lang('admin.email-settings')</a></li>
                            <li><a class="nav-link" href="{{ route('admin.settings',['group'=>'zoom'])  }}">@lang('site.zoom')</a></li>

                            <li><a class="nav-link" href="{{ route('settings.sms_gateways') }}">@lang('admin.sms-settings')</a></li>

                            <li><a class="nav-link" href="{{ url('admin/admins') }}">@lang('admin.administrators')</a></li>

                            <li><a class="nav-link" href="{{ route('token') }}">@lang('admin.api-token')</a></li>

                        </ul>
                    </li>

                </ul>


                        </aside>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    @hasSection('innerTitle')
                        <h1>@yield('innerTitle')</h1>
                    @endif
                    @hasSection('breadcrumb')
                        <div class="section-header-breadcrumb">

                            @yield('breadcrumb')


                        </div>
                    @endif


                </div>

                <div class="section-body">


                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif


                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))

                            <div class="alert alert-{{ $msg }} alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    {{ Session::get('alert-' . $msg) }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                    @if(Session::has('flash_message'))

                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                {{ Session::get('flash_message') }}
                            </div>
                        </div>



                    @endif



                    @yield('content')
                </div>
            </section>
        </div>

        <!-- START SIMPLE MODAL MARKUP -->
        <div class="modal fade" id="generalModal" tabindex="-1" role="dialog" aria-labelledby="generalModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="generalModalLabel"></h4>
                    </div>
                    <div class="modal-body" id="genmodalinfo">

                    </div>
                    <div class="modal-footer">

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- END SIMPLE MODAL MARKUP -->
        <script>
            function openModal(title,url){
                $('#genmodalinfo').html(' <img  src="{{ asset('img/loader.gif') }}">');
                $('#generalModalLabel').text(title);
                $('#genmodalinfo').load(url);
                $('#generalModal').modal();
            }
            function openPopup(url){
                window.open(url, "_blank", "toolbar=no,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400");
                return false;
            }
        </script>
        <footer class="main-footer">
            <div class="footer-left">
                {!! __('site.credits',['name'=>setting('general_site_name'),'year'=>date('Y')]) !!}
            </div>
            <div class="footer-right">
                <a href="{{ route('site.privacy') }}">@lang('site.privacy-policy')</a>
            </div>

        </footer>


    </div>
</div>

<!-- General JS Scripts -->
<script src="{{ asset('themes/admin/assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('themes/admin/assets/modules/popper.js') }}"></script>
<script src="{{ asset('themes/admin/assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('themes/admin/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('themes/admin/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('themes/admin/assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('themes/admin/assets/js/stisla.js') }}"></script>
<script src="{{ asset('js/lib.js') }}"></script>

<!-- JS Libraies -->

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="{{ asset('themes/admin/assets/js/scripts.js') }}"></script>
<script src="{{ asset('themes/admin/assets/js/custom.js') }}"></script>
@yield('footer')

{!! setting('general_footer_scripts') !!}
</body>

</html>
Z
