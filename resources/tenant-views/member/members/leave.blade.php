@extends('layouts.member')
@section('pageTitle',__('admin.leave-group'))

@section('innerTitle')
    @lang('admin.leave-group')
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.leave-group')</span>
    </li>
@endsection

@section('content')

    <div class="card author-box card-primary">
        <div class="card-body">
            <p>@lang('admin.leave-group-text')</p>
            <form onsubmit="return confirm('{{ addslashes(__('admin.leave-confirm')) }}')" method="post" action="{{ route('member.process-leave') }}">
                @csrf
                <button class="btn btn-primary"><i class="fa fa-sign-out-alt"></i> @lang('admin.leave-group')</button>
            </form>
        </div>
    </div>


@endsection


