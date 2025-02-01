@extends('layouts.site')
@section('pageTitle',__('admin.sent-messages'))
@section('innerTitle')
    @lang('admin.sent-messages')       @if(Request::get('search'))
        : {{ Request::get('search') }}
    @endif
@endsection

@section('breadcrumb')
   <li><a href="{{ url('/') }}">@lang('site.home')</a></li>
   <li>@lang('admin.sent-messages')</li>
@endsection


@section('content')
    <div class="pd-20 bg-gray-200 mb-2">
        <nav class="nav nav-pills flex-column flex-md-row">
            <a class="nav-link" href="{{ route('user.emails.inbox') }}">@lang('admin.inbox')</a>
            <a class="nav-link active"   href="{{ url('user/emails') }}">@lang('admin.sent-messages')</a>
        </nav>
    </div><!-- pd-10 -->
    <div class="card">
        <div class="card-header">
            <h4><div class="btn-group" role="group"  >
                    <button  onclick="document.location.replace('{{ selfURL() }}')" type="button" class="btn btn-primary note-btn"><i class="fas fa-sync-alt"></i> @lang('admin.refresh')</button>
                    <button onclick="$('#msg-list').submit()" type="button" class="btn btn-danger note-btn"><i class="fa fa-trash"></i></button>
                    <button type="button" class="check btn btn-info note-btn"><i class="fa fa-check"></i></button>
                </div></h4>
            <div class="card-header-form">
                <form  method="GET" action="{{ url('/user/emails') }}" >
                    <div class="input-group">
                        <input name="search" value="{{ request('search') }}" type="text" class="form-control" placeholder="@lang('admin.search')">
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <form id="msg-list" action="{{ route('user.email.delete-multiple') }}" onsubmit="return confirm('@lang('admin.delete-prompt')')" method="post">
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
                            <th>@lang('admin.subject')</th>
                            <th></th>
                            <th>@lang('admin.date')</th>
                            <th></th>
                        </tr>
                        @foreach($emails as $item)
                            <tr>
                                <td class="p-0 text-center">
                                    <div class="custom-checkbox custom-control mt-2">
                                        <input name="{{ $item->id }}" value="{{ $item->id }}"  type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ $item->id }}">
                                        <label for="checkbox-{{ $item->id }}" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </td>

                                <td  class="clickable truncate">

                                    <a href="{{ url('/user/emails/' . $item->id) }}" class="wide-link"  >

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
                                <td  onclick="document.location.replace('{{ url('/user/emails/' . $item->id) }}')"  class="clickable">
                                    <a  class="wide-link" href="{{ url('/user/emails/' . $item->id) }}">{{ $item->subject }}</a>
                                </td>
                                <td  onclick="document.location.replace('{{ url('/user/emails/' . $item->id) }}')"  class="clickable">
                                    <a  style="width: 100%; height: 100%" href="{{ url('/user/emails/' . $item->id) }}">
                                        @if($item->emailAttachments()->count()>0)
                                            <i class="fas fa-paperclip"></i>
                                        @endif
                                    </a>
                                </td>
                                <td  onclick="document.location.replace('{{ url('/user/emails/' . $item->id) }}')"  class="clickable">{{ \Illuminate\Support\Carbon::parse($item->crated_at)->format('D, M d, Y') }}</td>
                                <td>
                                    <a  href="{{ route('user.email.delete',['id'=>$item->id]) }}"  title="@lang('site.delete')" onclick="return confirm('@lang('admin.delete-prompt')')" ><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody></table>
                </div>
            </div>
        </form>
        <div class="card-footer">
            {!! $emails->appends(['search' => Request::get('search')])->render() !!}
        </div>
    </div>







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







