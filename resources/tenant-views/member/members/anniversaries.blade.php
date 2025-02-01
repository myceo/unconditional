@extends('layouts.member')
@section('pageTitle',__('admin.wedding-anniversaries'))
@section('innerTitle',__('admin.wedding-anniversaries'))
@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.wedding-anniversaries')</span>
    </li>
@endsection

@section('content')
    <div class="card">

        <div class="card-body">
            <form id="sortform" class="form-inline" method="get" action="{{ route('member.birthdays') }}">

                @lang('admin.in') &nbsp; <select onchange="$('#sortform').submit()" name="weeks" id="weeks"  class="form-control mb-2 mr-sm-2 digits" >
                    @foreach(range(1,52) as $week)
                        <option value="{{ $week }}" @if($week==$weeks) selected @endif  >{{ $week }} @lang('admin.weeks')</option>
                    @endforeach
                </select>
            </form>
            <div class="table-responsive">
                <table class="table  table-striped">
                    <thead>
                    <tr>
                        <th width="80px"></th>
                        <th>@lang('admin.name')</th>
                        <th>

                                @lang('admin.wedding-anniversary')

                        </th>
                        <th>@lang('site.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($members as $item)
                        <tr>
                            <td class="pt-2 pb-2">
                                <figure class="avatar mr-2 avatar-xl">
                                    <a href="{{ url('/member/members/' . $item->id) }}">
                                        <img src="{{ profilePicture($item->id) }}" >
                                    </a>
                                </figure>
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>
                                @can('administer')
                                    {{  \Illuminate\Support\Carbon::parse($item->wedding_anniversary)->format('dS F Y') }}
                                    ({{ getAge($item->wedding_anniversary) }} @lang('admin.years'))
                                @else
                                    {{  \Illuminate\Support\Carbon::parse($item->wedding_anniversary)->format('dS F') }}
                                @endcan
                            </td>
                            <td>
                                <a href="{{ url('/member/members/' . $item->id) }}" class="btn btn-primary">@lang('admin.details')</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                <div class="custom-pagination">
                    {!! $members->appends(['weeks' => Request::get('weeks')])->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
