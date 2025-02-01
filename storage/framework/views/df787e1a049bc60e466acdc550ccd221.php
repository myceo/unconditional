<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="author" content="Caremate">
    <title><?php echo e($title ?? env('APP_NAME')); ?></title>
    <!-- Favicon -->

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?php echo e(asset('themes/admin/assets/modules/bootstrap/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/admin/assets/modules/fontawesome/css/all.min.css')); ?>">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('themes/admin/assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/admin/assets/css/components.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">


</head>

<body>


    <!-- Page content -->
    <div class="container mt-5">
    <?php echo e($slot); ?>


    <!-- Footer -->
        <footer class="footer pt-0">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6">
                    <div class="copyright text-center text-lg-left text-muted">
                        &copy; <?php echo e(date('Y')); ?> <?php echo e(env('APP_NAME')); ?>

                    </div>
                </div>
                <div class="col-lg-6">

                </div>
            </div>
        </footer>
    </div>




<!-- General JS Scripts -->
<script src="<?php echo e(asset('themes/admin/assets/modules/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('themes/admin/assets/modules/bootstrap/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/sweetalert/sweetalert2.all.min.js')); ?>"></script>
</body>

</html>
<?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/components/layouts/app.blade.php ENDPATH**/ ?>