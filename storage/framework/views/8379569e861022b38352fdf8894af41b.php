<?php $__env->startSection('pageTitle',__('saas.mailing-list')); ?>
<?php $__env->startSection('page-title',__('saas.mailing-list')); ?>

    <?php $__env->startSection('breadcrumb'); ?>
        <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('saas.mailing-list'); ?></li>
        <?php $__env->stopSection(); ?>


<?php $__env->startSection('page-content'); ?>
    <?php if(Session::has('flash_message')): ?>
        <?php echo e(Session::get('flash_message')); ?>

        <?php else: ?>
    <?php echo app('translator')->get('saas.email-saved'); ?>
    <?php endif; ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site-page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/site/index/list.blade.php ENDPATH**/ ?>