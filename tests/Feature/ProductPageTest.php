<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_page_renders_successfully(): void
    {
        $category = Category::create([
            'name' => 'Tinggi Muka Air Telemetri ( Automatic Water Level Recorder / AWLR )',
            'sub_nama' => 'Automatic Water Level Recorder',
            'tipe' => 'produk',
            'sort_order' => 1,
        ]);

        Product::create([
            'category_id' => $category->id,
            'title' => 'Perangkat Telemetri AWLR Pressure Sensor',
            'slug' => 'perangkat-telemetri-awlr-pressure-sensor',
            'desc' => 'Deskripsi AWLR',
            'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi',
            'is_active' => true,
        ]);

        $response = $this->get(route('products'));

        $response->assertStatus(200);
        $response->assertSee('Perangkat Telemetri AWLR Pressure Sensor');
    }

    public function test_products_category_filter_works(): void
    {
        $category1 = Category::create([
            'name' => 'Curah Hujan Telemetri ( Automatic Rain Recorder / ARR )',
            'tipe' => 'produk',
            'sort_order' => 1,
        ]);

        $category2 = Category::create([
            'name' => 'Tinggi Muka Air Telemetri ( Automatic Water Level Recorder / AWLR )',
            'tipe' => 'produk',
            'sort_order' => 2,
        ]);

        Product::create([
            'category_id' => $category1->id,
            'title' => 'Stasiun ARR HGT01',
            'slug' => 'stasiun-arr-hgt01',
            'desc' => 'ARR unit',
            'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $category2->id,
            'title' => 'Stasiun AWLR HGT02',
            'slug' => 'stasiun-awlr-hgt02',
            'desc' => 'AWLR unit',
            'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi',
            'is_active' => true,
        ]);

        $response = $this->get(route('products', ['category' => $category2->id]));

        $response->assertStatus(200);
        $response->assertSee('Stasiun AWLR HGT02');
        $response->assertDontSee('Stasiun ARR HGT01');
    }

    public function test_product_detail_page_renders_with_compact_breadcrumb(): void
    {
        $category = Category::create([
            'name' => 'Tinggi Muka Air Telemetri ( Automatic Water Level Recorder / AWLR )',
            'sub_nama' => 'Automatic Water Level Recorder',
            'tipe' => 'produk',
            'sort_order' => 1,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'title' => 'Non-Contact Radar Water Level Telemetry Station',
            'slug' => 'non-contact-radar-water-level-telemetry-station',
            'desc' => 'Sensor radar 80GHz',
            'inaproc_link' => 'https://katalog.inaproc.id/higertech-karya-sinergi',
            'is_active' => true,
        ]);

        $response = $this->get(route('products.show', $product->slug));

        $response->assertStatus(200);
        // Breadcrumb contains compact short_name 'AWLR'
        $response->assertSee('AWLR');
        // Full product title is present without truncation
        $response->assertSee('Non-Contact Radar Water Level Telemetry Station');
    }

    public function test_product_detail_page_links_to_its_inaproc_catalog(): void
    {
        $category = Category::create([
            'name' => 'Pemantau Visual Camera Capture ( CCTV Capture )',
            'tipe' => 'produk',
            'sort_order' => 5,
        ]);

        $customUrl = 'https://katalog.inaproc.id/higertech-karya-sinergi/perangkat-telemetri-cctv-capture-x';

        $product = Product::create([
            'category_id' => $category->id,
            'title' => 'PERANGKAT TELEMETRI CCTV CAPTURE',
            'slug' => 'perangkat-telemetri-cctv-capture-x',
            'inaproc_link' => $customUrl,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.show', $product->slug));

        $response->assertStatus(200);
        $response->assertSee('PERANGKAT TELEMETRI CCTV CAPTURE');
        $response->assertSee('Lihat di INAPROC');
        $response->assertSee('href="'.$customUrl.'"', false);
        $response->assertDontSee('Unduh Brosur');
        $response->assertDontSee('Minta Brosur');
        $response->assertSee('Deskripsi produk belum tersedia.');
        $response->assertDontSee('data-gallery-thumb=', false);
        $response->assertDontSee('TKDN 40% RESMI');
        $response->assertDontSee('picsum.photos');
    }

    public function test_product_gallery_and_brochure_are_loaded_from_its_database_record(): void
    {
        $category = Category::create(['name' => 'ARR', 'tipe' => 'produk']);
        $product = Product::create([
            'category_id' => $category->id,
            'title' => 'Stasiun ARR',
            'slug' => 'curah-hujan-telemetry-arr-telemetry-0-5-mm-0-2mm-data-logger-hgtks',
            'desc' => '<script>alert("test")</script>',
            'image' => 'products/database-main.jpg',
            'gallery_images' => ['products/database-second.jpg'],
            'brochure' => 'products/brochures/database-brochure.pdf',
            'is_active' => true,
        ]);

        $response = $this->get(route('products.show', $product->slug));
        $response->assertOk()
            ->assertSee(asset('storage/products/database-main.jpg'), false)
            ->assertSee(asset('storage/products/database-second.jpg'), false)
            ->assertSee(asset('storage/products/brochures/database-brochure.pdf'), false)
            ->assertSee('Unduh Brosur')
            ->assertSee('data-gallery-thumb="1"', false)
            ->assertSee($product->desc)
            ->assertDontSee($product->desc, false);

        $product->update(['slug' => 'other-arr-station', 'gallery_images' => [], 'brochure' => null]);
        $this->get(route('products.show', $product->slug))->assertOk()
            ->assertDontSee('data-gallery-thumb=', false)
            ->assertDontSee('Unduh Brosur')
            ->assertSee(asset('storage/products/database-main.jpg'), false)
            ->assertDontSee('arr-telemetry-station.png');
    }

    public function test_inactive_product_detail_is_not_public(): void
    {
        $category = Category::create(['name' => 'ARR', 'tipe' => 'produk']);
        $product = Product::create([
            'category_id' => $category->id,
            'title' => 'Produk Nonaktif',
            'slug' => 'produk-nonaktif',
            'is_active' => false,
        ]);

        $this->get(route('products.show', $product->slug))->assertNotFound();
    }

    public function test_product_detail_returns_404_when_not_found(): void
    {
        $response = $this->get(route('products.show', 'non-existent-product-slug'));

        $response->assertStatus(404);
    }
}
