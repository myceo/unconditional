@extends('layouts.admin')
@section('pageTitle',__('admin.view').' '.__('admin.sms'))

@section('innerTitle')
    @lang('admin.view') @lang('admin.sms')
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/admin/sms') }}">@lang('admin.sent-sms')</a>
    </li>
    <li><span>@lang('admin.view') @lang('admin.sms')</span>
    </li>
@endsection

@section('content')
    <div class="single-pro-review-area mt-t-30 mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-payment-inner-st">

                        <ul class="nav nav-pills" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab" aria-controls="home" aria-selected="true">@lang('admin.message')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">@lang('admin.recipients'): @lang('admin.members') ({{ $sms->users()->count() }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">@lang('admin.recipients'): @lang('admin.departments') ({{ $sms->departments()->count() }})</a>
                            </li>
                        </ul>
                        <div class="tab-content " id="myTab3Content">
                            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                <div class="card" id="mailContent">

                                        <div class="card-header">
   {{ \Illuminate\Support\Carbon::parse($sms->created_at)->diffForHumans() }} ({{ \Illuminate\Support\Carbon::parse($sms->created_at)->format('d.M.Y') }})

                                        </div>
                                        <div class="card-body">
                                            @if(!empty($sms->notes))
                                            <h6 class="card-subtitle mb-2 text-muted"><span class="font-extra-bold">@lang('admin.comment'): </span> {{ $sms->notes }}</h6>
                                            @endif
                                            <p class="card-text"> {!! nl2br(clean($sms->message)) !!}</p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="btn-group float-right">
                                                <button onclick="printPageArea('mailContent')" class="btn btn-primary"><i class="fa fa-print"></i> @lang('admin.print')</button>

                                                <a onclick="return confirm('@lang('admin.delete-prompt')')"  class="btn btn-danger" href="{{ route('sms.delete',['id'=>$sms->id]) }}"><i class="fa fa-trash"></i> @lang('admin.delete')</a>
                                            </div>
                                        </div>







                                </div>

                            </div>
                            <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                                <table style="width: 100%;" class="table" id="recipients">
                                    <thead>
                                    <tr>
                                        <td>@lang('admin.name')</td>
                                        <td>@lang('admin.telephone')</td>
                                        <td>@lang('admin.departments')</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sms->users()->orderBy('name')->limit(1000)->get() as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->telephone }}</td>
                                            <td>
                                                <ul class="comma-tags">
                                                    @foreach($user->departments as $department)
                                                        <li>{{ $department->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                            <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">
                                <ul>
                                    @foreach($sms->departments as $department)
                                        <li>{{ $department->name }}</li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>






                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('header')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/media/css/jquery.dataTables.min.css') }}">
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $(function(){
            $('#recipients').DataTable({
                language: {
                    search: "@lang('admin.search'):",
                    info: "@lang('admin.table-info')",
                    emptyTable: "@lang('admin.empty-table')",
                    lengthMenu:    "@lang('admin.table-length')",
                    paginate: {
                        first:      "@lang('admin.first')",
                        previous:   "@lang('admin.previous')",
                        next:       "@lang('admin.next')",
                        last:       "@lang('admin.last')"
                    }
                }
            });
        });
    </script>
@endsection
