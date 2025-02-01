@extends('layouts.admin')

@section('pageTitle',__('admin.departments'))
@section('innerTitle')
@lang('admin.departments') @if(Request::get('search'))
    : {{ Request::get('search') }}
@endif
@endsection
@section('titleForm-')

    <form id="nav-search" method="GET" action="{{ url('/admin/groups') }}" role="search" class="form-inline mr-auto">
        <input name="search" value="{{ request('search') }}" type="text" placeholder="{{ ucfirst(__('site.search')) }}..." class="search-int form-control">
        <a onClick="$('#nav-search').submit()" href="#"><i class="fa fa-search"></i></a>
        <input type="hidden" name="category" value="{{ request('category') }}"/>
    </form>
@endsection
@section('t-form-action')
    action="{{ url('/admin/groups') }}"
@endsection
@section('t-form-placeholder')
    placeholder="{{ ucfirst(__('site.search')) }} {{ __('admin.departments') }}"
@endsection
@section('t-form-extra')
    <input type="hidden" name="category" value="{{ request('category') }}"/>
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.departments')</span>
    </li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>    <a class="btn btn-primary" title="@lang('site.create-new')  @lang('site.department')" href="{{ url('/admin/groups/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a>
            </h4>
            <div class="card-header-form">
                <form class="form-inline" method="GET" action="{{ url('/admin/groups') }}" >
                    <input type="hidden" name="search" value="{{ request('search') }}"/>
                    <div class="form-group">
                        <select style="max-width: 300px" class="form-control" name="category" id="category">
                            <option value="">@lang('admin.all-categories')</option>
                            @foreach(\App\Category::orderBy('name')->get() as $category)
                                <option @if(request('category')==$category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">@lang('site.filter')</button>
                    </div>

                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody><tr>
                        <th>#</th>
                        <th>@lang('site.name')</th>
                        <th>@lang('admin.members')</th>
                        <th>@lang('site.enroll-open')</th>
                        <th>@lang('admin.status')</th>
                        <th>@lang('admin.visibility')</th>
                        <th>@lang('site.actions')</th>
                    </tr>
                    @foreach($departments as $item)
                    <tr>
                        <td class="p-0 text-center">
                            {{ $loop->iteration }}
                        </td>
                        <td>{{ $item->name }}</td>
                        <td class="align-middle">
                            {{ $item->users()->count() }}
                        </td>
                        <td>
                            {{ boolToString($item->enroll_open) }}
                        </td>
                        <td>
                            @if($item->enabled==1)
                                @lang('admin.enabled')
                            @else
                                @lang('admin.disabled')
                            @endif
                        </td>
                        <td>
                            @if($item->visible==1)

                                <div class="badge badge-success">@lang('admin.public')</div>
                            @else

                                <div class="badge badge-danger">@lang('admin.private')</div>
                            @endif



                        </td>
                        <td>
                            <div class="btn-group mb-2">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fa fa-cogs"></i>  @lang('admin.actions')
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('dept.members',['department'=>$item->id]) }}">@lang('admin.manage-members')</a>
                                    <a class="dropdown-item" href="{{ url('/admin/groups/' . $item->id) }}">@lang('site.view')</a>
                                    <a class="dropdown-item" href="{{ url('/admin/groups/' . $item->id . '/edit') }}">@lang('site.edit')</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" onclick="$('#delete-{{ $item->id }}').submit()">@lang('site.delete')</a>
                                </div>
                               &nbsp; <a class="btn btn-info btn-sm" href="{{ route('site.department-login',['department'=>$item->id]) }}"><i class="fas fa-sign-in-alt"></i> @lang('site.login')</a>

                            </div>

                            <form id="delete-{{ $item->id }}" onsubmit="return confirm('@lang('admin.delete-prompt')')" method="POST" action="{{ url('/admin/groups' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                             </form>


                        </td>
                    </tr>
                    @endforeach

                    </tbody></table>

            </div>
            <nav class="d-inline-block">
                {!! $departments->appends(['search' => Request::get('search'),'category'=>Request::get('category')])->render() !!}

            </nav>
        </div>
    </div>












@endsection
