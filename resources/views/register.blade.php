<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Trilogi Nusantara</title>
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
        <img src={{ asset('images/register-page.png') }}
             alt="Indonesia Background" 
             class="w-full h-full object-cover opacity-75">
        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#1F7A8C]/90 via-[#D4A017]/70 to-[#C1440E]/80 mix-blend-multiply"></div>
        {{-- Batik Pattern Overlay --}}
        <div class="absolute inset-0 batik-overlay opacity-20"></div>
    </div>

    {{-- Register Card --}}
    <div class="relative z-10 w-full max-w-md">
        {{-- Decorative Elements --}}
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#1F7A8C]/30 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-[#D4A017]/30 rounded-full blur-2xl"></div>
        
        {{-- Main Card --}}
        <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 overflow-hidden">

            {{-- Card Content --}}
            <div class="px-8 pt-8 pb-8">
                <h1 class="text-3xl font-bold text-center text-white mb-1">Daftar</h1>
                <p class="text-center text-white/80 text-sm mb-8">Mulai petualanganmu menjelajahi kekayaan budaya Indonesia</p>

                {{-- Form --}}
                <form class="space-y-4" method="POST" action="{{ route('register.submit') }}">
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
                    {{-- Name Input --}}
                    <div>
                        <label class="block text-white/90 text-sm font-medium mb-2">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="username"
                                   id="username"
                                   value="{{ old('username') }}"
                                   placeholder="indokeren123"
                                   class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#1F7A8C] focus:border-transparent transition-all duration-300">
                        </div>
                    </div>

                    {{-- Email Input --}}
                    <div>
                        <label class="block text-white/90 text-sm font-medium mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input type="email" 
                                   name="email"
                                   id="email"
                                   value="{{ old('email') }}"
                                   placeholder="indokeren@example.com"
                                   class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#1F7A8C] focus:border-transparent transition-all duration-300">
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
                                   class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#1F7A8C] focus:border-transparent transition-all duration-300">
                        </div>
                    </div>

                    {{-- Confirm Password Input --}}
                    <div>
                        <label class="block text-white/90 text-sm font-medium mb-2">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <input type="password" 
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   placeholder="••••••••"
                                   class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-[#1F7A8C] focus:border-transparent transition-all duration-300">
                        </div>
                    </div>

                    {{-- Terms --}}
                    {{-- <div class="flex items-center">
                        <input type="checkbox" class="rounded bg-white/10 border-white/20 text-[#1F7A8C] focus:ring-[#1F7A8C]">
                        <span class="ml-2 text-sm text-white/80">Saya setuju dengan <a href="#" class="text-[#D4A017] hover:text-[#C1440E]">Syarat & Ketentuan</a></span>
                    </div> --}}

                    {{-- Register Button --}}
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-[#1F7A8C] to-[#D4A017] text-white font-bold py-3 px-4 rounded-xl hover:scale-[1.02] transform transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-[#1F7A8C] focus:ring-offset-2 focus:ring-offset-transparent">
                        Daftar
                    </button>

                    {{-- Login Link --}}
                    <p class="text-center text-white/80 text-sm">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-[#D4A017] font-semibold hover:text-[#C1440E] transition-colors duration-300">Masuk</a>
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