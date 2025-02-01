@extends('layouts.site')

@section('pageTitle',__('site.tests'))
@section('innerTitle',__('site.tests'))

@section('content')

    @include('site.test.test-list',['tests'=>$tests])
    {{ $tests->links() }}
@endsection
