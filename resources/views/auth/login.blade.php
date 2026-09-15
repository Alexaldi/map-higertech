<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator | Higertech Karya Sinergi</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen overflow-hidden bg-white sm:bg-[#eef5ff] text-slate-900 antialiased">

    <main class="h-dvh w-full flex items-stretch overflow-hidden sm:p-4 md:p-6 lg:p-8">

        {{-- MAIN CONTAINER --}}
        <div class="relative w-full flex flex-col md:flex-row overflow-hidden bg-white
                    sm:rounded-[24px]
                    shadow-none sm:shadow-[0_25px_80px_rgba(30,64,175,0.12)]">

            {{-- LEFT : HERO / BRANDING  — Tablet & Desktop only --}}
            <section class="hidden md:flex relative flex-1 flex-col overflow-hidden
                            bg-gradient-to-br from-[#eef6ff] via-[#e8f2ff] to-[#dbeafe]">

                {{-- Decorative glows --}}
                <div class="absolute -top-40 -left-32 w-[500px] h-[500px] rounded-full bg-blue-400/15 blur-3xl pointer-events-none"></div>
                <div class="absolute bottom-[-180px] left-[25%] w-[550px] h-[550px] rounded-full bg-cyan-400/15 blur-3xl pointer-events-none"></div>

                {{-- Decorative rings --}}
                <div class="absolute top-0 right-0 w-[520px] h-[520px] opacity-30 pointer-events-none hidden lg:block">
                    <div class="absolute inset-12 rounded-[45%] border border-blue-300/50 rotate-[20deg]"></div>
                    <div class="absolute inset-20 rounded-[45%] border border-blue-300/40 rotate-[20deg]"></div>
                    <div class="absolute inset-28 rounded-[45%] border border-blue-300/30 rotate-[20deg]"></div>
                </div>

                {{-- Background monitoring image --}}
                <div class="absolute inset-0 pointer-events-none">
                    <img src="{{ asset('images/products/arr.png') }}" alt=""
                        class="absolute w-[500px] lg:w-[680px] xl:w-[760px]
                               right-[-160px] lg:right-[-230px]
                               bottom-[-20px] lg:bottom-[-40px]
                               opacity-[0.15] lg:opacity-[0.20]
                               object-contain mix-blend-multiply">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#eef6ff] via-[#eef6ff]/50 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#eef6ff] via-transparent to-transparent"></div>
                </div>

                {{-- LEFT CONTENT --}}
                <div class="relative z-10 flex flex-col justify-center h-full
                            px-6 py-6
                            sm:px-10 sm:py-8
                            lg:px-12 lg:py-10">

                    {{-- Logo --}}
                    <div class="mb-4 sm:mb-6 lg:mb-10">
                        <img src="{{ asset('images/brand/higertech-logo.png') }}" alt="Higertech Karya Sinergi"
                            class="h-7 sm:h-9 lg:h-12 w-auto object-contain">
                    </div>

                    {{-- Hero Text --}}
                    <div class="max-w-[520px]">

                        {{-- Eyebrow --}}
                        <div class="flex items-center gap-2 mb-2 sm:mb-3">
                            <span class="h-[3px] w-8 rounded-full bg-blue-600"></span>
                            <span class="text-[10px] sm:text-xs font-bold tracking-[0.28em] uppercase text-blue-600">
                                Integrated Telemetry Solution
                            </span>
                        </div>

                        {{-- Heading --}}
                        <h1 class="text-[26px] sm:text-[36px] lg:text-[50px] xl:text-[56px]
                                   leading-[1.0] font-black tracking-tight text-[#10234b]">
                            Satu Data,
                            <span class="block text-blue-600">Solusi Nyata</span>
                            <span class="block">untuk Negeri</span>
                        </h1>

                        {{-- Description --}}
                        <p class="mt-2 sm:mt-3 lg:mt-4 max-w-[460px]
                                  text-[10px] sm:text-sm lg:text-[15px]
                                  leading-[1.5] text-slate-600">
                            Mendukung pengelolaan sumber daya air, lingkungan, dan infrastruktur
                            melalui teknologi telemetri dan monitoring yang andal, akurat, serta berkelanjutan.
                        </p>

                    </div>

                    {{-- Feature List — hidden on mobile --}}
                    <div class="hidden sm:flex flex-col gap-3 mt-6 lg:mt-8 max-w-[460px]">

                        @foreach ([
                            ['icon' => '<path d="M4 19V9"/><path d="M10 19V5"/><path d="M16 19v-7"/><path d="M22 19V3"/>', 'title' => 'Monitoring Real-Time', 'desc' => 'Data akurat untuk keputusan yang lebih baik'],
                            ['icon' => '<path d="m12 3 9 5-9 5-9-5 9-5Z"/><path d="m3 12 9 5 9-5"/><path d="m3 16 9 5 9-5"/>', 'title' => 'Teknologi Terintegrasi', 'desc' => 'Sensor, software, dan analitik dalam satu ekosistem'],
                            ['icon' => '<path d="M12 3 20 6v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6l8-3Z"/>', 'title' => 'Berpengalaman & Terpercaya', 'desc' => 'Mitra strategis untuk masa depan yang lebih baik'],
                        ] as $feat)
                            <div class="flex items-center gap-3 lg:gap-4">
                                <div class="w-10 h-10 lg:w-11 lg:h-11 shrink-0 rounded-2xl bg-white/80 border border-white shadow-[0_8px_25px_rgba(30,64,175,0.10)] flex items-center justify-center">
                                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        {!! $feat['icon'] !!}
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-sm lg:text-base text-[#10234b] leading-tight">{{ $feat['title'] }}</h3>
                                    <p class="text-xs lg:text-sm text-slate-500 leading-snug">{{ $feat['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>
            </section>


            {{-- RIGHT : LOGIN--}}
            <section class="relative bg-white flex-1 md:flex-none md:w-[52%] lg:w-[46%] xl:w-[44%]
                            flex items-center overflow-hidden min-h-0">

                {{-- Decorative backgrounds --}}
                <div class="absolute top-0 right-0 w-64 h-64 rounded-full bg-blue-50 blur-3xl opacity-80 pointer-events-none"></div>
                <div class="absolute bottom-0 right-0 w-40 h-40 bg-blue-50/70 pointer-events-none
                            [clip-path:polygon(25%_0,100%_0,100%_75%,75%_100%,0_100%,0_25%)]"></div>

                {{-- Login content --}}
                <div class="relative z-10 w-full max-w-[460px] mx-auto
                            px-5 py-5
                            sm:px-8 sm:py-7
                            lg:px-12 lg:py-10">

                    {{-- Heading --}}
                    <div class="mb-5 sm:mb-7 lg:mb-8">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-[#10234b] leading-tight">
                            Selamat Datang
                        </h2>
                        <h3 class="mt-0.5 text-base sm:text-xl lg:text-2xl font-bold text-blue-600">
                            Di Portal Administrator
                        </h3>
                        <p class="mt-2 max-w-md text-[10px] sm:text-sm lg:text-[15px] leading-[1.5] text-slate-500">
                            Masuk untuk mengakses sistem monitoring, management data,
                            dan layanan internal PT Higertech Karya Sinergi.
                        </p>
                    </div>

                    {{-- Form --}}
                    <form
                        id="loginForm"
                        action="{{ route('login.store') }}"
                        method="POST"
                        class="space-y-3 sm:space-y-4 lg:space-y-5"
                    >
                    @csrf
                        {{-- Email --}}
                        <div>
                            <label for="email" class="block mb-1.5 text-sm font-bold text-[#10234b]">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path d="m3 7 9 6 9-6"/>
                                    </svg>
                                </div>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    placeholder="Masukkan email Anda"
                                    class="w-full h-11 lg:h-12 rounded-xl border border-slate-200 bg-white
                                           pl-10 pr-4 text-sm text-slate-800 placeholder:text-slate-400
                                           outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 shadow-sm">
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs font-medium text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="text-sm font-bold text-[#10234b]">Password</label>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <rect x="5" y="10" width="14" height="10" rx="2"/>
                                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                    </svg>
                                </div>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    placeholder="Masukkan password Anda"
                                    class="w-full h-11 lg:h-12 rounded-xl border border-slate-200 bg-white
                                           pl-10 pr-11 text-sm text-slate-800 placeholder:text-slate-400
                                           outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 shadow-sm">
                                <button type="submit" id="togglePassword"
                                    class="absolute inset-y-0 right-0 px-3.5 text-slate-400 hover:text-blue-600 transition">
                                    <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/>
                                        <circle cx="12" cy="12" r="2.5"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-xs font-medium text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        @if($errors->has('login'))
                            <p class="mt-3 text-xs font-medium text-red-500">
                                {{ $errors->first('login') }}
                            </p>
                        @endif

                        {{-- Submit Button --}}
                        <button
                                type="submit"
                                class="w-full h-11 lg:h-12 rounded-xl mt-1
                                    bg-gradient-to-r from-blue-700 to-blue-600 text-white
                                    font-bold text-sm shadow-[0_12px_30px_rgba(37,99,235,0.25)]
                                    hover:from-blue-800 hover:to-blue-700 hover:-translate-y-0.5
                                    active:translate-y-0 transition-all duration-200"
                            >
                            <span class="flex items-center justify-center gap-2.5">
                                <span class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M5 12h13"/><path d="m13 6 6 6-6 6"/>
                                    </svg>
                                </span>
                                Masuk Sekarang
                            </span>
                        </button>

                    </form>

                    {{-- Divider --}}
                    <div class="flex items-center gap-3 my-4 sm:my-5 lg:my-6">
                        <div class="h-px bg-slate-200 flex-1"></div>
                        <span class="text-[10px] text-slate-400">PT Higertech Karya Sinergi</span>
                        <div class="h-px bg-slate-200 flex-1"></div>
                    </div>

                    {{-- Restricted Access Panel --}}
                    <div class="rounded-xl border border-blue-100 bg-blue-50/60 p-3 sm:p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 shrink-0 rounded-lg bg-blue-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 3 20 6v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6l8-3Z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-[#10234b]">Akses Terbatas</p>
                                <p class="text-[10px] sm:text-xs text-slate-500 leading-relaxed mt-0.5">
                                    Portal ini hanya untuk personel yang berwenang.
                                    Aktivitas login dipantau dan dicatat oleh sistem.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <p class="mt-4 text-center text-[10px] text-slate-400">
                        &copy; {{ date('Y') }} PT Higertech Karya Sinergi. All rights reserved.
                    </p>

                </div>
            </section>

        </div>
    </main>

    <script>
        const loginForm = document.getElementById('loginForm');
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            eyeIcon.innerHTML = isPassword
                ? `<path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/><circle cx="12" cy="12" r="2.5"/>`
                : `<path d="M3 3l18 18"/>
                <path d="M10.58 10.58a2 2 0 0 0 2.83 2.83"/>
                <path d="M9.88 5.09A10.94 10.94 0 0 1 12 5c6.5 0 10 7 10 7a17.14 17.14 0 0 1-3.17 3.83"/>
                <path d="M6.61 6.61C3.85 8.28 2 12 2 12s3.5 7 10 7a10.94 10.94 0 0 0 4.12-.8"/>`;
        });

        loginForm.addEventListener('submit', function () {
            passwordInput.type = 'password';
        });
    </script>

</body>
</html>