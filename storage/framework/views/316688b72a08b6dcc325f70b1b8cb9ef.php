<?php $__env->startSection('pageTitle',__("admin.setting-".$group)); ?>

<?php $__env->startSection('pageTitle',__('saas.create-new').' '.__('saas.plan')); ?>
<?php $__env->startSection('page-title',__("admin.setting-".$group)); ?>

<?php $__env->startSection('page-content'); ?>

    <div class="single-pro-review-area mt-t-30 mg-b-15">


        <div class="container-fluid">
            <div class="product-payment-inner-st form-content">


                <form method="POST" action="<?php echo e(route('admin.save-settings')); ?>" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group">
                            <label for="<?php echo e($setting->key); ?>"><?php echo app('translator')->get('settings.'.$setting->key); ?></label>
                            <?php if($setting->type=='text'): ?>

                                <input placeholder="<?php echo e($setting->placeholder); ?>" <?php if(empty($setting->class)): ?> class="form-control" <?php else: ?> class="<?php echo e($setting->class); ?>"<?php endif; ?> type="text" name="<?php echo e($setting->key); ?>" value="<?php echo e($setting->value); ?>"/>
                                
                                <?php elseif($setting->type=='textarea'): ?>

                                <textarea placeholder="<?php echo e($setting->placeholder); ?>"  <?php if(empty($setting->class)): ?> class="form-control" <?php else: ?> class="<?php echo e($setting->class); ?>" <?php endif; ?>  name="<?php echo e($setting->key); ?>" id="<?php echo e($setting->key); ?>"><?php echo $setting->value; ?></textarea>
                            
                                <?php elseif($setting->type=='select'): ?>
                                <?php



                                if(!empty($setting->options)){
                                    $options = explode(',',$setting->options);
                                    $foptions = [];

                                    foreach($options as $option){
                                        if(preg_match('#=#',$option)) {
                                            $temp = explode('=', $option);
                                            $foptions[$temp[0]] = $temp[1];
                                        }
                                        else{
                                            $foptions[$option]=$option;
                                        }

                                    }

                                }
                                else{
                                    $foptions=[];
                                }







                                    if(empty($setting->class)){
                                        $class = 'form-control';
                                    }
                                    else{
                                        $class = $setting->class;
                                    }
                                ?>
                                <?php echo e(Form::select($setting->key,$foptions,$setting->value,['placeholder' => $setting->placeholder,'class'=>$class])); ?>



                            <?php elseif($setting->type=='radio'): ?>

                                <?php


                                if(!empty($setting->options)){
                                    $options = explode(',',$setting->options);
                                    $foptions = [];

                                    foreach($options as $option){
                                        if(preg_match('#=#',$option)) {
                                            $temp = explode('=', $option);
                                            $foptions[$temp[0]] = $temp[1];
                                        }
                                        else{
                                            $foptions[$option]=$option;
                                        }

                                    }

                                }
                                else{
                                    $foptions=[];
                                }
                                ?>

                                <?php $__currentLoopData = $foptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2=>$value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" <?php if($setting->value==$key2): ?> checked <?php endif; ?>  name="<?php echo e($setting->key); ?>" id="<?php echo e($setting->key); ?>" value="<?php echo e($key2); ?>" >
                                            <?php echo e($value2); ?>

                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                <?php elseif($setting->type='image'): ?>

                                    <?php if(!empty($setting->value)): ?>
                                    <img class="img-responsive" src="<?php echo e(asset($setting->value)); ?>" style="max-width: 300px"/>
                                    <br/>
                                    <a class="btn btn-danger" href="<?php echo e(route('admin.remove-picture',['setting'=>$setting->id])); ?>"><?php echo app('translator')->get('admin.remove-picture'); ?></a>
                                    <br/><br/>
                                        <?php endif; ?>

                                <input type="file" name="<?php echo e($setting->key); ?>"/>
                            <?php endif; ?>
                                
                        </div>
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                    <button class="btn btn-primary btn-block btn-lg" type="submit"><?php echo app('translator')->get('admin.save'); ?></button>
                </form>




            </div>
        </div>


    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('footer'); ?>
    <script src="<?php echo e(asset('themes/main/js/summernote/summernote.min.js')); ?>"></script>
    <script src="<?php echo e(asset('themes/main/js/summernote/summernote-active.js')); ?>"></script>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('themes/main/css/summernote/summernote.css')); ?>">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/admin/settings/settings.blade.php ENDPATH**/ ?>