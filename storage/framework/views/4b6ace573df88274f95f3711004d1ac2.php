


<div
    x-data="loadingBar()"
    x-init="init()"
    class="fixed top-0 left-0 right-0 z-[9999] pointer-events-none"
    aria-hidden="true"
>
    
    <div class="h-[3px] bg-transparent w-full">
        
        <div
            x-ref="bar"
            class="h-full bg-gradient-to-r from-primary via-accent to-primary rounded-r-full transition-none"
            :style="`width: ${progress}%; opacity: ${active ? 1 : 0}; transition: ${fastMode ? 'width 150ms ease' : 'width 400ms ease'}`"
        ></div>
    </div>
</div>

<script>
function loadingBar() {
    return {
        progress: 0,
        active: false,
        fastMode: false,
        interval: null,

        init() {
            // Device-aware: check reduced motion preference
            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (prefersReduced) {
                this.fastMode = true;
            }

            // Device-aware: check connection speed
            const conn = navigator.connection;
            if (conn && (conn.saveData || conn.effectiveType === 'slow-2g' || conn.effectiveType === '2g')) {
                this.fastMode = true;
            }

            // ─── Livewire v4 navigation events ───
            // Full page navigations (Livewire Navigate)
            window.addEventListener('livewire:navigating', () => this.start());
            window.addEventListener('livewire:navigated', () => this.finish());
            window.addEventListener('livewire:navigate-failed', () => this.cancel());

            // Livewire component requests (wire:click, wire:submit, wire:poll, etc.)
            Livewire.hook('request', ({ abort }) => {
                this.start();

                return () => this.finish();
            });
        },

        start() {
            this.active = true;
            this.progress = 0;

            // Animate progress: quick ramp up
            clearInterval(this.interval);
            this.interval = setInterval(() => {
                if (this.progress < 90) {
                    // Slower as it approaches 100
                    const increment = this.fastMode ? 8 : (this.progress < 50 ? 15 : 5);
                    this.progress = Math.min(90, this.progress + increment);
                }
            }, this.fastMode ? 50 : 100);
        },

        finish() {
            clearInterval(this.interval);
            this.progress = 100;

            // Hide after animation completes
            setTimeout(() => {
                this.active = false;
                this.progress = 0;
            }, this.fastMode ? 150 : 400);
        },

        cancel() {
            clearInterval(this.interval);
            this.progress = 0;
            this.active = false;
        },

        destroy() {
            clearInterval(this.interval);
        }
    }
}
</script>
<?php /**PATH C:\laragon\www\Luwene\resources\views/components/loading-bar.blade.php ENDPATH**/ ?>