
<?php $__env->startSection('title', 'Tax Rates'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal781784ddc1cff9584ff159910cf34f25 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal781784ddc1cff9584ff159910cf34f25 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.common.page-breadcrumb','data' => ['pageTitle' => 'Tax Rates']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('common.page-breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pageTitle' => 'Tax Rates']); ?>
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

<div class="flex items-center justify-between mb-4">
    <div></div>
    <a href="<?php echo e(route('admin.tax-rates.create')); ?>"
       class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
        + New Tax Rate
    </a>
</div>

<?php if(session('success')): ?>
    <div class="mb-4 rounded-lg bg-success-50 dark:bg-success-500/10 px-4 py-3 text-sm text-success-700 dark:text-success-400">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-800">
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Country</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Region</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Label</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Rate (%)</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Priority</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $taxRates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxRate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="px-4 py-3.5 text-sm font-medium text-gray-800 dark:text-white/90"><?php echo e($taxRate->country); ?></td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400"><?php echo e($taxRate->region ?? '—'); ?></td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400"><?php echo e($taxRate->label); ?></td>
                        <td class="px-4 py-3.5 text-sm text-gray-800 dark:text-white/90"><?php echo e(number_format($taxRate->rate, 2)); ?>%</td>
                        <td class="px-4 py-3.5 text-sm text-center text-gray-500 dark:text-gray-400"><?php echo e($taxRate->priority); ?></td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            <?php if($taxRate->is_active): ?>
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500">Active</span>
                            <?php else: ?>
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="<?php echo e(route('admin.tax-rates.edit', $taxRate)); ?>"
                                   class="text-brand-500 hover:text-brand-600 font-medium">Edit</a>
                                <form action="<?php echo e(route('admin.tax-rates.destroy', $taxRate)); ?>" method="POST"
                                      onsubmit="return confirm('Delete this tax rate?')" class="inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-500 hover:text-red-600 font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" class="px-4 py-10 text-center text-sm text-gray-400 dark:text-gray-500">No tax rates found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4"><?php echo e($taxRates->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/admin/tax-rates/index.blade.php ENDPATH**/ ?>