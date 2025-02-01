@extends('layouts.admin')
@section('pageTitle',__('admin.admin-dashboard'))
@section('innerTitle',__('admin.admin-dashboard'))

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ url('admin/groups') }}">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fa fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>@lang('admin.departments')</h4>
                    </div>
                    <div class="card-body">
                        {{ $departments }}
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ url('admin/members') }}">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fa fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>@lang('admin.members')</h4>
                    </div>
                    <div class="card-body">
                        {{ $members }}
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ url('admin/admins') }}">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fa fa-user-secret"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>@lang('admin.administrators')</h4>
                    </div>
                    <div class="card-body">
                        {{ $admins }}
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ url('admin/emails') }}">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>@lang('admin.messages')</h4>
                    </div>
                    <div class="card-body">
                        {{ $messages }}
                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="d-inline">@lang('admin.new-members')</h4>
                    <div class="card-header-action">
                        <a href="{{ url('admin/members') }}" class="btn btn-primary">@lang('admin.view-all')</a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border">
                        @foreach($newMembers as $item)
                        <li class="media">
                            @if(!empty($item->picture))
                                <img src="{{ asset($item->picture) }}"  class="mr-3 rounded-circle" width="50"  />
                            @else
                                <img src="{{ avatar($item->gender) }}"  class="mr-3 rounded-circle"   width="50"  />
                            @endif

                            <div class="media-body">


                                    <div class="btn-group mb-2 float-right">
                                        <button class="btn  btn-danger  btn-sm dropdown-toggle rounded-btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @lang('admin.actions')
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ url('/admin/members/' . $item->id) }}">@lang('admin.details')</a>
                                            <a class="dropdown-item" href="{{ url('/admin/members/' . $item->id . '/edit') }}">@lang('site.edit')</a>
                                            <a class="dropdown-item" href="{{ url('admin/emails/create') }}?user={{ $item->id }}">@lang('admin.email')</a>
                                            <a class="dropdown-item" href="{{ url('admin/sms/create') }}?user={{ $item->id }}">@lang('admin.sms')</a>
                                        </div>
                                    </div>





                                <h6 class="media-title"><a href="{{ url('/admin/members/' . $item->id) }}">{{ $item->name }}</a></h6>
                                <div class="text-small text-muted">{{ gender($item->gender) }} <div class="bullet"></div> <span class="text-primary">{{ $item->created_at->diffForHumans() }}</span></div>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">

            <div class="card">
                <div class="card-header">
                    <h4>@lang('admin.recent-messages')</h4>
                    <div class="card-header-action">
                        <a href="{{ url('admin/emails') }}" class="btn btn-primary">@lang('admin.view-all')</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th>@lang('admin.subject')</th>
                                <th>@lang('admin.sender')</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($emails as $item)
                            <tr>
                                <td  onclick="document.location.replace('{{ route('email.view-inbox',['email'=>$item->id]) }}')" >
                                    {{ $item->subject }}  @if($item->emailAttachments()->count()>0)
                                        <i class="fa fa-paperclip"></i>
                                    @endif
                                    <div class="table-links">
                                        {{ \Illuminate\Support\Carbon::parse($item->crated_at)->format('D, M d, Y') }}
                                        <div class="bullet"></div>
                                        <a href="{{ route('email.view-inbox',['email'=>$item->id]) }}">@lang('site.view')</a>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('email.view-inbox',['email'=>$item->id]) }}" class="font-weight-600">
                                        @if(!empty($item->user->picture))
                                            <img src="{{ asset($item->user->picture) }}"  width="30" class="rounded-circle mr-1"  />
                                        @else
                                            <img src="{{ avatar($item->user->gender) }}"  width="30" class="rounded-circle mr-1"  />
                                        @endif

                                            {{ $item->user->name }}</a>
                                </td>
                                <td>
                                      <a    class="btn btn-danger btn-action" data-toggle="tooltip" title="@lang('site.delete')" data-confirm="@lang('admin.delete-prompt')" data-confirm-yes="document.location.replace('{{ route('email.delete-inbox',['id'=>$item->id]) }}')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@if(request()->has('wizard'))


@section('footer')
    <div class="modal fade" tabindex="-1" role="dialog" id="welcomeModal">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">

                    <h5 class="modal-title">@lang('admin.welcome-header',['name'=>env('APP_NAME')])</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <p class="mb-0">@lang('admin.welcome-text-1',['name'=>env('app_name')])</p>
                      <p class="mb-0">@lang('admin.welcome-text-2',['url'=>'<a href="'.url('').'" >'.url('').'</a>'])</p>
                      <p class="mb-0">@lang('admin.welcome-text-3',['url'=>'<a href="'.env('APP_URL').'/apps" >'.env('APP_URL').'/apps</a>'])</p>
                      <p class="mb-0">@lang('admin.welcome-text-4',['username'=>'<strong>'.getUsernameFromFQDN(url('')).'</strong>'])</p>
                      <div class="row mb-3 mt-3">

                          <div class="col-md-2 offset-md-3 mb-3 text-center">
                              <a target="_blank"  href="{{ env('PLAY_URL') }}"><img src="{{ asset('themes/bluetec/images/misc/download-playstore.png') }}" ></a>

                          </div>
                          <div class="col-md-2 offset-md-1  text-center">
                              <a  target="_blank"   href="{{ env('APPLE_URL') }}"><img src="{{ asset('themes/bluetec/images/misc/download-appstore.png') }}" ></a>&nbsp;
                          </div>
                      </div>

                  </div>
                  <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('admin.close')</button>
                  </div>
                </div>
              </div>
            </div>
    <script>
        $('#welcomeModal').modal();
    </script>
@endsection
@endif
