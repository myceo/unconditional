@extends('layouts.member')
@section('pageTitle','Emails')

@section('innerTitle')
    @lang('site.edit') email #{{ $email->id }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/member/emails') }}">Emails</a>
    </li>
    <li><span>@lang('site.edit') email</span>
    </li>
@endsection

@section('content')
    <div class="single-pro-review-area mt-t-30 mg-b-15">


        <div class="container-fluid">
            <div class="product-payment-inner-st form-content">


            <form method="POST" action="{{ url('/member/emails/' . $email->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}

                @include ('member.emails.form', ['formMode' => 'edit'])

            </form>




        </div>
    </div>


    </div>

@endsection
