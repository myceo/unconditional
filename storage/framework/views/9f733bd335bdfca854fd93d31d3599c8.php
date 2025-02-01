<div class="form-group <?php echo e($errors->has('menu_title') ? 'has-error' : ''); ?>">
    <label for="menu_title" class="control-label"><?php echo app('translator')->get('saas.menu-title'); ?></label>
    <input class="form-control" name="menu_title" type="text" id="menu_title" value="<?php echo e(old('menu_title',isset($article->menu_title) ? $article->menu_title : '')); ?>" >
    <?php echo clean( $errors->first('menu_title', '<p class="help-block">:message</p>')); ?>

</div>
<div class="form-group <?php echo e($errors->has('page_title') ? 'has-error' : ''); ?>">
    <label for="page_title" class="control-label"><?php echo app('translator')->get('saas.page-title'); ?></label>
    <input class="form-control" name="page_title" type="text" id="page_title" value="<?php echo e(old('page_title',isset($article->page_title) ? $article->page_title : '')); ?>" >
    <?php echo clean( $errors->first('page_title', '<p class="help-block">:message</p>')); ?>

</div>
<div class="form-group <?php echo e($errors->has('content') ? 'has-error' : ''); ?>">
    <label for="content" class="control-label"><?php echo app('translator')->get('saas.content'); ?></label>
    <textarea class="form-control" rows="5" name="content" type="textarea" id="content" ><?php echo e(old('content',isset($article->content) ? clean($article->content) : '')); ?></textarea>
    <?php echo clean( $errors->first('content', '<p class="help-block">:message</p>')); ?>

</div>


<div class="form-group">
    <label for="categories"><?php echo app('translator')->get('saas.categories'); ?></label>
    <?php if($formMode === 'edit'): ?>
        <select multiple name="categories[]" id="categories" class="form-control select2">
            <option></option>
            <?php $__currentLoopData = \App\Models\ArticleCategory::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option  <?php if( (is_array(old('categories')) && in_array(@$category->id,old('categories')))  || (null === old('categories')  && $article->articleCategories()->where('article_category_id',$category->id)->first() )): ?>
                    selected
                    <?php endif; ?>
                    value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    <?php else: ?>
        <select  multiple name="categories[]" id="categories" class="form-control select2">
            <option></option>
            <?php $__currentLoopData = \App\Models\ArticleCategory::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option <?php if(is_array(old('categories')) && in_array(@$category->id,old('categories'))): ?> selected <?php endif; ?> value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    <?php endif; ?>
    
</div>



<div class="form-group <?php echo e($errors->has('sort_order') ? 'has-error' : ''); ?>">
    <label for="sort_order" class="control-label"><?php echo app('translator')->get('saas.sort-order'); ?></label>
    <input class="form-control number" name="sort_order" type="text" id="sort_order" value="<?php echo e(old('sort_order',isset($article->sort_order) ? $article->sort_order : '')); ?>" >
    <?php echo clean( $errors->first('sort_order', '<p class="help-block">:message</p>')); ?>

</div>
<div class="form-group <?php echo e($errors->has('meta_title') ? 'has-error' : ''); ?>">
    <label for="meta_title" class="control-label"><?php echo app('translator')->get('saas.meta-title'); ?></label>
    <input class="form-control" name="meta_title" type="text" id="meta_title" value="<?php echo e(old('meta_title',isset($article->meta_title) ? $article->meta_title : '')); ?>" >
    <?php echo clean( $errors->first('meta_title', '<p class="help-block">:message</p>')); ?>

</div>
<div class="form-group <?php echo e($errors->has('meta_description') ? 'has-error' : ''); ?>">
    <label for="meta_description" class="control-label"><?php echo app('translator')->get('saas.meta-description'); ?></label>
    <textarea class="form-control" rows="5" name="meta_description" type="textarea" id="meta_description" ><?php echo e(old('meta_description',isset($article->meta_description) ? $article->meta_description : '')); ?></textarea>
    <?php echo clean( $errors->first('meta_description', '<p class="help-block">:message</p>')); ?>

</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? __('saas.update') : __('saas.create')); ?>">
</div>
<?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/admin/articles/form.blade.php ENDPATH**/ ?>