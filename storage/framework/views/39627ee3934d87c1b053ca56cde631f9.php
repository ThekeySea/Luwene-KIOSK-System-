<div class="min-h-dvh bg-warm-50">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="<?php echo e(route('customer.packages')); ?>" class="text-warm-400 hover:text-dark transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-lg font-display font-bold text-dark"><?php echo e($package->name); ?></h1>
            <div class="w-6"></div>
        </div>
    </header>

    <div class="max-w-3xl mx-auto pb-32">
        <div class="aspect-[4/3] bg-warm-100">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($package->image): ?>
                <img src="<?php echo e(asset('storage/' . $package->image)); ?>" alt="<?php echo e($package->name); ?>" class="w-full h-full object-cover">
            <?php else: ?>
                <div class="w-full h-full flex items-center justify-center">
                    <span class="text-6xl">&#127873;</span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="px-4 py-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-display font-bold text-dark"><?php echo e($package->name); ?></h2>
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium <?php echo e($package->type === 'MODULAR' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700'); ?>">
                            <?php echo e($package->type === 'MODULAR' ? 'Modular' : 'Tetap'); ?>

                        </span>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($package->type === 'FIXED'): ?>
                    <p class="text-xl font-bold text-primary">Rp <?php echo e(number_format($package->price, 0, ',', '.')); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($package->description): ?>
                <p class="text-sm text-warm-600 mt-3"><?php echo e($package->description); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <form wire:submit.prevent="addToCart">
            <div class="px-4 space-y-6">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($package->type === 'FIXED'): ?>
                    <div>
                        <h3 class="text-sm font-semibold text-dark mb-3">Isi Paket</h3>
                        <div class="space-y-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $fixedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-warm-100">
                                    <span class="text-xl">🍽️</span>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-dark"><?php echo e($item->product->name); ?></p>
                                        <p class="text-xs text-warm-500">x<?php echo e($item->quantity); ?></p>
                                    </div>
                                    <p class="text-sm text-warm-500">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></p>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($package->type === 'MODULAR'): ?>
                    <?php $sectionsCollect = $sections; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sectionsCollect; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sIndex => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sIndex == $currentStep): ?>
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="text-sm font-semibold text-dark">
                                        <?php echo e($section->name); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($section->choice_type === 'SINGLE'): ?><span class="text-red-500">*</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </h3>
                                    <span class="text-xs text-warm-400">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($section->choice_type === 'SINGLE'): ?>
                                            Pilih 1
                                        <?php else: ?>
                                            Pilih maks <?php echo e($section->max_pick); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </span>
                                </div>
                                <p class="text-xs text-warm-400 mb-3">Langkah <?php echo e($currentStep + 1); ?> dari <?php echo e($sectionsCollect->count()); ?></p>

                                <div class="space-y-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $section->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <?php
                                            $isSelected = $section->choice_type === 'SINGLE'
                                                ? ($selections[$sIndex] ?? '') === $item->id
                                                : in_array($item->id, $selections[$sIndex] ?? []);
                                        ?>
                                        <label class="relative flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition
                                            <?php echo e($isSelected ? 'border-primary bg-primary/10 shadow-sm' : 'border-warm-200 bg-white'); ?>">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($section->choice_type === 'SINGLE'): ?>
                                                <input type="radio" name="section_<?php echo e($sIndex); ?>" wire:click="toggleSelection(<?php echo e($sIndex); ?>, '<?php echo e($item->id); ?>')" class="w-5 h-5 accent-primary">
                                            <?php else: ?>
                                                <input type="checkbox" wire:click="toggleSelection(<?php echo e($sIndex); ?>, '<?php echo e($item->id); ?>')"
                                                    <?php echo e(in_array($item->id, $selections[$sIndex] ?? []) ? 'checked' : ''); ?>

                                                    class="w-5 h-5 accent-primary rounded">
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div class="flex-1">
                                                <span class="text-sm font-medium text-dark"><?php echo e($item->product->name); ?></span>
                                            </div>
                                            <span class="text-sm text-accent">+Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isSelected): ?>
                                                <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center shrink-0" aria-hidden="true">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </label>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ["selections.{$sIndex}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    
                    <div class="flex gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep > 0): ?>
                            <button type="button" wire:click="prevStep" class="flex-1 py-3 bg-warm-100 text-dark text-sm font-semibold rounded-xl hover:bg-warm-200 transition">
                                Kembali
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep < $sectionsCollect->count() - 1): ?>
                            <button type="button" wire:click="nextStep" class="flex-1 py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition">
                                Selanjutnya
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div>
                    <h3 class="text-sm font-semibold text-dark mb-3">Jumlah</h3>
                    <div class="flex items-center gap-4">
                        <button type="button" wire:click="$set('quantity', max(1, <?php echo e($quantity); ?> - 1))" class="w-12 h-12 bg-warm-100 rounded-xl flex items-center justify-center text-dark font-bold hover:bg-warm-200 transition">-</button>
                        <span class="text-lg font-bold text-dark w-8 text-center"><?php echo e($quantity); ?></span>
                        <button type="button" wire:click="$set('quantity', min(20, <?php echo e($quantity); ?> + 1))" class="w-12 h-12 bg-warm-100 rounded-xl flex items-center justify-center text-dark font-bold hover:bg-warm-200 transition">+</button>
                    </div>
                </div>
            </div>

            <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-warm-100 z-20">
                <div class="max-w-3xl mx-auto flex items-center justify-between">
                    <div>
                        <p class="text-xs text-warm-400">Total</p>
                        <p class="text-xl font-bold text-primary">Rp <?php echo e(number_format($totalPrice, 0, ',', '.')); ?></p>
                    </div>
                    <button type="submit" class="px-8 py-4 text-lg bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 transition"
                        wire:loading.attr="disabled" wire:loading.class="opacity-50">
                        <span wire:loading.remove>Tambah ke Keranjang</span>
                        <span wire:loading>Menambahkan...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/customer/package-detail.blade.php ENDPATH**/ ?>