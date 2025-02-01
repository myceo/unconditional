@extends('layouts.member')
@section('pageTitle',__('admin.sent-sms'))
@section('innerTitle')
    @lang('admin.sent-sms')     @if(Request::get('search'))
        : {{ Request::get('search') }}
    @endif
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.sent-sms')</span>
    </li>
@endsection


@section('content')



    <div class="card">
        <div class="card-header">
            <h4><div class="btn-group" role="group"  >
                    <button  onclick="document.location.replace('{{ selfURL() }}')" type="button" class="btn btn-primary note-btn"><i class="fas fa-sync-alt"></i> @lang('admin.refresh')</button>
                    <button onclick="$('#msg-list').submit()" type="button" class="btn btn-danger note-btn"><i class="fa fa-trash"></i></button>
                    <button type="button" class="check btn btn-info note-btn"><i class="fa fa-check"></i></button>
                </div></h4>
            <div class="card-header-form">
                <form  method="GET" action="{{ url('/member/sms') }}" >
                    <div class="input-group">
                        <input name="search" value="{{ request('search') }}" type="text" class="form-control" placeholder="@lang('admin.search-sent')">
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <form id="msg-list" action="{{ route('member.sms.delete-multiple') }}" onsubmit="return confirm('@lang('admin.delete-prompt')')" method="post">
            @csrf
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody><tr>
                            <th class="text-center">
                                <div class="custom-checkbox custom-control">
                                    <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                </div>
                            </th>
                            <th>@lang('admin.recipients')</th>
                            <th>@lang('admin.message')</th>
                            <th>@lang('admin.date')</th>
                            <th></th>
                        </tr>
                        @foreach($sms as $item)
                            <tr>
                                <td class="p-0 text-center">
                                    <div class="custom-checkbox custom-control">
                                        <input name="{{ $item->id }}" value="{{ $item->id }}"  type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ $item->id }}">
                                        <label for="checkbox-{{ $item->id }}" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </td>

                                <td  onclick="document.location.replace('{{ url('/member/sms/' . $item->id) }}')"  class="clickable truncate">

                                    <a href="{{ url('/member/sms/' . $item->id) }}" class="wide-link"  >

                                        <div>
                                            <strong>
                                                @if($item->users()->count()==1)
                                                    {{ $item->users()->first()->name }}
                                                @else
                                                    <ul class="comma-tags">
                                                        @foreach($item->departments as $department)
                                                            <li>{{ $department->name }}</li>
                                                        @endforeach

                                                        <li>{{ $item->users()->count() }} @lang(strtolower('admin.recipients'))</li>

                                                    </ul>
                                                @endif
                                            </strong>
                                        </div>

                                    </a>
                                </td>
                                <td  onclick="document.location.replace('{{ url('/member/sms/' . $item->id) }}')"  class="clickable">
                                    {!! nl2br(clean($item->message)) !!}
                                </td>
                                <td  onclick="document.location.replace('{{ url('/member/sms/' . $item->id) }}')"  class="clickable">{{ \Illuminate\Support\Carbon::parse($item->crated_at)->format('D, M d, Y') }}</td>
                                <td>
                                    <a  href="{{ route('member.sms.delete',['id'=>$item->id]) }}"  title="@lang('site.delete')" onclick="return confirm('@lang('admin.delete-prompt')')" ><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody></table>
                </div>
            </div>
        </form>
        <div class="card-footer">
            {!! $sms->appends(['search' => Request::get('search')])->render() !!}
        </div>
    </div>







    @if(false)
        <div class="product-status mg-b-15">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="hpanel">

                            <form  method="GET" action="{{ url('/admin/sms') }}" >
                                <div class="panel-heading hbuilt mailbox-hd">
                                    <div class="text-center p-xs font-normal">
                                        <div class="input-group">
                                            <input name="search" value="{{ request('search') }}" type="text" class="form-control input-sm" placeholder="@lang('admin.search-sent')"> <span class="input-group-btn active-hook"> <button type="submit" class="btn btn-sm btn-default">@lang('admin.search')
                                            </button> </span></div>
                                    </div>
                                </div>
                            </form>
                            <form id="msg-list" action="{{ route('sms.delete-multiple') }}" method="post">
                                @csrf
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6 col-md-6 col-sm-6 col-xs-8">
                                            <div class="btn-group ib-btn-gp active-hook mail-btn-sd mg-b-15">
                                                <button type="button"  onclick="document.location.replace('{{ selfURL() }}')" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> @lang('admin.refresh')</button>
                                                <button onclick="return confirm('@lang('admin.delete-prompt')')" title="@lang('admin.delete')" type="submit" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                                <button  type="button" class="check btn btn-default btn-sm"><i class="fa fa-check"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-md-6 col-sm-6 col-xs-4 mailbox-pagination">
                                            <div class="btn-group ib-btn-gp active-hook mail-btn-sd mg-b-15">
                                                @if($sms->previousPageUrl() != null)
                                                    <a href="{{ $sms->previousPageUrl() }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i></a>
                                                @endif

                                                @if($sms->nextPageUrl() != null)
                                                    <a  href="{{ $sms->nextPageUrl() }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-right"></i></a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive ib-tb">
                                        <table class="table table-hover table-mailbox">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>@lang('admin.recipients')</th>
                                                <th>@lang('admin.message')</th>
                                                <th class="text-right mail-date" style="padding-right: 80px">@lang('admin.date')</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($sms as $item)

                                                <tr>
                                                    <td class="">
                                                        <div class="checkbox">
                                                            <input name="{{ $item->id }}" value="{{ $item->id }}" type="checkbox" style="margin-left: 0px;">
                                                            <label></label>
                                                        </div>
                                                    </td>
                                                    <td onclick="document.location.replace('{{ url('/admin/sms/' . $item->id) }}')" class="clickable truncate">
                                                        <a href="{{ url('/admin/sms/' . $item->id) }}" style="width: 100%; height: 100%">

                                                            <div>
                                                                <strong>
                                                                    @if($item->users()->count()==1)
                                                                        {{ $item->users()->first()->name }}
                                                                    @else
                                                                        <ul class="comma-tags">
                                                                            @foreach($item->departments as $department)
                                                                                <li>{{ $department->name }}</li>
                                                                            @endforeach

                                                                            <li>{{ $item->users()->count() }} @lang(strtolower('admin.recipients'))</li>

                                                                        </ul>
                                                                    @endif
                                                                </strong>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td  onclick="document.location.replace('{{ url('/admin/sms/' . $item->id) }}')"  class="clickable"><a  style="width: 100%; height: 100%" href="{{ url('/admin/sms/' . $item->id) }}">{!! nl2br(clean($item->message)) !!}</a>
                                                    </td>

                                                    <td  onclick="document.location.replace('{{ url('/admin/sms/' . $item->id) }}')"  class="clickable text-right mail-date">{{ \Illuminate\Support\Carbon::parse($item->crated_at)->format('D, M d, Y') }}</td>
                                                    <td>
                                                        <a  href="{{ route('sms.delete',['id'=>$item->id]) }}"  title="@lang('site.delete')" onclick="return confirm('@lang('admin.delete-prompt')')" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>


                                                    </td>
                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                            <div class="panel-footer ib-ml-ft">
                                {!! $sms->appends(['search' => Request::get('search')])->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('footer')
    <script src="{{ asset('themes/admin/assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('themes/admin/assets/js/page/components-table.js') }}"></script>
    <script>
        $(function(){

            $('.check:button').click(function(){
                var checked = !$(this).data('checked');
                $('#msg-list input:checkbox').prop('checked', checked);
                $(this).val(checked ? 'uncheck all' : 'check all' )
                $(this).data('checked', checked);
            });

            $("#checkBtn").change(function () {
                console.log('checking');
                $("#member-form input:checkbox").prop('checked', $(this).prop("checked"));
            });
        });
    </script>

@endsection




@if(false)
@section('content')
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="hpanel">

                        <form  method="GET" action="{{ url('/member/sms') }}" >
                            <div class="panel-heading hbuilt mailbox-hd">
                                <div class="text-center p-xs font-normal">
                                    <div class="input-group">
                                        <input name="search" value="{{ request('search') }}" type="text" class="form-control input-sm" placeholder="@lang('admin.search-sent')"> <span class="input-group-btn active-hook"> <button type="submit" class="btn btn-sm btn-default">@lang('admin.search')
                                            </button> </span></div>
                                </div>
                            </div>
                        </form>
                        <form id="msg-list" action="{{ route('member.sms.delete-multiple') }}" method="post">
                            @csrf
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6 col-md-6 col-sm-6 col-xs-8">
                                        <div class="btn-group ib-btn-gp active-hook mail-btn-sd mg-b-15">
                                            <button type="button"  onclick="document.location.replace('{{ selfURL() }}')" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> @lang('admin.refresh')</button>
                                            <button onclick="return confirm('@lang('admin.delete-prompt')')" title="@lang('admin.delete')" type="submit" class="btn btn-default btn-sm"><i class="fa fa-trash"></i></button>
                                            <button  type="button" class="check btn btn-default btn-sm"><i class="fa fa-check"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-md-6 col-sm-6 col-xs-4 mailbox-pagination">
                                        <div class="btn-group ib-btn-gp active-hook mail-btn-sd mg-b-15">
                                            @if($sms->previousPageUrl() != null)
                                                <a href="{{ $sms->previousPageUrl() }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i></a>
                                            @endif

                                            @if($sms->nextPageUrl() != null)
                                                <a  href="{{ $sms->nextPageUrl() }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-right"></i></a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive ib-tb">
                                    <table class="table table-hover table-mailbox">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>@lang('admin.recipients')</th>
                                            <th>@lang('admin.message')</th>
                                            <th class="text-right mail-date" style="padding-right: 80px">@lang('admin.date')</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sms as $item)

                                            <tr>
                                                <td class="">
                                                    <div class="checkbox">
                                                        <input name="{{ $item->id }}" value="{{ $item->id }}" type="checkbox" style="margin-left: 0px;">
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td onclick="document.location.replace('{{ url('/member/sms/' . $item->id) }}')" class="clickable truncate">
                                                    <a href="{{ url('/member/sms/' . $item->id) }}" style="width: 100%; height: 100%">

                                                        <div>
                                                            <strong>
                                                                @if($item->users()->count()==1)
                                                                    {{ $item->users()->first()->name }}
                                                                @else
                                                                    <ul class="comma-tags">


                                                                        <li>{{ $item->users()->count() }} @lang(strtolower('admin.recipients'))</li>

                                                                    </ul>
                                                                @endif
                                                            </strong>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td  onclick="document.location.replace('{{ url('/member/sms/' . $item->id) }}')"  class="clickable"><a  style="width: 100%; height: 100%" href="{{ url('/member/sms/' . $item->id) }}">{!! nl2br(clean($item->message)) !!}</a>
                                                </td>

                                                <td  onclick="document.location.replace('{{ url('/member/sms/' . $item->id) }}')"  class="clickable text-right mail-date">{{ \Illuminate\Support\Carbon::parse($item->crated_at)->format('D, M d, Y') }}</td>
                                                <td>
                                                    <a  href="{{ route('member.sms.delete',['id'=>$item->id]) }}"  title="@lang('site.delete')" onclick="return confirm('@lang('admin.delete-prompt')')" ><i class="fa fa-trash" aria-hidden="true"></i></a>


                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                        <div class="panel-footer ib-ml-ft">
                            {!! $sms->appends(['search' => Request::get('search')])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('footer')
    <script>
        $(function(){

            $('.check:button').click(function(){
                var checked = !$(this).data('checked');
                $('#msg-list input:checkbox').prop('checked', checked);
                $(this).val(checked ? 'uncheck all' : 'check all' )
                $(this).data('checked', checked);
            });

            $("#checkBtn").change(function () {
                console.log('checking');
                $("#member-form input:checkbox").prop('checked', $(this).prop("checked"));
            });
        });
    </script>

@endsection
@endif
