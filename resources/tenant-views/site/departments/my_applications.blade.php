@extends('layouts.site')
@section('pageTitle',__('site.applications'))
@section('innerTitle',__('site.applications'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('site.home') }}">@lang('site.home')</a>
    </li>
    <li class="breadcrumb-item"><span>{{ ucfirst(__('site.applications')) }}</span>
    </li>
@endsection

@section('content')

    <div class="table-responsive">

        <table class="table table-striped">
            <thead>
            <tr>
                <th>@lang('site.application-date')</th>
                <th>{{ ucfirst(__('site.department')) }}</th>
                <th>@lang('site.status')</th>
                <th>@lang('site.comment')</th>
                <th>@lang('site.actions')</th>
            </tr>
            </thead>

            <tbody>

            @foreach($applications as $application)
                <tr>
                    <td>{{ \Illuminate\Support\Carbon::parse($application->created_at)->format('d/M/Y') }}</td>
                    <td>{{ $application->department->name }}</td>
                    <td>
                        @if($application->status=='p')
                            @lang('site.pending')
                        @elseif($application->status=='a')
                            @lang('site.approved')
                        @elseif($application->status=='d')
                            @lang('site.denied')
                        @endif

                    </td>
                    <td>{!! nl2br(clean($application->comment)) !!}</td>
                    <td>
                        @if($user->departmentFields()->where('department_id',$application->department_id)->count()>0)
                            <a class="btn btn-primary" href="#"  data-toggle="modal" data-target="#myModal{{ $application->id }}">@lang('site.view')</a>
                        @endif

                        <a class="btn btn-danger" onclick="return confirm('@lang('site.confirm-delete')')" href="{{ route('site.delete-application',['application'=>$application->id]) }}">@lang('site.delete')</a>

                    </td>
                </tr>

            @section('footer')
                @parent
                <!-- Modal -->
                <div class="modal fade" id="myModal{{ $application->id }}" tabindex="-1" role="dialog" aria-labelledby="myModal{{ $application->id }}Label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModal{{ $application->id }}Label">{{ $application->department->name }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                            </div>
                            <div class="modal-body">

                                @foreach($user->departmentFields()->where('department_id',$application->department_id)->get() as $field)
                                    <div class="card">
                                        <div class="card-header">
                                            {{ $field->name }}
                                        </div>
                                        <div class="card-body">
                                            <div class="card-text">
                                                {!! nl2br(clean($field->pivot->value)) !!}
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.close')</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection

            @endforeach

            </tbody>

        </table>
        <div class="custom-pagination">
            {!! $applications->render() !!}
        </div>

    </div>


@endsection
