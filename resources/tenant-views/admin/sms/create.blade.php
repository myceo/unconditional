@extends('layouts.admin')
@section('pageTitle',__('admin.sms'))

@section('innerTitle')
    @lang('site.create-new') @lang('admin.sms')
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/admin/sms') }}">@lang('admin.sms')</a>
    </li>
    <li><span>@lang('site.create-new') @lang('admin.sms')</span>
    </li>
@endsection

@section('content')



            <form id="sendForm" method="post" action="{{ url('/admin/sms') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}

                @include ('admin.sms.form', ['formMode' => 'create'])

            </form>




@endsection

@section('footer')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(function(){

            $('#sendForm').submit(function(e){

                console.log($('#members').val());

                if( !$('#members').val() && !$('#departments').val() && !$('#all_members').prop("checked")){
                    e.preventDefault();
                    alert('@lang('admin.recipient-error')');
                }
            });

            $('#departments').select2();
            $('#members').select2({
                placeholder: "@lang('admin.search-members')...",
                minimumInputLength: 3,
                ajax: {
                    url: '{{ route('members.search') }}?format=number',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            term: $.trim(params.term)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }

            });
        });
    </script>

    <script>
        $(document).ready(function(){
            var $remaining = $('#remaining'),
                    $messages = $remaining.next();

            $('#message').keyup(function(){
                var chars = this.value.length,
                        messages = Math.ceil(chars / 160),
                        remaining = messages * 160 - (chars % (messages * 160) || messages * 160);

                $remaining.text(remaining + ' @lang('admin.characters-remaining').');
                $messages.text(messages + ' @lang('admin.message_s')');
            });

            $('#message').trigger('keyup');
        });

    </script>
@endsection

@section('header')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
@endsection
