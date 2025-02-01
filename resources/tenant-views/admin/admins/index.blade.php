@extends('layouts.admin')
@section('pageTitle',__('admin.administrators'))

@section('innerTitle')
    @lang('admin.administrators')
    @if(Request::get('search'))
        : {{ Request::get('search') }}
        @endif

@endsection



@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.administrators')</span>
    </li>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h4><a  title="@lang('site.create-new')" class="btn btn-primary" href="{{ url('/admin/admins/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a></h4>
            <div class="card-header-form">
                <form method="GET" action="{{ url('/admin/admins') }}" role="search" >
                    <div class="input-group">
                        <input name="search" value="{{ request('search') }}"  type="text" class="form-control" placeholder="{{ ucfirst(__('site.search')) }}...">
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
                    <thead>
                    <tr>
                        <th>#</th><th>@lang('admin.name')</th><th>@lang('admin.email')</th><th>@lang('admin.status')</th><th>@lang('site.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $item)
                        <tr>
                            <td>{{  $item->id }}</td>
                            <td>{{ $item->name }}
                            @if(!empty($item->is_billing))
                                <strong>(@lang('admin.billing-account'))</strong>
                             @endif
                            </td><td>{{ $item->email }}</td><td>
                                @if($item->status==1)
                                    @lang('admin.enabled')
                                @else
                                    @lang('admin.disabled')
                                @endif

                            </td>
                            <td>
                                <a href="{{ url('/admin/members/' . $item->id) }}" title="@lang('site.view') @lang('admin.member')"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('site.view')</button></a>
                                <a href="{{ url('/admin/members/' . $item->id . '/edit') }}" title="@lang('site.edit') @lang('admin.member')"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> @lang('site.edit')</button></a>

                                @if(empty($item->is_billing))
                                <form method="POST" action="{{ url('/admin/members' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete') @lang('admin.member')" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('site.delete')</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {!! $admins->appends(['search' => Request::get('search')])->render() !!}
        </div>
    </div>





@endsection
