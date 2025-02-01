@extends('layouts.admin')
@section('pageTitle',__('admin.categories'))
@section('innerTitle')
    @lang('admin.categories')@if(Request::get('search'))
        : {{ Request::get('search') }}
    @endif
@endsection


@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.categories')</span>
    </li>
@endsection

@section('content')




    <div class="card">
        <div class="card-header">
            <h4> <a class="btn btn-primary" title="@lang('admin.add-new') @lang('admin.category')" href="{{ url('/admin/categories/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a></h4>
            <div class="card-header-form">
                <form  method="GET" action="{{ url('/admin/categories') }}" >
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"  placeholder="@lang('admin.search')..." >
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
                        <th>
                            #
                        </th>
                        <th>@lang('admin.name')</th>
                        <th>@lang('admin.sort-order')</th>
                        <th>@lang('admin.actions')</th>
                    </tr>
                    @foreach($categories as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->sort_order }}</td>
                            <td>
                                <a href="{{ url('/admin/categories/' . $item->id) }}" title="@lang('admin.view') @lang('admin.category')"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('admin.view')</button></a>
                                <a href="{{ url('/admin/categories/' . $item->id . '/edit') }}" title="@lang('admin.edit') @lang('admin.category')"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> @lang('admin.edit')</button></a>

                                <form method="POST" action="{{ url('/admin/categories' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="@lang('admin.delete') @lang('admin.category')" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('admin.delete')</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody></table>
            </div>
            <div class="custom-pagination">
                {!! $categories->appends(['search' => Request::get('search')])->render() !!}
            </div>
        </div>
    </div>










@endsection
