@extends('layouts.admin')

@section('pageTitle',__('site.course-categories'))
@section('innerTitle',__('site.view'))

@section('content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div  >
                    <div  >

                        <a href="{{ url('/admin/course-categories') }}" title="@lang('site.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('site.back')</button></a>
                        <a href="{{ url('/admin/course-categories/' . $coursecategory->id . '/edit') }}" title="@lang('site.edit') courseCategory"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> @lang('site.edit')</button></a>

                        <form method="POST" action="{{ url('admin/coursecategories' . '/' . $coursecategory->id) }}" accept-charset="UTF-8" class="int_inlinedisp""display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete') courseCategory" onclick="return confirm(&quot;@lang('site.confirm-delete')?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('site.delete')</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>@lang('site.id')</th><td>{{ $coursecategory->id }}</td>
                                    </tr>
                                    <tr><th> @lang('site.name') </th><td> {{ $coursecategory->name }} </td></tr>

                                    <tr><th> @lang('site.description') </th><td> {{ nl2br($coursecategory->description) }} </td></tr>
                                    <tr><th> @lang('site.sort-order') </th><td> {{ $coursecategory->sort_order }} </td></tr>
                                    <tr><th> @lang('site.enabled') </th><td> {{ boolToString($coursecategory->enabled) }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
