@extends('layouts.member')
@section('pageTitle',__('admin.teams'))
@section('innerTitle')
    @lang('admin.teams')
    @if(Request::get('search'))
        : {{ Request::get('search') }}
    @endif
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.teams')</span>
    </li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4><a class="btn btn-primary"  title="@lang('site.create-new') team" href="{{ url('/member/teams/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a></h4>
            <div class="card-header-form">
                <form method="GET" action="{{ url('/member/teams') }}" >
                    <div class="input-group">
                        <input  class="form-control" name="search" value="{{ request('search') }}" type="text" placeholder="{{ ucfirst(__('site.search')) }}..." >
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
                            <td>
                                <a href="{{ url('/member/teams/' . $item->id) }}" title="@lang('site.view') team"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('site.view')</button></a>
                                <a href="{{ url('/member/teams/' . $item->id . '/edit') }}" title="@lang('site.edit') team"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('site.edit')</button></a>

                                <form method="POST" action="{{ url('/member/teams' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete') team" onclick="return confirm('@lang('admin.delete-prompt')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('site.delete')</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    </tbody></table>
            </div>
        </div>
    </div>

    @if(false)
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap">
                        <h4>@lang('admin.teams')
                        @if(Request::get('search'))
                             : {{ Request::get('search') }}
                            @endif
                        </h4>
                        <div class="add-product">
                            <a  title="@lang('site.create-new') team" href="{{ url('/member/teams/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a>
                        </div>
                        <div class="asset-inner">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>@lang('admin.name')</th>
                                    <th>@lang('admin.members')</th>
                                    <th>@lang('site.actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teams as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->users()->count() }}</td>
                                        <td>
                                            <a href="{{ url('/member/teams/' . $item->id) }}" title="@lang('site.view') team"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('site.view')</button></a>
                                            <a href="{{ url('/member/teams/' . $item->id . '/edit') }}" title="@lang('site.edit') team"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('site.edit')</button></a>

                                            <form method="POST" action="{{ url('/member/teams' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete') team" onclick="return confirm('@lang('admin.delete-prompt')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('site.delete')</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="custom-pagination">
                            {!! $teams->appends(['search' => Request::get('search')])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
