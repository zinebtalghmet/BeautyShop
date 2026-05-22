<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — BeautyShop</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>
<body class="bg-gray-50 dark:bg-gray-900 flex items-center justify-center min-h-screen p-4 font-sans antialiased">
    <div class="w-full max-w-[420px] rounded-2xl border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-800 dark:bg-white/[0.03] sm:p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90 tracking-tight">BEAUTY<span class="text-brand-500">·</span></h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Admin Panel</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="mb-5 rounded-lg bg-error-50 p-4 text-sm text-error-700 dark:bg-error-500/15 dark:text-error-500">
                <ul class="list-disc pl-4 space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.login.post')); ?>">
            <?php echo csrf_field(); ?>
            <div class="space-y-5">
                <div>
                    <label for="email" class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required autofocus
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                </div>
                <div>
                    <label for="password" class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Password</label>
                    <input type="password" name="password" id="password" required
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                    Remember me
                </label>
                <button type="submit" class="w-full rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">Sign In</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>