<?php $__env->startSection('title', 'Notifications'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal781784ddc1cff9584ff159910cf34f25 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal781784ddc1cff9584ff159910cf34f25 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.common.page-breadcrumb','data' => ['pageTitle' => 'Notifications']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('common.page-breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pageTitle' => 'Notifications']); ?>
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
    <form method="POST" action="<?php echo e(route('admin.notifications.read-all')); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800 dark:bg-white/[0.08] dark:hover:bg-white/[0.12]">
            Mark All as Read
        </button>
    </form>
</div>

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-800">
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Message</th>
                    <th class="px-4 py-3 text-right text-theme-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/5 <?php echo e(!$n->is_read ? 'bg-gray-50 dark:bg-white/[0.02]' : ''); ?>">
                        <td class="px-4 py-3.5">
                            <?php if($n->is_read): ?>
                                <span class="inline-block w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                            <?php else: ?>
                                <span class="inline-block w-2 h-2 rounded-full bg-brand-500"></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400">
                            <?php switch($n->type):
                                case ('new_order'): ?> <span class="text-orange-500">📦 Order</span> <?php break; ?>
                                <?php case ('new_contact'): ?> <span class="text-blue-500">✉️ Contact</span> <?php break; ?>
                                <?php case ('new_review'): ?> <span class="text-purple-500">⭐ Review</span> <?php break; ?>
                                <?php default: ?> <span><?php echo e($n->type); ?></span>
                            <?php endswitch; ?>
                        </td>
                        <td class="px-4 py-3.5 text-sm font-medium <?php echo e($n->is_read ? 'text-gray-600 dark:text-gray-400' : 'text-gray-800 dark:text-white/90'); ?>">
                            <?php if($n->link): ?>
                                <a href="<?php echo e($n->link); ?>" class="hover:text-brand-500"><?php echo e($n->title); ?></a>
                            <?php else: ?>
                                <?php echo e($n->title); ?>

                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate"><?php echo e($n->message); ?></td>
                        <td class="px-4 py-3.5 text-sm text-right text-gray-500 dark:text-gray-400"><?php echo e($n->created_at->diffForHumans()); ?></td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            <?php if(!$n->is_read): ?>
                                <form method="POST" action="<?php echo e(route('admin.notifications.read', $n)); ?>" class="inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                    <button type="submit" class="text-brand-500 hover:text-brand-600 text-xs font-medium">Mark Read</button>
                                </form>
                            <?php else: ?>
                                <span class="text-gray-400 text-xs">Read</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="px-4 py-10 text-center text-sm text-gray-400">No notifications yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4"><?php echo e($notifications->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/admin/notifications/index.blade.php ENDPATH**/ ?>