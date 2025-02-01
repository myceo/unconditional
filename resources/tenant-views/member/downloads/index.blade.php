@extends('layouts.member')
@section('pageTitle',$title)
@section('innerTitle')
    {{ $title }}
    @if(Request::get('search'))
        : {{ Request::get('search') }}
    @endif
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.downloads')</span>
    </li>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h4> <a class="btn btn-primary"  title="@lang('site.create-new') @lang('site.download')" href="{{ url('/member/downloads/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a></h4>
            <div class="card-header-form">
                <form  method="GET" action="{{ $route }}" >
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
                        <th>@lang('admin.added-on')</th>

                        @if($creator)
                        <th>@lang('admin.created-by')</th>

                        @endif


                        <th>@lang('admin.files')</th>
                        <th>@lang('site.actions')</th>
                    </tr>
                    @foreach($downloads as $item)
                    <tr>
                        <td>{{ $item->name }}
                            @if($item->pinned==1)
                                <i class="fa fa-thumbtack text-primary ml-1"></i>
                            @endif
                        </td>
                        <td>{{  \Carbon\Carbon::parse($item->created_at)->format('d/M/Y') }}</td>
                        @if($creator)
                        <td>

                            <div class="row">
                                <div class="col-sm-2"><img alt="image" src="{{ profilePicture($item->user_id) }}" class="rounded-circle" data-toggle="tooltip" title="" data-original-title="{{ $item->user->name }}" width="35">
                                </div>
                                <div class="col-sm-10">{{ $item->user->name }}</div>
                            </div>
                        </td>

                        @endif


                        <td>{{ $item->downloadFiles()->count() }}</td>
                        <td>
                            @if(false)
                            <a class="btn btn-success btn-sm" href="{{ route('member.download.download-attachments',['download'=>$item->id]) }}"><i class="fa fa-download"></i> @lang('admin.download')</a>
                            <a href="{{ url('/member/downloads/' . $item->id) }}" title="@lang('site.view') download"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('site.view')</button></a>

                            @if($manage)
                                <a href="{{ url('/member/downloads/' . $item->id . '/edit') }}" title="@lang('site.edit') download"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('site.edit')</button></a>

                                <form   method="POST" action="{{ url('/member/downloads' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete') download" onclick="return confirm('@lang('site.confirm-delete')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('site.delete')</button>
                                </form>
                            @endif
                            @endif

                            <form onsubmit="return confirm('@lang('site.confirm-delete')')" id="{{ 'delete_'.$item->id }}"  method="POST" action="{{ url('/member/downloads' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}

                            </form>

                             <div class="dropdown d-inline mr-2">
                                                   <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                     @lang('admin.actions')
                                                   </button>
                                                   <div class="dropdown-menu">
                                                     <a class="dropdown-item" href="{{ route('member.download.download-attachments',['download'=>$item->id]) }}"><i class="fa fa-download"></i> @lang('admin.download')</a>
                                                     <a class="dropdown-item" href="{{ url('/member/downloads/' . $item->id) }}"><i class="fa fa-eye"></i> @lang('site.view')</a>
                                                       @if($manage)
                                                       <a class="dropdown-item" href="{{ url('/member/downloads/' . $item->id . '/edit') }}"><i class="fa fa-edit" aria-hidden="true"></i> @lang('site.edit')</a>
                                                       <a onclick="$('#delete_{{ $item->id }}').submit()" class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> @lang('site.delete')</a>
                                                       @endif
                                                       @can('administer')
                                                       <a class="dropdown-item"   href="{{ route('member.download.pinned',['download'=>$item,'pinned'=>($item->pinned==1?0:1)]) }}"><i class="fa fa-thumbtack"></i> {{ $item->pinned==1? __('admin.unpin'):__('admin.pin') }}</a>
                                                        @endcan
                                                   </div>
                                                 </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody></table>
            </div>
            <div class="custom-pagination">
                {!! $downloads->appends(['search' => Request::get('search')])->render() !!}
            </div>
        </div>
    </div>

@endsection
