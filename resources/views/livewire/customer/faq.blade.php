<div class="min-h-dvh bg-warm-50" x-data="{ open: null }">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-3xl mx-auto px-4 py-4 text-center">
            <h1 class="text-lg font-display font-bold text-dark">Pertanyaan Umum</h1>
            <p class="text-xs text-warm-400">Hal yang sering ditanyakan pelanggan</p>
        </div>
    </header>

    <main class="max-w-3xl mx-auto p-4 space-y-3">
        @php($faqs = [
            ['q' => 'Bagaimana cara memesan?', 'a' => 'Pilih Dine In atau Bawa Pulang di Beranda, pilih menu dan atur di halaman detail, lalu masukkan ke Nampan. Kalau sudah pasti, isi Nama, Email, dan Nomor Telepon, lanjut ke Pembayaran. Setelah bayar, halaman sukses muncul otomatis — tanpa perlu akun.'],
            ['q' => 'Apa bedanya Dine In dan Bawa Pulang?', 'a' => 'Dine In: kamu memilih nomor meja dan makanan disajikan di meja. Bawa Pulang: pesanan dibungkus untuk dibawa pulang. Pilihan ini ditentukan di awal dan tidak bisa diubah di tengah jalan.'],
            ['q' => 'Apa saja metode pembayarannya?', 'a' => 'Tunai (bayar langsung ke kasir) dan QRIS (scan kode saat checkout). Tidak ada pembayaran online lain untuk saat ini.'],
            ['q' => 'Bagaimana cara memakai kode promo?', 'a' => 'Buka halaman Promo dari navbar bawah, masukkan kode voucher, tekan Pakai. Potongan otomatis dihitung di Nampan dan Checkout. Satu kode promo berlaku untuk satu nampan dan memotong total belanja, bukan per menu.'],
            ['q' => 'Bagaimana cara melacak pesananku?', 'a' => 'Setelah checkout kamu langsung diarahkan ke halaman status pesanan: Dibuat → Dikonfirmasi → Diproses → Siap → Selesai. Jika kamu login, riwayat pesanan bisa dilihat di menu Pesanan.'],
            ['q' => 'Apakah harus punya akun untuk memesan?', 'a' => 'Tidak. Kamu bisa memesan langsung tanpa akun. Akun berguna untuk melihat riwayat pesanan dan mempercepat checkout di kunjungan berikutnya.'],
            ['q' => 'Kapan LUWENE buka dan di mana lokasinya?', 'a' => 'LUWENE Main buka setiap hari pukul 10.00–22.00, berlokasi di Jl. Contoh No. 123, Jakarta Selatan.'],
        ])
        @foreach ($faqs as $index => $faq)
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <button
                    @click="open === {{ $index }} ? open = null : open = {{ $index }}"
                    class="w-full flex items-center justify-between gap-3 p-4 text-left min-h-[48px]"
                >
                    <span class="font-semibold text-dark text-sm">{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 text-warm-400 transition shrink-0" :class="open === {{ $index }} ? 'rotate-180 text-primary' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="open === {{ $index }}" x-transition class="px-4 pb-4 text-sm text-warm-600 leading-relaxed">
                    {{ $faq['a'] }}
                </div>
            </div>
        @endforeach
    </main>
</div>
