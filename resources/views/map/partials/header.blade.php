@php
    $productLinks = [
        ['label' => 'Hidrologi', 'url' => 'https://higertech.com/Product/Hidrologi'],
        ['label' => 'Hidrogeologi', 'url' => 'https://higertech.com/Product/Hidrogeologi'],
        ['label' => 'Hidrometeorologi', 'url' => 'https://higertech.com/Product/Hidrometeorologi'],
        ['label' => 'Data Logger', 'url' => 'https://higertech.com/Product/Logger'],
        ['label' => 'Software Monitoring', 'url' => 'https://higertech.com/Product/Software'],
        ['label' => 'Perangkat Pendukung', 'url' => 'https://higertech.com/Product/Pendukung'],
        ['label' => 'CCTV', 'url' => 'https://higertech.com/Product/Cctv'],
    ];
@endphp

<header class="site-header">
    <div class="site-topbar">
        <div class="site-header__inner">
            <div class="site-socials" aria-label="Media sosial Higertech">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-label="X"><path d="M4 4l16 16M20 4 4 20"/></svg>
                <svg viewBox="0 0 24 24" fill="currentColor" aria-label="Facebook"><path d="M13.7 22v-8h2.7l.4-3.1h-3.1V9c0-.9.3-1.5 1.6-1.5H17V4.7c-.8-.1-1.6-.2-2.4-.2-2.4 0-4.1 1.5-4.1 4.2v2.2H7.8V14h2.7v8h3.2Z"/></svg>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-label="Instagram"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
                <svg viewBox="0 0 24 24" fill="currentColor" aria-label="LinkedIn"><path d="M6.5 8.2H3.3V21h3.2V8.2ZM4.9 3A1.9 1.9 0 1 0 5 6.8 1.9 1.9 0 0 0 5 3ZM21 13.7c0-3.8-2-5.6-4.7-5.6a4 4 0 0 0-3.6 2V8.3H9.5V21h3.2v-6.3c0-1.7.3-3.3 2.4-3.3 2 0 2.1 1.9 2.1 3.4V21H21v-7.3Z"/></svg>
            </div>

            <div class="site-contact">
                <a href="mailto:higertechkaryasinergi@gmail.com">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                    higertechkaryasinergi@gmail.com
                </a>
                <a href="tel:+622221010299">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z"/></svg>
                    022-2101-0299
                </a>
            </div>
        </div>
    </div>

    <div class="site-branding">
        <div class="site-header__inner">
            <div class="site-branding__start">
                <button
                    id="drawer-toggle"
                    class="site-icon-button lg:hidden"
                    type="button"
                    aria-label="Buka filter station"
                    aria-controls="station-sidebar"
                    aria-expanded="false"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <a class="site-brand" href="{{ url('/map') }}" aria-label="Higertech Live Monitoring">
                    <img src="{{ asset('images/brand/higertech-logo.png') }}" alt="Higertech Karya Sinergi" width="400" height="125">
                </a>
            </div>

            <nav class="site-nav" aria-label="Navigasi utama">
                <a href="https://higertech.com/" target="_blank" rel="noopener noreferrer">Home</a>
                <details class="site-nav__dropdown">
                    <summary>Product <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m7 10 5 5 5-5"/></svg></summary>
                    <div>
                        @foreach ($productLinks as $product)
                            <a href="{{ $product['url'] }}" target="_blank" rel="noopener noreferrer">{{ $product['label'] }}</a>
                        @endforeach
                    </div>
                </details>
                <a href="https://higertech.com/#services" target="_blank" rel="noopener noreferrer">Projects</a>
                <a href="https://higertech.com/Article" target="_blank" rel="noopener noreferrer">Articles</a>
                <a href="https://higertech.com/Tutorial" target="_blank" rel="noopener noreferrer">Download</a>
                <a class="is-active" href="{{ url('/map') }}" aria-current="page">Peta</a>
                <a class="inaproc-link" href="https://katalog.inaproc.id/higertech-karya-sinergi" target="_blank" rel="noopener noreferrer" aria-label="Buka INAPROC Katalog Elektronik">
                    <img src="{{ asset('images/brand/inaproc-logo.png') }}" alt="INAPROC Katalog Elektronik" width="253" height="79">
                </a>
                <span class="language-switch" aria-label="Pilihan bahasa, Indonesia aktif">
                    <span>EN</span><strong>ID</strong>
                </span>
            </nav>

            <details class="site-mobile-nav">
                <summary class="site-icon-button" aria-label="Buka navigasi utama">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </summary>
                <div class="site-mobile-nav__panel">
                    <a href="https://higertech.com/" target="_blank" rel="noopener noreferrer">Home</a>
                    <details>
                        <summary>Product</summary>
                        @foreach ($productLinks as $product)
                            <a href="{{ $product['url'] }}" target="_blank" rel="noopener noreferrer">{{ $product['label'] }}</a>
                        @endforeach
                    </details>
                    <a href="https://higertech.com/#services" target="_blank" rel="noopener noreferrer">Projects</a>
                    <a href="https://higertech.com/Article" target="_blank" rel="noopener noreferrer">Articles</a>
                    <a href="https://higertech.com/Tutorial" target="_blank" rel="noopener noreferrer">Download</a>
                    <a class="is-active" href="{{ url('/map') }}" aria-current="page">Peta</a>
                    <a href="https://katalog.inaproc.id/higertech-karya-sinergi" target="_blank" rel="noopener noreferrer">INAPROC ↗</a>
                </div>
            </details>
        </div>
    </div>
</header>
