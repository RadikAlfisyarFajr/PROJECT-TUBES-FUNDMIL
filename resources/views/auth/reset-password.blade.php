<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#f5f9f3] px-4 py-8">
        <div class="w-full max-w-lg">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold tracking-tight text-[#10391d]">reset password</h1>
                <p class="mt-3 text-sm text-[#44523d]">masukkan password baru untuk akunmu agar dapat login kembali.</p>
            </div>

            <div class="bg-white shadow-[0_28px_60px_rgba(15,23,42,0.08)] rounded-[28px] border border-[#e6efeb] px-8 py-10">
                @if ($errors->any())
                <div class="rounded-2xl bg-[#fef3f2] border border-[#fbcaca] p-4 text-sm text-[#9b2c2c] mb-6">
                    <ul class="space-y-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="post" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label for="email" class="block text-sm font-semibold text-[#33412f]">email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $request->email) }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="mt-3 w-full rounded-[18px] border border-[#d8e0d4] bg-[#f7faf5] px-4 py-3 text-sm text-[#1f2b1e] outline-none transition focus:border-[#166534] focus:ring-2 focus:ring-[#d1fae5]" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-[#33412f]">password baru</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            class="mt-3 w-full rounded-[18px] border border-[#d8e0d4] bg-[#f7faf5] px-4 py-3 text-sm text-[#1f2b1e] outline-none transition focus:border-[#166534] focus:ring-2 focus:ring-[#d1fae5]" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-[#33412f]">konfirmasi password baru</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="mt-3 w-full rounded-[18px] border border-[#d8e0d4] bg-[#f7faf5] px-4 py-3 text-sm text-[#1f2b1e] outline-none transition focus:border-[#166534] focus:ring-2 focus:ring-[#d1fae5]" />
                    </div>

                    <div class="flex items-center justify-between text-sm text-[#44523d]">
                        <a href="{{ route('login') }}" class="font-semibold text-[#166534] hover:text-[#14532d]">kembali ke login</a>
                        <button type="submit" class="rounded-[18px] bg-[#166534] px-5 py-3 text-sm font-semibold text-white shadow-xl shadow-[#14532d1a] transition hover:bg-[#14532d]">reset password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>