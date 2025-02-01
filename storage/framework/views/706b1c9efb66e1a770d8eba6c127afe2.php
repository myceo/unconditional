
<?php $__env->startSection('pageTitle','Search Results: '.$q); ?>
<?php $__env->startSection('content'); ?>
    <?php if($posts->count()==0): ?>
        <p>
            <h2><?php echo app('translator')->get('saas.no-results'); ?></h2>
        </p>
        <?php else: ?>
        <ul>
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><h3 style="margin-bottom: 0px; padding-bottom: 0px"><a href="<?php echo e(route('docs.post',['id'=>$post->id,'slug'=>safeUrl($post->title)])); ?>"><?php echo e($post->title); ?></a></h3>

                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

    <?php endif; ?>
    <?php $__env->stopSection(); ?>
<?php echo e($posts->links()); ?>
<?php echo $__env->make('layouts.doc', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/site/docs/search.blade.php ENDPATH**/ ?>