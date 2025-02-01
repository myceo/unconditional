<?php $__env->startSection('pageTitle',__('saas.domains')); ?>
<?php $__env->startSection('page-title',__('saas.domains')); ?>

<?php $__env->startSection('page-content'); ?>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home"><?php echo app('translator')->get('saas.domains'); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu1"><?php echo app('translator')->get('saas.change'); ?> <?php echo app('translator')->get('saas.domain'); ?></a>
        </li>

    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane container active" id="home" style="padding-top: 30px">

            <ul>
                <?php $__currentLoopData = $domains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $domain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($domain->fqdn); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

        </div>
        <div class="tab-pane container fade" id="menu1"  style="padding-top: 30px">
            <form action="<?php echo e(route('user.domains.save')); ?>" method="post">
            <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for=""><?php echo app('translator')->get('saas.username'); ?></label>
                    <input required class="form-control" type="text" name="username" placeholder="<?php echo app('translator')->get('saas.username'); ?>"/>
                </div>
<button type="submit" class="btn btn-primary"><?php echo app('translator')->get('saas.save'); ?></button>
            </form>

        </div>


    </div>



<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.account-page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/subscriber/home/domains.blade.php ENDPATH**/ ?>