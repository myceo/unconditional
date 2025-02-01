<?php $__env->startSection('pageTitle',__('saas.dashboard')); ?>

<?php if(false): ?>
<?php $__env->startSection('page-header'); ?>
    <div class="row">
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Traffic</h5>
                            <span class="h2 font-weight-bold mb-0">350,897</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                        <span class="text-nowrap">Since last month</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">New users</h5>
                            <span class="h2 font-weight-bold mb-0">2,356</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
                        <span class="text-nowrap">Since last week</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
                            <span class="h2 font-weight-bold mb-0">924</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                        <span class="text-nowrap">Since yesterday</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Performance</h5>
                            <span class="h2 font-weight-bold mb-0">49,65%</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                <i class="fas fa-percent"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                        <span class="text-nowrap">Since last month</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php endif; ?>
<?php $__env->startSection('content'); ?>
    <?php if($subscribed): ?>
    <div class="row">
        <div class="col-xl-8 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="mb-0"><?php echo app('translator')->get('saas.info'); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if($user->subscriber()->exists() && $user->subscriber->website->hostnames()->exists()): ?>
                        <h4 style="text-align: center"><?php echo app('translator')->get('saas.app-url'); ?>: <a href="http://<?php echo e($user->subscriber->website->hostnames()->latest()->first()->fqdn); ?>"><?php echo e($user->subscriber->website->hostnames()->latest()->first()->fqdn); ?></a></h4>
                        <?php endif; ?>

                    <div id="stats-box">
                        <?php echo app('translator')->get('saas.loading'); ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1"><?php echo app('translator')->get('saas.current-plan'); ?></h6>
                            <h2 class="mb-0"><?php echo e($user->subscriber->packageDuration->package->name); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="text-align: center">
                    <h1 style="text-align: center; font-size: 60px; margin-top: -30px;"><?php if(empty($user->subscriber->packageDuration->package->is_free)): ?><?php echo clean( price($user->subscriber->packageDuration->price)); ?><?php else: ?> <?php echo app('translator')->get('saas.free'); ?> <?php endif; ?></h1>
                    <div style="margin-bottom: 20px" ><small>
                            <?php if($user->subscriber->packageDuration->type=='m'): ?>
                            <?php echo app('translator')->get('saas.monthly'); ?>
                                <?php else: ?>
                            <?php echo app('translator')->get('saas.yearly'); ?>

                            <?php endif; ?>
                        </small>
                    <div>
                        <small><?php echo app('translator')->get('saas.expires'); ?>: <?php echo e(date('d/M/Y',$user->subscriber->expires)); ?></small>
                    </div>
                    </div>


                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?php echo e($user->subscriber->packageDuration->package->user_limit); ?> <?php echo app('translator')->get('saas.users'); ?></li>
                        <li class="list-group-item"><?php echo e($user->subscriber->packageDuration->package->department_limit); ?> <?php echo app('translator')->get('admin.departments'); ?></li>
                        <li class="list-group-item"><?php echo e($user->subscriber->packageDuration->package->storage_space); ?><?php echo e($user->subscriber->packageDuration->package->storage_unit); ?> <?php echo app('translator')->get('saas.disk-space'); ?></li>

                    </ul>

                </div>
            </div>
        </div>

    </div>
    <?php endif; ?>
    <div class="row mt-5">
        <div class="col-xl-8 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0"><?php echo app('translator')->get('saas.invoices'); ?></h3>
                        </div>
                        <div class="col text-right">
                            <a href="<?php echo e(route('user.billing.invoices')); ?>" class="btn btn-sm btn-primary"><?php echo app('translator')->get('saas.view-all'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th><?php echo app('translator')->get('saas.item'); ?></th>
                            <th><?php echo app('translator')->get('saas.amount'); ?></th>
                            <th><?php echo app('translator')->get('saas.created-on'); ?></th>
                            <th><?php echo app('translator')->get('saas.status'); ?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $user->invoices()->latest()->limit(7)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>#<?php echo e($invoice->id); ?></td>
                                <td><?php echo e($invoice->invoicePurpose->purpose); ?></td>
                                <td><?php echo clean( price($invoice->amount,$invoice->currency_id)); ?></td>
                                <td><?php echo e($invoice->created_at); ?></td>
                                <td>
                                    <?php echo e(($invoice->paid==0)?__('saas.unpaid'):__('saas.paid')); ?>

                                </td>
                                <td>
                                    <?php if($invoice->paid==0): ?>
                                        <a class="btn btn-success" href="<?php echo e(route('user.billing.pay',['invoice'=>$invoice->id])); ?>"><i class="fa fa-money-check"></i> <?php echo app('translator')->get('saas.pay-now'); ?></a>
                                    <?php endif; ?>
                                    <a class="btn btn-primary" href="<?php echo e(route('user.billing.invoice',['invoice'=>$invoice->id])); ?>"><i class="fa fa-eye"></i> <?php echo app('translator')->get('saas.view'); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header  ">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0"><?php echo app('translator')->get('saas.domains'); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <?php if($user->subscriber()->exists()): ?>
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">

                        <tbody>
                        <?php $__currentLoopData = $user->subscriber->website->hostnames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $domain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th scope="row">
                                <a href="http://<?php echo e($domain->fqdn); ?>"><?php echo e($domain->fqdn); ?></a>
                            </th>

                        </tr>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('footer'); ?>
    <script>
        $('#stats-box').load('<?php echo e(route('user.get-stats')); ?>');
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/subscriber/home/dashboard.blade.php ENDPATH**/ ?>