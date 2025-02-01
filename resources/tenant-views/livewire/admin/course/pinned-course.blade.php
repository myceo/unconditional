<div style="position: absolute;z-index:1;right: 20px">
  @if($course->pinned==1)
        <a wire:click="setPinned(0)"   data-toggle="tooltip" data-placement="top" title="@lang('site.unpin-item')" href="javascript:;"><i class="fa fa-thumbtack"></i></a>

    @else
        <a wire:click="setPinned(1)"  class="text-light"  data-toggle="tooltip" data-placement="top" title="@lang('site.pin-item')"  href="javascript:;"><i class="fa fa-thumbtack"></i></a>
    @endif
</div>
