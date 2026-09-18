<?php
$w = 32;
$hr = str_repeat('=', $w);
$sep = str_repeat('-', $w);
$rp = fn($n) => 'Rp '.number_format((float) $n, 0, ',', '.');
$pair = function ($left, $right) use ($w) {
    $left = mb_substr((string) $left, 0, $w);
    $right = (string) $right;
    $gap = $w - mb_strlen($left) - mb_strlen($right);
    return $left.($gap > 0 ? str_repeat(' ', $gap) : ' ').$right;
};
$center = function ($t) use ($w) {
    $t = mb_substr((string) $t, 0, $w);
    $pad = max(0, $w - mb_strlen($t));
    $left = intdiv($pad, 2);
    return str_repeat(' ', $left).$t.str_repeat(' ', $pad - $left);
};

$out = [];
$out[] = $hr;
$out[] = $center('LUWENE');
$out[] = $center($order->branch->name ?? 'LUWENE Main');
if (! empty($order->branch->address)) {
    $out[] = $center($order->branch->address);
}
$out[] = $sep;
$out[] = $pair('No. Pesanan', '#'.$order->order_number);
$out[] = $pair('Tanggal', $order->created_at->format('d-m-Y H:i'));
$out[] = $pair('Pelanggan', $order->customer_name ?? '-');
$out[] = $pair('Tipe', $order->order_mode === 'DINE_IN'
    ? 'Dine In'.($order->table ? ' M'.$order->table->table_number : '')
    : 'Bawa Pulang');
$out[] = $sep;
foreach ($order->items as $item) {
    $out[] = mb_substr($item->quantity.'x '.$item->product_name.($item->variant_name ? ' ('.$item->variant_name.')' : ''), 0, $w);
    if ($item->modifiers->count() > 0) {
        $out[] = mb_substr('   '.implode(', ', $item->modifiers->pluck('modifier_name')->all()), 0, $w);
    }
    $out[] = $pair('', $rp($item->subtotal));
}
$out[] = $sep;
$out[] = $pair('Subtotal', $rp($order->subtotal));
if ((float) $order->discount_amount > 0) {
    $out[] = $pair('Diskon', '-'.$rp($order->discount_amount));
}
$out[] = $pair('PPN (11%)', $rp($order->tax_amount));
$out[] = $pair('TOTAL', $rp($order->total_amount));
$out[] = $sep;
$out[] = $pair('Metode', ($order->payment?->method ?? 'CASH') === 'QRIS' ? 'QRIS' : 'Tunai');
$out[] = $pair('Status', $order->payment_status === 'PAID' ? 'LUNAS' : $order->payment_status);
$out[] = $sep;
$out[] = $center('Terima kasih!');
$out[] = $center('Tunjukkan nomor ini ke kasir');
$out[] = $hr;
echo implode(PHP_EOL, $out).PHP_EOL;
?><?php /**PATH C:\laragon\www\Luwene\resources\views/receipts/order-plain.blade.php ENDPATH**/ ?>