    <div class="min-h-dvh flex items-center justify-center p-4">
        <div class="w-full max-w-lg">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-display font-bold text-primary tracking-tight">LUWENE</h1>
                <p class="text-warm-500 mt-2">Masuk ke akun Anda</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form wire:submit="login">
                    @if ($errors->has('email') && !str_contains($errors->first('email'), 'salah'))
                        <div class="mb-4 p-3 bg-red-50 text-red-600 rounded-xl text-sm">
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-warm-700 mb-1">Email</label>
                            <input
                                type="email"
                                wire:model="email"
                                id="email"
                                class="w-full px-4 py-3 bg-warm-50 border border-warm-200 rounded-xl text-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                                placeholder="email@luwene.id"
                            />
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-warm-700 mb-1">Password</label>
                            <input
                                type="password"
                                wire:model="password"
                                id="password"
                                class="w-full px-4 py-3 bg-warm-50 border border-warm-200 rounded-xl text-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"
                                placeholder="Masukkan password"
                            />
                        </div>

                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                wire:model="remember"
                                id="remember"
                                class="w-4 h-4 text-primary border-warm-300 rounded focus:ring-primary"
                            />
                            <label for="remember" class="ml-2 text-sm text-warm-600">Ingat saya</label>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full mt-6 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 transition"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-50"
                    >
                        <span wire:loading.remove>Masuk</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-warm-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline">Daftar</a>
                </div>
            </div>
        </div>
    </div>
