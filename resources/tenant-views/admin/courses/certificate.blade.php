@extends('layouts.admin')

@section('pageTitle',$course->name)
@section('innerTitle',__('site.certificate'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">@lang('site.courses')</a></li>
     <li class="breadcrumb-item"><a href="#">@lang('site.certificate')</a></li>
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('admin.course.certificate',['course'=>$course])
    </div>
@endsection

@section('header')
    @livewireStyles
    <link type="text/css" rel="stylesheet" href="{{ asset('vendor/jquery-ui-1.11.4/jquery-ui.min.css') }}" />
@endsection

@section('footer')
    @livewireScripts
    <script src="{{ asset('vendor/jquery-ui-1.11.4/jquery-ui.min.js') }}"></script>


    <script src="{{ asset('vendor/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 5000,
            timerProgressBar:true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        window.addEventListener('alert',({detail:{type,message}})=>{
            Toast.fire({
                icon:type,
                title:message
            })
        })
    </script>

@endsection
