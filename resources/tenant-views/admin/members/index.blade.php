@extends('layouts.admin')
@section('pageTitle',__('admin.members'))

@section('innerTitle')
    @if($deptName) {{ $deptName }} @endif @lang('admin.members') ({{ $count }}) @if(Request::get('search'))
        : {{ Request::get('search') }}
    @endif
@endsection

@section('t-form-action')
    action="{{ url('/admin/members') }}"
@endsection

@section('t-form-extra')
    <input type="hidden" name="department" value="{{ request('department') }}"/>
@endsection


@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.members')</span>
    </li>
@endsection

@section('content')


    <div class="card">
        <div class="card-header">
            <h4>
                <form class="form-inline" method="POST" action="{{ route('members.export') }}" >
                    <a class="btn btn-primary float-right" title="@lang('site.create-new')  @lang('site.member')" href="{{ url('/admin/members/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a>
                   &nbsp;
                    @csrf
                    <input name="search" value="{{ request('search') }}" type="hidden"  >
                    <button class="btn btn-success"><i class="fa fa-download"></i> @lang('admin.export')</button>
                    <input type="hidden" name="department" value="{{ request('department') }}"/>
                </form>
            </h4>
            <div class="card-header-form">
                <div class="row">
                    <div class="col-md-8">
                        <form id="filterForm" method="GET" action="{{ url('/admin/members') }}" >
                            <input type="hidden" name="search" value="{{ request('search') }}"/>
                            <select style="max-width: 300px" class="form-control" name="department" id="department">
                                <option value="">@lang('admin.all-departments')</option>
                                @foreach(\App\Department::orderBy('name')->get() as $department)
                                    <option @if(request('department')==$department->id) selected @endif value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>


                        </form>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" form="filterForm" class="btn btn-primary">@lang('admin.filter')</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody><tr>
                        <th>#</th>
                        <th>@lang('admin.name')</th>
                        <th>@lang('admin.picture')</th>
                        <th>@lang('admin.email')</th>
                        <th>@lang('admin.status')</th>
                        <th>@lang('site.actions')</th>
                    </tr>
                    @foreach($members as $item)
                    <tr>
                        <td class="p-0 text-center">{{ $item->id }} </td>
                        <td><a  class="dropdown-item" href="{{ url('/admin/members/' . $item->id) }}" title="@lang('site.view') @lang('admin.member')">{{ $item->name }}</a></td>
                        <td>
                            <a href="{{ url('/admin/members/' . $item->id) }}">
                            @if(!empty($item->picture))

                                <img alt="image" src="{{ asset($item->picture) }}" class="rounded-circle" data-toggle="tooltip" title="" data-original-title="{{ $item->name }}" width="35">

                            @else
                                    <img alt="image" src="{{ avatar($item->gender) }}" class="rounded-circle" data-toggle="tooltip" title="" data-original-title="{{ $item->name }}" width="35">

                                @endif
                                </a>


                        </td>
                        <td>
                            {{ $item->email }}
                        </td>
                        <td>     @if($item->status==1)
                                @lang('admin.enabled')
                            @else
                                @lang('admin.disabled')
                            @endif
                        </td>
                        <td>

                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-cogs" aria-hidden="true"></i>    @lang('admin.actions') <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">

                                    <li><a  class="dropdown-item" href="{{ url('/admin/members/' . $item->id) }}" title="@lang('site.view') @lang('admin.member')">@lang('site.view')</a></li>
                                    <li> <a class="dropdown-item" href="{{ url('/admin/members/' . $item->id . '/edit') }}" title="@lang('site.edit') @lang('admin.member')">@lang('site.edit')</a></li>

                                </ul>
                            </div>




                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>    @lang('admin.contact') <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">

                                    <li><a class="dropdown-item"  href="{{ url('admin/emails/create') }}?user={{ $item->id }}" >@lang('admin.email')</a></li>
                                    <li> <a class="dropdown-item"  href="{{ url('admin/sms/create') }}?user={{ $item->id }}" >@lang('admin.sms')</a></li>
                                </ul>
                            </div>
                            @if(empty($item->is_billing))
                            <form method="POST" action="{{ url('/admin/members' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete') @lang('admin.member')" onclick="return confirm(&quot;@lang('admin.delete-prompt')&quot;)"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                            </form>
                             @endif


                        </td>
                    </tr>
                    @endforeach
                    </tbody></table>
            </div>
            <div class="custom-pagination">
                {!! $members->appends(['search' => Request::get('search')])->render() !!}
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

