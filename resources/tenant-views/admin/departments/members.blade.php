@extends('layouts.admin')
@section('pageTitle',__('admin.manage-members').' : '.$department->name)

@section('innerTitle')
    @lang('admin.manage-members') : {{ $department->name }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/admin/groups') }}">@lang('admin.departments')</a>
    </li>
    <li><span>@lang('admin.manage-members')</span>
    </li>
@endsection

@section('content')


    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab" aria-controls="home" aria-selected="true">@lang('admin.current-members') ({{ $total }})</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#reviews" role="tab" aria-controls="profile" aria-selected="false">@lang('admin.add-members')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">@lang('admin.administrators') ({{ $admins->count() }})</a>
        </li>
    </ul>
    <div class="tab-content tab-bordered" id="myTab3Content">
        <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
            <div class="row">
                <div class="col-md-6">
                    <form style="margin-bottom: 20px" id="nav-search" method="GET" action="{{ route('dept.members',['department'=>$department->id]) }}" role="search" class="sr-input-func form-inline">
                        <input name="search" value="{{ request('search') }}" type="text" placeholder="{{ ucfirst(__('site.search')) }}..." class="search-int form-control">


                    </form>
                </div>
                <div class="col-md-2">
                    <label><input type="checkbox" id="memberCheckAll"/> @lang('admin.check-all')</label>
                </div>
                <div class="col-md-4">
                    <button type="button" onclick="$('#member-form').submit()" class="btn btn-danger float-right"><i class="fa fa-minus"></i> @lang('admin.remove-selected')</button>

                </div>
            </div>

            <form id="member-form" action="{{ route('dept.remove-members',['department'=>$department->id]) }}" method="post">
                @csrf
                <div class="contacts-area mg-b-15">
                    <div class="container-fluid">
                        <div class="row">
                            @foreach($members as $item)
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 mb-5">

                                    <div class="user-item">
                                         @if(!empty($item->picture))
                                            <img src="{{ asset($item->picture) }}" class="img-fluid" />
                                        @else
                                            <img src="{{ avatar($item->gender) }}" class="img-fluid"   />
                                        @endif
                                        <div class="user-details">
                                            <div class="user-name">     <input type="checkbox" name="{{ $item->id }}" value="{{ $item->id }}" >  &nbsp; {{ $item->name }}
                                                @if($item->pivot->department_admin==1)
                                                    <span style="color: green">(@lang('admin.admin'))</span>
                                                @endif</div>
                                            <div class="text-job text-muted">{{ gender($item->gender) }}</div>
                                            <div class="user-cta">

                                                <div class="btn-group mb-2">
                                                    <button class="btn btn-primary  dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-cogs" aria-hidden="true"></i>    @lang('admin.actions')
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @if($item->pivot->department_admin==0)
                                                        <a class="dropdown-item"  href="{{ route('dept.set-admin',['department'=>$department->id,'user'=>$item->id,'mode'=>1]) }}">@lang('admin.make-admin')</a>
                                                        @else
                                                          <a class="dropdown-item"  href="{{ route('dept.set-admin',['department'=>$department->id,'user'=>$item->id,'mode'=>0]) }}">@lang('admin.remove-admin')</a>
                                                        @endif
                                                        <a  class="dropdown-item" href="{{ url('/admin/members/' . $item->id) }}">@lang('admin.details')</a>
                                                         <a class="dropdown-item"  href="{{ url('/admin/members/' . $item->id . '/edit') }}" title="@lang('site.edit') @lang('admin.member')"> @lang('site.edit')</a>
                                                         <a class="dropdown-item"  href="{{ url('admin/emails/create') }}?user={{ $item->id }}">@lang('admin.email')</a>
                                                         <a  class="dropdown-item" href="{{ url('admin/sms/create') }}?user={{ $item->id }}" >@lang('admin.sms')</a>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
            {!! $members->appends(['search' => Request::get('search')])->render() !!}

        </div>
        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="profile-tab2">


        </div>
        <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">

            <div class="contacts-area mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        @foreach($admins as $item)
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

                                <div class="user-item">
                                    @if(!empty($item->picture))
                                        <img src="{{ asset($item->picture) }}" class="img-fluid" />
                                    @else
                                        <img src="{{ avatar($item->gender) }}" class="img-fluid"   />
                                    @endif

                                    <div class="user-details mb-5">
                                        <div class="user-name">{{ $item->name }} </div>
                                        <div class="text-job text-muted">{{ gender($item->gender) }}</div>
                                        <div class="user-cta">

                                            <div class="btn-group mb-2">
                                                <button class="btn btn-primary  dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-cogs" aria-hidden="true"></i>    @lang('admin.actions')
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if($item->pivot->department_admin==0)
                                                        <a class="dropdown-item"  href="{{ route('dept.set-admin',['department'=>$department->id,'user'=>$item->id,'mode'=>1]) }}">@lang('admin.make-admin')</a>
                                                    @else
                                                        <a class="dropdown-item"  href="{{ route('dept.set-admin',['department'=>$department->id,'user'=>$item->id,'mode'=>0]) }}">@lang('admin.remove-admin')</a>
                                                    @endif
                                                    <a  class="dropdown-item" href="{{ url('/admin/members/' . $item->id) }}">@lang('admin.details')</a>
                                                    <a class="dropdown-item"  href="{{ url('/admin/members/' . $item->id . '/edit') }}" title="@lang('site.edit') @lang('admin.member')"> @lang('site.edit')</a>
                                                    <a class="dropdown-item"  href="{{ url('admin/emails/create') }}?user={{ $item->id }}">@lang('admin.email')</a>
                                                    <a  class="dropdown-item" href="{{ url('admin/sms/create') }}?user={{ $item->id }}" >@lang('admin.sms')</a>

                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>



                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>




@endsection

@section('footer')
    <script>
        $(function(){
            $('#reviews').load('{{ route('dept.all-members',['department'=>$department->id]) }}');
            $(document).on('click','.ajax-links a',function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                $('#reviews').html('Loading...');
                $('#reviews').load(url,function(){
                    $("body,html").animate(
                            {
                                scrollTop: $("#myTabedu1").offset().top
                            },
                            800 //speed
                    );
                });

            });

            $(document).on('submit','.ajax-form',function(e){
                e.preventDefault();
                var url = $(this).attr('action')+'?'+$(this).serialize();
                console.log(url);
                $('#reviews').html('Loading...');
                $('#reviews').load(url);

            });

            $("#memberCheckAll").change(function () {
                console.log('checking');
                $("#member-form input:checkbox").prop('checked', $(this).prop("checked"));
            });

            $(document).on('change','#allCheckAll',function(){
                $("#add-form input:checkbox").prop('checked', $(this).prop("checked"));
            })
        });
    </script>

@endsection
