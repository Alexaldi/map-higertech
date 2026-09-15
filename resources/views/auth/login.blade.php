<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Administrator | Higertech Karya Sinergi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen overflow-hidden bg-[#eef5ff] text-slate-900 antialiased">

    <main class="h-screen w-full flex items-center justify-center p-0 sm:p-4 lg:p-8 overflow-hidden">

        {{-- MAIN LOGIN CONTAINER --}}
        <div
            class="relative w-full h-full max-w-[1440px]
            overflow-hidden bg-white
            sm:rounded-[28px]
            shadow-none sm:shadow-[0_25px_80px_rgba(30,64,175,0.12)]
            grid grid-cols-1 lg:grid-cols-[1.05fr_0.95fr]">

            {{-- LEFT : BRAND / HERO --}}
            <section
                class="relative min-h-[620px] lg:min-h-[760px]
                overflow-hidden
                bg-gradient-to-br from-[#eef6ff] via-[#e8f2ff] to-[#dbeafe]">

                {{-- Background decorative glow --}}
                <div
                    class="absolute -top-40 -left-32 w-[500px] h-[500px]
                    rounded-full bg-blue-400/15 blur-3xl">
                </div>

                <div
                    class="absolute bottom-[-180px] left-[25%] w-[550px] h-[550px]
                    rounded-full bg-cyan-400/15 blur-3xl">
                </div>

                {{-- Decorative contour --}}
                <div
                    class="absolute top-0 right-0 w-[520px] h-[520px]
                    opacity-30 pointer-events-none">
                    <div
                        class="absolute inset-12 rounded-[45%]
                        border border-blue-300/50 rotate-[20deg]">
                    </div>

                    <div
                        class="absolute inset-20 rounded-[45%]
                        border border-blue-300/40 rotate-[20deg]">
                    </div>

                    <div
                        class="absolute inset-28 rounded-[45%]
                        border border-blue-300/30 rotate-[20deg]">
                    </div>
                </div>

                {{-- Background monitoring image --}}
                <div class="absolute inset-0 pointer-events-none">

                    <img
                        src="{{ asset('assets/images/products.png') }}"
                        alt=""
                        class="absolute
                        w-[680px] max-w-none
                        lg:w-[760px]
                        right-[-230px]
                        bottom-[-40px]
                        opacity-[0.20]
                        object-contain
                        mix-blend-multiply">

                    {{-- Image fade --}}
                    <div
                        class="absolute inset-0
                        bg-gradient-to-r
                        from-[#eef6ff] via-[#eef6ff]/50 to-transparent">
                    </div>

                    <div
                        class="absolute inset-0
                        bg-gradient-to-t
                        from-[#eef6ff]
                        via-transparent
                        to-transparent">
                    </div>

                </div>


                {{-- LEFT CONTENT --}}
                <div
                    class="relative z-10
                    h-full
                    px-7 py-8
                    sm:px-10 sm:py-10
                    lg:px-12 lg:py-12
                    flex flex-col">

                    {{-- Logo --}}
                    <div>
                        <img
                            src="{{ asset('images/brand/higertech-logo.png') }}"
                            alt="Higertech Karya Sinergi"
                            class="w-auto h-10 sm:h-11 lg:h-12 object-contain">
                    </div>


                    {{-- Hero text --}}
                    <div
                        class="mt-16 sm:mt-20 lg:mt-24
                        max-w-[560px]">

                        {{-- Eyebrow --}}
                        <div class="flex items-center gap-3 mb-5">

                            <span class="h-[3px] w-10 rounded-full bg-blue-600"></span>

                            <span
                                class="text-[11px] sm:text-xs
                                font-bold tracking-[0.32em]
                                uppercase text-blue-600">
                                Integrated Telemetry Solution
                            </span>

                        </div>


                        {{-- Heading --}}
                        <h1
                            class="text-[42px] leading-[1.02]
                            sm:text-5xl
                            lg:text-[58px]
                            font-black tracking-tight
                            text-[#10234b]">

                            Satu Data,

                            <span class="block text-blue-600">
                                Solusi Nyata
                            </span>

                            <span class="block">
                                untuk Negeri
                            </span>

                        </h1>


                        {{-- Description --}}
                        <p
                            class="mt-6 max-w-[500px]
                            text-sm sm:text-base
                            lg:text-[17px]
                            leading-7
                            text-slate-600">

                            Mendukung pengelolaan sumber daya air,
                            lingkungan, dan infrastruktur melalui teknologi
                            telemetri dan monitoring yang andal, akurat,
                            serta berkelanjutan.

                        </p>

                    </div>


                    {{-- Feature list --}}
                    <div
                        class="mt-10 sm:mt-12
                        space-y-4
                        max-w-[520px]">

                        {{-- Feature 1 --}}
                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 shrink-0
                                rounded-2xl
                                bg-white/80
                                border border-white
                                shadow-[0_8px_25px_rgba(30,64,175,0.10)]
                                flex items-center justify-center">

                                <svg
                                    class="w-6 h-6 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24">

                                    <path d="M4 19V9" />
                                    <path d="M10 19V5" />
                                    <path d="M16 19v-7" />
                                    <path d="M22 19V3" />

                                </svg>

                            </div>

                            <div>
                                <h3 class="font-bold text-[#10234b]">
                                    Monitoring Real-Time
                                </h3>

                                <p class="text-sm text-slate-500">
                                    Data akurat untuk keputusan yang lebih baik
                                </p>
                            </div>

                        </div>


                        {{-- Feature 2 --}}
                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 shrink-0
                                rounded-2xl
                                bg-white/80
                                border border-white
                                shadow-[0_8px_25px_rgba(30,64,175,0.10)]
                                flex items-center justify-center">

                                <svg
                                    class="w-6 h-6 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24">

                                    <path d="m12 3 9 5-9 5-9-5 9-5Z" />
                                    <path d="m3 12 9 5 9-5" />
                                    <path d="m3 16 9 5 9-5" />

                                </svg>

                            </div>

                            <div>
                                <h3 class="font-bold text-[#10234b]">
                                    Teknologi Terintegrasi
                                </h3>

                                <p class="text-sm text-slate-500">
                                    Sensor, software, dan analitik dalam satu ekosistem
                                </p>
                            </div>

                        </div>


                        {{-- Feature 3 --}}
                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 shrink-0
                                rounded-2xl
                                bg-white/80
                                border border-white
                                shadow-[0_8px_25px_rgba(30,64,175,0.10)]
                                flex items-center justify-center">

                                <svg
                                    class="w-6 h-6 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24">

                                    <path
                                        d="M12 3 20 6v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6l8-3Z" />

                                </svg>

                            </div>

                            <div>
                                <h3 class="font-bold text-[#10234b]">
                                    Berpengalaman & Terpercaya
                                </h3>

                                <p class="text-sm text-slate-500">
                                    Mitra strategis untuk masa depan yang lebih baik
                                </p>
                            </div>

                        </div>

                    </div>


                    {{-- Stats --}}
                    <div
                        class="mt-auto pt-10
                        hidden sm:flex
                        items-center gap-0
                        max-w-[470px]">

                        <div class="flex-1">
                            <div class="text-2xl font-black text-blue-700">
                                100+
                            </div>

                            <div class="text-xs text-slate-500 mt-1">
                                Project<br>
                                Terselesaikan
                            </div>
                        </div>

                        <div class="h-12 w-px bg-slate-300"></div>

                        <div class="flex-1 pl-6">
                            <div class="text-2xl font-black text-blue-700">
                                50+
                            </div>

                            <div class="text-xs text-slate-500 mt-1">
                                Instansi<br>
                                Partner
                            </div>
                        </div>

                        <div class="h-12 w-px bg-slate-300"></div>

                        <div class="flex-1 pl-6">
                            <div class="text-2xl font-black text-blue-700">
                                10+
                            </div>

                            <div class="text-xs text-slate-500 mt-1">
                                Tahun<br>
                                Pengalaman
                            </div>
                        </div>

                    </div>


                    {{-- Bottom tagline --}}
                    <div class="mt-8">

                        <div class="flex items-center gap-2">

                            <span class="w-10 h-1 rounded-full bg-blue-600"></span>

                            <span class="w-8 h-1 rounded-full bg-blue-200"></span>

                            <span class="w-8 h-1 rounded-full bg-blue-200"></span>

                        </div>

                        <p class="mt-3 text-xs sm:text-sm text-slate-400">
                            Membangun Solusi, Menghubungkan Masa Depan
                        </p>

                    </div>

                </div>

            </section>


            {{-- =====================================================
                RIGHT : LOGIN
            ====================================================== --}}
            <section
                class="relative bg-white
                min-h-[650px]
                lg:min-h-[760px]
                flex items-center">

                {{-- Decorative background --}}
                <div
                    class="absolute top-0 right-0
                    w-64 h-64
                    rounded-full
                    bg-blue-50
                    blur-3xl
                    opacity-80">
                </div>

                <div
                    class="absolute bottom-0 right-0
                    w-40 h-40
                    bg-blue-50/70
                    [clip-path:polygon(25%_0,100%_0,100%_75%,75%_100%,0_100%,0_25%)]">
                </div>


                {{-- Login content --}}
                <div
                    class="relative z-10
                    w-full
                    max-w-[500px]
                    mx-auto
                    px-7 py-10
                    sm:px-12 sm:py-12
                    lg:px-14 lg:py-16">

                    {{-- Admin badge --}}
                    <div class="flex justify-end mb-12">

                        <div
                            class="inline-flex items-center gap-3
                            rounded-full
                            bg-blue-50
                            border border-blue-100
                            px-4 py-2.5
                            shadow-sm">

                            <div
                                class="w-8 h-8
                                rounded-full
                                bg-blue-600
                                text-white
                                flex items-center justify-center">

                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24">

                                    <rect
                                        x="5"
                                        y="11"
                                        width="14"
                                        height="10"
                                        rx="2" />

                                    <path d="M8 11V7a4 4 0 0 1 8 0v4" />

                                </svg>

                            </div>

                            <span
                                class="text-[11px]
                                font-extrabold
                                uppercase
                                tracking-wide
                                text-blue-700">

                                Area Administrator

                            </span>

                        </div>

                    </div>


                    {{-- Login heading --}}
                    <div class="mb-9">

                        <h2
                            class="text-3xl sm:text-4xl
                            font-black
                            tracking-tight
                            text-[#10234b]">

                            Selamat Datang

                        </h2>

                        <h3
                            class="mt-1
                            text-xl sm:text-2xl
                            font-bold
                            text-blue-600">

                            Di Portal Administrator

                        </h3>

                        <p
                            class="mt-4
                            max-w-md
                            text-sm sm:text-[15px]
                            leading-6
                            text-slate-500">

                            Masuk untuk mengakses sistem monitoring,
                            management data, dan layanan internal
                            PT Higertech Karya Sinergi.

                        </p>

                    </div>


                    {{-- LOGIN FORM UI --}}
                    <form class="space-y-6">

                        {{-- Email --}}
                        <div>

                            <label
                                for="email"
                                class="block mb-2
                                text-sm font-bold
                                text-[#10234b]">

                                Email

                            </label>

                            <div class="relative">

                                <div
                                    class="absolute inset-y-0 left-0
                                    pl-4
                                    flex items-center
                                    pointer-events-none">

                                    <svg
                                        class="w-5 h-5 text-slate-500"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24">

                                        <rect
                                            x="3"
                                            y="5"
                                            width="18"
                                            height="14"
                                            rx="2" />

                                        <path d="m3 7 9 6 9-6" />

                                    </svg>

                                </div>

                                <input
                                    id="email"
                                    type="email"
                                    placeholder="Masukkan email Anda"
                                    class="w-full h-14
                                    rounded-xl
                                    border border-slate-200
                                    bg-white
                                    pl-12 pr-4
                                    text-sm
                                    text-slate-800
                                    placeholder:text-slate-400
                                    outline-none
                                    transition
                                    focus:border-blue-500
                                    focus:ring-4
                                    focus:ring-blue-500/10
                                    shadow-sm">

                            </div>

                        </div>


                        {{-- Password --}}
                        <div>

                            <div class="flex items-center justify-between mb-2">

                                <label
                                    for="password"
                                    class="text-sm font-bold text-[#10234b]">

                                    Password

                                </label>

                            </div>

                            <div class="relative">

                                <div
                                    class="absolute inset-y-0 left-0
                                    pl-4
                                    flex items-center
                                    pointer-events-none">

                                    <svg
                                        class="w-5 h-5 text-slate-500"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24">

                                        <rect
                                            x="5"
                                            y="10"
                                            width="14"
                                            height="10"
                                            rx="2" />

                                        <path d="M8 10V7a4 4 0 0 1 8 0v3" />

                                    </svg>

                                </div>

                                <input
                                    id="password"
                                    type="password"
                                    placeholder="Masukkan password Anda"
                                    class="w-full h-14
                                    rounded-xl
                                    border border-slate-200
                                    bg-white
                                    pl-12 pr-12
                                    text-sm
                                    text-slate-800
                                    placeholder:text-slate-400
                                    outline-none
                                    transition
                                    focus:border-blue-500
                                    focus:ring-4
                                    focus:ring-blue-500/10
                                    shadow-sm">

                                {{-- Eye UI only --}}
                                <button
                                    type="button"
                                    class="absolute inset-y-0 right-0
                                    px-4
                                    text-slate-400
                                    hover:text-blue-600
                                    transition">

                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24">

                                        <path
                                            d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" />

                                        <circle cx="12" cy="12" r="2.5" />

                                    </svg>

                                </button>

                            </div>


                            {{-- Forgot password --}}
                            <div class="mt-3 text-right">

                                <a
                                    href="#"
                                    class="text-sm font-semibold
                                    text-blue-600
                                    hover:text-blue-800
                                    transition">

                                    Lupa password?

                                </a>

                            </div>

                        </div>


                        {{-- Login button --}}
                        <button
                            type="button"
                            class="w-full h-14
                            rounded-xl
                            bg-gradient-to-r
                            from-blue-700 to-blue-600
                            text-white
                            font-bold
                            text-sm sm:text-base
                            shadow-[0_12px_30px_rgba(37,99,235,0.25)]
                            hover:from-blue-800
                            hover:to-blue-700
                            hover:-translate-y-0.5
                            active:translate-y-0
                            transition-all
                            duration-200">

                            <span class="flex items-center justify-center gap-3">

                                <span
                                    class="w-8 h-8
                                    rounded-full
                                    bg-white/10
                                    flex items-center justify-center">

                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24">

                                        <path d="M5 12h13" />
                                        <path d="m13 6 6 6-6 6" />

                                    </svg>

                                </span>

                                Masuk Sekarang

                            </span>

                        </button>

                    </form>


                    {{-- Divider --}}
                    <div class="flex items-center gap-4 my-9">

                        <div class="h-px bg-slate-200 flex-1"></div>

                        <span class="text-xs text-slate-400">
                            PT Higertech Karya Sinergi
                        </span>

                        <div class="h-px bg-slate-200 flex-1"></div>

                    </div>


                    {{-- Restricted access --}}
                    <div
                        class="rounded-2xl
                        bg-blue-50
                        border border-blue-100
                        p-4 sm:p-5">

                        <div class="flex items-start gap-4">

                            <div
                                class="w-11 h-11 shrink-0
                                rounded-xl
                                bg-blue-600
                                text-white
                                flex items-center justify-center">

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24">

                                    <path
                                        d="M12 3 20 6v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6l8-3Z" />

                                    <path d="m9 12 2 2 4-4" />

                                </svg>

                            </div>

                            <div>

                                <h4
                                    class="font-bold
                                    text-sm
                                    text-blue-900">

                                    Akses Terbatas

                                </h4>

                                <p
                                    class="mt-1
                                    text-xs sm:text-sm
                                    leading-5
                                    text-slate-600">

                                    Halaman ini hanya untuk administrator
                                    dan pengguna yang berwenang.

                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Footer --}}
                    <p
                        class="mt-8
                        text-center
                        text-xs
                        text-slate-400">

                        © {{ date('Y') }} Higertech Karya Sinergi.
                        All rights reserved.

                    </p>

                </div>

            </section>

        </div>

    </main>

</body>

</html>