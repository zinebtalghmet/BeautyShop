
<?php $__env->startSection('title', $slide->exists ? 'Edit Slide' : 'New Slide'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal781784ddc1cff9584ff159910cf34f25 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal781784ddc1cff9584ff159910cf34f25 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.common.page-breadcrumb','data' => ['pageTitle' => ''.e($slide->exists ? 'Edit Slide' : 'New Slide').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('common.page-breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pageTitle' => ''.e($slide->exists ? 'Edit Slide' : 'New Slide').'']); ?>
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
        <form method="POST" action="<?php echo e($slide->exists ? route('admin.slides.update', $slide) : route('admin.slides.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if($slide->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div class="mb-5">
                <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Title</label>
                <input type="text" name="title" value="<?php echo e(old('title', $slide->title)); ?>" required
                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
            </div>

            <div class="mb-5">
                <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Subtitle</label>
                <textarea name="subtitle" rows="2" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"><?php echo e(old('subtitle', $slide->subtitle)); ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-5">
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Button Text</label>
                    <input type="text" name="button_text" value="<?php echo e(old('button_text', $slide->button_text)); ?>"
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
                </div>
                <div class="mb-5">
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Button Link</label>
                    <input type="text" name="button_link" value="<?php echo e(old('button_link', $slide->button_link)); ?>"
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
                </div>
            </div>

            <div class="mb-5">
                <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Image</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif"
                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400">
                <p class="mt-1 text-theme-xs text-gray-500">Allowed: JPG, PNG, WebP, GIF. Max 10MB.</p>
                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-error-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php if($slide->exists && $slide->image): ?>
                    <div class="mt-2"><img src="<?php echo e(asset('storage/' . $slide->image)); ?>" alt="Current image" class="max-w-[200px] max-h-[120px] rounded-lg border border-gray-200 dark:border-gray-700"></div>
                <?php endif; ?>
                <div id="slide-image-preview" class="mt-2"></div>
            </div>

            <div class="flex items-center gap-4 mb-6">
                <div>
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Sort Order</label>
                    <input type="number" name="sort_order" value="<?php echo e(old('sort_order', $slide->sort_order)); ?>" min="0"
                           class="h-11 w-24 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                </div>
                <div class="pt-6">
                    <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500" <?php echo e(old('is_active', $slide->is_active ?? true) ? 'checked' : ''); ?>>
                        Active
                    </label>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600"><?php echo e($slide->exists ? 'Update' : 'Create'); ?></button>
                <a href="<?php echo e(route('admin.slides.index')); ?>" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelector('input[name="image"]')?.addEventListener('change', function() {
    const preview = document.getElementById('slide-image-preview');
    preview.innerHTML = '';
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'max-w-[200px] max-h-[120px] rounded-lg border border-gray-200 dark:border-gray-700';
            preview.appendChild(img);
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/admin/slides/form.blade.php ENDPATH**/ ?>