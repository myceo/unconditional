@extends('layouts.member')
@section('pageTitle',__('admin.announcements'))
@section('innerTitle')
@lang('admin.announcements')
@if(Request::get('search'))
    : {{ Request::get('search') }}
@endif
@endsection



@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.announcements')</span>
    </li>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            @can('administer')
            <h4>  <a class="btn btn-primary"  title="@lang('site.create-new') announcement" href="{{ url('/member/announcements/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> @lang('site.add-new')</a>
            </h4>
            @endcan

            <div class="card-header-form">
                <form method="GET" action="{{ url('/member/announcements') }}" >
                    <div class="input-group">
                        <input type="text" class="form-control"  name="search" value="{{ request('search') }}" placeholder="{{ ucfirst(__('site.search')) }}">
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>





    @foreach($announcements as $item)

        <article class="article article-style-c">

            <div class="article-details">
                <div class="article-category"><a href="#">{{ \Illuminate\Support\Carbon::parse($item->created_at)->format('d.M.Y') }}</a> <div class="bullet"></div> <a href="#">{{ \Illuminate\Support\Carbon::parse($item->created_at)->diffForHumans() }}</a>
                @if($item->pinned==1)

                   <h5 class=" float-right "><i class="fa fa-thumbtack text-primary"></i></h5>
                @endif
                    @if($item->enable_comments==1 || $item->announcementComments()->count() > 0)
                    <a href="{{ route('member.announcement-comments.index',['announcement'=>$item->id]) }}" class="btn btn-info btn-sm btn-rounded float-right text-white mr-3">
                        <i class="fa fa-comments"></i> @lang('admin.comments') ({{ $item->announcementComments()->count() }})
                    </a>
                    @endif
                </div>
                <div class="article-title">
                    <h2><a href="#">{{ $item->title }}</a></h2>
                </div>
                <p>{!! clean(($item->content)) !!} </p>
                <div class="article-user">
                    <img alt="image" src="{{ profilePicture($item->user_id) }}">
                    <div class="article-user-details">
                        <div class="user-detail-name">
                            <a href="{{ url('/member/members/'.$item->user_id) }}">{{ $item->user->name }}</a>
                        </div>
                        @if($item->user->can('administer'))
                        <div class="text-job">@lang('admin.admin')</div>
                            @endif
                    </div>
                </div>
                @can('administer')
                    <div  class="text-right">
                        <a href="{{ url('/member/announcements/' . $item->id) }}" title="@lang('site.view')"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('site.view')</button></a>
                        <a href="{{ url('/member/announcements/' . $item->id . '/edit') }}" title="@lang('site.edit')"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('site.edit')</button></a>

                        <form method="POST" action="{{ url('/member/announcements' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete')" onclick="return confirm('@lang('site.confirm-delete')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('site.delete')</button>
                        </form>
                        <a class="btn btn-info btn-sm" href="{{ route('member.annoucements.pinned',['announcement'=>$item,'pinned'=>($item->pinned==1?0:1)]) }}"><i class="fa fa-thumbtack"></i> {{ $item->pinned==1? __('admin.unpin'):__('admin.pin') }}</a>

                    </div>
                @endcan
            </div>
        </article>



    @endforeach

    <div class="blog-details-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="custom-pagination">
                        {!! $announcements->appends(['search' => Request::get('search')])->render() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>



@endsection
