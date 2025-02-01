@extends('layouts.site')
@section('pageTitle',__('site.departments'))
@section('innerTitle', (isset($categoryName) && !empty($categoryName))? $categoryName:__('site.departments'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('site.home') }}">@lang('site.home')</a>
    </li>
    @if(request('search') || request('category'))
        <li class="breadcrumb-item"><a href="{{ route('site.departments') }}">@lang('site.departments')</a>
        </li>
            @if(request('category'))
                <li class="breadcrumb-item"><a href="{{ route('site.departments') }}?category={{ request('category') }}">{{ $categoryName }}</a> @if(request('search'))  @endif
                </li>
            @endif

        @if(request('search'))
            <li class="breadcrumb-item">@lang('site.search-results')</li>
            @endif

        @else
    <li class="breadcrumb-item">@lang('site.departments')
    </li>
    @endif

@endsection

@section('content')

    <div class="container_fluid mg-b-15" style="min-height: 400px">

        <div class="row"  style="margin-left: 0px;margin-right: 0px;">
            <div class="col-md-12">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert-title dropzone-custom-sys">
                        <h2>


                            @if(request('search'))@lang('site.search-uc') : {{ request('search') }} @endif</h2>
                        <p>@lang('site.dept-info')</p>


                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8"  >
                            <form class="form-inline" method="GET" action="{{ route('site.departments') }}" >
                                <input type="hidden" name="search" value="{{ request('search') }}"/>

                                <div class="form-group">
                                    <select style="max-width: 300px" class="form-control" name="category" id="category">
                                        <option value="">@lang('site.all-departments')</option>
                                        @foreach(\App\Category::orderBy('name')->get() as $category)
                                            <option @if(request('category')==$category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary">@lang('site.filter')</button>
                                </div>

                            </form>
                        </div>
                        <div class="col-md-4"  >
                            <form role="search" class="form-inline" method="get" action="{{ route('site.departments') }}">
                                <div class="search-element">
                                    <input class="form-control" type="search" value="{{ request('search') }}" placeholder="@lang('site.search-uc')" aria-label="@lang('site.search-uc')"   >
                                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                                    <div class="search-backdrop"></div>

                                </div>
                                @if(false)
                                <input value="{{ request('search') }}" type="text" placeholder="@lang('site.search')..." class="search-int form-control" name="search">
                                <a href="#"><i class="fa fa-search"></i></a>
                               @endif
                                <input type="hidden" name="category" value="{{ request('category') }}"/>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="row">

                        @foreach($departments as $department)
                           @include('site.partials.department')
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
