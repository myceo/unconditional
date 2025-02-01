<div class="blog_right_sidebar">
    <aside class="single_sidebar_widget search_widget">
        <form action="<?php echo e(route('blog.listing')); ?>" class="search-box" method="get">
            <div class="input-group">
                <input name="q" type="text" class="form-control" placeholder="<?php echo app('translator')->get('saas.search'); ?>">
                              <span class="input-group-btn">
                                  <button  class="btn btn-default" type="submit">
                                      <i class="lnr lnr-magnifier"></i>
                                  </button>
                              </span>
            </div>
            <!-- /input-group -->
            <div class="br"></div>
        </form>
    </aside>
    <aside class="single_sidebar_widget popular_post_widget">
        <h3 class="widget_title"><?php echo app('translator')->get('saas.recent-posts'); ?></h3>
        <?php $__currentLoopData = $recent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="media post_item">
                <?php if(!empty($post->cover_image)): ?>
                    <img style="max-width: 100px" src="<?php echo e(asset($post->cover_image)); ?>" alt="image" />
                <?php endif; ?>
                <div class="media-body">
                    <a href="<?php echo e(route('blog.post',['blogPost'=>$post->id,'slug'=>safeUrl($post->title)])); ?>">
                        <h3><?php echo e($post->title); ?></h3>
                    </a>
                    <p><?php echo e(\Carbon\Carbon::parse($post->created_at)->diffForHumans()); ?></p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="br"></div>
    </aside>

    <aside class="single_sidebar_widget post_category_widget">
        <h4 class="widget_title"><?php echo app('translator')->get('saas.categories'); ?></h4>
        <ul class="list cat-list">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e(route('blog.listing')); ?>?category=<?php echo e($category->id); ?>" class="d-flex justify-content-between">
                        <p><?php echo e($category->category); ?></p>
                        <p><?php echo e($category->blogPosts()->whereDate('published_on','<=',\Carbon\Carbon::now()->toDateTimeString())->count()); ?></p>
                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <div class="br"></div>
    </aside>
    <form id="nlform" action="<?php echo e(route('site.save-email')); ?>"
          method="post"  >
        <?php echo csrf_field(); ?>
        <aside class="single-sidebar-widget newsletter_widget">
            <h4 class="widget_title"><?php echo app('translator')->get('saas.newsletter'); ?></h4>
            <p>
                <?php echo app('translator')->get('saas.upto-date'); ?>
            </p>

            <div class="form-group d-flex flex-row">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </div>
                    </div>
                    <input required name="email" type="text" class="form-control" id="inlineFormInputGroup" placeholder="<?php echo app('translator')->get('saas.email'); ?>" onfocus="this.placeholder = ''"
                           onblur="this.placeholder = '<?php echo app('translator')->get('saas.your-email'); ?>'">
                </div>
                <a  href="#nlform" onclick="return $('#nlform').submit()" class="bbtns"><?php echo app('translator')->get('saas.subscribe'); ?></a>

            </div>

            <p class="text-bottom"><?php echo app('translator')->get('saas.unsubscribe-text'); ?></p>
            <div class="br"></div>
        </aside>
    </form>
</div><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/site/blog/sidebar.blade.php ENDPATH**/ ?>