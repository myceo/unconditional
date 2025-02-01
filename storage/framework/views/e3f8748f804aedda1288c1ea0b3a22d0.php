<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?php echo $__env->yieldContent('pageTitle',__('saas.admin')); ?>
    </title>
    <!-- Favicon -->

    <?php if(!empty(setting('image_icon'))): ?>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset(setting('image_icon'))); ?>">
        <?php endif; ?>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="<?php echo e(asset('themes/argon/assets/js/plugins/nucleo/css/nucleo.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('themes/argon/assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="<?php echo e(asset('themes/argon/assets/css/argon-dashboard.css?v=1.1.0')); ?>" rel="stylesheet" />
    <?php echo $__env->yieldContent('header'); ?>
</head>

<body class="">
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="<?php echo e(url('/')); ?>">
            <?php if(!empty(setting('image_logo'))): ?>
                <img src="<?php echo e(asset(setting('image_logo'))); ?>" class="navbar-brand-img" >
                <?php else: ?>
                <h1><?php echo e(setting('general_site_name')); ?></h1>
                <?php endif; ?>
        </a>



        <!-- User -->
        <ul class="nav align-items-center d-md-none">

            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img   src="<?php echo e(asset('img/man.jpg')); ?>">
              </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0"><?php echo app('translator')->get('saas.welcome'); ?>!</h6>
                    </div>
                    <a href="<?php echo e(route('admin.profile')); ?>" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span><?php echo app('translator')->get('saas.my-profile'); ?></span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <a  href="#"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item">
                        <i class="ni ni-user-run"></i>
                        <span><?php echo app('translator')->get('saas.logout'); ?></span>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="<?php echo e(url('/')); ?>">

                            <?php if(!empty(setting('image_logo'))): ?>
                                <img src="<?php echo e(asset(setting('image_logo'))); ?>"   >
                            <?php else: ?>
                                <h1><?php echo e(setting('general_site_name')); ?></h1>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item  active" >
                <a class=" nav-link active " href="<?php echo e(route('admin.dashboard')); ?>"> <i class="ni ni-tv-2 text-primary"></i> <?php echo app('translator')->get('saas.dashboard'); ?>
                </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="#nav-subscribers" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="subscribers">
                        <i class="ni ni-single-02 text-orange"></i>
                        <span class="nav-link-text"><?php echo app('translator')->get('saas.subscribers'); ?></span>
                    </a>
                    <div class="collapse" id="nav-subscribers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(url('/admin/subscribers/create')); ?>" class="nav-link"><?php echo app('translator')->get('saas.create-subscriber'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/admin/subscribers')); ?>" class="nav-link"><?php echo app('translator')->get('saas.all-subscribers'); ?></a>
                            </li>

                            <li class="nav-item">
                                <a href="<?php echo e(url('/admin/subscribers')); ?>?sort=c" class="nav-link"><?php echo app('translator')->get('saas.active-customers'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/admin/subscribers')); ?>?sort=t" class="nav-link"><?php echo app('translator')->get('saas.active-trials'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/admin/subscribers')); ?>?sort=ec" class="nav-link"><?php echo app('translator')->get('saas.expired-customers'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/admin/subscribers')); ?>?sort=et" class="nav-link"><?php echo app('translator')->get('saas.expired-trials'); ?></a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#nav-plans" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                        <i class="ni ni-briefcase-24 text-yellow"></i>
                        <span class="nav-link-text"><?php echo app('translator')->get('saas.plans'); ?></span>
                    </a>
                    <div class="collapse" id="nav-plans">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(url('/admin/plans')); ?>" class="nav-link"><?php echo app('translator')->get('saas.manage-plans'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/admin/plans/create')); ?>" class="nav-link"><?php echo app('translator')->get('saas.create-plan'); ?></a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#nav-invoices" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="nav-invoices">
                        <i class="ni ni-money-coins text-blue"></i>
                        <span class="nav-link-text"><?php echo app('translator')->get('saas.invoices'); ?></span>
                    </a>
                    <div class="collapse" id="nav-invoices">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(url('/admin/invoices')); ?>" class="nav-link"><?php echo app('translator')->get('saas.view-invoices'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/admin/invoices/create')); ?>" class="nav-link"><?php echo app('translator')->get('saas.create-invoice'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="#nav-features" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="nav-features">
                        <i class="ni ni-satisfied text-red"></i>
                        <span class="nav-link-text"><?php echo app('translator')->get('saas.features'); ?></span>
                    </a>
                    <div class="collapse" id="nav-features">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.features.index')); ?>" class="nav-link"><?php echo app('translator')->get('saas.manage-posts'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.features.create')); ?>" class="nav-link"><?php echo app('translator')->get('saas.create-post'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="#nav-articles" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="nav-articles">
                        <i class="ni ni-books text-info"></i>
                        <span class="nav-link-text"><?php echo app('translator')->get('saas.articles'); ?></span>
                    </a>
                    <div class="collapse" id="nav-articles">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.articles.index')); ?>" class="nav-link"><?php echo app('translator')->get('saas.manage-posts'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.articles.create')); ?>" class="nav-link"><?php echo app('translator')->get('saas.create-post'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.article-categories.index')); ?>" class="nav-link"><?php echo app('translator')->get('saas.manage-categories'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="#nav-blog" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="nav-blog">
                        <i class="ni ni-book-bookmark text-pink"></i>
                        <span class="nav-link-text"><?php echo app('translator')->get('saas.blog'); ?></span>
                    </a>
                    <div class="collapse" id="nav-blog">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.blog-posts.index')); ?>" class="nav-link"><?php echo app('translator')->get('saas.manage-posts'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.blog-posts.create')); ?>" class="nav-link"><?php echo app('translator')->get('saas.create-post'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.blog-categories.index')); ?>" class="nav-link"><?php echo app('translator')->get('saas.manage-categories'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="#nav-docs" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="nav-docs">
                        <i class="ni ni-support-16 text-green"></i>
                        <span class="nav-link-text"><?php echo app('translator')->get('saas.documentation'); ?></span>
                    </a>
                    <div class="collapse" id="nav-docs">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.help-posts.index')); ?>" class="nav-link"><?php echo app('translator')->get('saas.manage-posts'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.help-posts.create')); ?>" class="nav-link"><?php echo app('translator')->get('saas.create-post'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.help-categories.index')); ?>" class="nav-link"><?php echo app('translator')->get('saas.manage-categories'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item" >
                    <a class=" nav-link" href="<?php echo e(route('admin.payment-methods')); ?>"> <i class="ni ni-credit-card text-primary"></i> <?php echo app('translator')->get('saas.payment-methods'); ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#nav-settings" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="nav-settings">
                        <i class="ni ni-settings-gear-65 text-default"></i>
                        <span class="nav-link-text"><?php echo app('translator')->get('saas.settings'); ?></span>
                    </a>
                    <div class="collapse" id="nav-settings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.settings',['group'=>'general'])); ?>" class="nav-link"><?php echo app('translator')->get('saas.general'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.trial')); ?>" class="nav-link"><?php echo app('translator')->get('saas.free-trial'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.currencies.index')); ?>" class="nav-link"><?php echo app('translator')->get('saas.currencies'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.language')); ?>" class="nav-link"><?php echo app('translator')->get('saas.language'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.settings',['group'=>'mail'])); ?>" class="nav-link"><?php echo app('translator')->get('saas.email-settings'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.settings',['group'=>'mailchimp'])); ?>" class="nav-link"><?php echo app('translator')->get('saas.mailchimp-settings'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.settings',['group'=>'social'])); ?>" class="nav-link"><?php echo app('translator')->get('saas.social-settings'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.settings',['group'=>'image'])); ?>" class="nav-link"><?php echo app('translator')->get('saas.logo-icon'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.admins.index')); ?>" class="nav-link"><?php echo app('translator')->get('saas.administrators'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>



            </ul>

        </div>
    </div>
