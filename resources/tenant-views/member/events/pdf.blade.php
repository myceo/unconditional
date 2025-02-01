<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Roster</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">

</head>

<body>
<div>
<div class="container-fluid pt-3">

    <h1>{{ setting('general_site_name') }}</h1>
    <h4>{{ $event->name }} ({{ \Carbon\Carbon::parse($event->event_date)->format('D d/M/Y') }})</h4>

    <div class=" mb-3">
            <table class="table table-bordered table-striped" style="margin-top: 10px">
                <tbody>
                <tr>
                    <td style="border-top: none"><strong>@lang('admin.starts'):</strong></td>
                    <td style="border-top: none">{{ \Carbon\Carbon::parse($event->event_date)->format('D d/M/Y') }} ({{ \Carbon\Carbon::parse($event->event_date)->diffForHumans() }})</td>
                </tr>
                @if(!empty($event->venue))
                    <tr>
                        <td><strong>@lang('admin.venue'):</strong></td>
                        <td>{{ $event->venue }}</td>
                    </tr>
                @endif
                <tr>
                    <td><strong>@lang('admin.shifts'):</strong></td>
                    <td>{{ $event->shifts()->count() }}</td>
                </tr>
                <?php
                $users = [];
                ?>
                @foreach($event->shifts as $shift)
                    @foreach($shift->users as $user)
                        <?php
                        $users[$user->id] = $user;
                        ?>
                    @endforeach
                @endforeach
                @if(!empty($users))
                    <tr>
                        <td><strong>@lang('admin.members'):</strong></td>
                        <td>

                            <ul class="comma-tags">
                                @foreach($users as $user)
                                    <li>{{ $user->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            @if(!empty($event->description))
                <div class="alert alert-success" role="alert">{!! nl2br(clean($event->description)) !!}</div>
            @endif

    </div>

    <h2>@lang('admin.shifts')</h2>
    <hr>
    @foreach($event->shifts()->orderBy('starts')->get() as $shift)
        <div class="card mb-3">
            <div class="card-body">
                    <h4 style="margin-top: 20px">{{ \Illuminate\Support\Carbon::parse($shift->starts)->format('h:i A') }} to {{ \Illuminate\Support\Carbon::parse($shift->ends)->format('h:i A') }} <span class="float-right">{{ $shift->name }}</span></h4>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>@lang('admin.member')</th>
                            <th>@lang('admin.telephone')</th>
                            <th>@lang('admin.email')</th>
                            <th>@lang('admin.tasks')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shift->users()->orderBy('name')->get() as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->telephone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->pivot->tasks }}</td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                    @if(!empty($shift->description))
                        <div class="alert alert-success" role="alert">
                            {{ $shift->description }}
                        </div>
                    @endif

            </div>
        </div>

    @endforeach
    <div class="text-center pb-3" style=" margin-top: 30px">

        <h4>@lang('site.get-apps')</h4>
        <p>@lang('admin.roaster-text',['name'=>'GForce']) (<a href="https://gforce.app">gforce.app</a>)</p>
        <p>@lang('admin.portal-username',['username'=>$username,'sitename'=>setting('general_site_name'),'tag1'=>'<strong>','tag2'=>'</strong>'])</p>
        <div class="container">
            <div class="row">

                <div class="col-md-2 offset-md-4 text-center appicon-margin">
                    <a  href="{{ env('APPLE_URL') }}"><img src="{{ asset('themes/bluetec/images/misc/download-appstore.png') }}" class="img-fluid_"></a>

                </div>
                <div class="col-md-2 text-center">
                    <a href="{{ env('PLAY_URL') }}"><img src="{{ asset('themes/bluetec/images/misc/download-playstore.png') }}" class="img-fluid_"></a>

                </div>

            </div>
        </div>


    </div>
</div>

</div>




</body>
</html>
