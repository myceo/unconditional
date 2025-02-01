
<?php $__env->startSection('pageTitle','Offline Documentation'); ?>
<?php $__env->startSection('content'); ?>

    <div>
        <p>
            Download the latest version of our documentation in PDF format here.
        </p>
        <form method="post" class="form" action="<?php echo e(route('docs.download')); ?>">
            <?php echo e(csrf_field()); ?>

            <button class="btn btn-primary" type="submit">Download</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li><a href="<?php echo e(route('docs.index')); ?>">Table Of Contents</a></li>
    <li class="active">Offline Documentation</li>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.doc', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/site/docs/offline.blade.php ENDPATH**/ ?>