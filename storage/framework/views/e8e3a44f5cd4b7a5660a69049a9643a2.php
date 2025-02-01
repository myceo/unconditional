
<?php $__env->startSection('pageTitle','Table Of Contents'); ?>
<?php $__env->startSection('content'); ?>

    <?php $__currentLoopData = \App\Models\HelpCategory::orderBy('sort_order')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="panel panel-color panel-inverse">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo e($category->name); ?></h3>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <?php $__currentLoopData = $category->helpPosts()->where('status',1)->orderBy('sort_order')->get(['title','id']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($post->sort_order); ?>. <a href="<?php echo e(route('docs.post',['id'=>$post->id,'slug'=>safeUrl($post->title)])); ?>"><?php echo e($post->title); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>



    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.doc', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/site/docs/index.blade.php ENDPATH**/ ?>