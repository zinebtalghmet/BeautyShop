<?php
    $currentPath = request()->path();
    $menuGroups = \App\Helpers\MenuHelper::getMenuGroups();
?>

<aside id="sidebar"
    class="fixed flex flex-col mt-0 top-0 px-5 left-0 bg-white dark:bg-gray-900 dark:border-gray-800 text-gray-900 h-screen transition-all duration-300 ease-in-out z-99999 border-r border-gray-200"
    x-data="{
        openSubmenus: {},
        init() { this.initializeActiveMenus(); },
        initializeActiveMenus() {
            const cp = '<?php echo e($currentPath); ?>';
            <?php $__currentLoopData = $menuGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gi => $mg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $mg['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ii => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($item['subItems'])): ?>
                        <?php $__currentLoopData = $item['subItems']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $si): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            if (cp === '<?php echo e(ltrim($si['path'], '/')); ?>' || window.location.pathname === '<?php echo e($si['path']); ?>') { this.openSubmenus['<?php echo e($gi); ?>-<?php echo e($ii); ?>'] = true; }
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        },
        toggleSubmenu(g, i) { const k = g + '-' + i; if (!this.openSubmenus[k]) this.openSubmenus = {}; this.openSubmenus[k] = !this.openSubmenus[k]; },
        isOpen(g, i) { return this.openSubmenus[g + '-' + i] || false; },
        isActive(p) { return window.location.pathname === p || '<?php echo e($currentPath); ?>' === p.replace(/^\//, ''); }
    }"
    :class="{
        'w-[290px]': $store.sidebar.isExpanded || $store.sidebar.isMobileOpen || $store.sidebar.isHovered,
        'w-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
        'translate-x-0': $store.sidebar.isMobileOpen,
        '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
    }"
    @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
    @mouseleave="$store.sidebar.setHovered(false)">

    <div class="pt-8 pb-7 flex"
        :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'xl:justify-center' : 'justify-start'">
        <a href="/" class="flex items-center gap-2">
            <span class="text-2xl font-bold text-brand-500">B</span>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="text-xl font-bold text-gray-900 dark:text-white">Beauty<span class="text-brand-500">·</span></span>
        </a>
    </div>

    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <nav class="mb-6">
            <div class="flex flex-col gap-4">
                <?php $__currentLoopData = $menuGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gi => $mg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <h2 class="mb-4 text-xs uppercase flex leading-[20px] text-gray-400"
                        :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'lg:justify-center' : 'justify-start'">
                        <template x-if="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"><span><?php echo e($mg['title']); ?></span></template>
                        <template x-if="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451Z" fill="currentColor"/></svg>
                        </template>
                    </h2>
                    <ul class="flex flex-col gap-1">
                        <?php $__currentLoopData = $mg['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ii => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <?php if(isset($item['subItems'])): ?>
                            <button @click="toggleSubmenu(<?php echo e($gi); ?>, <?php echo e($ii); ?>)"
                                class="menu-item group w-full"
                                :class="[isOpen(<?php echo e($gi); ?>, <?php echo e($ii); ?>) ? 'menu-item-active' : 'menu-item-inactive', !$store.sidebar.isExpanded && !$store.sidebar.isHovered ? 'xl:justify-center' : 'xl:justify-start']">
                                <span :class="isOpen(<?php echo e($gi); ?>, <?php echo e($ii); ?>) ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"><?php echo \App\Helpers\MenuHelper::getIconSvg($item['icon']); ?></span>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="menu-item-text flex items-center gap-2"><?php echo e($item['name']); ?></span>
                                <svg x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ml-auto w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180 text-brand-500': isOpen(<?php echo e($gi); ?>, <?php echo e($ii); ?>) }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="isOpen(<?php echo e($gi); ?>, <?php echo e($ii); ?>) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)">
                                <ul class="mt-2 space-y-1 ml-9">
                                    <?php $__currentLoopData = $item['subItems']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $si): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e($si['path']); ?>" class="menu-dropdown-item" :class="isActive('<?php echo e($si['path']); ?>') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"><?php echo e($si['name']); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <?php else: ?>
                            <a href="<?php echo e($item['path']); ?>" class="menu-item group"
                                :class="[isActive('<?php echo e($item['path']); ?>') ? 'menu-item-active' : 'menu-item-inactive', (!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'xl:justify-center' : 'justify-start']">
                                <span :class="isActive('<?php echo e($item['path']); ?>') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"><?php echo \App\Helpers\MenuHelper::getIconSvg($item['icon']); ?></span>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="menu-item-text flex items-center gap-2"><?php echo e($item['name']); ?></span>
                            </a>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </nav>
    </div>
</aside>
<?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>