@extends('layouts.admin')

@section('pageTitle','lesson'.' #'.$lesson->id)
@section('innerTitle','lesson'.' #'.$lesson->id)

@section('content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div  >
                    <div  >

                        <a href="{{ url('/admin/lessons') }}" title="@lang('site.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('site.back')</button></a>
                        <a href="{{ url('/admin/lessons/' . $lesson->id . '/edit') }}" title="@lang('site.edit') lesson"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> @lang('site.edit')</button></a>

                        <form method="POST" action="{{ url('admin/lessons' . '/' . $lesson->id) }}" accept-charset="UTF-8" class="int_inlinedisp""display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete') lesson" onclick="return confirm(&quot;@lang('site.confirm-delete')?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('site.delete')</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>@lang('site.id')</th><td>{{ $lesson->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $lesson->name }} </td></tr><tr><th> Picture </th><td> {{ $lesson->picture }} </td></tr><tr><th> Description </th><td> {{ $lesson->description }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
