@extends('layouts.member')
@section('pageTitle',__('admin.gallery'))
@section('innerTitle',__('admin.gallery'))



@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.gallery')</span>
    </li>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h4>       <a class="btn btn-primary" title="@lang('site.create-new') gallery" href="{{ url('/member/galleries/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a>
            </h4>
            <div class="card-header-form">
                <form method="GET" action="{{ url('/member/galleries') }}" >
                    <div class="input-group">
                        <input   class="form-control" name="search" value="{{ request('search') }}" type="text" placeholder="{{ ucfirst(__('site.search')) }}..." >
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

                        <th>@lang('admin.name')</th><th>@lang('admin.picture')</th><th>@lang('site.actions')</th>
                    </tr>
                    @foreach($galleries as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>
                                <img  width="55" src="{{ asset($item->file_path) }}"  class="img-thumbnail"   />

                            </td>
                            <td>
                                <a href="{{ url('/member/galleries/' . $item->id) }}" title="@lang('site.view') gallery"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('site.view')</button></a>
                                <a href="{{ url('/member/galleries/' . $item->id . '/edit') }}" title="@lang('site.edit') gallery"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('site.edit')</button></a>

                                <form method="POST" action="{{ url('/member/galleries' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete') gallery" onclick="return confirm('@lang('site.confirm-delete')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('site.delete')</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody></table>
            </div>
            {!! $galleries->appends(['search' => Request::get('search')])->render() !!}
        </div>
    </div>


    @if(false)
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap">
                        <h4>Galleries
                        @if(Request::get('search'))
                             : {{ Request::get('search') }}
                            @endif
                        </h4>
                        <div class="add-product">
                            <a  title="@lang('site.create-new') gallery" href="{{ url('/member/galleries/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a>
                        </div>
                        <div class="asset-inner">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th><th>@lang('admin.name')</th><th>@lang('admin.picture')</th><th>@lang('site.actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($galleries as $item)
                                    <tr>
                                        <td>{{  $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <img src="{{ asset($item->file_path) }}" class="img-fluid img-circle m-b" style="max-width: 200px"/>

                                        </td>
                                        <td>
                                            <a href="{{ url('/member/galleries/' . $item->id) }}" title="@lang('site.view') gallery"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('site.view')</button></a>
                                            <a href="{{ url('/member/galleries/' . $item->id . '/edit') }}" title="@lang('site.edit') gallery"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('site.edit')</button></a>

                                            <form method="POST" action="{{ url('/member/galleries' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete') gallery" onclick="return confirm('@lang('site.confirm-delete')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('site.delete')</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="custom-pagination">
                            {!! $galleries->appends(['search' => Request::get('search')])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
