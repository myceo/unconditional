@extends('layouts.admin')



@section('pageTitle',__('site.courses'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">@lang('site.courses')</a></li>
    <li class="breadcrumb-item"><a href="#">@lang('site.students')</a></li>
@endsection

@section('innerTitle')
    {{ __('site.students') }}: {{ limitLength($course->name,50) }}

@endsection

@section('content')


        @livewire('admin.course.user-list',['course' => $course])

@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}">
    @livewireStyles
@endsection

@section('footer')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('js/admin/textrte.js') }}"></script>

    <script>
        $(function(){
            $('#users').select2({
                placeholder: "@lang('admin.search-members')...",
                minimumInputLength: 3,
                ajax: {
                    url: '{{ route('members.search') }}',
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
    @livewireScripts
@endsection

