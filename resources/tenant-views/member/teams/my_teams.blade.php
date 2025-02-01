@extends('layouts.member')
@section('pageTitle',__('admin.my-teams'))
@section('innerTitle',__('admin.my-teams'))

@section('titleForm_')
    <form id="nav-search" method="GET" action="{{ route('member.my-teams') }}" role="search" class="sr-input-func">
        <input name="search" value="{{ request('search') }}" type="text" placeholder="{{ ucfirst(__('site.search')) }}..." class="search-int form-control">
        <a onClick="$('#nav-search').submit()" href="#"><i class="fa fa-search"></i></a>
    </form>
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.my-teams')</span>
    </li>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h4></h4>
            <div class="card-header-form" style="margin-left: inherit;">
                <form method="GET" action="{{ route('member.my-teams') }}" >
                    <div class="input-group">
                        <input  name="search" value="{{ request('search') }}"  type="text" class="form-control" placeholder="{{ ucfirst(__('site.search')) }}...">
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody><tr>
                        <th>@lang('admin.name')</th>
                        <th>@lang('admin.members')</th>
                        <th>@lang('site.actions')</th>
                    </tr>
                    @foreach($teams as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->users()->count() }}</td>
                        <td>@can('dept_allows','show_members')
                                <a href="{{ url('/member/teams/' . $item->id) }}" title="@lang('site.view') team"><button class="btn btn-info btn-sm"><i class="fa fa-users" aria-hidden="true"></i> @lang('admin.members')</button></a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    </tbody></table>
            </div>
            {!! $teams->appends(['search' => Request::get('search')])->render() !!}
        </div>
    </div>

@endsection
