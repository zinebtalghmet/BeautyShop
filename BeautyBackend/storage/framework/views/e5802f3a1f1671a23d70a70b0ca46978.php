
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal781784ddc1cff9584ff159910cf34f25 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal781784ddc1cff9584ff159910cf34f25 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.common.page-breadcrumb','data' => ['pageTitle' => 'Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('common.page-breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pageTitle' => 'Dashboard']); ?>
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
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between mb-4">
            <span class="text-theme-sm text-gray-500 dark:text-gray-400">Total Products</span>
            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-brand-50 text-brand-500 dark:bg-brand-500/10">🛍️</span>
        </div>
        <h4 class="text-title-md font-bold text-gray-800 dark:text-white/90"><?php echo e(\App\Models\Product::count()); ?></h4>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between mb-4">
            <span class="text-theme-sm text-gray-500 dark:text-gray-400">Categories</span>
            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-success-50 text-success-500 dark:bg-success-500/10">📂</span>
        </div>
        <h4 class="text-title-md font-bold text-gray-800 dark:text-white/90"><?php echo e(\App\Models\Category::count()); ?></h4>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between mb-4">
            <span class="text-theme-sm text-gray-500 dark:text-gray-400">Total Orders</span>
            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-orange-50 text-orange-500 dark:bg-orange-500/10">📦</span>
        </div>
        <h4 class="text-title-md font-bold text-gray-800 dark:text-white/90"><?php echo e(\App\Models\Order::count()); ?></h4>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between mb-4">
            <span class="text-theme-sm text-gray-500 dark:text-gray-400">Contacts</span>
            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-error-50 text-error-500 dark:bg-error-500/10">✉️</span>
        </div>
        <h4 class="text-title-md font-bold text-gray-800 dark:text-white/90"><?php echo e(\App\Models\Contact::count()); ?></h4>
    </div>
</div>
<div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
    <p class="text-gray-500 dark:text-gray-400">Welcome to the BeautyShop admin panel. Manage your products, orders, and more from here.</p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>