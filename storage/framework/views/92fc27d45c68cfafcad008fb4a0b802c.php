<head>
  <title><?php echo $__env->yieldContent('title'); ?></title>
  <?php echo $__env->make('layouts.style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php echo $__env->make('layouts.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<?php /**PATH /Users/nagamura/works/sites/mt-d.mitaden.local/resources/views/layouts/head.blade.php ENDPATH**/ ?>