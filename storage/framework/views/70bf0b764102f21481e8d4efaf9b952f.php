<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('pageTitle',setting('general_homepage_title')); ?></title>

    <meta name="description" content="<?php echo $__env->yieldContent('pageMetaDesc',setting('general_homepage_meta_desc')); ?>">
     
    <?php if(!empty(setting('image_icon'))): ?>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset(setting('image_icon'))); ?>">
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo e(asset('themes/parason/vendors/bootstrap/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/parason/vendors/fontawesome/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/parason/vendors/themify-icons/themify-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/parason/vendors/linericon/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/parason/vendors/owl-carousel/owl.theme.default.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/parason/vendors/owl-carousel/owl.carousel.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('themes/parason/css/style.css')); ?>">
    <?php echo $__env->yieldContent('header'); ?>

    <?php echo setting('general_header_scripts'); ?>


</head>
<body>
<!--================Header Menu Area =================-->
<header class="header_area">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container box_1620">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="<?php echo e(url('/')); ?>">
                    <?php if(!empty(setting('image_logo'))): ?>
                        <img src="<?php echo e(asset(setting('image_logo'))); ?>"   >
                    <?php else: ?>
                        <h1><?php echo e(setting('general_site_name')); ?></h1>
                    <?php endif; ?>
                
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav justify-content-end">
                        <li class="nav-item active"><a class="nav-link" href="<?php echo e(route('homepage')); ?>"><?php echo app('translator')->get('saas.home'); ?></a></li>

                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false"><?php echo app('translator')->get('saas.features'); ?></a>
                            <ul class="dropdown-menu">
                                <?php $__currentLoopData = \App\Models\Feature::orderBy('sort_order')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('site.feature',['feature'=>$feature->id,'slug'=>safeUrl($feature->page_title)])); ?>"><?php echo e($feature->menu_title); ?></a></li>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('site.pricing')); ?>"><?php echo app('translator')->get('saas.pricing'); ?></a>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('docs.index')); ?>"><?php echo app('translator')->get('saas.docs'); ?></a>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('blog.listing')); ?>"><?php echo app('translator')->get('saas.blog'); ?></a>

                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('site.contact')); ?>"><?php echo app('translator')->get('saas.contact'); ?></a></li>
                        <?php if(auth()->guard()->guest()): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/login')); ?>"><?php echo app('translator')->get('saas.login'); ?></a>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link"   href="#"
                                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><?php echo app('translator')->get('saas.logout'); ?></a>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                    <?php echo csrf_field(); ?>
                                </form>
                        <?php endif; ?>
                    </ul>

                    <ul class="navbar-right">
                        <li class="nav-item">
                            <?php if(auth()->guard()->guest()): ?>
                            <a  class="button button-header bg" href="<?php echo e(url('/register')); ?>"><?php echo app('translator')->get('saas.signup'); ?></a>
                            <?php else: ?>
                                <a  class="button button-header bg" href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('saas.my-account'); ?></a>
                                <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
<!--================Header Menu Area =================-->



<?php echo $__env->yieldContent('content'); ?>



<!-- ================ start footer Area ================= -->
<footer class="footer-area section-gap">
    <div class="container">
        <div class="row">

            <?php $__currentLoopData = \App\Models\ArticleCategory::orderBy('sort_order')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-2 col-sm-6 mb-4 mb-xl-0 single-footer-widget">
                <h4><?php echo e($category->name); ?></h4>
                <ul>
                    <?php $__currentLoopData = $category->articles()->orderBy('sort_order')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(route('site.article',['article'=>$article->id,'slug'=>safeUrl($article->page_title)])); ?>"><?php echo e($article->menu_title); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="col-xl-4 col-md-8 mb-4 mb-xl-0 single-footer-widget">
                <h4><?php echo app('translator')->get('saas.newsletter'); ?></h4>
                <p><?php echo app('translator')->get('saas.trust-us'); ?></p>
                <div class="form-wrap" id="mc_embed_signup_">
                    <form  action="<?php echo e(route('site.save-email')); ?>"
                          method="post" class="form-inline">
                        <?php echo csrf_field(); ?>
                        <input class="form-control" name="email" placeholder="<?php echo app('translator')->get('saas.your-email-add'); ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = '<?php echo app('translator')->get('saas.your-email-add'); ?> '"
                               required="" type="email">
                        <button class="click-btn btn btn-default"><?php echo app('translator')->get('saas.subscribe'); ?></button>


                        <div class="info"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="footer-bottom row align-items-center text-center text-lg-left">
            <p class="footer-text m-0 col-lg-8 col-md-12">
                <?php echo app('translator')->get('saas.copyright'); ?> &copy;<?php echo e(date('Y')); ?> <?php echo e(setting('general_site_name')); ?>. <?php echo app('translator')->get('saas.all-rights'); ?>
                </p>
            <div class="col-lg-4 col-md-12 text-center text-lg-right footer-social">

              <?php if(!empty(setting('social_facebook'))): ?>
                <a href="<?php echo e(setting('social_facebook')); ?>"><i class="fab fa-facebook-f"></i></a>
                <?php endif; ?>
                  <?php if(!empty(setting('social_facebook'))): ?>
                <a href="<?php echo e(setting('social_twitter')); ?>"><i class="fab fa-twitter"></i></a>
                  <?php endif; ?>
                  <?php if(!empty(setting('social_instagram'))): ?>
                <a href="<?php echo e(setting('social_instagram')); ?>"><i class="fab fa-instagram"></i></a>
                  <?php endif; ?>
                  <?php if(!empty(setting('social_linkedin'))): ?>
                <a href="<?php echo e(setting('social_linkedin')); ?>"><i class="fab fa-linkedin-in"></i></a>
                  <?php endif; ?>
                  <?php if(!empty(setting('social_youtube'))): ?>
                      <a href="<?php echo e(setting('social_youtube')); ?>"><i class="fab fa-youtube"></i></a>
                  <?php endif; ?>


            </div>
        </div>
    </div>
</footer>
<!-- ================ End footer Area ================= -->
<div class="modal fade"  id="currencyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="currencyModalLabel"><?php echo app('translator')->get('saas.change-currency'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <?php $__currentLoopData = \App\Models\Currency::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li class="list-group-item"><a href="<?php echo e(route('set.currency',['currency'=>$currency->id])); ?>"><?php echo e($currency->country->currency_name); ?> (<?php echo clean( $currency->country->currency_code); ?>)</a></li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo app('translator')->get('saas.close'); ?></button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo e(asset('themes/parason/vendors/jquery/jquery-3.2.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/parason/vendors/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/parason/js/main.js')); ?>"></script>
<?php echo $__env->yieldContent('footer'); ?>

<?php echo setting('general_footer_scripts'); ?>


</body>
</html><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/layouts/site.blade.php ENDPATH**/ ?>