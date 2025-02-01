<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <!-- App title -->
    <title><?php echo $__env->yieldContent('pageTitle',setting('general_homepage_title')); ?></title>

    <!--Morris Chart CSS -->

    <?php if(!empty(setting('image_icon'))): ?>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset(setting('image_icon'))); ?>">
        <?php endif; ?>

    <!-- App css -->
    <link href="<?php echo e(asset('themes/cpanel/default/assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('themes/cpanel/default/assets/css/core.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('themes/cpanel/default/assets/css/components.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('themes/cpanel/default/assets/css/icons.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('themes/cpanel/default/assets/css/pages.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('themes/cpanel/default/assets/css/menu.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('themes/cpanel/default/assets/css/responsive.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo e(asset('themes/cpanel/plugins/switchery/switchery.min.css')); ?>">

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="<?php echo e(asset('themes/cpanel/default/assets/assets/js/modernizr.min.js')); ?>"></script>
        <?php echo $__env->yieldContent('header'); ?>
        <?php if(false): ?>
        <?php echo setting('general_header_scripts'); ?>

        <?php endif; ?>
</head>


<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left">
            <a href="<?php echo e(route('homepage')); ?>" class="logo">
                <?php if(!empty(setting('image_logo'))): ?>
                    <img style="max-width: 100%; max-height: 50px;"  class="logo logo-display"  src="<?php echo e(asset(setting('image_logo'))); ?>"   >
                <?php else: ?>
                    <h1><?php echo e(setting('general_site_name')); ?></h1>
                <?php endif; ?>
            </a>


            <!-- Image logo -->
            <!--<a href="index.html" class="logo">-->
            <!--<span>-->
            <!--<img src="assets/images/logo.png" alt="" height="30">-->
            <!--</span>-->
            <!--<i>-->
            <!--<img src="assets/images/logo_sm.png" alt="" height="28">-->
            <!--</i>-->
            <!--</a>-->
        </div>

        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">

                <!-- Navbar-left -->
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <button class="button-menu-mobile open-left waves-effect">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>
                    <li class="hidden-xs">
                        <form action="<?php echo e(route('docs.search')); ?>" method="get" role="search" class="app-search">
                            <input value="<?php echo e(@$_GET['q']); ?>" name="q" type="text" placeholder="<?php echo app('translator')->get('saas.search'); ?>..."
                                   class="form-control">
                            <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li>


                    <li class="hidden-lg hidden-md hidden-sm">
                       <h4><?php echo app('translator')->get('saas.documentation'); ?></h4>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right pull-right hidden-xs">
                    <li  >
                        <button  onclick="location.replace('<?php echo e(route('docs.offline')); ?>')" class="button-menu-mobile waves-effect">
                            <i class="fa fa-download"></i> <?php echo app('translator')->get('saas.offline'); ?>
                        </button>

                    </li>
                </ul>


            </div><!-- end container -->
        </div><!-- end navbar -->
    </div>
    <!-- Top Bar End -->


    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <ul>
                    <li class="hidden-lg hidden-md hidden-sm">
                        <form action="<?php echo e(route('docs.search')); ?>" method="get" role="search" class="app-search">
                            <input  value="<?php echo e(@$_GET['q']); ?>"  style="color: white" name="q" type="text" placeholder="Search docs..."
                                   class="form-control">
                            <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li>
                    <li class="menu-title"><?php echo app('translator')->get('saas.user-guide'); ?></li>

                    <?php $__currentLoopData = \App\Models\HelpCategory::orderBy('sort_order')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><span> <?php echo e($category->name); ?> </span> </a>
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $category->helpPosts()->where('status',1)->orderBy('sort_order')->get(['title','id']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(route('docs.post',['id'=>$post->id,'slug'=>safeUrl($post->title)])); ?>"><?php echo e($post->title); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(route('docs.offline')); ?>"><?php echo app('translator')->get('saas.offline'); ?></a></li>


                </ul>
            </div>
            <!-- Sidebar -->
            <div class="clearfix"></div>


        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->



    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="page-title-box">
                            <h4 class="page-title"><?php echo $__env->yieldContent('pageTitle'); ?></h4>

                            <ol class="breadcrumb p-0 m-0">
                                <?php echo $__env->yieldContent('breadcrumb'); ?>
                            </ol>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-md-12">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>



            </div> <!-- container -->

        </div> <!-- content -->

        <footer class="footer text-right">
            <?php echo e(date('Y')); ?> © <?php echo e(setting('general_site_name')); ?>

        </footer>

    </div>


    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->




</div>
<!-- END wrapper -->



<script>
    var resizefunc = [];
</script>
<!-- jQuery  -->
<script src="<?php echo e(asset('themes/cpanel/default/assets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/cpanel/default/assets/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/cpanel/default/assets/js/detect.js')); ?>"></script>
<script src="<?php echo e(asset('themes/cpanel/default/assets/js/fastclick.js')); ?>"></script>
<script src="<?php echo e(asset('themes/cpanel/default/assets/js/jquery.blockUI.js')); ?>"></script>
<script src="<?php echo e(asset('themes/cpanel/default/assets/js/waves.js')); ?>"></script>
<script src="<?php echo e(asset('themes/cpanel/default/assets/js/jquery.slimscroll.js')); ?>"></script>
<script src="<?php echo e(asset('themes/cpanel/default/assets/js/jquery.scrollTo.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/cpanel/plugins/switchery/switchery.min.js')); ?>"></script>

<!-- Counter js  -->
<script src="<?php echo e(asset('themes/cpanel/plugins/waypoints/jquery.waypoints.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/cpanel/plugins/counterup/jquery.counterup.min.js')); ?>"></script>

<!--Morris Chart-->
<script src="<?php echo e(asset('themes/cpanel/plugins/morris/morris.min.js_')); ?>"></script>
<script src="<?php echo e(asset('themes/cpanel/plugins/raphael/raphael-min.js_')); ?>"></script>

<!-- Dashboard init -->
<script src="<?php echo e(asset('themes/cpanel/default/assets/pages/jquery.dashboard.js_')); ?>"></script>

<!-- App js -->
<script src="<?php echo e(asset('themes/cpanel/default/assets/js/jquery.core.js')); ?>"></script>
<script src="<?php echo e(asset('themes/cpanel/default/assets/js/jquery.app.js')); ?>"></script>
<?php echo $__env->yieldContent('footer'); ?>

<?php echo setting('general_footer_scripts'); ?>


</body>
</html><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/layouts/doc.blade.php ENDPATH**/ ?>