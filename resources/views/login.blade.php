<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Trilogi Nusantara</title>
    @vite(['resources/css/app.css'])
    <style>
        .batik-overlay {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 5L35 20L50 20L38 30L43 45L30 37L17 45L22 30L10 20L25 20L30 5Z' fill='%23C1440E' fill-opacity='0.03'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="min-h-screen relative flex items-center justify-center p-4">
    {{-- Fullscreen Background --}}
    <div class="fixed inset-0 z-0">
        <img src={{ asset('images/login.jpg') }}
             alt="Indonesia Background" 
             class="w-full h-full object-cover">
        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#C1440E]/90 via-[#D4A017]/70 to-[#1F7A8C]/80 mix-blend-multiply"></div>
        {{-- Batik Pattern Overlay --}}
        <div class="absolute inset-0 batik-overlay opacity-20"></div>
    </div>

    {{-- Login Card --}}
    <div class="relative z-10 w-full max-w-md">
        {{-- Decorative Elements --}}
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-[#D4A017]/30 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-[#C1440E]/30 rounded-full blur-2xl"></div>
        
        {{-- Main Card --}}
        <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 overflow-hidden">

            {{-- Card Content --}}
            <div class="px-8 pt-8 pb-8">
                <h1 class="text-3xl font-bold text-center text-white mb-1">Masuk</h1>
                <p class="text-center text-white/80 text-sm mb-8">Jelajahi kembali kekayaan Nusantara</p>

                {{-- Form --}}
                <form class="space-y-5" method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    @if ($errors->any())
                        <div class="rounded-xl bg-red-500/20 border border-red-400/40 text-white text-sm p-3 space-y-1" role="alert">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- Email (akun = email + kata sandi) --}}
                    <div>
                        <label for="email" class="block text-white/90 text-sm font-medium mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   autocomplete="email"
                                   value="{{ old('email') }}"
                                   placeholder="nama@email.com"
                                   required
                                   class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#D4A017] focus:border-transparent transition-all duration-300">
                        </div>
                    </div>

                    {{-- Password Input --}}
                    <div>
                        <label class="block text-white/90 text-sm font-medium mb-2">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input type="password" 
                                   name="password"
                                   id="password"
                                   placeholder="••••••••"
                                   class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#D4A017] focus:border-transparent transition-all duration-300">
                        </div>
                    </div>

                    {{-- Forgot Password & Remember --}}
                    {{-- <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded bg-white/10 border-white/20 text-[#D4A017] focus:ring-[#D4A017]">
                            <span class="ml-2 text-sm text-white/80">Ingat saya</span>
                        </label>
                        <a href="#" class="text-sm text-[#D4A017] hover:text-[#C1440E] transition-colors duration-300">Lupa password?</a>
                    </div> --}}

                    {{-- Login Button --}}
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-[#C1440E] to-[#D4A017] text-white font-bold py-3 px-4 rounded-xl hover:scale-[1.02] transform transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-[#D4A017] focus:ring-offset-2 focus:ring-offset-transparent">
                        Masuk
                    </button>

                    {{-- Register Link --}}
                    <p class="text-center text-white/80 text-sm">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-[#D4A017] font-semibold hover:text-[#C1440E] transition-colors duration-300">Daftar</a>
                    </p>

                    {{-- Back --}}
                    <p class="text-center text-white/70 text-sm mt-2 italic">
                        <a href="{{ route('landing') }}" class="hover:underline">
                            ← Kembali ke Beranda
                        </a>
                    </p>
                </form>
            </div>
        </div>

        {{-- Footer --}}
        <p class="text-center text-white/60 text-xs mt-6">© 2026 Trilogi Nusantara</p>
    </div>
</body>
</html>