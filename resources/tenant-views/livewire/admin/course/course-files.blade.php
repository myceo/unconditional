<div>
    <table class="table">
        @foreach($course->courseFiles as $file)
            <tr>
                <td>{{ $file->name }}</td>
                <td>
                    @if($showDelete)
                    <button  onclick="confirm('@lang('site.confirm-delete')') || event.stopImmediatePropagation()"  wire:click="delete({{ $file->id }})" type="button" class="btn btn-icon btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    @endif
                    <button class="btn btn-sm btn-icon btn-primary" wire:click="download({{ $file->id }})"><i class="fa fa-download"></i></button>
                </td>
            </tr>
        @endforeach
    </table>

</div>
