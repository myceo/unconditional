

<?php $__env->startSection('pageTitle',__('saas.create-new').' '.__('saas.subscriber')); ?>
<?php $__env->startSection('page-title',__('saas.create-new').' '.__('saas.subscriber')); ?>

<?php $__env->startSection('page-content'); ?>
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div  >
                    <div >
                        <a href="<?php echo e(url('/admin/subscribers')); ?>" title="<?php echo app('translator')->get('saas.back'); ?>"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo app('translator')->get('saas.back'); ?></button></a>
                        <br />
                        <br />



                        <form method="POST" action="<?php echo e(url('/admin/subscribers')); ?>" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>


                            <?php echo $__env->make('admin.subscribers.form', ['formMode' => 'create'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/admin/subscribers/create.blade.php ENDPATH**/ ?>