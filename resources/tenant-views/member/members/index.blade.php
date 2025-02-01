@extends('layouts.member')
@section('pageTitle',__('admin.members'))
@section('innerTitle')
@if($deptName) {{ $deptName }} @endif @lang('admin.members') ({{ $members->count() }}) @if(Request::get('search'))
    : {{ Request::get('search') }}
@endif
@endsection
@section('titleForm_')
    <form id="nav-search" method="GET" action="{{ url('/member/members') }}" role="search" class="sr-input-func">
        <input name="search" value="{{ request('search') }}" type="text" placeholder="{{ ucfirst(__('site.search')) }}..." class="search-int form-control">
        <a onClick="$('#nav-search').submit()" href="#"><i class="fa fa-search"></i></a>
    </form>
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.members')</span>
    </li>
@endsection

@section('content')
    <form  id="exportform" method="POST" action="{{ route('member.members.export') }}" >
        @csrf
        <input name="search" value="{{ request('search') }}" type="hidden"  >

    </form>

    <div class="card">
        <div class="card-header">
            <h4>
                   @can('administer')
                        <a class="btn btn-primary" title="@lang('site.create-new')  @lang('site.member')" href="{{ url('/member/members/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a>
                   @endcan
                    <button onclick="$('#exportform').submit()" type="button" class="btn btn-success "><i class="fa fa-download"></i>  @lang('admin.export')</button>

            </h4>
            <div class="card-header-form">
                <form  method="GET" action="{{ url('/member/members') }}">
                    <div class="input-group">
                        <input  class="form-control"  name="search" value="{{ request('search') }}" type="text" placeholder="{{ ucfirst(__('site.search')) }}..." >
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills" id="myTab3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">@lang('admin.current-members') ({{ $total }})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">@lang('admin.administrators') ({{ $admins->count() }})</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent2">
                <div class="tab-pane fade show active pt-5" id="home3" role="tabpanel" aria-labelledby="home-tab3">

                        <div class="container-fluid">
                            <div class="row">
                                @foreach($members as $item)
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 mb-5">

                                        <div class="user-item">
                                            @if(!empty($item->picture))
                                                <img src="{{ asset($item->picture) }}" class="img-fluid" />
                                            @else
                                                <img src="{{ avatar($item->gender) }}" class="img-fluid"   />
                                            @endif
                                            <div class="user-details">
                                                <div class="user-name">{{ $item->name }}
                                                    @if($item->pivot->department_admin==1)
                                                        <span style="color: green">(@lang('admin.admin'))</span>
                                                    @endif</div>
                                                <div class="text-job text-muted">{{ gender($item->gender) }}</div>
                                                <div class="user-cta">

                                                    <div class="btn-group mb-2">
                                                        <button class="btn btn-primary  dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-cogs" aria-hidden="true"></i>    @lang('admin.actions')
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ url('/member/members/' . $item->id) }}">@lang('admin.details')</a>
                                                            <a class="dropdown-item" href="{{ url('member/emails/create') }}?user={{ $item->id }}">@lang('site.send') @lang('admin.email')</a>
                                                            @can('administer')
                                                                 <a class="dropdown-item" href="{{ url('member/sms/create') }}?user={{ $item->id }}" >@lang('site.send') @lang('admin.sms')</a>
                                                                <a class="dropdown-item" href="{{ route('member.members.remove',['id'=>$item->id]) }}" onclick="return confirm('@lang('admin.delete-prompt')')">@lang('admin.remove')</a>
                                                                @if($item->pivot->department_admin==0)
                                                                    <a class="dropdown-item" href="{{ route('member.members.set-admin',['user'=>$item->id,'mode'=>1]) }}">@lang('admin.make-admin')</a>
                                                                @else
                                                                    <a class="dropdown-item" href="{{ route('member.members.set-admin',['user'=>$item->id,'mode'=>0]) }}">@lang('admin.remove-admin')</a>

                                                                @endif
                                                            @endcan


                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                @endforeach

                            </div>

                        </div>
                    {!! $members->appends(['search' => Request::get('search')])->render() !!}


                </div>
                <div class="tab-pane fade  pt-5" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                    <div class="container-fluid">
                        <div class="row">
                            @foreach($admins as $item)
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 mb-5">

                                    <div class="user-item">
                                        @if(!empty($item->picture))
                                            <img src="{{ asset($item->picture) }}" class="img-fluid" />
                                        @else
                                            <img src="{{ avatar($item->gender) }}" class="img-fluid"   />
                                        @endif
                                        <div class="user-details">
                                            <div class="user-name">{{ $item->name }}
                                                @if($item->pivot->department_admin==1)
                                                    <span style="color: green">(@lang('admin.admin'))</span>
                                                @endif</div>
                                            <div class="text-job text-muted">{{ gender($item->gender) }}</div>
                                            <div class="user-cta">

                                                <div class="btn-group mb-2">
                                                    <button class="btn btn-primary  dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-cogs" aria-hidden="true"></i>    @lang('admin.actions')
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ url('/member/members/' . $item->id) }}">@lang('admin.details')</a>
                                                        <a class="dropdown-item" href="{{ url('member/emails/create') }}?user={{ $item->id }}">@lang('site.send') @lang('admin.email')</a>
                                                        @can('administer')
                                                            <a class="dropdown-item" href="{{ url('member/sms/create') }}?user={{ $item->id }}" >@lang('site.send') @lang('admin.sms')</a>
                                                            <a class="dropdown-item" href="{{ route('member.members.remove',['id'=>$item->id]) }}" onclick="return confirm('@lang('admin.delete-prompt')')">@lang('admin.remove')</a>
                                                            @if($item->pivot->department_admin==0)
                                                                <a class="dropdown-item" href="{{ route('member.members.set-admin',['user'=>$item->id,'mode'=>1]) }}">@lang('admin.make-admin')</a>
                                                            @else
                                                                <a class="dropdown-item" href="{{ route('member.members.set-admin',['user'=>$item->id,'mode'=>0]) }}">@lang('admin.remove-admin')</a>

                                                            @endif
                                                        @endcan


                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                            @endforeach

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection


@section('header')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">

@endsection

@section('footer')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $('select').select2();
        });
    </script>
@endsection

