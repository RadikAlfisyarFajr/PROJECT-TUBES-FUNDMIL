<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-[#f8faf8]">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
            <div class="w-full max-w-xl text-center mb-8">
                <a href="/" class="inline-flex items-center justify-center gap-3 text-2xl font-extrabold text-[#0f722b]">
                    <x-application-logo class="w-12 h-12 fill-current text-[#0f722b]" />
                    FUNDMIL SOREANG
                </a>
                <p class="mt-3 text-sm leading-6 text-slate-600">Transparansi zakat dengan tampilan profesional dan bersahabat.</p>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 bg-white border border-[#e8eee8] shadow-[0_24px_55px_rgba(19,35,22,0.12)] rounded-[28px]">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
