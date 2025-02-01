<?php $__env->startSection('pageTitle',__('saas.contact')); ?>
<?php $__env->startSection('page-title',__('saas.contact')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('saas.contact'); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('page-content'); ?>

    <div class="row">
        <div class="col-md-4 col-lg-3 mb-4 mb-md-0">
            <div class="media contact-info">
                <span class="contact-info__icon"><i class="ti-home"></i></span>
                <div class="media-body">
                    <h3><?php echo e(setting('general_address')); ?></h3>
                    <p><?php echo e(setting('general_site_name')); ?></p>
                </div>
            </div>
            <div class="media contact-info">
                <span class="contact-info__icon"><i class="ti-headphone"></i></span>
                <div class="media-body">
                    <h3><a href="tel:<?php echo e(setting('general_tel')); ?>"><?php echo e(setting('general_tel')); ?></a></h3>

                </div>
            </div>
            <div class="media contact-info">
                <span class="contact-info__icon"><i class="ti-email"></i></span>
                <div class="media-body">
                    <h3><a href="mailto:<?php echo e(setting('general_contact_email')); ?>"><?php echo e(setting('general_contact_email')); ?></a></h3>

                </div>
            </div>
        </div>
        <div class="col-md-8 col-lg-9">
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
            <form  class="form-contact contact_form" action="<?php echo e(route('site.send-msg')); ?>" method="post" id="contactForm">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <input required class="form-control" name="name" id="name" type="text" placeholder="<?php echo app('translator')->get('saas.enter-name'); ?>">
                        </div>
                        <div class="form-group">
                            <input required  class="form-control" name="email" id="email" type="email" placeholder="<?php echo app('translator')->get('saas.enter-email'); ?>">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="subject" id="subject" type="text" placeholder="<?php echo app('translator')->get('saas.enter-subject'); ?>">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <?php echo captcha_img(); ?>

                            </div>
                            <div class="col-md-7">
                                <input type="text" name="captcha" class="form-control" placeholder="<?php echo app('translator')->get('site.enter-code'); ?>" value="<?php echo e(old('captcha')); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-group">
                            <textarea  required  class="form-control different-control w-100" name="message" id="message" cols="30" rows="5" placeholder="<?php echo app('translator')->get('saas.enter-message'); ?>"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center text-md-right mt-3">
                    <button type="submit" class="button button-contactForm"><?php echo app('translator')->get('saas.send-message'); ?></button>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site-page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/site/index/contact.blade.php ENDPATH**/ ?>