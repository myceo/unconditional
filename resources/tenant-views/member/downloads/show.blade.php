@extends('layouts.member')
@section('pageTitle',__('admin.downloads'))

@section('innerTitle')
     @lang('admin.download') : {{ $download->name }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/member/downloads') }}">@lang('admin.downloads')</a>
    </li>
    <li><span>@lang('admin.download')</span>
    </li>
@endsection

@section('content')
    <div class="single-pro-review-area mt-t-30 mg-b-15">


        <div class="container-fluid">
            <div class="product-payment-inner-st form-content">


            <div class="card">
                <div class="card-body">

                    <a href="{{ url('/member/downloads') }}" title="@lang('admin.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('admin.back')</button></a>
                    @can('administer')
                    <a href="{{ url('/member/downloads/' . $download->id . '/edit') }}" title="@lang('admin.edit') download"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('admin.edit')</button></a>

                    <form method="POST" action="{{ url('member/downloads' . '/' . $download->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm" title="@lang('admin.delete') download" onclick="return confirm('@lang('site.confirm-delete')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('admin.delete')</button>
                    </form>
                    @endcan
                    <br/>
                    <br/>

                    <div >
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>@lang('admin.added-on')</th><td>{{ Carbon\Carbon::parse($download->created_at)->format('D d/M/Y') }}</td>
                            </tr>
                            <tr>
                                <th>@lang('admin.created-by')</th>
                                <td>{{ $download->user->name }}</td>
                            </tr>
                            <tr><th> @lang('admin.name') </th><td> {{ $download->name }} </td></tr><tr><th> @lang('admin.description') </th><td> {!! nl2br(clean($download->description)) !!} </td></tr>
                            <tr>
                                <td colspan="2">
                                    @if($download->downloadFiles()->count()>0)
                                        <div class="mg-tb-15">
                                            <p class="m-b-md">
                                                <span><i class="fa fa-paperclip"></i> {{ $download->downloadFiles()->count() }} @if($download->downloadFiles()->count()>1) @lang('admin.attachments') @else @lang('admin.attachment') @endif - </span>
                                                <a href="{{ route('member.download.download-attachments',['download'=>$download->id]) }}" class="btn btn-default btn-xs">@lang('admin.download-all') <i class="fa fa-file-zip-o"></i> </a>
                                            </p>

                                            <div>
                                                <div class="row">
                                                    @foreach($download->downloadFiles as $attachment)

                                                            <div class="col-md-4">
                                                            <div class="card" >
                                                                @if(isImage($attachment->file_path))
                                                                <img style="max-height: 270px;" src="{{ route('member.download.view-image',['downloadFile'=>$attachment->id]) }}" class="card-img-top" />
                                                                @else
                                                                    <img src="{{ asset('themes/admin/assets/img/file.png') }}" alt="">
                                                                @endif
                                                                <div class="card-body">
                                                                    <h5 class="card-title">{{ basename($attachment->file_path) }}</h5>
                                                                    <a href="{{ route('member.download.download-attachment',['downloadFile'=>$attachment->id]) }}" class="btn btn-primary">@lang('admin.download')</a>
                                                                </div>
                                                            </div>
                                                            </div>



                                                    @endforeach


                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


            </div>
        </div>


    </div>
@endsection
