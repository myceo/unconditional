<div class="col-md-4">

    <div class="card"  >
         @if(!empty($department->picture) && file_exists($department->picture))
            <a href="{{ route('site.department',['department'=>$department->id]) }}"><img  class="card-img-top"  src="{{ asset($department->picture) }}"  ></a>
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $department->name }}</h5>
            <p class="card-text">{{ limitLength($department->description,200) }}</p>
            <p class="card-text">
            @if(setting('general_member_count')==1)
                 <b>@lang('site.members'):</b> {{ $department->users()->count() }} <br>
            @endif

             <b>@lang('site.new-membership'):</b> @if($department->enroll_open==1) @lang('site.open') @else @lang('site.closed') @endif
                <br>

            @if($department->enroll_open==1)
                 <b>@lang('site.enrollment'):</b>
                    @if($department->approval_required==1)
                        @lang('site.approval-required')
                    @else
                        @lang('site.instant')
                    @endif <br>
                @endif
            </p>


            <a class="btn btn-primary" href="{{ route('site.department',['department'=>$department->id]) }}"><i class="fas fa-info-circle"></i> @lang('site.details')</a>
            @if($department->enroll_open==1)

                @if($department->approval_required==1)
                    <a class="btn btn-success" href="{{ route('site.apply',['department'=>$department->id]) }}"><i class="fas fa-user-plus"></i> @lang('site.apply')</a>
                @else
                    <a class="btn btn-success" href="{{ route('site.join-department',['department'=>$department->id]) }}"><i class="fas fa-user-plus"></i> @lang('site.join')</a>
                @endif

            @endif
        </div>
    </div>







</div>
