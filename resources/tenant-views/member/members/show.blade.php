@extends('layouts.member')
@section('pageTitle',__('admin.member'))

@section('innerTitle')
     @lang('admin.member') : {{ $member->name }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><a href="{{ url('/member/members') }}">@lang('admin.members')</a>
    </li>
    <li><span>@lang('admin.member')</span>
    </li>
@endsection

@section('content')

    <a href="{{ prevPage() }}" title="@lang('admin.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('admin.back')</button></a>


    <br><br>
    <div class="card author-box card-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <div class="author-box-left"  >
                        <div class="gallery gallery-fw" data-item-height="250">
                            <div class="gallery-item" style="width: 250px; float: none;" data-image="{{ profilePicture($member->id) }}" data-title="Image 1"></div>
                        </div>
                        <div class="clearfix"></div>
                        @can('dept_allows','allow_members_communicate')
                            <a class="btn btn-success btn-block btn-lg" href="{{ url('member/emails/create') }}?user={{ $member->id }}"><i class="fa fa-envelope"></i> @lang('admin.send-message')</a>

                        @endcan
                    </div>

                </div>
                <div class="col-md-7">
                    <div class="author-box-details_">
                        <div class="author-box-name">
                            <a href="#">{{ $member->name }}</a>
                        </div>
                        <div class="author-box-job">{{ gender($member->gender) }}</div>
                        <div class="author-box-description">
                            <p>{!! linkify(nl2br(clean($member->about))) !!}</p>
                        </div>

                        <div >

                            <div class="mb-2 mt-3"><div class="text-small font-weight-bold">@lang('admin.email')</div>
                                {{ $member->email }}
                            </div>


                            <div class="mb-2 mt-3"><div class="text-small font-weight-bold">@lang('admin.telephone')</div>
                                {{ $member->telephone }}
                            </div>

                            @if(setting('general_enable_birthday')==1 && !empty($member->date_of_birth))
                                <div class="mb-2 mt-3"><div class="text-small font-weight-bold">@lang('admin.birthday')</div>
                                    @can('administer')
                                        {{  \Illuminate\Support\Carbon::parse($member->date_of_birth)->format('dS F Y') }} ({{ getAge($member->date_of_birth) }})
                                        @else
                                        {{  \Illuminate\Support\Carbon::parse($member->date_of_birth)->format('dS F') }}
                                    @endcan
                                </div>
                            @endif

                            @if(setting('general_enable_anniversary')==1 && !empty($member->wedding_anniversary))
                                <div class="mb-2 mt-3"><div class="text-small font-weight-bold">@lang('admin.wedding-anniversary')</div>
                                    @can('administer')
                                        {{  \Illuminate\Support\Carbon::parse($member->wedding_anniversary)->format('jS F Y') }}
                                    @else
                                        {{  \Illuminate\Support\Carbon::parse($member->wedding_anniversary)->format('jS F') }}
                                    @endcan
                                </div>
                            @endif

                            @foreach(\App\Field::where('public',1)->orderBy('sort_order','asc')->get() as $field)

                                <div class="mb-2 mt-3"><div class="text-small font-weight-bold"> {{ $field->name }}</div>

                                    <?php
                                    $value = $member->fields()->where('field_id',$field->id)->first() ? $member->fields()->where('field_id',$field->id)->first()->pivot->value:'';

                                    ?>
                                    @if($field->type=='checkbox')
                                        {{ boolToString($value) }}
                                    @else
                                        {!! linkify(nl2br(clean($value ))) !!}
                                    @endif

                                </div>
                            @endforeach

                        </div>

                    </div>

                </div>
            </div>


        </div>
    </div>


@endsection

@section('header')

    <link rel="stylesheet" href="{{ asset('themes/admin/assets/modules/chocolat/dist/css/chocolat.css') }}">
@endsection

@section('footer')
    <script src="{{ asset('themes/admin/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
@endsection
