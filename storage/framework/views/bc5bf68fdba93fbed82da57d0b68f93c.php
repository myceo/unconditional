<?php $__env->startSection('search-form'); ?>
    <!-- Form -->
    <form  method="GET" action="<?php echo e(url('/admin/subscribers')); ?>"  class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
        <div class="form-group mb-0">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input value="<?php echo e(request('search')); ?>" name="search"  class="form-control" placeholder="<?php echo app('translator')->get('admin.search'); ?> <?php echo app('translator')->get('saas.subscribers'); ?>" type="text">
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="row">
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0"><?php echo app('translator')->get('saas.subscribers'); ?></h5>
                            <span class="h2 font-weight-bold mb-0"><?php echo e(number_format($totalSubscribers)); ?></span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>

                    <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-nowrap"><?php echo app('translator')->get('saas.active-text'); ?></span>
                    </p>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0"><?php echo app('translator')->get('saas.total-sales'); ?></h5>
                            <span class="h2 font-weight-bold mb-0"><?php echo e(price($totalSales)); ?></span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-nowrap"><?php echo app('translator')->get('saas.sales-total'); ?></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0"><?php echo app('translator')->get('saas.month-sales'); ?></h5>
                            <span class="h2 font-weight-bold mb-0"><?php echo e(price($monthSales)); ?></span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-nowrap"><?php echo app('translator')->get('saas.sales-month'); ?></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0"><?php echo app('translator')->get('saas.annual-sales'); ?></h5>
                            <span class="h2 font-weight-bold mb-0"><?php echo e(price($yearSales)); ?></span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                <i class="fas fa-search-dollar"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-nowrap"><?php echo app('translator')->get('saas.sales-annual'); ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-7 mb-5 mb-xl-0">
            <div class="card bg-gradient-default shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-light ls-1 mb-1"><?php echo app('translator')->get('saas.stats'); ?></h6>
                            <h2 class="text-white mb-0"><?php echo app('translator')->get('saas.sales-value'); ?></h2>
                        </div>
                        <div class="col">
                            <?php if(false): ?>
                            <ul class="nav nav-pills justify-content-end">
                                <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales" data-update='{"data":{"datasets":[{"data":[0, 20, 10, 30, 15, 40, 20, 60, 60]}]}}' data-prefix="$" data-suffix="k">
                                    <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                                        <span class="d-none d-md-block">Month</span>
                                        <span class="d-md-none">M</span>
                                    </a>
                                </li>

                            </ul>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <!-- Chart wrapper -->
                        <canvas id="chart-sales2" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1"><?php echo app('translator')->get('stats'); ?></h6>
                            <h2 class="mb-0"><?php echo app('translator')->get('saas.total-orders'); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="chart-orders2" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0"><?php echo app('translator')->get('saas.recent-invoices'); ?></h3>
                        </div>
                        <div class="col text-right">
                            <a href="<?php echo e(url('/admin/invoices')); ?>" class="btn btn-sm btn-primary"><?php echo app('translator')->get('saas.view-all'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->get('saas.subscriber'); ?></th>
                                <th><?php echo app('translator')->get('saas.item'); ?></th>
                                <th><?php echo app('translator')->get('saas.amount'); ?></th>
                                <th><?php echo app('translator')->get('saas.status'); ?></th>
                                <th><?php echo app('translator')->get('saas.created-on'); ?></th>
                                <th><?php echo app('translator')->get('saas.actions'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $recentInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($item->user): ?>
                                <tr>
                                    <td><?php echo e($item->id); ?></td>
                                    <td><a href="<?php echo e(url('/admin/subscribers/' . $item->user_id)); ?>"><?php echo e($item->user->name); ?></a></td>
                                    <td><?php echo e($item->invoicePurpose->purpose); ?> - <?php echo e($controller->getInvoiceItemName($item->id)); ?> </td>
                                    <td><?php echo clean( price($item->amount)); ?></td>
                                    <td><?php echo e(($item->paid==1)? __('saas.paid'):__('saas.unpaid')); ?></td>
                                    <td>
                                        <?php echo e(\Carbon\Carbon::parse($item->created_at)->format('d/M/Y')); ?>

                                    </td>
                                    <td>
                                        <?php if($item->paid==0): ?>
                                            <a onclick="return confirm('<?php echo app('translator')->get('saas.confirm-approve'); ?>')" class="btn btn-success btn-sm" href="<?php echo e(route('admin.invoices.approve',['invoice'=>$item->id])); ?>"><i class="fa fa-thumbs-up"></i> <?php echo app('translator')->get('saas.approve'); ?></a>
                                        <?php endif; ?>
                                        <a href="<?php echo e(url('/admin/invoices/' . $item->id)); ?>" title="<?php echo app('translator')->get('saas.view'); ?>"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo app('translator')->get('saas.view'); ?></button></a>
                                        <a href="<?php echo e(url('/admin/invoices/' . $item->id . '/edit')); ?>" title="<?php echo app('translator')->get('saas.edit'); ?>"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> <?php echo app('translator')->get('saas.edit'); ?></button></a>

                                        <form method="POST" action="<?php echo e(url('/admin/invoices' . '/' . $item->id)); ?>" accept-charset="UTF-8" style="display:inline">
                                            <?php echo e(method_field('DELETE')); ?>

                                            <?php echo e(csrf_field()); ?>

                                            <button type="submit" class="btn btn-danger btn-sm" title="<?php echo app('translator')->get('saas.delete'); ?>" onclick="return confirm(&quot;<?php echo app('translator')->get('saas.confirm-delete'); ?>?&quot;)"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo app('translator')->get('saas.delete'); ?></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                     </div>

                 </div>
            </div>
        </div>

    </div>

    <div class="row mt-5">
        <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0"><?php echo app('translator')->get('saas.recent-subscribers'); ?></h3>
                        </div>
                        <div class="col text-right">
                            <a href="<?php echo e(url('/admin/subscribers')); ?>" class="btn btn-sm btn-primary"><?php echo app('translator')->get('saas.view-all'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th><th><?php echo app('translator')->get('saas.name'); ?></th><th><?php echo app('translator')->get('saas.email'); ?></th><th><?php echo app('translator')->get('saas.plan'); ?></th>
                            <th><?php echo app('translator')->get('saas.expires'); ?></th>
                            <th><?php echo app('translator')->get('saas.enabled'); ?>?</th>
                            <th><?php echo app('translator')->get('saas.actions'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $recentSubscribers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->id); ?></td>
                                <td><?php echo e($item->name); ?></td><td><?php echo e($item->email); ?></td>
                                <td>
                                    <?php if($item->subscriber()->exists()): ?>
                                        <?php echo e($item->subscriber->packageDuration->package->name); ?> (<?php echo e(($item->subscriber->packageDuration->type=='m')? __('saas.monthly'):__('saas.annual')); ?>)
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($item->subscriber()->exists()): ?>
                                        <?php echo e(date('d/M/Y g:i a',$item->subscriber->expires)); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e(boolToString($item->enabled)); ?>

                                </td>
                                <td>
                                    <a href="<?php echo e(url('/admin/subscribers/' . $item->id)); ?>" title="<?php echo app('translator')->get('saas.view'); ?>"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo app('translator')->get('saas.view'); ?></button></a>
                                    <a href="<?php echo e(url('/admin/subscribers/' . $item->id . '/edit')); ?>" title="<?php echo app('translator')->get('saas.edit'); ?>"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> <?php echo app('translator')->get('saas.edit'); ?></button></a>
                                    <?php if($item->subscriber()->exists()): ?>
                                        <a class="btn btn-sm btn-success" href="<?php echo e(route('admin.hostnames.index',['website'=>$item->subscriber->website->id])); ?>"><i class="fa fa-link" aria-hidden="true"></i> <?php echo app('translator')->get('saas.manage-domains'); ?></a>
                                    <?php endif; ?>
                                    <form method="POST" action="<?php echo e(url('/admin/subscribers' . '/' . $item->id)); ?>" accept-charset="UTF-8" style="display:inline">
                                        <?php echo e(method_field('DELETE')); ?>

                                        <?php echo e(csrf_field()); ?>

                                        <button type="submit" class="btn btn-danger btn-sm" title="<?php echo app('translator')->get('saas.delete'); ?>" onclick="return confirm(&quot;<?php echo app('translator')->get('saas.confirm-delete'); ?>?&quot;)"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo app('translator')->get('saas.delete'); ?></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <script>

        //
        // Orders chart
        //

        var OrdersChart = (function() {

            //
            // Variables
            //

            var $chart = $('#chart-orders2');
            var $ordersSelect = $('[name="ordersSelect"]');


            //
            // Methods
            //

            // Init chart
            function initChart($chart) {

                // Create chart
                var ordersChart = new Chart($chart, {
                    type: 'bar',
                    options: {
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    lineWidth: 1,
                                    color: '#dfe2e6',
                                    zeroLineColor: '#dfe2e6'
                                },
                                ticks: {
                                    callback: function(value) {
                                        if (!(value % 10)) {
                                            //return '$' + value + 'k'
                                            return value
                                        }
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(item, data) {
                                    var label = data.datasets[item.datasetIndex].label || '';
                                    var yLabel = item.yLabel;
                                    var content = '';

                                    if (data.datasets.length > 1) {
                                        content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                                    }

                                    content += '<span class="popover-body-value">' + yLabel + '</span>';

                                    return content;
                                }
                            }
                        }
                    },
                    data: {
                        labels: <?php echo clean( $monthList ); ?>,
                        datasets: [{
                            label: '<?php echo app('translator')->get('saas.sales'); ?>',
                            data: <?php echo clean( $monthSaleCount); ?>

                        }]
                    }
                });

                // Save to jQuery object
                $chart.data('chart', ordersChart);
            }


            // Init chart
            if ($chart.length) {
                initChart($chart);
            }

        })();

        //
        // Charts
        //

        'use strict';

        //
        // Sales chart
        //

        var SalesChart = (function() {

            // Variables

            var $chart = $('#chart-sales2');


            // Methods

            function init($chart) {

                var salesChart = new Chart($chart, {
                    type: 'line',
                    options: {
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    lineWidth: 1,
                                    color: Charts.colors.gray[900],
                                    zeroLineColor: Charts.colors.gray[900]
                                },
                                ticks: {
                                    callback: function(value) {
                                        if (!(value % 10)) {
                                            return '<?php echo e($currency); ?>' + value ;
                                        }
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(item, data) {
                                    var label = data.datasets[item.datasetIndex].label || '';
                                    var yLabel = item.yLabel;
                                    var content = '';

                                    if (data.datasets.length > 1) {
                                        content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                                    }

                                    content += '<span class="popover-body-value"><?php echo e($currency); ?>' + yLabel + '</span>';
                                    return content;
                                }
                            }
                        }
                    },
                    data: {
                        labels: <?php echo clean( $monthList ); ?>,
                        datasets: [{
                            label: '<?php echo app('translator')->get('saas.sales'); ?>',
                            data: <?php echo clean( $monthSaleData); ?>

                        }]
                    }
                });

                // Save to jQuery object

                $chart.data('chart', salesChart);

            };


            // Events

            if ($chart.length) {
                init($chart);
            }

        })();
    </script>


    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/admin/home/index.blade.php ENDPATH**/ ?>