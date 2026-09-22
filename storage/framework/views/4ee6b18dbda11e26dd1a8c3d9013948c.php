<div class="min-h-dvh bg-warm-50">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="<?php echo e(route('customer.menu')); ?>" class="text-warm-400 hover:text-dark transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-lg font-display font-bold text-dark">Detail Menu</h1>
            <div class="w-6"></div>
        </div>
    </header>

    <div class="max-w-5xl mx-auto md:grid md:grid-cols-[40%_1fr] md:gap-8 md:items-start md:pt-6 md:pb-12 product-detail-layout">
        
        <div class="md:sticky md:top-20 md:self-start">
            <div class="aspect-[4/3] bg-warm-100 md:rounded-2xl md:overflow-hidden">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->image): ?>
                    <img src="<?php echo e(str_starts_with($product->image ?? '', 'http') ? $product->image : asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-20 h-20 text-warm-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="px-4 pt-5 pb-32 md:px-0 md:pt-0 md:pb-0">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-display font-bold text-dark"><?php echo e($product->name); ?></h2>
                    <p class="text-sm md:text-base text-warm-500 mt-1"><?php echo e($product->category->name); ?></p>
                </div>
                <p class="text-xl md:text-2xl font-bold text-primary shrink-0">Rp <?php echo e(number_format($variantPrice, 0, ',', '.')); ?></p>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->description): ?>
                <p class="text-sm md:text-base text-warm-600 mt-3"><?php echo e($product->description); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form wire:submit.prevent="addToCart" id="addToCart">
                <div class="space-y-6 mt-6">
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->variants->count() > 0): ?>
                        <div>
                            <h3 class="text-sm font-semibold text-dark mb-3">Pilih Tipe</h3>
                            <div class="space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <label class="relative flex items-center gap-3 p-3 md:p-4 rounded-xl border-2 cursor-pointer transition
                                        <?php echo e($selectedVariant === $variant->id ? 'border-primary bg-primary/10 shadow-sm' : 'border-warm-200 bg-white'); ?>">
                                        <input type="radio" name="variant" wire:model.live="selectedVariant" value="<?php echo e($variant->id); ?>" class="w-5 h-5 accent-primary">
                                        <div class="flex-1">
                                            <span class="text-sm md:text-base <?php echo e($selectedVariant === $variant->id ? 'font-bold text-primary' : 'font-medium text-dark'); ?>"><?php echo e($variant->name); ?></span>
                                        </div>
                                        <span class="text-sm md:text-base font-semibold text-primary">Rp <?php echo e(number_format($variant->price, 0, ',', '.')); ?></span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedVariant === $variant->id): ?>
                                            <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center shrink-0" aria-hidden="true">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </label>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['selectedVariant'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showNasi && $nasiGroup && $nasiGroup->modifiers->count() > 0): ?>
                        <div>
                            <h3 class="text-sm font-semibold text-dark mb-3">Pilih Nasi <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($nasiIsRequired): ?><span class="text-red-500">*</span><?php else: ?><span class="text-warm-400 font-normal">(Opsional)</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></h3>
                            <div class="space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $nasiGroup->modifiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <label class="relative flex items-center gap-3 p-3 md:p-4 rounded-xl border-2 cursor-pointer transition
                                        <?php echo e($selectedNasi === $nasi->id ? 'border-primary bg-primary/10 shadow-sm' : 'border-warm-200 bg-white'); ?>">
                                        <input type="radio" name="nasi" wire:model.live="selectedNasi" value="<?php echo e($nasi->id); ?>" class="w-5 h-5 accent-primary">
                                        <div class="flex-1">
                                            <span class="text-sm md:text-base <?php echo e($selectedNasi === $nasi->id ? 'font-bold text-primary' : 'font-medium text-dark'); ?>"><?php echo e($nasi->name); ?></span>
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($nasi->price > 0): ?>
                                            <span class="text-sm text-accent">+Rp <?php echo e(number_format($nasi->price, 0, ',', '.')); ?></span>
                                        <?php else: ?>
                                            <span class="text-xs text-warm-400">Gratis</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedNasi === $nasi->id): ?>
                                            <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center shrink-0" aria-hidden="true">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </label>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['selectedNasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sambals->count() > 0): ?>
                        <div>
                            <h3 class="text-sm font-semibold text-dark mb-3">Pilih Sambal <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sambalIsRequired): ?><span class="text-red-500">*</span><?php else: ?><span class="text-warm-400 font-normal">(Opsional)</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></h3>
                            <div class="grid grid-cols-3 md:grid-cols-4 gap-2 md:gap-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sambals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sambal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <label class="relative flex flex-col items-center p-3 md:p-4 rounded-xl border-2 cursor-pointer transition
                                        <?php echo e($selectedSambal === $sambal->id ? 'border-primary bg-primary/10 shadow-sm' : 'border-warm-200 bg-white'); ?>">
                                        <input type="radio" name="sambal" wire:model.live="selectedSambal" value="<?php echo e($sambal->id); ?>" class="sr-only">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedSambal === $sambal->id): ?>
                                            <span class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full bg-primary text-white flex items-center justify-center" aria-hidden="true">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <span class="text-2xl mb-1">🌶️</span>
                                        <span class="text-xs md:text-sm font-medium text-dark text-center"><?php echo e($sambal->name); ?></span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sambal->pivot->price > 0): ?>
                                            <span class="text-xs text-accent">+Rp <?php echo e(number_format($sambal->pivot->price, 0, ',', '.')); ?></span>
                                        <?php else: ?>
                                            <span class="text-[10px] text-green-600 font-medium">Gratis</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </label>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['selectedSambal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($spiceLevels->count() > 0): ?>
                        <div>
                            <h3 class="text-sm font-semibold text-dark mb-3">Level Pedas <span class="text-red-500">*</span></h3>
                            <div class="grid grid-cols-<?php echo e(min($spiceLevels->count(), 4)); ?> md:grid-cols-<?php echo e(min($spiceLevels->count(), 5)); ?> gap-2 md:gap-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $spiceLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <label class="relative flex flex-col items-center p-3 md:p-4 rounded-xl border-2 cursor-pointer transition
                                        <?php echo e($selectedSpiceLevel === $level->id ? 'border-primary bg-primary/10 shadow-sm' : 'border-warm-200 bg-white'); ?>">
                                        <input type="radio" name="spice_level" wire:model.live="selectedSpiceLevel" value="<?php echo e($level->id); ?>" class="sr-only">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedSpiceLevel === $level->id): ?>
                                            <span class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full bg-primary text-white flex items-center justify-center" aria-hidden="true">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <span class="text-lg md:text-xl font-bold
                                            <?php if($level->level === 0): ?> text-green-500
                                            <?php elseif($level->level === 1): ?> text-yellow-500
                                            <?php elseif($level->level === 2): ?> text-orange-500
                                            <?php else: ?> text-red-500 <?php endif; ?>">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($level->level === 0): ?> 😋
                                            <?php elseif($level->level === 1): ?> 😄
                                            <?php elseif($level->level === 2): ?> 🥵
                                            <?php else: ?> 💀 <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </span>
                                        <span class="text-xs md:text-sm font-medium text-dark"><?php echo e($level->name); ?></span>
                                    </label>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['selectedSpiceLevel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($extraGroup && $extraGroup->modifiers->count() > 0): ?>
                        <div>
                            <h3 class="text-sm font-semibold text-dark mb-3">Extra (Opsional)</h3>
                            <div class="space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $extraGroup->modifiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modifier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <label class="flex items-center gap-3 p-3 md:p-4 bg-white rounded-xl border-2 cursor-pointer transition
                                        <?php echo e(in_array($modifier->id, $selectedExtras) ? 'border-accent bg-accent/10 shadow-sm' : 'border-warm-200 bg-white'); ?>">
                                        <input type="checkbox" wire:model.live="selectedExtras" value="<?php echo e($modifier->id); ?>" class="w-5 h-5 accent-accent rounded">
                                        <div class="flex-1">
                                            <span class="text-sm md:text-base font-medium text-dark"><?php echo e($modifier->name); ?></span>
                                        </div>
                                        <span class="text-sm text-accent">+Rp <?php echo e(number_format($modifier->price, 0, ',', '.')); ?></span>
                                    </label>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
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

                    
                    <div class="hidden md:block pt-4 desktop-only">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm text-warm-400">Total</p>
                                <p class="text-2xl font-bold text-primary">Rp <?php echo e(number_format($totalPrice, 0, ',', '.')); ?></p>
                            </div>
                            <button type="submit" class="px-8 py-4 text-lg bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 transition"
                                wire:loading.attr="disabled" wire:loading.class="opacity-50">
                                <span wire:loading.remove>Tambah ke Keranjang</span>
                                <span wire:loading>Menambahkan...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-warm-100 z-20 md:hidden mobile-only">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-warm-400">Total</p>
                <p class="text-xl font-bold text-primary">Rp <?php echo e(number_format($totalPrice, 0, ',', '.')); ?></p>
            </div>
            <button type="submit" form="addToCart" class="px-8 py-4 text-lg bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 transition"
                wire:loading.attr="disabled" wire:loading.class="opacity-50">
                <span wire:loading.remove>Tambah ke Keranjang</span>
                <span wire:loading>Menambahkan...</span>
            </button>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Luwene\resources\views/livewire/customer/product-detail.blade.php ENDPATH**/ ?>