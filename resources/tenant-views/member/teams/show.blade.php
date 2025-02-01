@extends('layouts.member')
@section('pageTitle','Teams')

@section('innerTitle')
     @lang('admin.team') : {{ $team->name }}
@endsection

@section('breadcrumb')

    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    @can('adminster')
    <li><a href="{{ url('/member/teams') }}">@lang('admin.teams')</a>
    </li>
    @else
        <li><a href="{{ url('/member/teams/my-teams') }}">@lang('admin.my-teams')</a>
        </li>
    @endcan
    <li><span>@lang('admin.view') @lang('admin.team')</span>
    </li>
@endsection

@section('content')


            <div class="card">
                <div class="card-header">
                    @can('administer')
                        <a href="{{ url('/member/teams') }}" title="@lang('admin.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('admin.back')</button></a>
                        &nbsp;
                        <a href="{{ url('/member/teams/' . $team->id . '/edit') }}" title="@lang('admin.edit') team"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('admin.edit')</button></a>
                        &nbsp;
                        <form method="POST" action="{{ url('member/teams' . '/' . $team->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="@lang('admin.delete') team" onclick="return confirm('@lang('site.confirm-delete')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('admin.delete')</button>
                        </form>
                    @endcan

                    @cannot('administer')
                        <a href="{{ url('/member/teams/my-teams') }}" title="@lang('admin.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('admin.back')</button></a>

                    @endcannot
                </div>
                <div class="card-body">




                           <div class="row mb-5">
                                    @foreach($team->users as $item)
                                   <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 mb-5">

                                       <div class="user-item">
                                           @if(!empty($item->picture))
                                               <img src="{{ asset($item->picture) }}" class="img-fluid" />
                                           @else
                                               <img src="{{ avatar($item->gender) }}" class="img-fluid"   />
                                           @endif
                                           <div class="user-details">
                                               <div class="user-name">{{ $item->name }}
                                                   @if($item->pivot->department_admin==1)
                                                       <span style="color: green">(@lang('admin.admin'))</span>
                                                   @endif</div>
                                               <div class="text-job text-muted">{{ gender($item->gender) }}</div>
                                               <div class="user-cta">

                                                   <div class="btn-group mb-2">
                                                       <button class="btn btn-primary  dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                           <i class="fa fa-cogs" aria-hidden="true"></i>    @lang('admin.actions')
                                                       </button>
                                                       <div class="dropdown-menu">
                                                           <a class="dropdown-item" href="{{ url('/member/members/' . $item->id) }}">@lang('admin.details')</a>
                                                           <a class="dropdown-item" href="{{ url('member/emails/create') }}?user={{ $item->id }}">@lang('site.send') @lang('admin.email')</a>
                                                           @can('administer')
                                                               <a class="dropdown-item" href="{{ url('member/sms/create') }}?user={{ $item->id }}" >@lang('site.send') @lang('admin.sms')</a>

                                                           @endcan


                                                       </div>
                                                   </div>

                                               </div>
                                           </div>
                                       </div>


                                   </div>

                                        @if(false)
                                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                            <div class="student-inner-std res-mg-b-30">
                                                <div class="student-img imgv-box" style="height: 259px; overflow: hidden">
                                                    @if(!empty($item->picture))
                                                        <img src="{{ asset($item->picture) }}" class="img-fluid imgv" />
                                                    @else
                                                        <img src="{{ avatar($item->gender) }}" class="img-fluid imgv"   />
                                                    @endif
                                                </div>
                                                <div class="student-dtl">

                                                    <h2>
                                                        <div  class="i-checks " >
                                                            <label>
                                                                {{ $item->name }}


                                                            </label>
                                                        </div>
                                                    </h2>

                                                    <p class="dp">{{ gender($item->gender) }}</p>
                                                    <p class="dp-ag">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-cogs" aria-hidden="true"></i>    @lang('admin.actions') <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu">

                                                            <li><a href="{{ url('/member/members/' . $item->id) }}">@lang('admin.details')</a></li>
                                                            <li><a href="{{ url('member/emails/create') }}?user={{ $item->id }}">@lang('admin.email')</a></li>
                                                            @can('administer')
                                                            <li> <a href="{{ url('member/sms/create') }}?user={{ $item->id }}" >@lang('admin.sms')</a></li>
                                                            @endcan
                                                        </ul>
                                                    </div>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>




                </div>
            </div>



@endsection
