@extends('layouts.member')
@section('pageTitle',__('admin.my-shifts'))

@section('innerTitle')

        @if(empty($start) && empty($end))
            @lang('admin.my-shifts')
        @else
            @lang('admin.my-shifts')
            @if(Request::get('start'))
                : {{ Request::get('start') }}
            @endif
            @if(Request::get('end'))
                @lang('to')   {{ Request::get('end') }}
            @endif
        @endif

@endsection

@section('breadcrumb')
    <li><a href="{{ route('member.dashboard') }}">@lang('admin.dashboard')</a>
    </li>
    <li><span>@lang('admin.my-shifts')</span>
    </li>
@endsection

@section('content')
     <div class="product-status-wrap">
                        <div class="mb-3 ">
                            <form  method="GET" action="{{ route('member.events.shifts') }}" >
                                <div class="row">
                                    <div class="col-md-3">
                                        <input placeholder="@lang('admin.from')" class="form-control date" type="text" name="start" value="{{ $start }}"/>
                                    </div>
                                    <div class="col-md-3">
                                        <input placeholder="@lang('admin.to')" class="form-control date" type="text" name="end" value="{{ $end }}"/>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-primary" type="submit">@lang('admin.filter')</button>
                                        <a class="btn btn-default" href="{{ route('member.events.shifts') }}">@lang('admin.reset')</a>
                                    </div>
                                </div>
                            </form>
                        </div>



         <div class="card">
             @if($shifts->count()==0)
             <div class="card-header">

                     <h4>@lang('admin.no-results')</h4>

             </div>
             @endif
             <div class="card-body">
                 <table class="table table-striped">
                     <thead>
                     <tr>
                         <th>@lang('admin.event')</th>
                         <th>@lang('admin.date')</th>
                         <th>@lang('admin.shift')</th>
                         <th>@lang('admin.starts')</th>
                         <th>@lang('admin.ends')</th>
                         <th>@lang('admin.tasks')</th>
                         <th>@lang('admin.actions')</th>
                     </tr>
                     </thead>
                     <tbody>



                     @foreach($shifts as $shift)
                         <tr>
                             <td>{{ $shift->event->name }}</td>
                             <td>{{ \Carbon\Carbon::parse($shift->event->event_date)->format('D d/M/Y') }}</td>
                             <td>{{ $shift->name }}</td>
                             <td>{{ \Illuminate\Support\Carbon::parse($shift->starts)->format('h:i A') }}</td>
                             <td>{{ \Illuminate\Support\Carbon::parse($shift->ends)->format('h:i A') }}</td>
                             <td>{{ $shift->pivot->tasks }}</td>
                             <td>
                                 <div class="row">
                                     <div class="col-md-5">
                                         <a class="btn btn-danger  btn-sm" href="#"  data-toggle="modal" data-target="#myModal{{ $shift->id }}">@lang('admin.opt-out')</a>
                                     </div>
                                     <div class="col-md-5">
                                         <a class="btn btn-primary  btn-sm" href="#"   data-toggle="modal" data-target="#myModalInfo{{ $shift->id }}">@lang('admin.event') @lang('admin.info')</a>
                                       </div>
                                     <div class="col-md-2"></div>
                                 </div>

                               @section('footer')
                                   @parent
                                   <!-- Modal -->
                                       <div class="modal fade" id="myModal{{ $shift->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{ $shift->id }}">
                                           <div class="modal-dialog" role="document">
                                               <form action="{{ route('member.events.opt-out',['shift'=>$shift->id]) }}" method="post">
                                                   @csrf
                                                   <div class="modal-content">
                                                       <div class="modal-header">
                                                          <h4 class="modal-title" id="myModalLabel{{ $shift->id }}">@lang('admin.shift') {{ \Illuminate\Support\Carbon::parse($shift->starts)->format('h:i A') }} to {{ \Illuminate\Support\Carbon::parse($shift->ends)->format('h:i A') }} ({{ $shift->name }}) @lang('admin.opt-out')</h4>
                                                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                               <span aria-hidden="true">&times;</span>
                                                           </button>
                                                       </div>
                                                       <div class="modal-body">
                                                           <div class="form-group">
                                                               <label for="message">@lang('admin.reject-reason')</label>
                                                               <textarea required class="form-control"
                                                                         name="message" id="message{{ $shift->id }}"
                                                                         rows="4"></textarea>
                                                           </div>
                                                       </div>
                                                       <div class="modal-footer">
                                                           <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.close')</button>
                                                           <button type="submit" class="btn btn-danger">@lang('admin.opt-out')</button>
                                                       </div>
                                                   </div>
                                               </form>

                                           </div>
                                       </div>


                                       <!-- Modal -->
                                       <div class="modal fade" id="myModalInfo{{ $shift->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabelInfo{{ $shift->id }}">
                                           <div class="modal-dialog modal-lg" role="document">
                                               @csrf
                                               <div class="modal-content">
                                                   <div class="modal-header">
                                                       <h4 class="modal-title" id="myModalLabelInfo{{ $shift->id }}">{{ $shift->event->name }}({{ \Carbon\Carbon::parse($shift->event->event_date)->format('D d/M/Y') }})</h4>
                                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                           <span aria-hidden="true">&times;</span>
                                                       </button>
                                                   </div>
                                                   <div class="modal-body">





                                                       <ul class="nav nav-tabs" id="myTab{{ $shift->id }}" role="tablist">
                                                           <li class="nav-item">
                                                               <a class="nav-link active" id="home-tab{{ $shift->id }}" data-toggle="tab" href="#home{{ $shift->id }}" role="tab" aria-controls="home{{ $shift->id }}" aria-selected="true">@lang('admin.info')</a>
                                                           </li>
                                                           <li class="nav-item">
                                                               <a class="nav-link" id="profile-tab{{ $shift->id }}" data-toggle="tab" href="#profile{{ $shift->id }}" role="tab" aria-controls="profile{{ $shift->id }}" aria-selected="false">@lang('admin.shifts')</a>
                                                           </li>

                                                       </ul>
                                                       <div class="tab-content" id="myTabContent{{ $shift->id }}">
                                                           <div class="tab-pane fade show active" id="home{{ $shift->id }}" role="tabpanel" aria-labelledby="home-tab{{ $shift->id }}">


                                                               <table class="table mt-2" >

                                                                   <tr>
                                                                       <td style="border-top: none"><strong>@lang('admin.starts'):</strong></td>
                                                                       <td style="border-top: none">{{ \Carbon\Carbon::parse($shift->event->event_date)->format('D d/M/Y') }} ({{ \Carbon\Carbon::parse($shift->event->event_date)->diffForHumans() }})</td>
                                                                   </tr>

                                                                   @if(!empty($shift->event->venue))
                                                                       <tr>
                                                                           <td><strong>@lang('admin.venue'):</strong></td>
                                                                           <td>{{ $shift->event->venue }}</td>
                                                                       </tr>
                                                                   @endif
                                                                   <tr>
                                                                       <td><strong>@lang('admin.shifts'):</strong></td>
                                                                       <td>{{ $shift->event->shifts()->count() }}</td>
                                                                   </tr>
                                                                   <?php
                                                                   $users = [];
                                                                   ?>
                                                                   @foreach($shift->event->shifts as $shift2)
                                                                       @foreach($shift2->users as $user)
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



                                                               </table>


                                                               @if(!empty($shift->event->description))
                                                                   <div class="alert alert-success" role="alert">{!! nl2br(clean($shift->event->description)) !!}</div>
                                                               @endif


                                                           </div>
                                                           <div class="tab-pane fade" id="profile{{ $shift->id }}" role="tabpanel" aria-labelledby="profile-tab{{ $shift->id }}">
                                                               @foreach($shift->event->shifts()->orderBy('starts')->get() as $shift)
                                                                   <div style="border: solid 1px #CCCCCC; padding-left: 15px; padding-right: 15px; margin-bottom: 30px">
                                                                       <h3 style="margin-top: 20px">{{ \Illuminate\Support\Carbon::parse($shift->starts)->format('h:i A') }} to {{ \Illuminate\Support\Carbon::parse($shift->ends)->format('h:i A') }} <span class="float-right">{{ $shift->name }}</span></h3>

                                                                       <table class="table">
                                                                           <thead>
                                                                           <tr>
                                                                               <th>@lang('admin.members')</th>
                                                                               <th>@lang('admin.tasks')</th>
                                                                           </tr>
                                                                           </thead>
                                                                           <tbody>
                                                                           @foreach($shift->users()->orderBy('name')->get() as $user)
                                                                               <tr>
                                                                                   <td>{{ $user->name }}</td>
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
                                                               @endforeach

                                                           </div>

                                                       </div>

                                                   </div>
                                                   <div class="modal-footer">
                                                       <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('admin.close')</button>
                                                   </div>
                                               </div>

                                           </div>
                                       </div>

                                   @endsection

                             </td>
                         </tr>

                     @endforeach


                     </tbody>
                 </table>


             </div>
             <div class="card-footer">
                 {!! $shifts->appends(['start' => Request::get('start'),'end'=> Request::get('end')])->render() !!}

             </div>
         </div>



                    </div>

@endsection



@section('header')
    <link href="{{ asset('vendor/pickadate/themes/default.date.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/pickadate/themes/default.time.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/pickadate/themes/default.css') }}" rel="stylesheet">


@endsection


@section('footer')


    <script src="{{ asset('vendor/pickadate/picker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/pickadate/picker.date.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/pickadate/picker.time.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/pickadate/legacy.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('.date').pickadate({
            format: 'yyyy-mm-dd'
        });
    </script>
@endsection
