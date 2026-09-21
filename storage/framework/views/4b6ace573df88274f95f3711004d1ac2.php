
<div
    x-data="loadingBar()"
    x-init="init()"
    class="fixed top-0 left-0 w-full h-[3px] z-[9999] pointer-events-none overflow-hidden"
    aria-hidden="true"
>
    <div
        x-ref="bar"
        class="h-full bg-gradient-to-r from-primary via-accent to-primary rounded-r-full will-change-[width,opacity]"
        :style="barStyle"
    ></div>
</div>

<script>
function loadingBar() {
    return {
        progress: 0,
        active: false,
        finishing: false,
        fastMode: false,
        raf: null,
        startTime: 0,

        get barStyle() {
            if (!this.active && this.progress === 0) return 'width:0%;opacity:0';
            return `width:${this.progress}%;opacity:${this.active ? 1 : 0};transition:${this.finishing ? 'width 300ms ease, opacity 400ms ease 200ms' : 'none'}`;
        },

        init() {
            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const conn = navigator.connection;
            if (prefersReduced || (conn && (conn.saveData || conn.effectiveType === 'slow-2g' || conn.effectiveType === '2g'))) {
                this.fastMode = true;
            }

            window.addEventListener('livewire:navigating', () => this.start());
            window.addEventListener('livewire:navigated', () => this.finish());
            window.addEventListener('livewire:navigate-failed', () => this.cancel());

            let pending = 0;
            Livewire.hook('request', () => {
                pending++;
                this.start();
                return () => {
                    pending--;
                    if (pending <= 0) {
                        pending = 0;
                        this.finish();
                    }
                };
            });
        },

        start() {
            cancelAnimationFrame(this.raf);
            this.finishing = false;

            if (!this.active) {
                this.progress = 0;
                this.active = true;
            }

            this.startTime = performance.now();
            const duration = this.fastMode ? 800 : 2500;
            const from = this.progress;

            const tick = (now) => {
                const elapsed = now - this.startTime;
                const t = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - t, 3);
                this.progress = from + (90 - from) * eased;

                if (t < 1) {
                    this.raf = requestAnimationFrame(tick);
                }
            };
            this.raf = requestAnimationFrame(tick);
        },

        finish() {
            cancelAnimationFrame(this.raf);
            this.finishing = true;
            this.progress = 100;

            setTimeout(() => {
                this.active = false;
                setTimeout(() => { this.progress = 0; this.finishing = false; }, 400);
            }, 300);
        },

        cancel() {
            cancelAnimationFrame(this.raf);
            this.finishing = true;
            this.progress = 100;
            setTimeout(() => {
                this.active = false;
                setTimeout(() => { this.progress = 0; this.finishing = false; }, 400);
            }, 200);
        },

        destroy() {
            cancelAnimationFrame(this.raf);
        }
    }
}
</script>
<?php /**PATH C:\laragon\www\Luwene\resources\views/components/loading-bar.blade.php ENDPATH**/ ?>