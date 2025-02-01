
<?php $__env->startSection('pageTitle',__('saas.cart')); ?>
<?php $__env->startSection('page-title',__('saas.cart')); ?>
<?php $__env->startSection('page-content'); ?>
    <div class="card-box">
        <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th><?php echo app('translator')->get('saas.invoice-no'); ?></th>
                <th><?php echo app('translator')->get('saas.item'); ?></th>
                <th><?php echo app('translator')->get('saas.amount'); ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>#<?php echo e($invoice->id); ?> </td>
                <td><?php echo e($description); ?> </td>
                <td><?php echo clean( price($invoice->amount,$invoice->currency_id)); ?></td>
                <td><a  title="<?php echo app('translator')->get('saas.delete'); ?>"  href="<?php echo e(route('user.invoice.cancel')); ?>"><i class="fa fa-trash"></i></a></td>
            </tr>


            </tbody>
        </table>
        </div>
        <form action="<?php echo e(route('user.invoice.set-method')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-4 offset-md-8">
                    <br/>
                    <ul class="list-group">
                        <li class="list-group-item active"><?php echo app('translator')->get('saas.payment-methods'); ?></li>
                        <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item" style="padding-left: 40px">

                            <input class="form-check-input" type="radio" name="method" id="method<?php echo e($method->id); ?>" value="<?php echo e($method->id); ?>">
                            <label style="width: 100%;" class="form-check-label" for="method<?php echo e($method->id); ?>">
                                <?php echo e($method->method_label); ?>

                            </label>


                        </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                    <br/>
                </div>
            </div>
            <button class="btn btn-primary btn-lg float-right"><?php echo app('translator')->get('saas.proceed-payment'); ?></button>
        </form>

        <a style="margin-top: 30px" class="btn btn-sm" data-toggle="modal" data-target="#currencyModal" href="#"><?php echo app('translator')->get('saas.change-currency'); ?></a>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.account-page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/subscriber/billing/cart.blade.php ENDPATH**/ ?>