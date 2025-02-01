@extends('layouts.member')
@section('pageTitle',__('admin.gallery'))

@section('innerTitle')
     @lang('admin.picture'): {{ $gallery->name }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/member/galleries') }}">@lang('admin.gallery')</a>
    </li>
    <li><span>@lang('admin.gallery')</span>
    </li>
@endsection

@section('content')
    <div class="single-pro-review-area mt-t-30 mg-b-15">


        <div class="container-fluid">
            <div class="product-payment-inner-st form-content">


            <div class="card">
                <div class="card-body">

                    <a href="{{ url('/member/galleries') }}" title="@lang('admin.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('admin.back')</button></a>
                    <a href="{{ url('/member/galleries/' . $gallery->id . '/edit') }}" title="@lang('admin.edit') gallery"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> @lang('admin.edit')</button></a>

                    <form method="POST" action="{{ url('member/galleries' . '/' . $gallery->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm" title="@lang('admin.delete') gallery" onclick="return confirm('@lang('site.confirm-delete')')"><i class="fa fa-trash" aria-hidden="true"></i> @lang('admin.delete')</button>
                    </form>
                    <br/>
                    <br/>

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>

                            <tr><th> @lang('admin.name') </th><td> {{ $gallery->name }} </td></tr><tr><th> @lang('admin.description') </th><td> {{ $gallery->description }} </td></tr>
                            <tr>
                                <th>@lang('admin.picture')</th>
                                <td>  <img src="{{ asset($gallery->file_path) }}" class="img-fluid"  />
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
