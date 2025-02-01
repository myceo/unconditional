@extends('layouts.admin')
@section('pageTitle',__('admin.fields'))



@section('t-form-action')
    action="{{ url('/admin/fields') }}"
@endsection

@section('innerTitle')
    @lang('admin.member-fields')
    @if(Request::get('search'))
        : {{ Request::get('search') }}
    @endif
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.member-fields')</span>
    </li>
@endsection

@section('content')
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap">

                        <div class="card">
                         <div class="card-header">
                             <a class="btn btn-primary"  title="@lang('site.create-new') @lang('admin.field')" href="{{ url('/admin/fields/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a>

                         </div>
                        <div class="card-body">
                            <div class="asset-inner">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th><th>@lang('admin.name')</th><th>@lang('admin.type')</th><th>@lang('admin.sort-order')</th>
                                        <th>@lang('admin.enabled')</th>
                                        <th>@lang('admin.public')</th>
                                        <th>@lang('site.actions')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($fields as $item)
                                        <tr>
                                            <td>{{  $item->id }}</td>
                                            <td>{{ $item->name }}</td><td>{{ $item->type }}</td><td>{{ $item->sort_order }}</td>
                                            <td>{{ boolToString($item->enabled) }}</td>
                                            <td>{{ boolToString($item->public) }}</td>
                                            <td>
                                                <a href="{{ url('/admin/fields/' . $item->id) }}" title="@lang('site.view') field"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('site.view')</button></a>
                                                <a href="{{ url('/admin/fields/' . $item->id . '/edit') }}" title="@lang('site.edit') field"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> @lang('site.edit')</button></a>

                                                <form method="POST" action="{{ url('/admin/fields' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete') field" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('site.delete')</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                            <div class="card-footer">
                                {!! $fields->appends(['search' => Request::get('search')])->render() !!}
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
