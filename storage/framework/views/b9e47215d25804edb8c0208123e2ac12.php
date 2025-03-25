<!doctype html>
<html lang="ja">
<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <body>
  <div id='wrapper'>
    <div id='main' class='flex flex-col text-sm lg:flex-row'>
<?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('content'); ?>
    </div>
  </div>
</body>
</html>
<?php /**PATH /Users/nagamura/works/sites/mt-d.mitaden.local/resources/views/layouts/main.blade.php ENDPATH**/ ?>