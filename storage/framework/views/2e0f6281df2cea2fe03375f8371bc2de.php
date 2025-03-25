<?php if($paginator->hasPages()): ?>
<div class="text-[10px] py-[20px] mb-6">
  <p>
    <!-- 前へ移動ボタン -->
    <?php if($paginator->onFirstPage()): ?>
    <?php else: ?>
    <a href="<?php echo e($paginator->url(1), false); ?>" class="text-gray-900 bg-white m-0 mr-2 p-1 pb-0.5 border border-gray-300 float-left w-6 text-center no-underline overflow-hidden hover:text-white hover:bg-gray-300">&lt;&lt;</a>
    <a href="<?php echo e($paginator->previousPageUrl(), false); ?>" class="text-gray-900 bg-white m-0 mr-2 p-1 pb-0.5 border border-gray-300 float-left w-6 text-center no-underline overflow-hidden hover:text-white hover:bg-gray-300">&lt;</a>
    <?php endif; ?>
    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(is_array($element)): ?>
    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($page == $paginator->currentPage()): ?>
    <span class="text-white bg-gray-300  m-0 mr-2 p-1 pb-0.5 border border-gray-300 float-left w-6 text-center no-underline overflow-hidden"><?php echo e($page, false); ?></span>
    <?php else: ?>
    <a href="<?php echo e($url, false); ?>" class="text-gray-900 bg-white m-0 mr-2 p-1 pb-0.5 border border-gray-300 float-left w-6 text-center no-underline overflow-hidden hover:text-white hover:bg-gray-300"><?php echo e($page, false); ?></a>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <!-- 次へ移動ボタン -->
    <?php if($paginator->hasMorePages()): ?>
    <a href="<?php echo e($paginator->nextPageUrl(), false); ?>" class="text-gray-900 bg-white m-0 mr-2 p-1 pb-0.5 border border-gray-300 float-left w-6 text-center no-underline overflow-hidden hover:text-white hover:bg-gray-300">&gt;</a>
    <a href="<?php echo e($paginator->lastPage(), false); ?>" class="text-gray-900 bg-white m-0 mr-2 p-1 pb-0.5 border border-gray-300 float-left w-6 text-center no-underline overflow-hidden hover:text-white hover:bg-gray-300">&gt;&gt;</a> 
    <?php endif; ?>
  </p>
</div>
<?php endif; ?>
<?php /**PATH /Users/nagamura/works/sites/mt-d.mitaden.local/resources/views/vendor/pagination/shop-order.blade.php ENDPATH**/ ?>