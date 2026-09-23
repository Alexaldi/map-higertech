<div id="network-status" class="network-status" aria-label="Ringkasan station">
    <div class="network-status__metric network-status__metric--total">
        <span class="network-status__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M20 10c0 5.2-8 11-8 11S4 15.2 4 10a8 8 0 1 1 16 0Z" />
                <circle cx="12" cy="10" r="2.5" />
            </svg>
        </span>
        <span><small>{{ __('map.total_pos') }}</small><strong id="summary-total">—</strong></span>
    </div>

    <div class="network-status__metric network-status__metric--online">
        <i aria-hidden="true"></i>
        <span><small>{{ __('map.online') }}</small><strong id="summary-online">—</strong></span>
    </div>

    <details id="network-details" class="network-details">
        <summary aria-label="Buka rincian jaringan">
            <span>{{ __('map.details') }}</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="m7 10 5 5 5-5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </summary>
        <div class="network-details__panel">
            <header>
                <span><strong>{{ __('map.network_details') }}</strong><small>{{ __('map.network_composition') }}</small></span>
                <span class="network-details__organization"><strong
                        id="summary-organizations">—</strong><small>{{ __('map.agencies') }}</small></span>
            </header>
            <ul id="type-summary-items"></ul>
            <button id="summary-retry" class="hidden" type="button">{{ __('map.reload_summary') }}</button>
        </div>
    </details>
</div>
