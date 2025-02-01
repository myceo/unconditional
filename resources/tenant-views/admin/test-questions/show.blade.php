@extends('layouts.admin')

@section('pageTitle',__('site.question').' #'.$testquestion->id)
@section('innerTitle',__('site.question').' #'.$testquestion->id)

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div  >
                    <div  >
                        <a href="{{ route('admin.test-questions.index',['test'=>$testquestion->test_id]) }}" title="@lang('site.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('site.back')</button></a>
                        <a href="{{ url('/admin/test-questions/' . $testquestion->id . '/edit') }}" ><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> @lang('site.edit')</button></a>
                        <button form="deleteform" type="submit" class="btn btn-danger btn-sm" title="@lang('site.delete')" onclick="return confirm(&quot;@lang('site.confirm-delete')&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('site.delete')</button>

                        <form id="deleteform" method="POST" action="{{ url('admin/test-questions' . '/' . $testquestion->id) }}" accept-charset="UTF-8" class="int_inlinedisp">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>@lang('site.id')</th><td>{{ $testquestion->id }}</td>
                                </tr>
                                <tr><th> @lang('site.question') </th><td> {!! $testquestion->question !!} </td></tr><tr><th> {{ __('site.sort-order') }} </th><td> {{ $testquestion->sort_order }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
