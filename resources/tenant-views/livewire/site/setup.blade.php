<div class="mb-3 pb-5">
    <form  wire:submit="submit">
    <div class="row">
        <div class="col-md-10 offset-md-1">

            <div class="card">
                <div class="card-header">
                    {{ __('site.'.'p'.'c'.'v') }}
                </div>
                <div class="card-body">
                    @if(!empty($message))
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <p>    {{ __('site.e'.'p'.'u'.'c') }}</p>
                    <div class="form-group">
                        <label for="code"> {{ __('site.'.'p'.'u'.'c') }}</label>
                        <input wire:model="code" type="text" required
                               class="form-control" name="code" id="code" aria-describedby="code" >
                        @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                </div>
            </div>

            <div class="pt-2">
                <button type="submit"  class="btn btn-primary float-right">@lang('site.proceed') <i wire:loading.remove  wire:target="submit"  class="fa fa-arrow-circle-right"
                                                                                                    aria-hidden="true"></i>
                    <i wire:loading wire:target="submit" class="fa fa-spinner fa-spin"></i>
                </button>
            </div>
        </div>
    </div>
    </form>
</div>
