<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#home"><?php echo app('translator')->get('saas.details'); ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#menu1"><?php echo app('translator')->get('saas.payment-settings'); ?></a>
    </li>

</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane container active" id="home" style="padding-top: 30px">
        <div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
            <label for="name" class="control-label"><?php echo app('translator')->get('saas.name'); ?></label>
            <input required class="form-control" name="name" type="text" id="name" value="<?php echo e(old('name',isset($plan->name) ? $plan->name : '')); ?>" >
            <?php echo clean( $errors->first('name', '<p class="help-block">:message</p>')); ?>

        </div>

        <div class="form-group <?php echo e($errors->has('storage_space') ? 'has-error' : ''); ?>">
            <label for="storage_space" class="control-label"><?php echo app('translator')->get('saas.storage-space'); ?></label>
            <div class="row" style="margin-left:0px; margin-right: 0px" >
                <input placeholder="<?php echo app('translator')->get('saas.numbers-only'); ?>" class="form-control col-md-6 digit" name="storage_space" type="text" id="storage_space" value="<?php echo e(old('storage_space',isset($plan->storage_space) ? $plan->storage_space : '')); ?>" >
                <select class="form-control col-md-6" name="storage_unit" id="storage_unit">
                    <?php $__currentLoopData = ['mb'=>'MB','gb'=>'GB','tb'=>'TB']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php if( old('storage_unit',isset($plan->storage_unit) ? $plan->storage_unit : '')==$unit): ?> selected <?php endif; ?> value="<?php echo e($unit); ?>" ><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php echo clean( $errors->first('storage_space', '<p class="help-block">:message</p>')); ?>


            <p class="help-block"><?php echo app('translator')->get('saas.unlimited-msg'); ?></p>
        </div>
        <div class="form-group <?php echo e($errors->has('user_limit') ? 'has-error' : ''); ?>">
            <label for="user_limit" class="control-label"><?php echo app('translator')->get('saas.user-limit'); ?></label>
            <input placeholder="<?php echo app('translator')->get('saas.numbers-only'); ?>"  class="form-control number" name="user_limit" type="text" id="user_limit" value="<?php echo e(old('user_limit',isset($plan->user_limit) ? $plan->user_limit : '')); ?>" >
            <?php echo clean( $errors->first('user_limit', '<p class="help-block">:message</p>')); ?>

            <p class="help-block"><?php echo app('translator')->get('saas.unlimited-msg'); ?></p>
        </div>
        <div class="form-group <?php echo e($errors->has('department_limit') ? 'has-error' : ''); ?>">
            <label for="department_limit" class="control-label"><?php echo app('translator')->get('saas.department-limit'); ?></label>
            <input placeholder="<?php echo app('translator')->get('saas.numbers-only'); ?>"  class="form-control number" name="department_limit" type="text" id="department_limit" value="<?php echo e(old('department_limit',isset($plan->department_limit) ? $plan->department_limit : '')); ?>" >
            <?php echo clean( $errors->first('department_limit', '<p class="help-block">:message</p>')); ?>

            <p class="help-block"><?php echo app('translator')->get('saas.unlimited-msg'); ?></p>
        </div>
        <div class="form-group <?php echo e($errors->has('public') ? 'has-error' : ''); ?>">
            <label for="public" class="control-label"><?php echo app('translator')->get('saas.visibility'); ?></label>
            <select name="public" class="form-control" id="public" >
                <?php $__currentLoopData = json_decode('{"1":"'.__('saas.public').'","0":"'.__('saas.private').'"}', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($optionKey); ?>" <?php echo e(((null !== old('public',@$plan->public)) && old('plan',@$plan->public) == $optionKey) ? 'selected' : ''); ?>><?php echo e($optionValue); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php echo clean( $errors->first('public', '<p class="help-block">:message</p>')); ?>

        </div>
        <div class="form-group <?php echo e($errors->has('public') ? 'has-error' : ''); ?>">
            <label for="is_free" class="control-label"><?php echo app('translator')->get('saas.is-free'); ?></label>
            <select name="is_free" class="form-control" id="is_free" >
                <?php $__currentLoopData = json_decode('{"0":"'.__('saas.no').'","1":"'.__('saas.yes').'"}', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($optionKey); ?>" <?php echo e(((null !== old('is_free',@$plan->is_free)) && old('is_free',@$plan->is_free) == $optionKey) ? 'selected' : ''); ?>><?php echo e($optionValue); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php echo clean( $errors->first('public', '<p class="help-block">:message</p>')); ?>

        </div>


        <div class="amount form-group <?php echo e($errors->has('monthly_price') ? 'has-error' : ''); ?>">
            <label for="monthly_price" class="control-label"><?php echo app('translator')->get('saas.monthly-price'); ?></label>
            <input placeholder="<?php echo app('translator')->get('saas.numbers-only'); ?>"  class="form-control digit" name="monthly_price" type="text" id="monthly_price" value="<?php echo e(old('monthly_price',isset($monthly_price) ? $monthly_price : '')); ?>" >
            <?php echo clean( $errors->first('monthly_price', '<p class="help-block">:message</p>')); ?>

        </div>

        <div class="amount form-group <?php echo e($errors->has('annual_price') ? 'has-error' : ''); ?>">
            <label for="annual_price" class="control-label"><?php echo app('translator')->get('saas.annual-price'); ?></label>
            <input placeholder="<?php echo app('translator')->get('saas.numbers-only'); ?>"  class="form-control digit" name="annual_price" type="text" id="annual_price" value="<?php echo e(old('annual_price',isset($annual_price) ? $annual_price : '')); ?>" >
            <?php echo clean( $errors->first('annual_price', '<p class="help-block">:message</p>')); ?>

        </div>

        <div class="form-group <?php echo e($errors->has('sort_order') ? 'has-error' : ''); ?>">
            <label for="sort_order" class="control-label"><?php echo app('translator')->get('saas.sort-order'); ?></label>
            <input placeholder="<?php echo app('translator')->get('saas.numbers-only'); ?>"  class="form-control number" name="sort_order" type="text" id="sort_order" value="<?php echo e(old('sort_order',isset($plan->sort_order) ? $plan->sort_order : '')); ?>" >
            <?php echo clean( $errors->first('sort_order', '<p class="help-block">:message</p>')); ?>

        </div>


    </div>
    <div class="tab-pane container fade" id="menu1"  style="padding-top: 30px">

        <div class="card" style="margin-bottom: 30px">
            <div class="card-body">
                <h5 class="card-title">Stripe</h5>
                <div class="form-group">
                    <label for="stripe_plan_m"><?php echo app('translator')->get('saas.monthly-plan-id'); ?></label>
                    <input class="form-control" type="text" name="stripe_plan_m" id="stripe_plan_m" value="<?php echo e(old('stripe_plan_m',@$monthlyDuration->stripe_plan)); ?>"/>
                </div>
                <div class="form-group">
                    <label for="stripe_plan_a"><?php echo app('translator')->get('saas.annual-plan-id'); ?></label>
                    <input class="form-control" type="text" name="stripe_plan_a" id="stripe_plan_a" value="<?php echo e(old('stripe_plan_m',@$annualDuration->stripe_plan)); ?>"/>
                </div>
                <p>
                    <?php echo app('translator')->get('saas.webhook-url'); ?>: <?php echo e(route('webhooks.stripe')); ?>

                </p>
            </div>

        </div>

        <div class="card" style="margin-bottom: 30px">
            <div class="card-body">
                <h5 class="card-title">Paypal</h5>

                <p>
                    <?php echo app('translator')->get('saas.webhook-url'); ?>: <?php echo e(route('webhooks.paypal')); ?>

                </p>
            </div>

        </div>


    </div>


</div>












<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? __('saas.update') : __('saas.create')); ?>">
</div>
<?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/admin/plans/form.blade.php ENDPATH**/ ?>