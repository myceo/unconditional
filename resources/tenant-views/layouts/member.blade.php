<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('pageTitle',$department->name)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if($icon)
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset($icon) }}">
@endif

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

                <form class="form-inline mr-auto"  method="GET" action="{{ url('/member/members') }}" >
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>

                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>

                    </ul>
                    @can('dept_allows','show_members')
                    <div class="search-element">
                        <input  name="search"  class="form-control" type="search" value="{{ request('search') }}"  placeholder="@lang('site.search-members')" aria-label="@lang('site.search-departments')" data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>


                    </div>
                    @endcan
                </form>

            @endif



            <ul class="navbar-nav navbar-right">

                <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i class="fa fa-users"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">@lang('site.my-departments')</div>

                        @if($userDepartments->count()>0)
                        <a class="dropdown-item" href="{{ route('site.select-department') }}">@lang('site.view-all')</a>
                            @foreach($userDepartments as $userDepartment)
                        <a class="dropdown-item" href="{{ route('site.department-login',['department'=>$userDepartment]) }}">{{ $userDepartment->name }}</a>
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
                <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle @if(isset($unread) && $unread) beep @endif"><i class="far fa-envelope"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">

                        <div class="dropdown-header">@lang('admin.messages') </div>
                        <div class="dropdown-list-content dropdown-list-message">
                        @foreach($emails as $email)

                            <a href="{{ route('member.email.view-inbox',['email'=>$email->id]) }}" class="dropdown-item @if($email->pivot->read==0) dropdown-item-unread @endif">
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
                            <a href="{{ route('member.emails.inbox') }}">@lang('admin.all-messages') <i class="fas fa-chevron-right"></i></a>
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

                <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep_"><i class="fas fa-bell"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">@lang('admin.announcements')  </div>
                        <div class="dropdown-list-content dropdown-list-icons">
                            @foreach($announcements as $msg)
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-avatar">
                                        <img alt="image" src="{{ asset(userPic($msg->user_id)) }}" class="rounded-circle">

                                    </div>
                                    <div class="dropdown-item-desc">
                                        <strong>{{ $msg->user->name }}</strong><br>
                                        <p  ><strong>{{ $msg->title }}</strong>
                                            <br/>{{ limitLength(strip_tags($msg->content),250) }}</p>

                                        <div class="time text-primary">{{ \Illuminate\Support\Carbon::parse($msg->created_at)->diffForHumans() }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="{{ url('member/announcements') }}">@lang('admin.view-all') <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </li>


                <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{ asset($picture) }}" class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">{{ $name }}</div></a>
                    <div class="dropdown-menu dropdown-menu-right">

                        <div class="dropdown-title">@lang('site.my-account')</div>
                        @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item has-icon">
                         <i class="fa fa-cogs"></i>   @lang('site.admin-section')
                        </a>
                        @endif

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
                    <li class="menu-header">{{ limitLength($department->name,15) }}</li>

                    <li><a class="nav-link" href="{{ route('member.dashboard') }}"><i class="fas fa-fire"></i> <span>@lang('admin.dashboard')</span></a></li>

                    @if($department->enable_roster==1)
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-calendar"></i><span>@lang('admin.events')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('member.events.roster') }}">@lang('admin.upcoming-events')</a></li>
                            @can('administer')
                            <li><a class="nav-link" href="{{ url('member/events') }}">@lang('admin.manage-events')</a></li>
                            @endcan
                            <li><a class="nav-link" href="{{ route('member.events.shifts') }}">@lang('admin.my-shifts')</a></li>
                            <li><a class="nav-link" href="{{ url('member/event-reports') }}">@lang('admin.my-reports')</a></li>
                        </ul>
                    </li>
                    @endif

                    @if($department->enable_announcements==1)
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-user-circle"></i><span>@lang('admin.announcements')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ url('member/announcements') }}">@lang('admin.view-all')</a></li>
                            @can('administer')
                            <li><a class="nav-link" href="{{ url('member/announcements/create') }}">@lang('admin.add-new')</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endif
                    @if($department->enable_resources==1)
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-download"></i><span>@lang('admin.downloads')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('member.downloads.browse') }}">@lang('admin.group-files')</a></li>
                            @can('dept_allows','allow_members_upload')
                            <li><a class="nav-link" href="{{ url('member/downloads/create') }}">@lang('admin.upload')</a></li>
                            <li><a class="nav-link" href="{{ url('member/downloads') }}">@lang('admin.my-files')</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endif

                    @if($department->enable_forum==1)
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-comments"></i><span>@lang('admin.forum')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ url('member/forum-topics') }}">@lang('admin.view-topics')</a></li>
                            <li><a class="nav-link" href="{{ url('member/forum-topics/create') }}">@lang('admin.create-topic')</a></li>


                        </ul>
                    </li>
                    @endif

                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-users"></i><span>@lang('admin.members')</span></a>
                        <ul class="dropdown-menu">
                            @can('dept_allows','show_members')
                            <li><a class="nav-link" href="{{ url('member/members') }}">@lang('admin.view-all')</a></li>
                            @endcan
                                @can('administer')
                            <li><a class="nav-link" href="{{ url('member/members/create') }}">@lang('admin.add-new')</a></li>
                            <li><a class="nav-link" href="{{ route('member.members.applications') }}">@lang('admin.applications')</a></li>
                            <li><a class="nav-link" href="{{ route('member.members.import') }}">@lang('admin.import') @lang('admin.members')</a></li>
                            <li><a class="nav-link" href="{{ url('member/teams') }}">@lang('admin.manage-teams')</a></li>
                                @endcan
                                @can('dept_allows','show_members')
                                    @if(setting('general_enable_birthday')==1)
                                    <li><a class="nav-link" href="{{ route('member.birthdays') }}">@lang('admin.birthdays')</a></li>
                                    @endif
                                        @if(setting('general_enable_anniversary')==1)
                                            <li><a class="nav-link" href="{{ route('member.anniversaries') }}">@lang('admin.wedding-anniversaries')</a></li>
                                        @endif



                                @endcan
                                <li><a class="nav-link" href="{{ route('member.my-teams') }}">@lang('admin.my-teams')</a></li>
                                <li><a class="nav-link" href="{{ route('member.leave-group') }}">@lang('admin.leave-group')</a></li>
                        </ul>
                    </li>


                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-envelope"></i><span>@lang('admin.messages')</span></a>
                        <ul class="dropdown-menu">
                            @can('dept_allows','allow_members_communicate')
                            <li><a class="nav-link" href="{{ url('member/emails/create') }}">@lang('admin.new-message')</a></li>
                            @endcan

                            <li><a class="nav-link" href="{{ route('member.emails.inbox') }}">@lang('admin.inbox')</a></li>

                                @can('dept_allows','allow_members_communicate')
                            <li><a class="nav-link" href="{{ url('member/emails') }}">@lang('admin.sent-messages')</a></li>
                                @endcan

                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-desktop"></i><span>@lang('site.training')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('member.courses') }}">@lang('site.courses')</a></li>

                            <li><a class="nav-link" href="{{ route('site.my-courses') }}">@lang('site.my-courses')</a></li>

                            <li><a class="nav-link" href="{{ route('site.tests') }}">@lang('site.tests')</a></li>




                        </ul>
                    </li>


                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-mobile"></i><span>@lang('admin.sms')</span></a>
                        <ul class="dropdown-menu">

                            @if(\Illuminate\Support\Facades\Auth::user()->can('administer'))
                            <li><a class="nav-link" href="{{ url('member/sms/create') }}">@lang('admin.new-message')</a></li>
                            @endif

                            <li><a class="nav-link" href="{{ route('member.sms.inbox') }}">@lang('admin.inbox')</a></li>

                                @if(\Illuminate\Support\Facades\Auth::user()->can('administer'))
                            <li><a class="nav-link" href="{{ url('member/sms') }}">@lang('admin.sent-messages')</a></li>
                                @endif

                        </ul>
                    </li>


                    @can('administer')

                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-images"></i><span>@lang('admin.gallery')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ url('member/galleries/create') }}">@lang('admin.upload-image')</a></li>
                            <li><a class="nav-link" href="{{ url('member/galleries') }}">@lang('admin.manage-gallery')</a></li>


                        </ul>
                    </li>


                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-cogs"></i><span>@lang('admin.settings')</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('member.settings.general')  }}">@lang('admin.general')</a></li>
                            <li><a class="nav-link" href="{{ url('member/fields') }}">@lang('admin.application-form')</a></li>


                        </ul>
                    </li>
                    @endcan


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

<!-- JS Libraies -->

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="{{ asset('themes/admin/assets/js/scripts.js') }}"></script>
<script src="{{ asset('themes/admin/assets/js/custom.js') }}"></script>
@yield('footer')

{!! setting('general_footer_scripts') !!}
</body>
</html>
