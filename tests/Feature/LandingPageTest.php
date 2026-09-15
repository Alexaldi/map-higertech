<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_renders_successfully_with_default_id_locale(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Higertech Karya Sinergi')
            ->assertSee('Sistem Telemetri & Instrumentasi')
            ->assertSee('Hidrometeorologi Terpadu')
            ->assertSee('PT Higertech Karya Sinergi')
            ->assertSee('Lima Solusi Utama Infrastruktur Presisi')
            ->assertSee('Higertech R&D Internship Academy')
            ->assertSee('Success Story & GIS Telemetry Map')
            ->assertSee('higertech_theme', false);
    }

    public function test_landing_page_includes_anti_flash_dark_mode_script(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('localStorage.getItem(\'higertech_theme\')', false)
            ->assertSee('window.matchMedia(\'(prefers-color-scheme: dark)\')', false)
            ->assertSee('document.documentElement.classList.add(\'dark\')', false);
    }

    public function test_locale_switch_redirects_and_updates_session(): void
    {
        $response = $this->get('/locale/en');

        $response->assertRedirect()
            ->assertSessionHas('locale', 'en');

        $landing = $this->withSession(['locale' => 'en'])->get('/');

        $landing->assertOk()
            ->assertSee('Telemetry & Instrumentation System')
            ->assertSee('Integrated Hydrometeorology')
            ->assertSee('Five Core Precision Infrastructure Solutions');
    }

    public function test_unsupported_locale_route_returns_404(): void
    {
        $response = $this->get('/locale/fr');

        $response->assertNotFound();
    }

    public function test_landing_page_embeds_live_map_preview_and_authentic_images(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('id="preview-station-map"', false)
            ->assertSee('data-preview-map', false)
            ->assertSee('images/products/hg-log900.png', false)
            ->assertSee('images/products/awlr.png', false)
            ->assertSee('images/products/arr.png', false)
            ->assertSee('images/products/aws.png', false)
            ->assertSee('images/products/ews.png', false)
            ->assertSee('images/articles/malahayu.png', false)
            ->assertSee('images/articles/aws-guide.png', false);
    }

    public function test_map_page_includes_dark_mode_and_locale_switch(): void
    {
        $response = $this->get('/map');

        $response->assertOk()
            ->assertSee('localStorage.getItem(\'higertech_theme\')', false)
            ->assertSee('btn-theme-light', false)
            ->assertSee('btn-theme-dark', false)
            ->assertSee('/locale/en', false)
            ->assertSee('/locale/id', false);

        $englishMap = $this->withSession(['locale' => 'en'])->get('/map');

        $englishMap->assertOk()
            ->assertSee('Station List')
            ->assertSee('Total Stations')
            ->assertSee('Marker Legend');
    }
}
