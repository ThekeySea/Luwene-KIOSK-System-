<div>
<div class="flex gap-2 mb-6">
    @foreach (['today' => 'Hari Ini', 'week' => '7 Hari', 'month' => '30 Hari'] as $value => $label)
        <button wire:click="setPreset('{{ $value }}')" class="px-4 py-2 rounded-lg text-xs font-semibold transition {{ $preset === $value ? 'bg-primary text-white' : 'bg-white border border-gray-200 text-gray-600 hover:text-gray-900' }}">{{ $label }}</button>
    @endforeach
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Pendapatan</p>
        <p class="text-xl font-display font-bold text-primary mt-1">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Order</p>
        <p class="text-xl font-display font-bold text-gray-900 mt-1">{{ number_format($orderCount) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Terbayar</p>
        <p class="text-xl font-display font-bold text-gray-900 mt-1">{{ number_format($paidCount) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Rata-rata / Order</p>
        <p class="text-xl font-display font-bold text-gray-900 mt-1">Rp {{ number_format($average, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
    <h2 class="font-display font-bold text-gray-900 mb-4">Pendapatan per {{ $preset === 'today' ? 'Jam' : 'Hari' }}</h2>
    <div style="height: 280px;">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h2 class="font-display font-bold text-gray-900 mb-4">Tipe Order</h2>
        <div style="height: 220px;">
            <canvas id="modeChart"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h2 class="font-display font-bold text-gray-900 mb-4">Metode Bayar</h2>
        <div style="height: 220px;">
            <canvas id="paymentChart"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <h2 class="font-display font-bold text-gray-900 mb-4">Status Order</h2>
        <div style="height: 220px;">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
    <h2 class="font-display font-bold text-gray-900 mb-4">Top 5 Produk Terlaris</h2>
    <div style="height: {{ count($chartData['topProducts']['labels']) > 0 ? count($chartData['topProducts']['labels']) * 60 + 40 : 100 }}px;">
        <canvas id="topProductsChart"></canvas>
    </div>
</div>

@if($byPayment->isNotEmpty())
<div class="bg-white rounded-xl border border-gray-200 p-5">
    <h2 class="font-display font-bold text-gray-900 mb-4">Detail Metode Bayar</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left py-2.5 text-xs font-semibold text-gray-500 uppercase">Metode</th>
                    <th class="text-right py-2.5 text-xs font-semibold text-gray-500 uppercase">Transaksi</th>
                    <th class="text-right py-2.5 text-xs font-semibold text-gray-500 uppercase">Pendapatan</th>
                    <th class="text-right py-2.5 text-xs font-semibold text-gray-500 uppercase">% dari Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($byPayment as $row)
                    <tr class="border-b border-gray-50 last:border-0">
                        <td class="py-2.5 font-medium text-gray-900">{{ $row->method }}</td>
                        <td class="py-2.5 text-right text-gray-600">{{ $row->total }}x</td>
                        <td class="py-2.5 text-right text-gray-900 font-medium">Rp {{ number_format($row->revenue, 0, ',', '.') }}</td>
                        <td class="py-2.5 text-right text-gray-500">{{ $revenue > 0 ? round($row->revenue / $revenue * 100, 1) : 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ═══ CHART DATA (stored in DOM, updated by Livewire morph) ═══ --}}
<div id="rd" data-d="{{ json_encode($chartData, JSON_HEX_TAG | JSON_HEX_AMP) }}" style="display:none"></div>
<div id="sc" data-d="{{ json_encode(['PENDING'=>'#F59E0B','CONFIRMED'=>'#3B82F6','PREPARING'=>'#8B5CF6','READY'=>'#10B981','COMPLETED'=>'#059669','CANCELLED'=>'#EF4444','SERVED'=>'#06B6D4'], JSON_HEX_TAG | JSON_HEX_AMP) }}" style="display:none"></div>

<script>
(function() {
    var _charts = {};

    function destroyAll() {
        for (var k in _charts) { if (_charts[k]) { _charts[k].destroy(); _charts[k] = null; } }
    }

    function readData() {
        var el = document.getElementById('rd');
        if (!el) return null;
        try { return JSON.parse(el.getAttribute('data-d')); } catch(e) { return null; }
    }

    function readColors() {
        var el = document.getElementById('sc');
        if (!el) return {};
        try { return JSON.parse(el.getAttribute('data-d')); } catch(e) { return {}; }
    }

    function build() {
        if (typeof Chart === 'undefined') return;
        var d = readData();
        if (!d) return;
        var sc = readColors();
        var fd = "'Inter', system-ui, sans-serif";
        var gc = 'rgba(0,0,0,0.05)';
        var tc = '#9CA3AF';
        Chart.defaults.font.family = fd;
        Chart.defaults.font.size = 12;
        Chart.defaults.color = tc;

        destroyAll();

        // Revenue Bar
        var rc = document.getElementById('revenueChart');
        if (rc) {
            _charts.revenue = new Chart(rc, {
                type: 'bar',
                data: {
                    labels: d.revenueTimeSeries.labels,
                    datasets: [{
                        label: 'Pendapatan', data: d.revenueTimeSeries.data,
                        backgroundColor: 'rgba(138,0,0,0.8)', hoverBackgroundColor: 'rgba(138,0,0,1)',
                        borderRadius: 6, borderSkipped: false, maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: '#1F2937', titleColor: '#F9FAFB', bodyColor: '#D1D5DB', padding: 12, cornerRadius: 8,
                            callbacks: { label: function(c) { return 'Rp ' + c.parsed.y.toLocaleString('id-ID'); } } }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: tc, maxRotation: 0 } },
                        y: { grid: { color: gc }, ticks: { color: tc, callback: function(v) { return v >= 1e6 ? (v/1e6).toFixed(0)+'jt' : v >= 1e3 ? (v/1e3).toFixed(0)+'rb' : v; } }, beginAtZero: true }
                    }
                }
            });
        }

        // Mode Doughnut
        var mc = document.getElementById('modeChart');
        if (mc && d.byMode.labels.length) {
            _charts.mode = new Chart(mc, {
                type: 'doughnut',
                data: { labels: d.byMode.labels, datasets: [{ data: d.byMode.data, backgroundColor: ['#F56A47', '#8A0000'], hoverOffset: 6, borderWidth: 0 }] },
                options: { responsive: true, maintainAspectRatio: false, cutout: '65%',
                    plugins: { legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true, pointStyleWidth: 10, font: { size: 11 } } },
                        tooltip: { backgroundColor: '#1F2937', titleColor: '#F9FAFB', bodyColor: '#D1D5DB', padding: 12, cornerRadius: 8 } } }
            });
        }

        // Payment Doughnut
        var pc = document.getElementById('paymentChart');
        if (pc && d.byPayment.labels.length) {
            var pC = ['#8A0000', '#F56A47', '#3B82F6', '#10B981', '#6B7280'];
            _charts.payment = new Chart(pc, {
                type: 'doughnut',
                data: { labels: d.byPayment.labels, datasets: [{ data: d.byPayment.data, backgroundColor: pC.slice(0, d.byPayment.labels.length), hoverOffset: 6, borderWidth: 0 }] },
                options: { responsive: true, maintainAspectRatio: false, cutout: '65%',
                    plugins: { legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true, pointStyleWidth: 10, font: { size: 11 } } },
                        tooltip: { backgroundColor: '#1F2937', titleColor: '#F9FAFB', bodyColor: '#D1D5DB', padding: 12, cornerRadius: 8,
                            callbacks: { label: function(c) { var r = d.byPayment.revenue[c.dataIndex] || 0; return c.label + ': ' + c.parsed + 'x (Rp ' + r.toLocaleString('id-ID') + ')'; } } } } }
            });
        }

        // Status Doughnut
        var stc = document.getElementById('statusChart');
        if (stc && d.byStatus.labels.length) {
            var sC = d.byStatus.labels.map(function(s) { return sc[s] || '#9CA3AF'; });
            _charts.status = new Chart(stc, {
                type: 'doughnut',
                data: { labels: d.byStatus.labels, datasets: [{ data: d.byStatus.data, backgroundColor: sC, hoverOffset: 6, borderWidth: 0 }] },
                options: { responsive: true, maintainAspectRatio: false, cutout: '65%',
                    plugins: { legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true, pointStyleWidth: 10, font: { size: 11 } } },
                        tooltip: { backgroundColor: '#1F2937', titleColor: '#F9FAFB', bodyColor: '#D1D5DB', padding: 12, cornerRadius: 8 } } }
            });
        }

        // Top Products Horizontal Bar
        var tpc = document.getElementById('topProductsChart');
        if (tpc && d.topProducts.labels.length) {
            _charts.top = new Chart(tpc, {
                type: 'bar',
                data: { labels: d.topProducts.labels, datasets: [{
                    label: 'Terjual', data: d.topProducts.qty,
                    backgroundColor: ['rgba(138,0,0,0.9)', 'rgba(138,0,0,0.7)', 'rgba(138,0,0,0.55)', 'rgba(138,0,0,0.4)', 'rgba(138,0,0,0.28)'],
                    borderRadius: 6, borderSkipped: false, maxBarThickness: 36
                }] },
                options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false },
                        tooltip: { backgroundColor: '#1F2937', titleColor: '#F9FAFB', bodyColor: '#D1D5DB', padding: 12, cornerRadius: 8,
                            callbacks: { label: function(c) { var r = d.topProducts.revenue[c.dataIndex] || 0; return c.parsed.x + ' terjual · Rp ' + r.toLocaleString('id-ID'); } } } },
                    scales: { x: { grid: { color: gc }, ticks: { color: tc, stepSize: 1 }, beginAtZero: true },
                        y: { grid: { display: false }, ticks: { color: '#374151', font: { weight: '600', size: 12 } } } } }
            });
        }
    }

    // ── Wait for Chart.js then build ──
    function waitAndBuild() {
        if (typeof Chart !== 'undefined') { build(); return; }
        var attempts = 0;
        var timer = setInterval(function() {
            attempts++;
            if (typeof Chart !== 'undefined') { clearInterval(timer); build(); }
            if (attempts > 100) clearInterval(timer); // 10s max
        }, 100);
    }

    // ── MutationObserver: rebuild when Livewire morphs the data node ──
    function observeChanges() {
        var node = document.getElementById('rd');
        if (!node) return;
        var observer = new MutationObserver(function() {
            if (typeof Chart !== 'undefined') { destroyAll(); build(); }
        });
        observer.observe(node, { attributes: true, attributeFilter: ['data-d'] });
    }

    // ── Init ──
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() { waitAndBuild(); observeChanges(); });
    } else {
        waitAndBuild();
        observeChanges();
    }
})();
</script>
</div>
