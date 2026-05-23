
<?php $__env->startSection('title', $product->exists ? 'Edit Product' : 'New Product'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal781784ddc1cff9584ff159910cf34f25 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal781784ddc1cff9584ff159910cf34f25 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.common.page-breadcrumb','data' => ['pageTitle' => ''.e($product->exists ? 'Edit Product' : 'New Product').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('common.page-breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pageTitle' => ''.e($product->exists ? 'Edit Product' : 'New Product').'']); ?>
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

<div class="max-w-3xl">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <form method="POST" action="<?php echo e($product->exists ? route('admin.products.update', $product) : route('admin.products.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if($product->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Name</label>
                    <input type="text" name="name" value="<?php echo e(old('name', $product->name)); ?>" required
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-error-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-4">
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Category</label>
                    <select name="category_id" required
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                        <option value="">Select category</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id', $product->category_id) == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-error-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-4">
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Price ($)</label>
                    <input type="number" step="0.01" min="0" name="price" value="<?php echo e(old('price', $product->price)); ?>" required
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                </div>
                <div class="mb-4">
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Original Price ($)</label>
                    <input type="number" step="0.01" min="0" name="original_price" value="<?php echo e(old('original_price', $product->original_price)); ?>"
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                </div>
                <div class="mb-4">
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Stock</label>
                    <input type="number" min="0" name="stock" value="<?php echo e(old('stock', $product->stock)); ?>" required
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Description</label>
                <textarea name="description" rows="5" required
                          class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90"><?php echo e(old('description', $product->description)); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-error-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-4">
                <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Features (one per line)</label>
                <textarea name="features" rows="4"
                          class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90"><?php echo e(old('features', $product->features ? implode("\n", $product->features) : '')); ?></textarea>
                <p class="mt-1 text-theme-xs text-gray-500">Enter each feature on a new line.</p>
                <?php $__errorArgs = ['features'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-error-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex items-center gap-6 mb-4">
                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500" <?php echo e(old('is_featured', $product->is_featured) ? 'checked' : ''); ?>>
                    Featured
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500" <?php echo e(old('is_active', $product->is_active ?? true) ? 'checked' : ''); ?>>
                    Active
                </label>
            </div>

            <div class="mb-4">
                <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Images</label>
                <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp,image/gif"
                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400">
                <p class="mt-1 text-theme-xs text-gray-500">Allowed: JPG, PNG, WebP, GIF. Max 10MB each.</p>
                <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-error-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div id="image-preview" class="flex gap-3 mt-2 flex-wrap"></div>
            </div>

            <?php if($product->exists && $product->images->isNotEmpty()): ?>
            <div class="mb-4">
                <label class="block mb-2 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Current Images</label>
                <div class="flex gap-3 flex-wrap">
                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="relative w-[120px] h-[120px] rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                            <img src="<?php echo e(asset('storage/' . $img->image)); ?>" alt="Product image" class="w-full h-full object-cover">
                            <form method="POST" action="<?php echo e(route('admin.products.images.destroy', [$product, $img])); ?>" class="absolute top-1 right-1">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" onclick="return confirm('Delete this image?')"
                                        class="w-6 h-6 rounded-full border-0 bg-black/60 text-white text-sm cursor-pointer flex items-center justify-center p-0 hover:bg-black/80">×</button>
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600"><?php echo e($product->exists ? 'Update Product' : 'Create Product'); ?></button>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelector('input[name="images[]"]')?.addEventListener('change', function() {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    for (const file of this.files) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'w-[100px] h-[100px] rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-full h-full object-cover';
            div.appendChild(img);
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/admin/products/form.blade.php ENDPATH**/ ?>