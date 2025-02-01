

<?php $__env->startSection('pageTitle',__('saas.subscriber').' : '.$subscriber->name); ?>
<?php $__env->startSection('page-title',__('saas.subscriber').' : '.$subscriber->name); ?>

<?php $__env->startSection('page-content'); ?>
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div  >
                    <div  >

                        <a href="<?php echo e(url('/admin/subscribers')); ?>" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo app('translator')->get('saas.back'); ?></button></a>
                        <a href="<?php echo e(url('/admin/subscribers/' . $subscriber->id . '/edit')); ?>" title="Edit subscriber"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> <?php echo app('translator')->get('saas.edit'); ?></button></a>


                        <br/>
                        <br/>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home"><?php echo app('translator')->get('saas.info'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#menu1"><?php echo app('translator')->get('saas.stats'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#menu2"><?php echo app('translator')->get('saas.domains'); ?></a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane container active" id="home" style="padding-top: 30px">

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th><?php echo app('translator')->get('saas.id'); ?></th><td><?php echo e($subscriber->id); ?></td>
                                        </tr>
                                        <tr><th> <?php echo app('translator')->get('saas.name'); ?> </th><td> <?php echo e($subscriber->name); ?> </td></tr>
                                        <tr><th> <?php echo app('translator')->get('saas.email'); ?> </th><td> <?php echo e($subscriber->email); ?> </td></tr>
                                        <?php if(setting('trial_enabled')==1): ?>
                                        <tr><th> <?php echo app('translator')->get('saas.trial'); ?> </th><td> <?php echo e(boolToString($subscriber->trial)); ?> </td></tr>
                                        <?php endif; ?>
                                        <tr><th> <?php echo app('translator')->get('saas.enabled'); ?> </th><td> <?php echo e(boolToString($subscriber->enabled)); ?> </td></tr>
                                    <?php if($subscriber->subscriber()->exists()): ?>
                                        <tr><th> <?php echo app('translator')->get('saas.plan'); ?> </th><td> <?php echo e($subscriber->subscriber->packageDuration->package->name); ?> (<?php echo e(($subscriber->subscriber->packageDuration->type=='m')? __('saas.monthly'):__('saas.annual')); ?>) </td></tr>
                                        <tr><th> <?php echo app('translator')->get('saas.expires'); ?> </th><td> <?php echo e(date('d/M/Y g:i a',$subscriber->subscriber->expires)); ?> </td></tr>
                                        <tr><th> <?php echo app('translator')->get('saas.currency'); ?> </th><td> <?php echo e($subscriber->subscriber->currency->country->currency_name); ?> </td></tr>
                                        <tr><th> <?php echo app('translator')->get('saas.website-id'); ?> </th><td> <?php echo e($subscriber->subscriber->website_id); ?> </td></tr>

                                    <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <div class="tab-pane container fade" id="menu1"  style="padding-top: 30px">
                            </div>

                            <div class="tab-pane container fade" id="menu2"  style="padding-top: 30px">
                                <?php if($subscriber->subscriber()->exists()): ?>
                                    <a class="btn btn-lg btn-primary" href="<?php echo e(route('admin.hostnames.index',['website'=>$subscriber->subscriber->website->id])); ?>"><?php echo app('translator')->get('saas.manage-domains'); ?></a>
                                    <br/> <br/>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><?php echo app('translator')->get('saas.domains'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $subscriber->subscriber->website->hostnames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hostname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><a href="http://<?php echo e($hostname->fqdn); ?>"><?php echo e($hostname->fqdn); ?></a></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php endif; ?>
                            </div>

                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <script type="text/javascript">
        $(function(){
           $('#menu1').load('<?php echo e(route('admin.subscribers.stats',['user'=>$subscriber->id])); ?>');
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/admin/subscribers/show.blade.php ENDPATH**/ ?>