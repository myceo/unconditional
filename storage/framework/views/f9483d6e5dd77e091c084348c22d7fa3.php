<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <?php if (! empty(trim($__env->yieldContent('page-title')))): ?>
                <div class="card-header border-0">
                    <h3 class="mb-0"><?php echo $__env->yieldContent('page-title'); ?></h3>
                </div>
                <?php endif; ?>

                <div class="card-body">
                    <?php echo $__env->yieldContent('page-content'); ?>
                </div>

                <?php if (! empty(trim($__env->yieldContent('page-footer')))): ?>
                <div class="card-footer py-4">
                    <?php echo $__env->yieldContent('page-footer'); ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>






<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/layouts/account-page.blade.php ENDPATH**/ ?>