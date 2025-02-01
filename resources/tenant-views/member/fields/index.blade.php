@extends('layouts.member')
@section('pageTitle',__('admin.application-form'))
@section('innerTitle')
    @lang('admin.questions')
    @if(Request::get('search'))
        : {{ Request::get('search') }}
    @endif
    @endsection



@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.member-fields')</span>
    </li>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h4><a class="btn btn-primary"  title="@lang('site.create-new') @lang('admin.field')" href="{{ url('/member/fields/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a></h4>
            <div class="card-header-form">
                <form method="GET" action="{{ url('/member/fields') }}" >
                    <div class="input-group">
                        <input name="search" value="{{ request('search') }}" type="text" placeholder="{{ ucfirst(__('site.search')) }}..." class="form-control"  >
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
                         <th>@lang('admin.name')</th><th>@lang('admin.type')</th><th>@lang('admin.sort-order')</th>
                        <th>@lang('admin.enabled')</th>
                        <th>@lang('site.actions')</th>
                    </tr>
                    @foreach($fields as $item)
                        <tr>
                            <td>{{ $item->name }}</td><td>{{ $item->type }}</td><td>{{ $item->sort_order }}</td>
                            <td>{{ boolToString($item->enabled) }}</td>
                            <td>
                                <a href="{{ url('/member/fields/' . $item->id) }}" title="@lang('site.view') field"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('site.view')</button></a>
                                <a href="{{ url('/member/fields/' . $item->id . '/edit') }}" title="@lang('site.edit') field"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('site.edit')</button></a>

                                <form method="POST" action="{{ url('/member/fields' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete') field" onclick="return confirm('@lang('site.confirm-delete')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('site.delete')</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody></table>
            </div>
            {!! $fields->appends(['search' => Request::get('search')])->render() !!}
        </div>
    </div>



@endsection
