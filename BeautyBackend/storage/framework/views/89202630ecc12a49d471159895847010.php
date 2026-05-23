<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>body{font-family:Arial,sans-serif;color:#333;line-height:1.6;margin:0;padding:0}.container{max-width:600px;margin:0 auto;padding:20px}.header{background:#d4a5a5;color:#fff;padding:20px;text-align:center;border-radius:8px 8px 0 0}.header h1{margin:0;font-size:22px}.content{padding:20px;background:#f9f9f9;border:1px solid #e0e0e0;border-top:none}.footer{padding:15px;text-align:center;font-size:12px;color:#999}table{width:100%;border-collapse:collapse;margin:15px 0}th,td{padding:10px 12px;text-align:left;border-bottom:1px solid #e0e0e0}th{background:#f0f0f0;font-size:13px}.total{font-size:16px;font-weight:700;text-align:right;padding-top:10px}.btn{display:inline-block;padding:10px 20px;background:#d4a5a5;color:#fff;text-decoration:none;border-radius:5px;margin-top:15px}</style></head>
<body>
<div class="container">
    <div class="header"><h1>Thank You for Your Order!</h1></div>
    <div class="content">
        <p>Hi <strong><?php echo e($order->shipping_first_name); ?></strong>,</p>
        <p>Your order <strong><?php echo e($order->order_number); ?></strong> has been placed successfully.</p>

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
            <p>Subtotal: $<?php echo e(number_format($order->subtotal, 2)); ?></p>
            <p>Shipping: <?php echo e($order->shipping_cost > 0 ? '$'.number_format($order->shipping_cost, 2) : 'FREE'); ?></p>
            <p>Tax: $<?php echo e(number_format($order->tax, 2)); ?></p>
            <p style="font-size:20px;">Total: $<?php echo e(number_format($order->total, 2)); ?></p>
        </div>

        <p><strong>Shipping to:</strong><br>
        <?php echo e($order->shipping_address); ?><br>
        <?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> <?php echo e($order->shipping_zip); ?><br>
        <?php echo e($order->shipping_country); ?></p>

        <p>Payment method: <strong><?php echo e(strtoupper(str_replace('_', ' ', $order->payment_method))); ?></strong></p>
        <p>Payment status: <strong><?php echo e(ucfirst($order->payment_status)); ?></strong></p>

        <p>We'll notify you when your order status changes. You can track your order anytime.</p>
        <p style="font-size:13px;color:#999;">If you have any questions, reply to this email or contact our support.</p>
    </div>
    <div class="footer">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.</div>
</div>
</body>
</html>
<?php /**PATH C:\Users\jdira\Herd\beautyshop\BeautyBackend\resources\views/emails/order-confirmation.blade.php ENDPATH**/ ?>