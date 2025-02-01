

<?php $__env->startSection('pageTitle',__('saas.plan').': '.$plan->name); ?>
<?php $__env->startSection('page-title',__('saas.plan').': '.$plan->name); ?>

<?php $__env->startSection('page-content'); ?>
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div  >
                    <div  >

                        <a href="<?php echo e(url('/admin/plans')); ?>" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo app('translator')->get('saas.back'); ?></button></a>
                        <a href="<?php echo e(url('/admin/plans/' . $plan->id . '/edit')); ?>" title="Edit plan"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo app('translator')->get('saas.edit'); ?></button></a>

                        <form method="POST" action="<?php echo e(url('admin/plans' . '/' . $plan->id)); ?>" accept-charset="UTF-8" style="display:inline">
                            <?php echo e(method_field('DELETE')); ?>

                            <?php echo e(csrf_field()); ?>

                            <button type="submit" class="btn btn-danger btn-sm" title="<?php echo app('translator')->get('saas.delete'); ?> plan" onclick="return confirm(&quot;<?php echo app('translator')->get('saas.confirm-delete'); ?>?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> <?php echo app('translator')->get('saas.delete'); ?></button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th><?php echo app('translator')->get('saas.id'); ?></th><td><?php echo e($plan->id); ?></td>
                                    </tr>
                                    <tr><th> <?php echo app('translator')->get('saas.name'); ?> </th><td> <?php echo e($plan->name); ?> </td></tr><tr><th> <?php echo app('translator')->get('saas.sort-order'); ?> </th><td> <?php echo e($plan->sort_order); ?> </td></tr><tr><th> <?php echo app('translator')->get('saas.storage-space'); ?> </th><td> <?php echo e($plan->storage_space); ?> <?php echo e($plan->storage_unit); ?></td> </tr>
                                <tr>
                                    <th><?php echo app('translator')->get('saas.user-limit'); ?></th>
                                    <td><?php echo e(limit($plan->user_limit)); ?></td>
                                </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('saas.department-limit'); ?></th>
                                        <td><?php echo e(limit($plan->department_limit)); ?></td>
                                    </tr>
                                <tr>
                                    <th><?php echo app('translator')->get('saas.is-free'); ?></th>
                                    <td><?php echo e(boolToString($plan->is_free)); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo app('translator')->get('saas.visibility'); ?></th>
                                    <td>
                                        <?php if($plan->public==1): ?>
                                            <?php echo app('translator')->get('saas.public'); ?>
                                            <?php else: ?>
                                            <?php echo app('translator')->get('saas.private'); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/admin/plans/show.blade.php ENDPATH**/ ?>