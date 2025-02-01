@extends('layouts.site')
@section('pageTitle',__('site.my-departments'))
@section('innerTitle',__('site.my-departments'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('site.home') }}">@lang('site.home')</a>
    </li>
    <li class="breadcrumb-item"><span>@lang('site.my-departments')</span>
    </li>
@endsection

@section('content')

    <div class="container_fluid mg-b-15" style="min-height: 400px">

        <div class="row"   >
            <div class="col-md-12">

                <div class="container-fluid">

                    <div class="row">

                        @foreach($departments as $department)
                            <div class="col-md-4 mg-b-15 ">


                                <div class="card"  >
                                    @if(!empty($department->picture) && file_exists($department->picture))
                                        <a href="{{ route('site.department',['department'=>$department->id]) }}"><img  class="card-img-top"  src="{{ asset($department->picture) }}"  ></a>
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $department->name }}</h5>
                                        <p class="card-text">{{ limitLength($department->description,200) }}</p>

                                        <a class="btn btn-success btn-lg btn-block" href="{{ route('site.department-login',['department'=>$department]) }}"><i class="fa fa-sign-in-alt"></i> @lang('site.login')</a>

                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="custom-pagination">
                        {!! $departments->appends(['search' => Request::get('search'),'category'=>Request::get('category')])->render() !!}
                    </div>


                </div>
            </div>
        </div>
    </div>


@endsection
