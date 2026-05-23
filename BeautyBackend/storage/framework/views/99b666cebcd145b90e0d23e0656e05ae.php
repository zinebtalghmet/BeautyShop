<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>body{font-family:Arial,sans-serif;color:#333;line-height:1.6;margin:0;padding:0}.container{max-width:600px;margin:0 auto;padding:20px}.header{background:#0f172a;color:#fff;padding:20px;text-align:center;border-radius:8px 8px 0 0}.header h1{margin:0;font-size:22px}.content{padding:20px;background:#f9f9f9;border:1px solid #e0e0e0;border-top:none}.footer{padding:15px;text-align:center;font-size:12px;color:#999}table{width:100%;border-collapse:collapse;margin:15px 0}th,td{padding:10px 12px;text-align:left;border-bottom:1px solid #e0e0e0}th{background:#f0f0f0;font-size:13px}.total{font-size:16px;font-weight:700;text-align:right;padding-top:10px}.label{display:inline-block;padding:3px 10px;border-radius:10px;font-size:12px;font-weight:600;background:#fef3c7;color:#92400e}</style></head>
<body>
<div class="container">
    <div class="header"><h1>New Order Received</h1></div>
    <div class="content">
        <p>A new order has been placed.</p>
        <p><strong>Order:</strong> <?php echo e($order->order_number); ?> <span class="label"><?php echo e(ucfirst($order->status)); ?></span></p>
        <p><strong>Customer:</strong> <?php echo e($order->shipping_first_name); ?> <?php echo e($order->shipping_last_name); ?> (<?php echo e($order->shipping_email); ?>)</p>
        <p><strong>Payment:</strong> <?php echo e(strtoupper(str_replace('_', ' ', $order->payment_method))); ?> - <?php echo e(ucfirst($order->payment_status)); ?></p>

        <table>
            <tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->product_name); ?></td>
                <td><?php echo e($item->quantity); ?></td>
                <td>$<?php echo e(number_format($item->product_price, 2)); ?></td>
                <td>$<?php echo e(number_format($item->subtotal, 2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

        <div class="total">
            <p>Total: $<?php echo e(number_format($order->total, 2)); ?></p>
        </div>

        <p><a href="<?php echo e(url('/admin/orders/'.$order->id)); ?>" style="color:#d4a5a5;">View order in admin &rarr;</a></p>
    </div>
    <div class="footer">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.</div>
</div>
</body>
</html>
<?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/emails/new-order-notification.blade.php ENDPATH**/ ?>