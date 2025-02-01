<?php $__env->startSection('pageTitle',__('saas.pricing')); ?>
<?php $__env->startSection('page-title',__('saas.pricing')); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('saas.pricing'); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('page-content'); ?>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home"><?php echo app('translator')->get('saas.monthly-plans'); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu1"><?php echo app('translator')->get('saas.annual-plans'); ?></a>
        </li>

    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane container active" id="home" style="padding-top: 30px">

            <div class="row">

                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php $__currentLoopData = $package->packageDurations()->where('type','m')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4" style=" margin-bottom: 20px">
                            <div class="card" style="text-align: center; " >
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 20px"><?php echo e($plan->package->name); ?></h5>
                                    <p class="card-text">
                                    <h1 style="text-align: center; font-size: 60px; margin-top: -30px;"><?php if(empty($package->is_free)): ?><?php echo clean( price($plan->price)); ?><?php else: ?> <?php echo app('translator')->get('saas.free'); ?> <?php endif; ?></h1>
                                    <div style="margin-bottom: 20px" ><small><?php echo app('translator')->get('saas.monthly'); ?></small></div>

                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><?php echo e(!empty($package->user_limit)? $package->user_limit:__('saas.unlimited')); ?> <?php echo app('translator')->get('saas.users'); ?></li>
                                        <li class="list-group-item"><?php echo e(!empty($package->department_limit)? $package->department_limit:__('saas.unlimited')); ?> <?php echo app('translator')->get('admin.departments'); ?></li>
                                        <li class="list-group-item"><?php echo e(!empty($package->storage_space)? $package->storage_space.$package->storage_unit:__('saas.unlimited')); ?> <?php echo app('translator')->get('saas.disk-space'); ?></li>

                                    </ul>
                                    </p>

                                    <a class="btn btn-primary" href="<?php echo e(url('/register')); ?>"><?php echo app('translator')->get('saas.select-plan'); ?></a>

                                </div>
                            </div>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

        </div>
        <div class="tab-pane container fade" id="menu1"  style="padding-top: 30px">

            <div class="row">

                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php $__currentLoopData = $package->packageDurations()->where('type','a')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4" style=" margin-bottom: 20px">
                            <div class="card" style="text-align: center; " >
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 20px"><?php echo e($plan->package->name); ?></h5>
                                    <p class="card-text">
                                    <h1 style="text-align: center; font-size: 60px; margin-top: -30px;"><?php if(empty($package->is_free)): ?><?php echo clean( price($plan->price)); ?><?php else: ?> <?php echo app('translator')->get('saas.free'); ?> <?php endif; ?></h1>
                                    <div style="margin-bottom: 20px" ><small><?php echo app('translator')->get('saas.yearly'); ?></small></div>

                                    <ul class="list-group list-group-flush">

                                        <li class="list-group-item"><?php echo e(!empty($package->user_limit)? $package->user_limit:__('saas.unlimited')); ?> <?php echo app('translator')->get('saas.users'); ?></li>
                                        <li class="list-group-item"><?php echo e(!empty($package->department_limit)? $package->department_limit:__('saas.unlimited')); ?> <?php echo app('translator')->get('admin.departments'); ?></li>
                                        <li class="list-group-item"><?php echo e(!empty($package->storage_space)? $package->storage_space.$package->storage_unit:__('saas.unlimited')); ?> <?php echo app('translator')->get('saas.disk-space'); ?></li>

                                    </ul>
                                    </p>

                                    <a class="btn btn-primary" href="<?php echo e(url('/register')); ?>"><?php echo app('translator')->get('saas.select-plan'); ?></a>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

        </div>


    </div>

    <div class="container">
        <a style="margin-top: 30px" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#currencyModal" href="#"><?php echo app('translator')->get('saas.change-currency'); ?></a>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site-page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/site/index/pricing.blade.php ENDPATH**/ ?>