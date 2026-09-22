<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MapPageTest extends TestCase
{
    use RefreshDatabase;
    public function test_map_page_renders_the_public_monitoring_shell(): void
    {
        $this->get('/map')
            ->assertOk()
            ->assertSee('Higertech Live Monitoring')
            ->assertSee('Cari nama pos...')
            ->assertSee('Total Pos')
            ->assertSee('data-live-map', false)
            ->assertSee('id="station-map"', false)
            ->assertSee('id="station-results"', false)
            ->assertSee('id="station-search"', false)
            ->assertSee('id="station-search-suggestions"', false)
            ->assertSee('id="organization-filter"', false)
            ->assertDontSee('data-stations-url=', false)
            ->assertDontSee('data-summary-url=', false)
            ->assertDontSee('/api/stations', false)
            ->assertSee('Memuat station...')
            ->assertSee('Tidak ada station yang cocok')
            ->assertSee('Data station gagal dimuat')
            ->assertSee('Coba lagi');
    }

    public function test_map_page_exposes_filter_and_layout_controls(): void
    {
        $this->get('/map')
            ->assertOk()
            ->assertSee('data-type="ARR"', false)
            ->assertSee('data-type="AWLR"', false)
            ->assertSee('data-type="AWS"', false)
            ->assertSee('data-type="AWLR_ARR"', false)
            ->assertSee('data-type="AGWLR"', false)
            ->assertSee('data-type="FM"', false)
            ->assertSee('data-type="EWS"', false)
            ->assertSee('data-type="AVWR"', false)
            ->assertSee('data-type="WQ"', false)
            ->assertSee('data-type="VNOTCH"', false)
            ->assertSee('data-type="OW"', false)
            ->assertSee('data-type="OSP"', false)
            ->assertDontSee('data-type="OTHER"', false)
            ->assertSee('data-status="online"', false)
            ->assertSee('data-status="offline"', false)
            ->assertSee('data-desktop-persistent', false)
            ->assertSee('id="drawer-toggle"', false)
            ->assertSee('aria-label="Buka pencarian, filter, dan daftar pos"', false)
            ->assertSee('station-drawer-toggle__label', false)
            ->assertSee('id="station-search-form"', false)
            ->assertSee('id="station-search-submit"', false)
            ->assertSee('id="station-panel-close"', false)
            ->assertSee('id="reset-map"', false)
            ->assertSee('id="fit-markers"', false)
            ->assertSee('id="fullscreen-map"', false);
    }

    public function test_sidebar_prioritizes_results_with_a_collapsible_filter_panel(): void
    {
        $this->get('/map')
            ->assertOk()
            ->assertSee('id="station-filter-panel"', false)
            ->assertSee('Filter station')
            ->assertSee('Tipe, status, dan instansi')
            ->assertSee('id="apply-filters"', false)
            ->assertSee('Terapkan Filter')
            ->assertSee('id="station-results"', false)
            ->assertDontSee('id="station-filter-panel" open', false);
    }

    public function test_map_page_exposes_reference_navigation_with_user_authorized_brand_assets(): void
    {
        $this->get('/map')
            ->assertOk()
            ->assertSee('aria-label="Navigasi utama"', false)
            ->assertSee('/images/brand/higertech-logo.png', false)
            ->assertSee('/images/brand/inaproc-logo.png', false)
            ->assertSee('alt="Higertech Karya Sinergi"', false)
            ->assertSee('alt="INAPROC Katalog Elektronik"', false)
            ->assertSee('https://higertech.com/Product/Hidrologi', false)
            ->assertSee('https://higertech.com/Article', false)
            ->assertSee('https://higertech.com/Tutorial', false)
            ->assertSee('aria-current="page"', false)
            ->assertSee('id="map-legend"', false)
            ->assertSee('Keterangan Marker');
    }

    public function test_header_renders_the_reference_two_level_navigation(): void
    {
        $html = $this->get('/map')
            ->assertOk()
            ->getContent();

        $document = new \DOMDocument;
        @$document->loadHTML($html);
        $xpath = new \DOMXPath($document);

        $this->assertCount(1, $xpath->query('//header[contains(concat(" ", normalize-space(@class), " "), " site-header ")]/*[contains(concat(" ", normalize-space(@class), " "), " site-topbar ")]'));
        $this->assertCount(4, $xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " site-socials ")]/*[local-name()="svg"]'));
        $this->assertCount(1, $xpath->query('//a[@href="mailto:higertechkaryasinergi@gmail.com"]'));
        $this->assertCount(1, $xpath->query('//a[@href="tel:+622221010299"]'));
        $this->assertCount(0, $xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " site-network-status ")]'));
        $this->assertCount(0, $xpath->query('//*[@id="header-online" or @id="header-offline"]'));
        $this->assertStringNotContainsString('Realtime Telemetry Network', $html);
    }

    public function test_map_workspace_keeps_search_filters_and_station_names_visible_on_desktop(): void
    {
        $html = $this->get('/map')
            ->assertOk()
            ->getContent();

        $document = new \DOMDocument;
        @$document->loadHTML($html);
        $xpath = new \DOMXPath($document);

        $this->assertCount(1, $xpath->query('//*[@id="station-sidebar" and @data-desktop-persistent]'));
        $this->assertCount(1, $xpath->query('//*[@id="station-sidebar"]/*[@data-station-controls]//*[@id="station-search"]'));
        $this->assertCount(1, $xpath->query('//*[@id="station-sidebar"]/*[@data-station-controls]//*[@id="station-filter-panel"]'));
        $this->assertCount(1, $xpath->query('//*[@id="station-sidebar"]/*[@data-station-list]//*[@id="station-results-heading"]'));
        $this->assertCount(1, $xpath->query('//*[@id="station-sidebar"]/*[@data-station-list]//*[@id="station-results"]'));
        $this->assertCount(0, $xpath->query('//*[@id="station-sidebar"]/*[@data-station-list]//*[@id="station-search" or @id="station-filter-panel"]'));
        $this->assertCount(1, $xpath->query('//*[@id="station-panel-launcher" and @aria-controls="station-sidebar" and @aria-expanded="true"]'));
        $this->assertStringContainsString('id="network-status"', $html);
        $this->assertStringContainsString('id="network-details"', $html);
        $this->assertStringContainsString('id="type-summary-items"', $html);
        $this->assertStringNotContainsString('map-summary__rail', $html);
        $this->assertStringNotContainsString('data-summary-key="ARR"', $html);
        $this->assertStringNotContainsString('data-summary-key="AWLR"', $html);
        $this->assertStringNotContainsString('data-summary-key="AWS"', $html);
    }

    public function test_station_docks_keep_controls_and_results_as_separate_surfaces(): void
    {
        $this->get('/map')
            ->assertOk()
            ->assertSee('data-dock="station-controls"', false)
            ->assertSee('data-dock="station-results"', false);
    }
}
