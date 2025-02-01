@extends('layouts.member')
@section('pageTitle',__('site.applications'))
@section('innerTitle')
    @lang('site.applications')@if(Request::get('search'))
        : {{ Request::get('search') }}
    @endif
@endsection
@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.applications')</span>
    </li>
@endsection

@section('titleForm_')
    <form id="nav-search" method="GET" action="{{ route('member.members.applications') }}" role="search" class="sr-input-func">
        <input name="search" value="{{ request('search') }}" type="text" placeholder="{{ ucfirst(__('site.search')) }}..." class="search-int form-control">
        <a onClick="$('#nav-search').submit()" href="#"><i class="fa fa-search"></i></a>
        <input type="hidden" name="status" value="{{ request('status') }}"/>
    </form>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>
                <form class="form-inline" method="GET" action="{{ route('member.members.applications') }}" >
                    <input type="hidden" name="search" value="{{ request('search') }}"/>
                    <div class="form-group">
                        <select style="max-width: 300px" class="form-control" name="status" id="status">
                            <option value="">@lang('admin.view-all')</option>
                            @foreach(['p'=>__('site.pending'),'a'=>__('site.approved'),'d'=>__('site.denied')] as $key=>$status)
                                <option @if(request('status')==$key) selected @endif value="{{ $key }}">{{ $status }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> @lang('site.filter')</button>
                    </div>

                </form>
            </h4>
            <div class="card-header-form">
                <form method="GET" action="{{ route('member.members.applications') }}" >
                    <div class="input-group">
                        <input name="search" value="{{ request('search') }}" type="text" class="form-control" placeholder="{{ ucfirst(__('site.search')) }}..." >
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody><tr>
                        <th>@lang('admin.date')</th>
                        <th>@lang('admin.name')</th>
                        <th>@lang('admin.picture')</th>
                        <th>@lang('admin.gender')</th>
                        <th>@lang('admin.email')</th>
                        <th>@lang('admin.status')</th>
                        <th>@lang('site.actions')</th>
                    </tr>
                    @foreach($applications as $application)
                    <tr>
                        <td>{{ \Illuminate\Support\Carbon::parse($application->created_at)->format('d/M/Y') }}</td>
                        <td>{{ $application->user->name }}</td>
                        <td>
                            <img alt="image" src="{{ profilePicture($application->user_id) }}" class="rounded-circle" data-toggle="tooltip" title="" data-original-title="Wildan Ahdian" width="35">
                        </td>
                        <td>{{ gender($application->user->gender) }}</td>
                        <td>{{ $application->user->email }}</td>
                        <td>
                            @if($application->status=='p')
                                @lang('site.pending')
                            @elseif($application->status=='a')
                                @lang('site.approved')
                            @elseif($application->status=='d')
                                @lang('site.denied')
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('member.members.application',['application'=>$application->id]) }}"><i class="fa fa-info-circle"></i> @lang('admin.details')</a>
                        </td>
                    </tr>
                    @endforeach

              </tbody></table>
            </div>
            {!! $applications->appends(['search' => Request::get('search'),'status'=>Request::get('status')])->render() !!}

        </div>
    </div>



@endsection
