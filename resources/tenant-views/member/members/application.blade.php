@extends('layouts.member')
@section('pageTitle',__('admin.application'))

@section('innerTitle')
    @lang('admin.application') : {{ $application->user->name }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ route('member.members.applications') }}">@lang('admin.applications')</a>
    </li>
    <li><span>@lang('admin.application')</span>
    </li>
@endsection

@section('content')


       <div class="container-fluid">
            <div class="row">

                <div class="col-md-4">

                    <div class="card">
                        <img src="{{ profilePicture($application->user_id) }}" class="card-img-top"  >
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                    <div class="address-hr">
                                        <p><b>@lang('admin.name')</b><br /> {{ $application->user->name }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                    <div class="address-hr tb-sm-res-d-n dps-tb-ntn">
                                        <p><b>@lang('admin.gender')</b><br />
                                            {{ gender($application->user->gender) }} </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                    <div class="address-hr">
                                        <p><b>@lang('admin.email')</b><br /> <a style="font-size: 15px;" href="mailto:{{ $application->user->email }}">{{ $application->user->email }}</a></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                    <div class="address-hr tb-sm-res-d-n dps-tb-ntn">
                                        <p><b>@lang('admin.telephone')</b><br /> <a style="font-size: 15px;"  href="tel:{{ $application->user->telephone }}">{{ $application->user->telephone }}</a></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">

                                    <a class="btn btn-success btn-block btn-lg" href="#"  data-toggle="modal" data-target="#myModalApprove"><i class="fa fa-thumbs-up"></i> @lang('admin.approve')</a>

                                </div>
                                <div class="col-md-6">

                                    <a class="btn btn-danger btn-block btn-lg" href="#"  data-toggle="modal" data-target="#myModalReject"><i class="fa fa-thumbs-down"></i> @lang('admin.reject')</a>

                                </div>
                            </div>


                        </div>
                    </div>



                </div>

                <div class="col-md-8">

                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">@lang('admin.answers')</a>
                                </li>
                                @if(!empty($application->message))
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">@lang('admin.comment')</a>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                            @if($fields->count()==0)
                                                @lang('admin.no-records')
                                            @endif

                                            <div style="min-height: 300px">
                                                @foreach($fields as $field)
                                                    <div class="card card-primary">
                                                        <div class="card-header">{{ $field->name }}</div>
                                                        <div class="card-body">
                                                            {!! nl2br(clean($field->pivot->value)) !!}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($application->message))
                                <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                                    {{ $application->message }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>








    <!-- Modal -->
    <div class="modal fade" id="myModalApprove" tabindex="-1" role="dialog" aria-labelledby="myModalApproveLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form" action="{{ route('member.members.update-application',['application'=>$application->id]) }}" method="post">
                    @csrf
                    <input type="hidden" name="status" value="a"/>
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalApproveLabel">@lang('admin.approve')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="comment">@lang('admin.comment') (@lang('admin.optional'))</label>
                        <textarea class="form-control" name="message" id="commenta" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.close')</button>
                    <button type="submit" class="btn btn-success">@lang('admin.approve')</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="myModalReject" tabindex="-1" role="dialog" aria-labelledby="myModalRejectLabel">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <form class="form" action="{{ route('member.members.update-application',['application'=>$application->id]) }}" method="post">
                    @csrf
                    <input type="hidden" name="status" value="d"/>
                <div class="modal-header">

                    <h4 class="modal-title" id="myModalRejectLabel">@lang('admin.reject')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="comment">@lang('admin.comment') (@lang('admin.optional'))</label>
                        <textarea class="form-control" name="message" id="commentd" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.close')</button>
                    <button type="submit" class="btn btn-danger">@lang('admin.reject')</button>
                </div>
                </form>
            </div>
        </div>
    </div>


@endsection
