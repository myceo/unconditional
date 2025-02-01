<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <?php if(!empty(setting('image_icon'))): ?>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset(setting('image_icon'))); ?>">
    <?php endif; ?>

    <title><?php echo app('translator')->get('saas.setup-wizard'); ?></title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="<?php echo e(asset('themes/wizard/assets/css/bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('themes/wizard/assets/css/material-bootstrap-wizard.css')); ?>" rel="stylesheet" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="<?php echo e(asset('themes/wizard/assets/css/demo.css')); ?>" rel="stylesheet" />
    <style>
        #about .form-group {
            margin: 0px 0 0 0;
        }
        label.error{
            color:red;
        }
    </style>
    <script>
        var checkUrl = '<?php echo e(route('user.username-check')); ?>';
    </script>
    <?php if(false): ?>
    <?php echo clean( setting('general_header_scripts')); ?>

<?php endif; ?>
</head>

<body>
<div class="image-container set-full-height" style="background-image: url('<?php echo e(asset('img/wizardbg.jpg')); ?>')">
    <!--   Creative Tim Branding   -->
    <a href="<?php echo e(url('/')); ?>">
        <div class="logo-container">
            <div class="logo">
                <?php if(!empty(setting('image_logo'))): ?>
                <img  src="<?php echo e(asset(setting('image_logo'))); ?>">
                    <?php endif; ?>
            </div>

        </div>
    </a>



    <!--   Big container   -->
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <!--      Wizard container        -->
                <div class="wizard-container">
                    <div class="card wizard-card" data-color="blue" id="wizardProfile">
                        <form action="<?php echo e(route('user.process-wizard')); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

                            <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->

                            <div class="wizard-header">
                                <h3 class="wizard-title">
                                    <?php echo app('translator')->get('saas.lets-setup'); ?>
                                </h3>

                                <?php if(Session::has('flash_message')): ?>

                                    <p class="alert alert-success"><?php echo e(Session::get('flash_message')); ?> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                <?php endif; ?>
                                <?php if(count($errors) > 0): ?>

                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <h5 style="color: red"><?php echo e($error); ?></h5>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php else: ?>
                                    <h5><?php echo app('translator')->get('saas.few-seconds'); ?></h5>
                                <?php endif; ?>

                            </div>
                            <div class="wizard-navigation">
                                <ul>
                                    <li><a href="#about" data-toggle="tab"><?php echo app('translator')->get('saas.username'); ?></a></li>
                                    <li><a href="#account" data-toggle="tab"><?php echo app('translator')->get('saas.admin-account'); ?></a></li>
                                    <li><a href="#address" data-toggle="tab"><?php echo app('translator')->get('saas.settings'); ?></a></li>
                                </ul>
                            </div>

                            <div class="tab-content" style="min-height: 140px;">
                                <div class="tab-pane" id="about">
                                    <div class="row">
                                        <h4 class="info-text"> <?php echo app('translator')->get('saas.select-username'); ?></h4>


                                        <div class="col-sm-10 ">
                                            <div class="row">
                                                <div class="col-md-2 col-md-offset-2"><strong style="font-size: 29px;"><?php echo e($_SERVER['REQUEST_SCHEME']); ?>://</strong></div>
                                                <div class="col-md-4"><input id="username" placeholder="<?php echo app('translator')->get('saas.min-char'); ?>" value="<?php echo e(old('username')); ?>" name="username" type="text" class="form-control" data-msg="<?php echo app('translator')->get('saas.required-msg'); ?>" data-msg-minlength="<?php echo app('translator')->get('saas.three-chars'); ?>" data-msg-maxlength="<?php echo app('translator')->get('saas.max-chars'); ?>">
                                                    <?php if($errors->has('username')): ?>
                                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('username')); ?></strong>
                                    </span>
                                                    <?php endif; ?>

                                                    <span id="username-exits" class="help-block"></span>
                                                </div>
                                                <div class="col-md-4"><strong style="font-size: 29px;">.<?php echo e($domain); ?></strong></div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="account">
                                    <h4 class="info-text"> <?php echo app('translator')->get('saas.create-first-admin'); ?> </h4>
                                    <div class="row">
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="form-group">
                                                <label for="first_name"><?php echo app('translator')->get('saas.name'); ?></label>
                                                <input  data-msg="<?php echo app('translator')->get('saas.required-msg'); ?>"  required="required" class="form-control" type="text" id="name" name="name"  value="<?php echo e(old('name')); ?>"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="username"><?php echo app('translator')->get('saas.email'); ?></label>
                                                <input  data-msg="<?php echo app('translator')->get('saas.required-msg'); ?>"   data-msg-email="<?php echo app('translator')->get('saas.valid-email'); ?>"  required="required"  class="form-control" type="email" id="email" name="email" value="<?php echo e(old('email')); ?>"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="password"><?php echo app('translator')->get('saas.password'); ?></label>
                                                <input min="6"  required="required"   data-msg="<?php echo app('translator')->get('saas.required-msg'); ?>" data-msg-minlength="<?php echo app('translator')->get('saas.password-length'); ?>"   class="form-control" id="password" type="password" name="password" value="<?php echo e(old('password')); ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="password"><?php echo app('translator')->get('saas.confirm-password'); ?></label>
                                                <input  min="6"   required="required"    data-msg="<?php echo app('translator')->get('saas.required-msg'); ?>"   data-msg-equalTo="<?php echo app('translator')->get('saas.password-confirm'); ?>"   class="form-control" type="password" id="password_confirmation" name="password_confirmation" value="<?php echo e(old('confirm_password')); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="address">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4 class="info-text"> <?php echo app('translator')->get('saas.basic-settings'); ?> </h4>
                                        </div>
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="form-group">
                                                <label for="general_site_name"><?php echo app('translator')->get('saas.site-name'); ?></label>
                                                <input data-msg="<?php echo app('translator')->get('saas.required-msg'); ?>" required="required" class="form-control" type="text" name="general_site_name" id="general_site_name"  value="<?php echo e(old('general_site_name')); ?>"/>
                                            </div>

                                            <div class="form-group">
                                                <label for="general_admin_email"><?php echo app('translator')->get('saas.site-email'); ?></label>
                                                <input   data-msg="<?php echo app('translator')->get('saas.required-msg'); ?>"    data-msg-email="<?php echo app('translator')->get('saas.valid-email'); ?>" required="required" class="form-control" type="text" name="general_admin_email" id="general_admin_email"  value="<?php echo e(old('general_admin_email')); ?>"/>
                                            </div>

                                            <div class="form-group">
                                                <label for="general_tel"><?php echo app('translator')->get('settings.general_tel'); ?></label>
                                                <input   required="required" class="form-control" type="text" name="general_tel" id="general_tel"  value="<?php echo e(old('general_tel')); ?>"/>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="wizard-footer">
                                <div class="pull-right">
                                    <input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next' value='<?php echo app('translator')->get('saas.next'); ?>' />
                                    <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd' name='finish' value='<?php echo app('translator')->get('saas.finish'); ?>' />
                                </div>

                                <div class="pull-left">
                                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='<?php echo app('translator')->get('saas.previous'); ?>' />
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div> <!-- wizard container -->
            </div>
        </div><!-- end row -->
    </div> <!--  big container -->

    <div class="footer">
        <div class="container text-center">
            © <?php echo e(date('Y')); ?> <?php echo e(setting('general_site_name')); ?>.
        </div>
    </div>
