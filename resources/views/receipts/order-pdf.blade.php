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
        .qr img { width: 20mm; }
        .codetext { text-align: center; letter-spacing: 4px; font-weight: bold; font-size: 13px; margin-bottom: 4px; }
    </style>
</head>
<body>
    <div class="c b" style="font-size:16px;">LUWENE</div>
    <div class="c">{{ $order->branch->name ?? 'LUWENE Main' }}</div>
    @if(! empty($order->branch->address))
        <div class="c">{{ $order->branch->address }}</div>
    @endif
    <div class="sep"></div>
    <table>
        <tr><td>No. Pesanan</td><td class="r b">#{{ $order->order_number }}</td></tr>
        <tr><td>Tanggal</td><td class="r">{{ $order->created_at->format('d-m-Y H:i') }}</td></tr>
        <tr><td>Pelanggan</td><td class="r">{{ $order->customer_name ?? '-' }}</td></tr>
        <tr><td>Tipe</td><td class="r">{{ $order->order_mode === 'DINE_IN' ? 'Dine In'.($order->table ? ' M'.$order->table->table_number : '') : 'Bawa Pulang' }}</td></tr>
    </table>
    <div class="sep"></div>
    @foreach ($order->items as $item)
        <div>{{ $item->quantity }}x {{ $item->product_name }}{{ $item->variant_name ? ' ('.$item->variant_name.')' : '' }}</div>
        @if($item->modifiers->count() > 0)
            <div style="padding-left:10px;">{{ $item->modifiers->pluck('modifier_name')->implode(', ') }}</div>
        @endif
        <table><tr><td></td><td class="r">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td></tr></table>
    @endforeach
    <div class="sep"></div>
    <table>
        <tr><td>Subtotal</td><td class="r">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td></tr>
        @if((float) $order->discount_amount > 0)
            <tr><td>Diskon</td><td class="r">-Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</td></tr>
        @endif
        <tr><td>PPN ({{ \App\Models\Setting::get('tax_rate', '11') }}%)</td><td class="r">Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</td></tr>
        <tr><td class="b big">TOTAL</td><td class="r b big">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td></tr>
    </table>
    <div class="sep"></div>
    <table>
        <tr><td>Metode</td><td class="r">{{ ($order->payment?->method ?? 'CASH') === 'QRIS' ? 'QRIS' : 'Tunai' }}</td></tr>
        <tr><td>Status</td><td class="r b">{{ $order->payment_status === 'PAID' ? 'LUNAS' : $order->payment_status }}</td></tr>
    </table>
    <div class="barcode">
        <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode pesanan">
    </div>
    <div class="codetext">{{ $order->order_number }}</div>
    @if(! empty($qrCode))
    <div class="qr">
        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Tracking">
    </div>
    <div class="c" style="font-size:9px;">Scan untuk lacak pesanan</div>
    @endif
    <div class="sep"></div>
    <div class="c">{{ \App\Models\Setting::get('receipt_footer', 'Terima kasih!') }}</div>
    <div class="c">Tunjukkan barcode ini ke kasir</div>
</body>
</html>
