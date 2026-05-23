
<?php $__env->startSection('title', 'Products'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal781784ddc1cff9584ff159910cf34f25 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal781784ddc1cff9584ff159910cf34f25 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.common.page-breadcrumb','data' => ['pageTitle' => 'Products']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('common.page-breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pageTitle' => 'Products']); ?>
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
    <a href="<?php echo e(route('admin.products.create')); ?>" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">+ New Product</a>
</div>

<form method="GET" class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] mb-4 flex flex-wrap gap-3 items-end">
    <div>
        <label class="block text-theme-xs font-medium text-gray-500 mb-1">Search</label>
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search products..." class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 w-56">
    </div>
    <div>
        <label class="block text-theme-xs font-medium text-gray-500 mb-1">Category</label>
        <select name="category" class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
            <option value="">All</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->slug); ?>" <?php echo e(request('category') === $cat->slug ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="block text-theme-xs font-medium text-gray-500 mb-1">Status</label>
        <select name="status" class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
            <option value="">All</option>
            <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
            <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
        </select>
    </div>
    <button type="submit" class="h-10 rounded-lg bg-gray-900 px-4 text-sm font-medium text-white hover:bg-gray-800 dark:bg-white/[0.08] dark:hover:bg-white/[0.12]">Filter</button>
</form>

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-800">
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-4 py-3 text-right text-theme-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Stock</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Featured</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="px-4 py-3.5 text-sm font-medium text-gray-800 dark:text-white/90"><?php echo e($product->name); ?></td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400"><?php echo e($product->category->name ?? '—'); ?></td>
                        <td class="px-4 py-3.5 text-sm text-right text-gray-800 dark:text-white/90">$<?php echo e(number_format($product->price, 2)); ?></td>
                        <td class="px-4 py-3.5 text-sm text-center" style="color: <?php echo e($product->stock > 5 ? '#12b76a' : ($product->stock > 0 ? '#f79009' : '#f04438')); ?>"><?php echo e($product->stock); ?></td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            <?php if($product->is_featured): ?>
                                <span class="text-orange-500">★</span>
                            <?php else: ?>
                                <span class="text-gray-300 dark:text-gray-600">★</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            <?php if($product->is_active): ?>
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500">Active</span>
                            <?php else: ?>
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="text-brand-500 hover:text-brand-600 font-medium">Edit</a>
                                <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" onsubmit="return confirm('Delete this product?')" class="inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-500 hover:text-red-600 font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" class="px-4 py-10 text-center text-sm text-gray-400">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4"><?php echo e($products->withQueryString()->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/admin/products/index.blade.php ENDPATH**/ ?>