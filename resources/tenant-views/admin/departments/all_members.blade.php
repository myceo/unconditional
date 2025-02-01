<div class="row">
    <div class="col-md-6">
        <form style="margin-bottom: 20px"  method="GET" action="{{ route('dept.all-members',['department'=>$department->id]) }}" role="search" class="sr-input-func form-inline ajax-form">
            <input id="ajaxinput" name="search" value="{{ request('search') }}" type="text" placeholder="{{ ucfirst(__('site.search')) }}..." class="search-int form-control">


        </form>
    </div>
    <div class="col-md-2">
        <label><input type="checkbox" id="allCheckAll"/> @lang('admin.check-all')</label>
    </div>
    <div class="col-md-4">
        <button type="button" onclick="$('#add-form').submit()" class="btn btn-primary float-right"><i class="fa fa-plus"></i> @lang('admin.add-selected')</button>

    </div>
</div>

<form id="add-form" action="{{ route('dept.add-members',['department'=>$department->id]) }}" method="post">
    @csrf
    <div class="contacts-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                @if(empty($total))
                    <p>@lang('admin.no-results')</p>
                    @endif
                @foreach($members as $item)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">



                        <div class="user-item">

                            @if(!empty($item->picture))
                                <img src="{{ asset($item->picture) }}"  class="img-fluid" />
                            @else
                                <img src="{{ avatar($item->gender) }}"  class="img-fluid"   />
                            @endif

                            <div class="user-details mb-5">
                                <div class="user-name"><input type="checkbox" name="{{ $item->id }}" value="{{ $item->id }}" > &nbsp; {{ $item->name }} </div>
                                <div class="text-job text-muted">{{ gender($item->gender) }}</div>
                                <div class="user-cta">

                                    <a class="btn btn-primary" href="{{ url('/admin/members/' . $item->id) }}">@lang('admin.details')</a>
                                </div>
                            </div>
                        </div>


                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
<div class="ajax-links">
{!! $members->appends(['search' => Request::get('search')])->render() !!}
</div>
