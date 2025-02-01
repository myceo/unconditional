<div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
    <label for="name" class="control-label"><?php echo app('translator')->get('saas.name'); ?></label>
    <input required class="form-control" name="name" type="text" id="name" value="<?php echo e(old('name',isset($subscriber->name) ? $subscriber->name : '')); ?>" >
    <?php echo clean( $errors->first('name', '<p class="help-block">:message</p>')); ?>

</div>
<div class="form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
    <label for="email" class="control-label"><?php echo app('translator')->get('saas.email'); ?></label>
    <input required  class="form-control" name="email" type="text" id="email" value="<?php echo e(old('email',isset($subscriber->email) ? $subscriber->email : '')); ?>" >
    <?php echo clean( $errors->first('email', '<p class="help-block">:message</p>')); ?>

</div>
<div class="form-group <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
    <label for="password" class="control-label"><?php if($formMode=='edit'): ?> <?php echo app('translator')->get('saas.change'); ?> <?php endif; ?> <?php echo app('translator')->get('saas.password'); ?></label>
    <input <?php if($formMode=='create'): ?>  required <?php endif; ?> class="form-control" name="password" type="password" id="password" value="<?php echo e(old('password')); ?>" >
    <?php echo clean( $errors->first('password', '<p class="help-block">:message</p>')); ?>

</div>
<?php if($formMode=='create'): ?>
<div class="form-group <?php echo e($errors->has('username') ? 'has-error' : ''); ?>">
    <label for="username" class="control-label"><?php echo app('translator')->get('saas.username'); ?></label>
    <input required  class="form-control" name="username" type="text" id="username" value="<?php echo e(old('username',isset($subscriber->username) ? $subscriber->username : '')); ?>" >
    <?php echo clean( $errors->first('username', '<p class="help-block">:message</p>')); ?>

</div>
<?php endif; ?>

<?php if($formMode=='edit'): ?>
<div class="form-group <?php echo e($errors->has('expires') ? 'has-error' : ''); ?>">
    <label for="expires" class="control-label"><?php echo app('translator')->get('saas.expires'); ?></label>
    <input required  class="form-control date" name="expires" type="text" id="expires" value="<?php echo e(old('expires',isset($expires) ? $expires : '')); ?>" >
    <?php echo clean( $errors->first('expires', '<p class="help-block">:message</p>')); ?>

</div>
<?php endif; ?>

<div class="form-group <?php echo e($errors->has('package_duration_id') ? 'has-error' : ''); ?>">
    <label for="package_duration_id" class="control-label"><?php echo app('translator')->get('saas.plan'); ?></label>
    <select required  class="form-control" name="package_duration_id" id="package_duration_id">
        <option value=""></option>
        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option <?php if(old('package_duration_id',isset($plan) ? $plan : '')==$package->id): ?> selected <?php endif; ?> value="<?php echo e($package->id); ?>"><?php echo e($package->package->name); ?> (<?php echo e(($package->type=='m')? __('saas.monthly'):__('saas.annual')); ?>) - <?php echo e(price($package->price)); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
   
    <?php echo clean( $errors->first('package_duration_id', '<p class="help-block">:message</p>')); ?>

</div>


<div class="form-group <?php echo e($errors->has('currency_id') ? 'has-error' : ''); ?>">
    <label for="currency_id" class="control-label"><?php echo app('translator')->get('saas.currency'); ?></label>
    <select required  class="form-control" name="currency_id" id="currency_id">
        <option value=""></option>
        <?php $__currentLoopData = \App\Models\Currency::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option <?php if(old('currency_id',isset($currencyId) ? $currencyId : '')==$currency->id): ?> selected <?php endif; ?> value="<?php echo e($currency->id); ?>"><?php echo e($currency->country->currency_name); ?> (<?php echo e($currency->country->currency_code); ?>)</option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <?php echo clean( $errors->first('currency_id', '<p class="help-block">:message</p>')); ?>

</div>


<div class="form-group <?php echo e($errors->has('trial') ? 'has-error' : ''); ?>">
    <label for="trial" class="control-label"><?php echo app('translator')->get('saas.trial'); ?></label>
    <select required  name="trial" class="form-control" id="trial" >
    <?php $__currentLoopData = json_decode('{"0":"No","1":"Yes"}', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($optionKey); ?>" <?php echo e(((null !== old('trial',@$subscriber->trial)) && old('subscriber',@$subscriber->trial) == $optionKey) ? 'selected' : ''); ?>><?php echo e($optionValue); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
    <?php echo clean( $errors->first('trial', '<p class="help-block">:message</p>')); ?>

</div>





<?php if($formMode=='create'): ?>
    <div class="form-group <?php echo e($errors->has('general_site_name') ? 'has-error' : ''); ?>">
        <label for="general_site_name" class="control-label"><?php echo app('translator')->get('settings.general_site_name'); ?></label>
        <input required  class="form-control" name="general_site_name" type="text" id="general_site_name" value="<?php echo e(old('general_site_name',isset($subscriber->general_site_name) ? $subscriber->general_site_name : '')); ?>" >
        <?php echo clean( $errors->first('general_site_name', '<p class="help-block">:message</p>')); ?>

    </div>


    <div class="form-group <?php echo e($errors->has('general_tel') ? 'has-error' : ''); ?>">
        <label for="general_tel" class="control-label"><?php echo app('translator')->get('settings.general_tel'); ?></label>
        <input required  class="form-control" name="general_tel" type="text" id="general_tel" value="<?php echo e(old('general_tel',isset($subscriber->general_tel) ? $subscriber->general_tel : '')); ?>" >
        <?php echo clean( $errors->first('general_tel', '<p class="help-block">:message</p>')); ?>

    </div>

<?php endif; ?>

<div class="form-group <?php echo e($errors->has('enabled') ? 'has-error' : ''); ?>">
    <label for="enabled" class="control-label"><?php echo app('translator')->get('saas.enabled'); ?></label>
    <select required  name="enabled" class="form-control" id="enabled" >
        <?php $__currentLoopData = json_decode('{"1":"Yes","0":"No"}', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($optionKey); ?>" <?php echo e(((null !== old('enabled',@$subscriber->enabled)) && old('subscriber',@$subscriber->enabled) == $optionKey) ? 'selected' : ''); ?>><?php echo e($optionValue); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php echo clean( $errors->first('enabled', '<p class="help-block">:message</p>')); ?>

</div>



<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? __('saas.update') : __('saas.create')); ?>">
</div>
<?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/admin/subscribers/form.blade.php ENDPATH**/ ?>