</nav>
<div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="<?php echo e(route('admin.dashboard')); ?>"><?php echo $__env->yieldContent('pageTitle','Admin'); ?></a>
            <?php echo $__env->yieldContent('search-form'); ?>

            <!-- User -->
            <ul class="navbar-nav align-items-center d-none d-md-flex">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                    <img   src="<?php echo e(asset('img/man.jpg')); ?>">
                </span>
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold"><?php echo e(\Illuminate\Support\Facades\Auth::user()->name); ?></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0"><?php echo app('translator')->get('saas.welcome'); ?>!</h6>
                        </div>
                        <a href="<?php echo e(route('admin.profile')); ?>" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span><?php echo app('translator')->get('saas.my-profile'); ?></span>
                        </a>

                        <div class="dropdown-divider"></div>
                        <a  href="#"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span><?php echo app('translator')->get('saas.logout'); ?></span>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <!-- Card stats -->

                <?php echo $__env->yieldContent('page-header'); ?>

            </div>
        </div>
    </div>
    <div class="container-fluid mt--7">

        <?php if(count($errors) > 0): ?>
            <div style="padding-left:50px; padding-right:50px">
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>


        <div class="flash-message"  style="padding-left:50px; padding-right:50px">
            <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(Session::has('alert-' . $msg)): ?>

                    <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(Session::has('flash_message')): ?>

                <p class="alert alert-success"><?php echo e(Session::get('flash_message')); ?> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            <?php endif; ?>
        </div> <!-- end .flash-message -->
        <?php echo $__env->yieldContent('content'); ?>
        <!-- Footer -->
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-6">
                    <div class="copyright text-center text-xl-left text-muted">
                        &copy; <?php echo e(date('Y')); ?> <?php echo e(setting('general_site_name')); ?>

                    </div>
                </div>
                <div class="col-xl-6">

                </div>
            </div>
        </footer>
    </div>
</div>




<!--   Core   -->
<script src="<?php echo e(asset('themes/argon/assets/js/plugins/jquery/dist/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/argon/assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')); ?>"></script>
<!--   Optional JS   -->
<script src="<?php echo e(asset('themes/argon/assets/js/plugins/chart.js/dist/Chart.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/argon/assets/js/plugins/chart.js/dist/Chart.extension.js')); ?>"></script>
<!--   Argon JS   -->
<script src="<?php echo e(asset('themes/argon/assets/js/argon-dashboard.min.js')); ?>?v=1.1.0"></script>
<script src="<?php echo e(asset('js/lib.js')); ?>" type="text/javascript"></script>
 <?php echo $__env->yieldContent('footer'); ?>
</body>

</html><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/layouts/admin.blade.php ENDPATH**/ ?>