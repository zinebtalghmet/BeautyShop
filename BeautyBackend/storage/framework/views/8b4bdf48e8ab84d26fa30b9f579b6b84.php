<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>body{font-family:Arial,sans-serif;color:#333;line-height:1.6;margin:0;padding:0}.container{max-width:600px;margin:0 auto;padding:20px}.header{background:#d4a5a5;color:#fff;padding:20px;text-align:center;border-radius:8px 8px 0 0}.header h1{margin:0;font-size:22px}.content{padding:20px;background:#f9f9f9;border:1px solid #e0e0e0;border-top:none}.footer{padding:15px;text-align:center;font-size:12px;color:#999}table{width:100%;border-collapse:collapse;margin:15px 0}th,td{padding:10px 12px;text-align:left;border-bottom:1px solid #e0e0e0}th{background:#f0f0f0;font-size:13px}.status-badge{display:inline-block;padding:5px 15px;border-radius:12px;font-size:14px;font-weight:700}.status-pending{background:#fef3c7;color:#92400e}.status-confirmed{background:#dbeafe;color:#1e40af}.status-processing{background:#ede9fe;color:#5b21b6}.status-shipped{background:#f0fdf4;color:#166534}.status-delivered{background:#dcfce7;color:#166534}.status-cancelled{background:#fef2f2;color:#dc2626}</style></head>
<body>
<div class="container">
    <div class="header">
        <?php if($order->status === 'delivered'): ?>
            <h1>Your Order Has Arrived!</h1>
        <?php elseif($order->status === 'cancelled'): ?>
            <h1>Order Cancelled</h1>
        <?php elseif($order->status === 'shipped'): ?>
            <h1>Your Order Is On Its Way!</h1>
        <?php else: ?>
            <h1>Order Status Update</h1>
        <?php endif; ?>
    </div>
    <div class="content">
        <p>Hi <strong><?php echo e($order->shipping_first_name); ?></strong>,</p>

        <?php if($order->status === 'delivered'): ?>
            <p>Your order <strong><?php echo e($order->order_number); ?></strong> has been delivered. We hope you love your products!</p>
            <p>Thank you for shopping with us. If you have any feedback, we'd love to hear from you.</p>
        <?php elseif($order->status === 'cancelled'): ?>
            <p>Your order <strong><?php echo e($order->order_number); ?></strong> has been cancelled.</p>
            <?php if($order->cancelled_reason): ?>
                <p>Reason: <?php echo e($order->cancelled_reason); ?></p>
            <?php endif; ?>
            <p>If you have any questions, please contact our support team.</p>
        <?php elseif($order->status === 'shipped'): ?>
            <p>Your order <strong><?php echo e($order->order_number); ?></strong> has been shipped and is on its way!</p>
        <?php else: ?>
            <p>Your order <strong><?php echo e($order->order_number); ?></strong> status has been updated.</p>
        <?php endif; ?>

        <p style="text-align:center;margin:20px 0;">
            <span class="status-badge status-<?php echo e($order->status); ?>"><?php echo e(ucfirst($order->status)); ?></span>
        </p>

        <table>
            <tr><th>Product</th><th>Qty</th><th>Price</th></tr>
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->product_name); ?></td>
                <td><?php echo e($item->quantity); ?></td>
                <td>$<?php echo e(number_format($item->product_price, 2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

        <p style="font-size:13px;color:#999;">Thank you for choosing <?php echo e(config('app.name')); ?>!</p>
    </div>
    <div class="footer">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.</div>
</div>
</body>
</html>
<?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/emails/order-status-update.blade.php ENDPATH**/ ?>