@foreach($crumbs as $crumb)
    @if($crumb['link']=='#')
        <li class="breadcrumb-item  @if ($loop->last)active @endif "  @if ($loop->last)aria-current="page" @endif >{{ $crumb['page'] }}</li>
    @else
    <li class="breadcrumb-item  @if ($loop->last)active @endif "  @if ($loop->last)aria-current="page" @endif ><a href="{{ $crumb['link'] }}">{{ $crumb['page'] }}</a></li>
    @endif
@endforeach
