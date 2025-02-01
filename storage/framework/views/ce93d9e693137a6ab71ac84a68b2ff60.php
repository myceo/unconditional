<?php $__env->startSection('search-form'); ?>
    <!-- Form -->
    <form  method="GET" action="<?php echo e(url('/admin/subscribers')); ?>"  class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
        <div class="form-group mb-0">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input value="<?php echo e(request('search')); ?>" name="search"  class="form-control" placeholder="<?php echo app('translator')->get('admin.search'); ?>" type="text">
            </div>
        </div>
        <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>"/>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageTitle',__('saas.subscribers')); ?>
<?php $__env->startSection('page-title',$title.(!empty(request('search'))? ': '.request('search'):'' )); ?>

<?php $__env->startSection('page-content'); ?>
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div >
                    <div  >
                        <a href="<?php echo e(url('/admin/subscribers/create')); ?>" class="btn btn-success btn-sm" title="<?php echo app('translator')->get('saas.add-new'); ?> subscriber">
                            <i class="fa fa-plus" aria-hidden="true"></i> <?php echo app('translator')->get('saas.add-new'); ?>
                        </a>



                        <br/>
                        <br/>
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
                                <?php $__currentLoopData = $subscribers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item->id); ?></td>
                                        <td><?php echo e($item->name); ?></td><td><?php echo e($item->email); ?></td>
                                        <td>
                                            <?php if($item->subscriber()->exists() && $item->subscriber->packageDuration): ?>
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
                            <div class="pagination-wrapper"> <?php echo clean( $subscribers->appends(['search' => Request::get('search'),'sort'=>Request::get('sort')])->render()); ?> </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/admin/subscribers/index.blade.php ENDPATH**/ ?>