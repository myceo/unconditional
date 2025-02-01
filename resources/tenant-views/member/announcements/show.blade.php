@extends('layouts.member')
@section('pageTitle',__('admin.announcements'))

@section('innerTitle')
     @lang('admin.announcement') : {{ $announcement->title }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/member/announcements') }}">@lang('admin.announcements')</a>
    </li>
    <li><span>@lang('admin.announcement')</span>
    </li>
@endsection

@section('content')




    @can('administer')
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('/member/announcements') }}" title="@lang('admin.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('admin.back')</button></a>
                  &nbsp;  <a href="{{ url('/member/announcements/' . $announcement->id . '/edit') }}" title="@lang('admin.edit') announcement"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('admin.edit')</button></a>
                    &nbsp;
                    <form method="POST" action="{{ url('member/announcements' . '/' . $announcement->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm" title="@lang('admin.delete') announcement" onclick="return confirm('@lang('site.confirm-delete')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('admin.delete')</button>
                    </form>
                </div>
            </div>
    @endcan



            <article class="article article-style-c">

                <div class="article-details">
                    <div class="article-category"><a href="#">{{ \Illuminate\Support\Carbon::parse($announcement->created_at)->format('d.M.Y') }}</a> <div class="bullet"></div> <a href="#">{{ \Illuminate\Support\Carbon::parse($announcement->created_at)->diffForHumans() }}</a>
                        <a href="{{ route('member.announcement-comments.index',['announcement'=>$announcement->id]) }}" class="btn btn-info btn-sm btn-rounded float-right text-white">
                            <i class="fa fa-comments"></i> @lang('admin.comments') ({{ $announcement->announcementComments()->count() }})
                        </a>
                    </div>
                    <div class="article-title">
                        <h2><a href="#">{{ $announcement->title }}</a></h2>

                    </div>
                    <p>{!! clean(($announcement->content)) !!} </p>
                    <div class="article-user">
                        <img alt="image" src="{{ profilePicture($announcement->user_id) }}">
                        <div class="article-user-details">
                            <div class="user-detail-name">
                                <a href="{{ url('/member/members/'.$announcement->user_id) }}">{{ $announcement->user->name }}</a>
                            </div>
                            @if($announcement->user->can('administer'))
                                <div class="text-job">@lang('admin.admin')</div>
                            @endif
                        </div>
                    </div>

                </div>
            </article>


@endsection
