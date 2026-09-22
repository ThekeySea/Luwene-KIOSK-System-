<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #000; margin: 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 1px 0; vertical-align: top; }
        .r { text-align: right; }
        .b { font-weight: bold; }
        .c { text-align: center; }
        .big { font-size: 15px; }
        .sep { border-top: 1px dashed #000; margin: 6px 0; }
        .barcode { text-align: center; margin: 8px 0 2px; }
        .barcode img { width: 62mm; }
        .qr { text-align: center; margin: 6px 0 2px; }
        .qr svg { width: 20mm; }
        .codetext { text-align: center; letter-spacing: 4px; font-weight: bold; font-size: 13px; margin-bottom: 4px; }
        .delivery-box { background: #f5f5f5; padding: 4px 6px; border-radius: 3px; margin: 4px 0; }
    </style>
</head>
<body>
    <div class="c b" style="font-size:16px;">LUWENE</div>
    <div class="c"><?php echo e($order->branch->name ?? 'LUWENE Main'); ?></div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($order->branch->address)): ?>
        <div class="c"><?php echo e($order->branch->address); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="sep"></div>
    <table>
        <tr><td>No. Pesanan</td><td class="r b">#<?php echo e($order->order_number); ?></td></tr>
        <tr><td>Tanggal</td><td class="r"><?php echo e($order->created_at->format('d-m-Y H:i')); ?></td></tr>
        <tr><td>Pelanggan</td><td class="r"><?php echo e($order->customer_name ?? '-'); ?></td></tr>
        <tr>
            <td>Tipe</td>
            <td class="r">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->order_mode === 'DINE_IN'): ?>
                    Dine In<?php echo e($order->table ? ' M'.$order->table->table_number : ''); ?>

                <?php elseif($order->order_mode === 'DELIVERY'): ?>
                    Delivery
                <?php else: ?>
                    Bawa Pulang
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </td>
        </tr>
    </table>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->order_mode === 'DELIVERY'): ?>
        <div class="delivery-box">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($order->delivery_address)): ?>
                <div><b>Alamat:</b> <?php echo e($order->delivery_address); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->delivery_fee > 0): ?>
                <div><b>Ongkir:</b> Rp <?php echo e(number_format($order->delivery_fee, 0, ',', '.')); ?></div>
            <?php else: ?>
                <div><b>Ongkir:</b> Gratis</div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->driver_name): ?>
                <div><b>Driver:</b> <?php echo e($order->driver_name); ?><?php echo e($order->driver_phone ? ' ('.$order->driver_phone.')' : ''); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->delivery_estimated_at): ?>
                <div><b>Estimasi:</b> <?php echo e($order->delivery_estimated_at->format('H:i')); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($order->delivery_notes)): ?>
                <div><b>Catatan:</b> <?php echo e($order->delivery_notes); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="sep"></div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div><?php echo e($item->quantity); ?>x <?php echo e($item->product_name); ?><?php echo e($item->variant_name ? ' ('.$item->variant_name.')' : ''); ?></div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->modifiers->count() > 0): ?>
            <div style="padding-left:10px;"><?php echo e($item->modifiers->pluck('modifier_name')->implode(', ')); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <table><tr><td></td><td class="r">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></td></tr></table>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    <div class="sep"></div>
    <table>
        <tr><td>Subtotal</td><td class="r">Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></td></tr>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((float) $order->discount_amount > 0): ?>
            <tr><td>Diskon</td><td class="r">-Rp <?php echo e(number_format($order->discount_amount, 0, ',', '.')); ?></td></tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->order_mode === 'DELIVERY' && $order->delivery_fee > 0): ?>
            <tr><td>Ongkir</td><td class="r">Rp <?php echo e(number_format($order->delivery_fee, 0, ',', '.')); ?></td></tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((float) $order->tax_amount > 0): ?>
            <tr><td>PPN (<?php echo e(\App\Models\Setting::get('tax_rate', '11')); ?>%)</td><td class="r">Rp <?php echo e(number_format($order->tax_amount, 0, ',', '.')); ?></td></tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <tr><td class="b big">TOTAL</td><td class="r b big">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></td></tr>
    </table>
    <div class="sep"></div>
    <table>
        <tr><td>Metode</td><td class="r"><?php echo e(($order->payment?->method ?? 'CASH') === 'QRIS' ? 'QRIS' : ($order->order_mode === 'DELIVERY' && ($order->payment?->method ?? 'COD') === 'COD' ? 'COD' : 'Tunai')); ?></td></tr>
        <tr><td>Status</td><td class="r b"><?php echo e($order->payment_status === 'PAID' ? 'LUNAS' : $order->payment_status); ?></td></tr>
    </table>
    <div class="barcode">
        <img src="data:image/png;base64,<?php echo e($barcode); ?>" alt="Barcode pesanan">
    </div>
    <div class="codetext"><?php echo e($order->order_number); ?></div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($qrCode)): ?>
    <div class="qr">
        <?php echo $qrCode; ?>

    </div>
    <div class="c" style="font-size:9px;">Scan untuk lacak pesanan</div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="sep"></div>
    <div class="c"><?php echo e(\App\Models\Setting::get('receipt_footer', 'Terima kasih!')); ?></div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->order_mode === 'DELIVERY'): ?>
        <div class="c" style="font-size:9px;">Pesanan akan diantar ke alamat tujuan</div>
    <?php else: ?>
        <div class="c">Tunjukkan barcode ini ke kasir</div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</body>
</html>
<?php /**PATH C:\laragon\www\Luwene\resources\views/receipts/order-pdf.blade.php ENDPATH**/ ?>