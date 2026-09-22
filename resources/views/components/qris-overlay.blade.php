<div
    x-data="qrisOverlay()"
    x-on:show-qris.window="open($event.detail)"
    x-show="show"
    class="fixed inset-0 z-[200] flex items-center justify-center p-4"
    x-cloak
>
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"></div>

    {{-- Modal --}}
    <div
        class="relative bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
    >
        {{-- Close Button --}}
        <button
            @click="confirmBypass()"
            class="absolute top-4 right-4 z-10 w-8 h-8 flex items-center justify-center rounded-full bg-warm-100 text-warm-500 hover:bg-red-100 hover:text-red-500 transition"
            title="Lewati Pembayaran"
        >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Header --}}
        <div class="px-6 pt-6 pb-2 text-center">
            <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                </svg>
            </div>
            <h2 class="text-lg font-bold text-dark">Scan QRIS untuk Bayar</h2>
            <p class="text-sm text-warm-400 mt-1">Gunakan aplikasi mobile banking atau e-wallet</p>
        </div>

        {{-- QR Code --}}
        <div class="px-6 py-4 flex justify-center">
            <div class="bg-white p-3 rounded-2xl border-2 border-warm-100 shadow-sm">
                <img
                    x-show="qrImageUrl"
                    :src="qrImageUrl"
                    alt="QRIS Code"
                    class="w-48 h-48"
                >
                <div x-show="!qrImageUrl" class="w-48 h-48 flex items-center justify-center bg-warm-50 rounded-xl">
                    <div class="text-center">
                        <svg class="animate-spin h-8 w-8 text-primary mx-auto mb-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <p class="text-xs text-warm-400">Memuat QR...</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Countdown --}}
        <div class="px-6 pb-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-warm-500">Sisa waktu</span>
                <span class="text-sm font-bold" :class="timeLeft <= 15 ? 'text-red-500' : 'text-dark'" x-text="formatTime(timeLeft)"></span>
            </div>
            <div class="w-full h-2 bg-warm-100 rounded-full overflow-hidden">
                <div
                    class="h-full rounded-full transition-all duration-1000 ease-linear"
                    :class="timeLeft <= 15 ? 'bg-red-500' : 'bg-primary'"
                    :style="`width: ${(timeLeft / 60) * 100}%`"
                ></div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-warm-100 mx-6"></div>

        {{-- Transaction Info --}}
        <div class="px-6 py-4 space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-warm-400">Pesanan</span>
                <span class="font-bold text-dark" x-text="orderNumber"></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-warm-400">Atas nama</span>
                <span class="font-medium text-dark" x-text="customerName"></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-warm-400">Waktu</span>
                <span class="font-medium text-dark" x-text="orderTime"></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-warm-400">Tipe</span>
                <span class="font-medium text-dark" x-text="formatOrderMode(orderMode)"></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-warm-400">Pemesanan</span>
                <span class="font-medium text-dark text-right max-w-[60%] truncate" x-text="formatItems(items)"></span>
            </div>
            <div class="flex justify-between text-lg font-bold pt-2 border-t border-warm-100">
                <span class="text-dark">Total</span>
                <span class="text-primary" x-text="'Rp ' + Number(total).toLocaleString('id-ID')"></span>
            </div>
        </div>

        {{-- Status Message --}}
        <div x-show="statusMessage" class="px-6 pb-4">
            <div class="p-3 rounded-xl text-sm font-medium text-center"
                :class="{
                    'bg-green-50 text-green-600': statusType === 'success',
                    'bg-red-50 text-red-600': statusType === 'error',
                    'bg-yellow-50 text-yellow-600': statusType === 'warning',
                }"
                x-text="statusMessage"
            ></div>
        </div>
    </div>

    {{-- Bypass Confirmation --}}
    <div
        x-show="showBypassConfirm"
        class="fixed inset-0 z-[210] flex items-center justify-center p-4"
    >
        <div class="absolute inset-0 bg-black/50" @click="showBypassConfirm = false"></div>
        <div class="relative bg-white rounded-2xl p-6 w-full max-w-xs shadow-xl z-10">
            <div class="text-center mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-dark">Lewati Pembayaran?</h3>
                <p class="text-sm text-warm-500 mt-1">Pesanan akan ditandai sebagai sudah dibayar tanpa verifikasi Midtrans.</p>
            </div>
            <div class="flex gap-2">
                <button @click="showBypassConfirm = false" class="flex-1 py-2.5 border border-warm-200 text-warm-600 text-sm font-semibold rounded-xl hover:bg-warm-50 transition">Batal</button>
                <button @click="doBypass()" :disabled="bypassLoading" class="flex-1 py-2.5 bg-yellow-500 text-white text-sm font-bold rounded-xl hover:bg-yellow-600 transition disabled:opacity-50">
                    <span x-show="!bypassLoading">Ya, Lewati</span>
                    <span x-show="bypassLoading" class="flex items-center justify-center gap-1">
                        <svg class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Memproses...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function qrisOverlay() {
    return {
        show: false,
        showBypassConfirm: false,
        bypassLoading: false,
        timeLeft: 60,
        statusMessage: '',
        statusType: '',
        qrImageUrl: '',
        qrString: '',
        orderId: '',
        orderNumber: '',
        customerName: '',
        orderTime: '',
        orderMode: '',
        items: [],
        total: 0,
        bypassUrl: '',
        timeoutUrl: '',
        statusUrl: '',
        successUrl: '',
        pollInterval: null,
        countdownInterval: null,

        open(data) {
            this.clearTimers();
            this.qrString = data.qrString || '';
            this.orderId = data.orderId || '';
            this.orderNumber = data.orderNumber || '';
            this.customerName = data.customerName || '';
            this.orderTime = data.orderTime || '';
            this.orderMode = data.orderMode || '';
            this.items = data.items || [];
            this.total = data.total || 0;
            this.bypassUrl = data.bypassUrl || '';
            this.timeoutUrl = data.timeoutUrl || '';
            this.statusUrl = data.statusUrl || '';
            this.successUrl = data.successUrl || '';
            this.timeLeft = 60;
            this.statusMessage = '';
            this.statusType = '';
            this.showBypassConfirm = false;
            this.qrImageUrl = '';
            this.show = true;

            this.generateQR();

            this.countdownInterval = setInterval(() => {
                this.timeLeft--;
                if (this.timeLeft <= 0) {
                    this.handleTimeout();
                }
            }, 1000);

            this.pollInterval = setInterval(() => {
                this.checkStatus();
            }, 3000);
        },

        generateQR() {
            if (this.qrString) {
                this.qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' + encodeURIComponent(this.qrString);
            }
        },

        async checkStatus() {
            if (!this.statusUrl) return;
            try {
                const res = await fetch(this.statusUrl);
                const data = await res.json();
                if (data.paid) {
                    this.handlePaid();
                }
            } catch (e) {
                console.error('Status check error:', e);
            }
        },

        handlePaid() {
            this.clearTimers();
            this.statusMessage = 'Pembayaran berhasil!';
            this.statusType = 'success';
            setTimeout(() => {
                window.location.href = this.successUrl;
            }, 1500);
        },

        handleTimeout() {
            this.clearTimers();
            this.statusMessage = 'Waktu habis! Pesanan dibatalkan.';
            this.statusType = 'error';

            fetch(this.timeoutUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Content-Type': 'application/json',
                }
            });

            setTimeout(() => {
                window.location.reload();
            }, 2500);
        },

        confirmBypass() {
            this.showBypassConfirm = true;
        },

        async doBypass() {
            this.bypassLoading = true;
            try {
                const res = await fetch(this.bypassUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Content-Type': 'application/json',
                    },
                });
                const data = await res.json();
                if (data.paid) {
                    this.showBypassConfirm = false;
                    this.handlePaid();
                }
            } catch (e) {
                this.statusMessage = 'Gagal melewati pembayaran.';
                this.statusType = 'error';
            } finally {
                this.bypassLoading = false;
            }
        },

        clearTimers() {
            if (this.countdownInterval) clearInterval(this.countdownInterval);
            if (this.pollInterval) clearInterval(this.pollInterval);
        },

        formatTime(seconds) {
            const m = Math.floor(seconds / 60);
            const s = seconds % 60;
            return m + ':' + String(s).padStart(2, '0');
        },

        formatOrderMode(mode) {
            const modes = { 'DINE_IN': 'Dine In', 'TAKE_AWAY': 'Bawa Pulang', 'DELIVERY': 'Delivery' };
            return modes[mode] || mode;
        },

        formatItems(items) {
            if (!items || !items.length) return '-';
            return items.map(i => i.quantity + 'x ' + i.product_name).join(', ');
        },

        destroy() {
            this.clearTimers();
        },
    };
}
</script>
