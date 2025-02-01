@extends('layouts.admin')


@section('pageTitle',__('site.class').': '.$lecture->lesson->name)
@section('innerTitle',__('site.files').': '.$lecture->title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">@lang('site.courses')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.classes.index',['course'=>$lecture->lesson->course_id]) }}">@lang('site.classes')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.classes.lectures.index',['lesson'=>$lecture->lesson_id]) }}">@lang('site.lectures')</a></li>
    <li class="breadcrumb-item"><a href="#">@lang('site.files')</a></li>
@endsection

@section('content')
    <div class="container-fluid">





                        <div class="table-responsive">

                            @livewire('admin.lecture.file-manager',['lectureID' => $lecture->id])

                        </div>




    </div>
@endsection
@section('header')
    @livewireStyles
@endsection

@section('footer')
    @livewireScripts
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

