@extends('layouts.member')
@section('pageTitle',__('admin.forum-topics'))

@section('innerTitle')
    @lang('admin.forum-topics')
    @if(Request::get('search'))
        : {{ Request::get('search') }}
    @endif
@endsection

@section('titleForm_')
    <form id="nav-search" method="GET" action="{{ url('/member/forum-topics') }}" role="search" class="sr-input-func">
        <input name="search" value="{{ request('search') }}" type="text" placeholder="{{ ucfirst(__('site.search')) }}..." class="search-int form-control">
        <a onClick="$('#nav-search').submit()" href="#"><i class="fa fa-search"></i></a>
    </form>
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.forum-topics')</span>
    </li>
@endsection

@section('content')


    <div class="card">
        <div class="card-header">
            @can('dept_allows','allow_members_create_topics')
            <h4><a  class="btn btn-primary" title="@lang('site.create-new') forumTopic" href="{{ url('/member/forum-topics/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a></h4>
            @endcan
            <div class="card-header-form">
                <form  method="GET" action="{{ url('/member/forum-topics') }}">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}"  class="form-control" placeholder="{{ ucfirst(__('site.search')) }}...">
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <ul class="list-unstyled list-unstyled-border">
                @foreach($forumtopics as $item)
                    <li class="media">

                        <img class="mr-3 rounded-circle" src="{{ profilePicture($item->user_id) }}" alt="avatar" width="50">
                        <div class="media-body">
                            @if(isDeptAdmin(\Illuminate\Support\Facades\Auth::user()))
                            <a class="btn btn-success btn-sm float-right btn-round ml-1" href="{{ route('member.forum.pinned',['forumTopic'=>$item->id,'pinned'=>($item->pinned==1?0:1)]) }}"  ><i class="fa fa-thumbtack"></i> {{ $item->pinned==1? __('admin.unpin'):__('admin.pin') }}</a>
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::user()->id==$item->user_id || isDeptAdmin(\Illuminate\Support\Facades\Auth::user()))

                                    @if($item->enabled==1)
                                        <a class="btn btn-dark btn-sm float-right btn-round ml-1" href="{{ route('member.forum.status',['forumTopic'=>$item->id,'status'=>0]) }}"  ><i class="fa fa-stop"></i> @lang('admin.close')</a>
                                    @elseif($item->enabled==0 && isDeptAdmin(\Illuminate\Support\Facades\Auth::user()))
                                        <a class="btn btn-warning btn-sm float-right btn-round ml-1" href="{{ route('member.forum.status',['forumTopic'=>$item->id,'status'=>1]) }}"  ><i class="fa fa-play"></i> @lang('admin.open')</a>
                                    @endif


                                    <form method="POST" action="{{ url('/member/forum-topics' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm float-right btn-round " title="@lang('site.delete')" onclick="return confirm('@lang('site.confirm-delete')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('site.delete')</button>
                                </form>


                                @endif
                            <a class="btn btn-info btn-sm float-right btn-round mr-1" href="{{ url('/member/forum-topics/' . $item->id) }}" title="@lang('site.view')"><i class="fa fa-eye" aria-hidden="true"></i> @lang('site.view')</a>


                            <h6 class="media-title"><a href="{{ url('/member/forum-topics/' . $item->id) }}">{{ $item->topic }}</a> @if($item->pinned==1) <i class="fa fa-thumbtack text-primary ml-2"></i> @endif</h6>
                            <div class="text-small text-muted">{{ $item->user->name }} <div class="bullet"></div> <span class="text-primary">{{ \Illuminate\Support\Carbon::parse($item->crated_at)->format('D, M d, Y') }}</span> <div class="bullet"></div>  <span class="text-primary">{{ $item->forumThreads()->count() -1 }} {{ strtolower(__('admin.replies')) }} </span>
                                @if(empty($item->enabled))
                                    <div class="bullet"></div> <span class="text-danger">@lang('admin.closed')</span>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="custom-pagination">
                {!! $forumtopics->appends(['search' => Request::get('search')])->render() !!}
            </div>
        </div>
    </div>



    @if(false)
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap">
                        <h4>@lang('admin.forum-topics')
                        @if(Request::get('search'))
                             : {{ Request::get('search') }}
                            @endif
                        </h4>
                        @can('dept_allows','allow_members_create_topics')
                        <div class="add-product">
                            <a  title="@lang('site.create-new') forumTopic" href="{{ url('/member/forum-topics/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a>
                        </div>
                        @endcan
                        <div class="asset-inner">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>@lang('admin.added-on')</th><th>@lang('admin.topic')</th><th>@lang('admin.created-by')</th>  <th>@lang('admin.replies')</th> <th>@lang('site.actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($forumtopics as $item)
                                    <tr>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('D d/M/Y') }}
                                        </td>
                                        <td><a href="{{ url('/member/forum-topics/' . $item->id) }}">{{ $item->topic }}</a></td><td >
                                            {{ $item->user->name }}</td>

                                        <td>
                                            {{ $item->forumThreads()->count() -1 }}
                                        </td>
                                        <td>
                                            <a href="{{ url('/member/forum-topics/' . $item->id) }}" title="@lang('site.view')"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('site.view')</button></a>

                                            @if(\Illuminate\Support\Facades\Auth::user()->id==$item->user_id || isDeptAdmin(\Illuminate\Support\Facades\Auth::user()))
                                            <form method="POST" action="{{ url('/member/forum-topics' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete')" onclick="return confirm('@lang('site.confirm-delete')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('site.delete')</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="custom-pagination">
                            {!! $forumtopics->appends(['search' => Request::get('search')])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
