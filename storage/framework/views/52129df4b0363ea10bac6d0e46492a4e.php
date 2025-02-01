<div class="table-responsive">
    <table class="table">
        <tbody>
        <?php if($subscriber->subscriber()->exists()): ?>
            <tr>
                <th><?php echo app('translator')->get('saas.users'); ?></th><td><?php echo e($stats['users']); ?> / <?php echo e($stats['package']->user_limit); ?></td>
            </tr>
            <tr><th> <?php echo app('translator')->get('admin.departments'); ?> </th><td> <?php echo e($stats['departments']); ?>  / <?php echo e($stats['package']->department_limit); ?></td></tr>

            <tr>
                <th><?php echo app('translator')->get('saas.disk-space'); ?></th><td><?php echo e($stats['disk']); ?> / <?php echo e($stats['limit']); ?></td>
            </tr>
            <tr><th> <?php echo app('translator')->get('saas.forum-topics'); ?> </th><td> <?php echo e($stats['forum_topics']); ?> </td></tr>
            <tr><th> <?php echo app('translator')->get('admin.events'); ?> </th><td> <?php echo e($stats['events']); ?> </td></tr>

            <tr><th> <?php echo app('translator')->get('admin.downloads'); ?> </th><td> <?php echo e($stats['downloads']); ?> </td></tr>
            <tr><th> <?php echo app('translator')->get('admin.announcements'); ?> </th><td> <?php echo e($stats['announcements']); ?> </td></tr>
            <tr><th> <?php echo app('translator')->get('admin.messages'); ?> </th><td> <?php echo e($stats['emails']); ?> </td></tr>
            <tr><th> <?php echo app('translator')->get('admin.sms'); ?> </th><td> <?php echo e($stats['sms']); ?> </td></tr>

        <?php endif; ?>
        </tbody>
    </table>
</div><?php /**PATH /home/unconditional/htdocs/unconditional.org/resources/views/admin/subscribers/stats.blade.php ENDPATH**/ ?>