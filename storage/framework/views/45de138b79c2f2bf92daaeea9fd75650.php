<?php $__env->startSection('title', 'マイページ'); ?>
<?php $__env->startSection('content'); ?>
<div class="p-5 lg:mt-6 lg:mt-0 bg-white">
  <p>ID: <?php echo e($user['id'], false); ?> </p>
  <p>NAME: <?php echo e($user['name'], false); ?> </p>
  <p>E-MAIL: <?php echo e($user['email'], false); ?> </p>
<?php if(auth()->guard()->check()): ?>  
  <a href="<?php echo e(route('auth.logout'), false); ?>" class="text-blue-500 inline-block cursor-pointer">ログアウト</a>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/nagamura/works/sites/mt-d.mitaden.local/resources/views/mypage/index.blade.php ENDPATH**/ ?>