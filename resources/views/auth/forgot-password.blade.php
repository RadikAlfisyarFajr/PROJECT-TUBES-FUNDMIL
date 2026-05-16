<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Lupa Password?</h1>
        <p class="mt-3 text-sm leading-6 text-slate-600">Masukkan email yang terdaftar, lalu kami kirimkan tautan reset password ke inbox Anda.</p>
    </div>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="space-y-4">
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('login') }}" class="text-sm font-semibold text-[#0f722b] hover:text-[#063d19]">Kembali ke Login</a>
            <x-primary-button class="w-full sm:w-auto bg-[#0f722b] hover:bg-[#063d19] focus:ring-[#0f722b]">
                {{ __('Kirim Link Reset') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
