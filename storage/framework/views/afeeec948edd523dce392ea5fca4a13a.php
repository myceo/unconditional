<?php $__env->startSection('content'); ?>


    <!--================ Hero sm Banner start =================-->
    <section class="hero-banner hero-banner--sm mb-30px">
        <div class="container">
            <div class="hero-banner--sm__content">
                <h1><?php echo $__env->yieldContent('page-title'); ?></h1>
                <?php if (! empty(trim($__env->yieldContent('breadcrumb')))): ?>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('homepage')); ?>"><?php echo app('translator')->get('saas.home'); ?></a></li>
                        <?php echo $__env->yieldContent('breadcrumb'); ?>


                    </ol>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--================ Hero sm Banner end =================-->


    <!--================ Offer section start =================-->
    <section class="section-margin">
        <div class="container">

            <?php echo $__env->yieldContent('page-content'); ?>

        </div>
    </section>
    <!--================ Offer section end =================-->


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/layouts/site-page.blade.php ENDPATH**/ ?>