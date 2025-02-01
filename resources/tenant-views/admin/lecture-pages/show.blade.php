@extends('layouts.admin')

@section('pageTitle','lecturePage'.' #'.$lecturepage->id)
@section('innerTitle','lecturePage'.' #'.$lecturepage->id)

@section('content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div  >
                    <div  >

                        <a href="{{ url('/admin/lecture-pages') }}" title="@lang('site.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('site.back')</button></a>
                        <a href="{{ url('/admin/lecture-pages/' . $lecturepage->id . '/edit') }}" title="@lang('site.edit') lecturePage"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> @lang('site.edit')</button></a>

                        <form method="POST" action="{{ url('admin/lecturepages' . '/' . $lecturepage->id) }}" accept-charset="UTF-8" class="int_inlinedisp""display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete') lecturePage" onclick="return confirm(&quot;@lang('site.confirm-delete')?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('site.delete')</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>@lang('site.id')</th><td>{{ $lecturepage->id }}</td>
                                    </tr>
                                    <tr><th> Title </th><td> {{ $lecturepage->title }} </td></tr><tr><th> Content </th><td> {{ $lecturepage->content }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
