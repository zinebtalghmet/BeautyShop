

<?php $__env->startSection('title', 'Order ' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<div style="padding: 24px; max-width: 900px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #0f172a;">Order <?php echo e($order->order_number); ?></h1>
            <p style="color: #64748b; font-size: 14px;">Placed <?php echo e($order->created_at->format('F d, Y \a\t g:i A')); ?></p>
        </div>
        <div style="display: flex; gap: 8px; align-items: center;">
            <a href="<?php echo e(route('admin.orders.invoice', $order)); ?>" target="_blank" style="padding: 8px 16px; background: #f1f5f9; color: #475569; border-radius: 8px; text-decoration: none; font-size: 13px;">Print Invoice</a>
            <form action="<?php echo e(route('admin.orders.destroy', $order)); ?>" method="POST" onsubmit="return confirm('Delete this order?')" style="display: inline;">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" style="padding: 8px 16px; background: #fef2f2; color: #dc2626; border: none; border-radius: 8px; font-size: 13px; cursor: pointer;">Delete</button>
            </form>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div style="background: #f0fdf4; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
        <!-- Status Update -->
        <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 12px;">Status</h3>
            <span style="display: inline-block; padding: 4px 14px; border-radius: 12px; font-size: 13px; font-weight: 600; margin-bottom: 12px;
                <?php echo e($order->status === 'pending' ? 'background: #fef3c7; color: #92400e;' : ''); ?>

                <?php echo e($order->status === 'confirmed' ? 'background: #dbeafe; color: #1e40af;' : ''); ?>

                <?php echo e($order->status === 'processing' ? 'background: #ede9fe; color: #5b21b6;' : ''); ?>

                <?php echo e($order->status === 'shipped' ? 'background: #f0fdf4; color: #166534;' : ''); ?>

                <?php echo e($order->status === 'delivered' ? 'background: #dcfce7; color: #166534;' : ''); ?>

                <?php echo e($order->status === 'cancelled' ? 'background: #fef2f2; color: #dc2626;' : ''); ?>">
                <?php echo e(ucfirst($order->status)); ?>

            </span>
            <?php if(!in_array($order->status, ['delivered', 'cancelled'])): ?>
                <form method="POST" action="<?php echo e(route('admin.orders.status', $order)); ?>" style="display: flex; gap: 8px;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <select name="status" style="flex: 1; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 13px;">
                        <?php $next = ['pending' => ['confirmed', 'cancelled'], 'confirmed' => ['processing', 'cancelled'], 'processing' => ['shipped', 'cancelled'], 'shipped' => ['delivered']]; ?>
                        <?php $__currentLoopData = $next[$order->status] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>"><?php echo e(ucfirst($s)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="submit" style="padding: 8px 16px; background: #0f172a; color: #fff; border: none; border-radius: 6px; font-size: 13px; cursor: pointer;">Update</button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Customer Info -->
        <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 12px;">Customer</h3>
            <p style="font-size: 13px; color: #475569; margin-bottom: 4px;"><strong><?php echo e($order->shipping_first_name); ?> <?php echo e($order->shipping_last_name); ?></strong></p>
            <p style="font-size: 13px; color: #475569; margin-bottom: 4px;"><?php echo e($order->shipping_email); ?></p>
            <?php if($order->shipping_phone): ?> <p style="font-size: 13px; color: #475569; margin-bottom: 4px;"><?php echo e($order->shipping_phone); ?></p> <?php endif; ?>
        </div>

        <!-- Shipping -->
        <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 12px;">Shipping Address</h3>
            <p style="font-size: 13px; color: #475569;"><?php echo e($order->shipping_address); ?><br><?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> <?php echo e($order->shipping_zip); ?><br><?php echo e($order->shipping_country); ?></p>
        </div>

        <!-- Payment -->
        <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 12px;">Payment</h3>
            <p style="font-size: 13px; color: #475569; margin-bottom: 4px;">Method: <strong><?php echo e(strtoupper($order->payment_method)); ?></strong></p>
            <p style="font-size: 13px; color: #475569;">Status: <strong><?php echo e(ucfirst($order->payment_status)); ?></strong></p>
        </div>
    </div>

    <!-- Order Items -->
    <div style="background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden; margin-bottom: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Product</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Price</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Qty</th>
                    <th style="padding: 12px 16px; text-align: right; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 14px 16px; font-size: 14px; color: #0f172a;"><?php echo e($item->product_name); ?></td>
                        <td style="padding: 14px 16px; text-align: center; font-size: 14px; color: #475569;">$<?php echo e(number_format($item->product_price, 2)); ?></td>
                        <td style="padding: 14px 16px; text-align: center; font-size: 14px; color: #475569;"><?php echo e($item->quantity); ?></td>
                        <td style="padding: 14px 16px; text-align: right; font-size: 14px; color: #0f172a;">$<?php echo e(number_format($item->subtotal, 2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); margin-left: auto; width: 320px;">
        <div style="display: flex; justify-content: space-between; font-size: 14px; color: #475569; margin-bottom: 8px;">
            <span>Subtotal</span><span>$<?php echo e(number_format($order->subtotal, 2)); ?></span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 14px; color: #475569; margin-bottom: 8px;">
            <span>Shipping</span><span><?php echo e($order->shipping_cost > 0 ? '$'.number_format($order->shipping_cost, 2) : 'FREE'); ?></span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 14px; color: #475569; margin-bottom: 8px;">
            <span>Tax</span><span>$<?php echo e(number_format($order->tax, 2)); ?></span>
        </div>
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 8px 0;">
        <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: 700; color: #0f172a;">
            <span>Total</span><span>$<?php echo e(number_format($order->total, 2)); ?></span>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>