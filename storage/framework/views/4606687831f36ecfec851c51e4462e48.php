


<?php $__env->startSection('pageTitle',__('saas.plans')); ?>
<?php $__env->startSection('page-title',__('saas.manage-plans')); ?>

<?php $__env->startSection('page-content'); ?>
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div >
                    <div  >
                        <a href="<?php echo e(url('/admin/plans/create')); ?>" class="btn btn-success btn-sm" title="<?php echo app('translator')->get('saas.add-new'); ?> plan">
                            <i class="fa fa-plus" aria-hidden="true"></i> <?php echo app('translator')->get('saas.add-new'); ?>
                        </a>



                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th><?php echo app('translator')->get('saas.name'); ?></th><th><?php echo app('translator')->get('saas.sort-order'); ?></th><th><?php echo app('translator')->get('saas.subscribers'); ?></th>
                                        <th><?php echo app('translator')->get('saas.monthly-price'); ?></th>
                                        <th><?php echo app('translator')->get('saas.annual-price'); ?></th>
                                        <th><?php echo app('translator')->get('saas.actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($item->name); ?></td><td><?php echo e($item->sort_order); ?></td><td><?php echo e($item->subscribers->count()); ?></td>
                                        <td><?php echo e(price($item->packageDurations()->where('type','m')->first()->price)); ?></td>
                                        <td><?php echo e(price($item->packageDurations()->where('type','a')->first()->price)); ?></td>
                                        <td>
                                            <a href="<?php echo e(url('/admin/plans/' . $item->id)); ?>" title="View plan"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo app('translator')->get('saas.view'); ?></button></a>
                                            <a href="<?php echo e(url('/admin/plans/' . $item->id . '/edit')); ?>" title="Edit plan"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> <?php echo app('translator')->get('saas.edit'); ?></button></a>

                                            <form method="POST" action="<?php echo e(url('/admin/plans' . '/' . $item->id)); ?>" accept-charset="UTF-8" style="display:inline">
                                                <?php echo e(method_field('DELETE')); ?>

                                                <?php echo e(csrf_field()); ?>

                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete plan" onclick="return confirm(&quot;<?php echo app('translator')->get('saas.confirm-delete'); ?>?&quot;)"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo app('translator')->get('saas.delete'); ?></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> <?php echo clean( $plans->appends(['search' => Request::get('search')])->render()); ?> </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/admin/plans/index.blade.php ENDPATH**/ ?>