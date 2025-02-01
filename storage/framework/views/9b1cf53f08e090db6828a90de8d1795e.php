<?php $__env->startSection('pageTitle',$title); ?>
<?php $__env->startSection('page-title',$title); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e($title); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('page-content'); ?>

    <!--================Blog Area =================-->
    <section class="blog_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog_left_sidebar">

                        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="row blog_item">
                            <div class="col-md-3">
                                <div class="blog_info text-right">
                                    <div class="post_tag">
                                        <?php $__currentLoopData = $post->blogCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('blog.listing')); ?>?category=<?php echo e($category->id); ?>"><?php echo e($category->category); ?>,</a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <ul class="blog_meta list">
                                        <?php if($post->user()->exists()): ?>
                                        <li>
                                            <a href="#"><?php echo e($post->user->name); ?>

                                                <i class="lnr lnr-user"></i>
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        <li>
                                            <a href="#"><?php echo e(\Carbon\Carbon::parse($post->published_on)->format('d M, Y')); ?>

                                                <i class="lnr lnr-calendar-full"></i>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="blog_post">
                                    <?php if(!empty($post->cover_image)): ?>
                                    <img src="<?php echo e(asset($post->cover_image)); ?>" alt="">
                                    <?php endif; ?>
                                    <div class="blog_details">
                                        <a href="<?php echo e(route('blog.post',['blogPost'=>$post->id,'slug'=>safeUrl($post->title)])); ?>">
                                            <h2><?php echo e($post->title); ?></h2>
                                        </a>
                                        <p><?php echo e(limitLength(strip_tags($post->content),300)); ?></p>
                                        <a class="button button-blog" href="<?php echo e(route('blog.post',['blogPost'=>$post->id,'slug'=>safeUrl($post->title)])); ?>"><?php echo app('translator')->get('saas.view-more'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                        <nav class="blog-pagination justify-content-center d-flex">

                            <?php echo $posts->appends(['q' => Request::get('q'),'category' => Request::get('category')])->render(); ?>

                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                    <?php echo $__env->make('site.blog.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </section>
    <!--================Blog Area =================-->


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site-page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/site/blog/listing.blade.php ENDPATH**/ ?>