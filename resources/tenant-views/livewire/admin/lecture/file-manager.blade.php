<div>
    <div class="row">
        <div class="col-md-6">
            <input class="form-control" type="file" wire:model.live="file">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" wire:click="upload"><i class="fa fa-upload" aria-hidden="true"></i> @lang('site.upload')</button>
        </div>
        <div wire:loading class="col-md-2">
            <img src="{{ asset('img/ajax-loader.gif') }}" >
        </div>
    </div>


    @error('file')
    <div class="text-red-500">{{ $message }}</div>
    @enderror
    <br>

    <table class="table">
        <thead>
        <tr>
            <th>@lang('site.file')</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($lectureFiles as $lectureFile)
        <tr>
            <td scope="row">{{ $lectureFile->name }}</td>
            <td>   <button class="btn btn-danger btn-icon btn-sm" onclick="confirm('@lang('site.confirm-delete')') || event.stopImmediatePropagation()"   wire:click="delete({{ $lectureFile->id }})"><i class="fa fa-trash"></i></button>
                @livewire('utils.download-button',['filePath'=>$lectureFile->path,'fileName'=>$lectureFile->name],key($lectureFile->id))
            </td>
        </tr>
        @endforeach

        </tbody>
    </table>
    {{ $lectureFiles->links() }}
</div>
