

<?php $__env->startSection('content'); ?>
    <h1><?php echo e($title); ?></h1>
    <h2>Skills:</h2>
    <?php if(count($skills) > 0): ?>
        <ul class="list-group">
            <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item"><?php echo e($skill); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/code/CBProject/resources/views/pages/about.blade.php ENDPATH**/ ?>