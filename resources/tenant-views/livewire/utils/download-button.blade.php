<div class="float-left">
 <button wire:click="download" class="btn btn-success btn-icon {{ $btnSize }}">
    <span wire:loading>
             <i class="fa fa-spinner fa-spin"></i>
    </span>
     <span wire:loading.remove>
             <i class="fa fa-download"></i>
    </span>
 </button>
</div>