</div>


</body>
<!--   Core JS Files   -->
<script src="<?php echo e(asset('themes/wizard/assets/js/jquery-2.2.4.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('themes/wizard/assets/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('themes/wizard/assets/js/jquery.bootstrap.js')); ?>" type="text/javascript"></script>

<!--  Plugin for the Wizard -->
<script src="<?php echo e(asset('themes/wizard/assets/js/material-bootstrap-wizard.js')); ?>"></script>

<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
<script src="<?php echo e(asset('themes/wizard/assets/js/jquery.validate.min.js')); ?>"></script>
<script>
    $(function(){
        $('#username').keyup(function(){
            $.get(checkUrl+'?username='+$(this).val(),function(data){
               console.log(data);
                if(data.status){
                    if($('#username').val().length >= 3){
                        $('#username-exits').text('<?php echo app('translator')->get('saas.username-valid'); ?>');
                    }
                    else{
                        $('#username-exits').text('');
                    }

                }
                else{
                    $('#username-exits').text('<?php echo app('translator')->get('saas.username-exists'); ?>');
                }
            });
        });

    });
</script>
<?php if(false): ?>
<?php echo clean( setting('general_footer_scripts')); ?>

    <?php endif; ?>
</html>
<?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/subscriber/setup/index.blade.php ENDPATH**/ ?>