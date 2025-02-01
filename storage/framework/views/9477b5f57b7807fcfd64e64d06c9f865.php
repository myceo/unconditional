<div class="mb-3 pb-5">
    <form  wire:submit="submit">
    <div class="row">
        <div class="col-md-10 offset-md-1">

            <div class="card">
                <div class="card-header">
                    <?php echo e(__('site.'.'p'.'c'.'v')); ?>

                </div>
                <div class="card-body">
                    <!--[if BLOCK]><![endif]--><?php if(!empty($message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <p>    <?php echo e(__('site.e'.'p'.'u'.'c')); ?></p>
                    <div class="form-group">
                        <label for="code"> <?php echo e(__('site.'.'p'.'u'.'c')); ?></label>
                        <input wire:model="code" type="text" required
                               class="form-control" name="code" id="code" aria-describedby="code" >
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                </div>
            </div>

            <div class="pt-2">
                <button type="submit"  class="btn btn-primary float-right"><?php echo app('translator')->get('site.proceed'); ?> <i wire:loading.remove  wire:target="submit"  class="fa fa-arrow-circle-right"
                                                                                                    aria-hidden="true"></i>
                    <i wire:loading wire:target="submit" class="fa fa-spinner fa-spin"></i>
                </button>
            </div>
        </div>
    </div>
    </form>
</div>
<?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/livewire/site/setup.blade.php ENDPATH**/ ?>