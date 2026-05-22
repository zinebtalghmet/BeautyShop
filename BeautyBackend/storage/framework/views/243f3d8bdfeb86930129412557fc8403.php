<?php $__env->startSection('title', 'Contact Message'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal781784ddc1cff9584ff159910cf34f25 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal781784ddc1cff9584ff159910cf34f25 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.common.page-breadcrumb','data' => ['pageTitle' => 'Message from '.e($contact->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('common.page-breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pageTitle' => 'Message from '.e($contact->name).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal781784ddc1cff9584ff159910cf34f25)): ?>
<?php $attributes = $__attributesOriginal781784ddc1cff9584ff159910cf34f25; ?>
<?php unset($__attributesOriginal781784ddc1cff9584ff159910cf34f25); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal781784ddc1cff9584ff159910cf34f25)): ?>
<?php $component = $__componentOriginal781784ddc1cff9584ff159910cf34f25; ?>
<?php unset($__componentOriginal781784ddc1cff9584ff159910cf34f25); ?>
<?php endif; ?>

<div class="max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <span class="block text-theme-xs font-medium text-gray-500 uppercase mb-1">Name</span>
                <span class="text-sm font-medium text-gray-800 dark:text-white/90"><?php echo e($contact->name); ?></span>
            </div>
            <div>
                <span class="block text-theme-xs font-medium text-gray-500 uppercase mb-1">Email</span>
                <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($contact->email); ?></span>
            </div>
            <div>
                <span class="block text-theme-xs font-medium text-gray-500 uppercase mb-1">Subject</span>
                <span class="text-sm text-gray-800 dark:text-white/90"><?php echo e($contact->subject); ?></span>
            </div>
            <div>
                <span class="block text-theme-xs font-medium text-gray-500 uppercase mb-1">Date</span>
                <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($contact->created_at->format('F d, Y \a\t g:i A')); ?></span>
            </div>
        </div>
        <div>
            <span class="block text-theme-xs font-medium text-gray-500 uppercase mb-2">Message</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed"><?php echo e($contact->message); ?></p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/admin/contacts/show.blade.php ENDPATH**/ ?>