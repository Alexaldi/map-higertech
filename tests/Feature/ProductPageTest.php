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

    public function test_catalog_search_matches_title_or_description_within_active_category(): void
    {
        $category = Category::create(['name' => 'ARR', 'tipe' => 'produk']);
        $other = Category::create(['name' => 'AWS', 'tipe' => 'produk']);
        foreach ([
            ['title' => 'Sensor Radar Pilihan', 'category_id' => $category->id, 'desc' => 'Teknologi pressure presisi', 'is_active' => true],
            ['title' => 'Radar Kategori Lain', 'category_id' => $other->id, 'desc' => 'Radar', 'is_active' => true],
            ['title' => 'Radar Nonaktif', 'category_id' => $category->id, 'desc' => 'Radar pressure', 'is_active' => false],
        ] as $index => $data) {
            Product::create([...$data, 'slug' => 'search-product-'.$index]);
        }

        foreach (['RADAR', 'pressure'] as $search) {
            $this->get(route('products', ['category' => $category->id, 'q' => $search]))->assertOk()
                ->assertSee('Sensor Radar Pilihan')
                ->assertDontSee('Radar Kategori Lain')
                ->assertDontSee('Radar Nonaktif')
                ->assertViewHas('products', fn ($products) => $products->total() === 1);
        }
    }

    public function test_catalog_preserves_search_and_category_across_pagination_and_links(): void
    {
        $category = Category::create(['name' => 'ARR', 'tipe' => 'produk']);
        $other = Category::create(['name' => 'AWS', 'tipe' => 'produk']);
        for ($index = 1; $index <= 12; $index++) {
            Product::create(['category_id' => $category->id, 'title' => 'Radar '.$index, 'slug' => 'radar-'.$index, 'is_active' => true]);
        }

        $response = $this->get(route('products', ['category' => $category->id, 'q' => 'Radar']));
        $response->assertOk()->assertViewHas('products', fn ($products) => $products->count() === 10 && $products->total() === 12)
            ->assertSee(route('products', ['category' => $other->id, 'q' => 'Radar']))
            ->assertSee(route('products', ['q' => 'Radar']));
        parse_str(parse_url($response->viewData('products')->url(2), PHP_URL_QUERY), $query);
        $this->assertSame('Radar', $query['q']);
        $this->assertSame((string) $category->id, $query['category']);
        $this->get(route('products', [...$query]))->assertOk()
            ->assertViewHas('products', fn ($products) => $products->count() === 2);
    }

    public function test_catalog_empty_search_and_invalid_inputs_are_handled_safely(): void
    {
        $category = Category::create(['name' => 'ARR', 'tipe' => 'produk']);
        Product::create(['category_id' => $category->id, 'title' => 'Produk Tersimpan', 'slug' => 'produk-tersimpan', 'is_active' => true]);
        $this->get(route('products', ['q' => "%' OR 1=1 --"]))->assertOk()
            ->assertSee('Produk tidak ditemukan')->assertDontSee('Produk Tersimpan');
        $this->get(route('products', ['q' => '<script>alert(1)</script>']))->assertOk()
            ->assertDontSee('<script>alert(1)</script>', false);
        $this->getJson(route('products', ['q' => ['invalid']]))->assertUnprocessable()->assertJsonValidationErrors('q');
        $this->getJson(route('products', ['q' => str_repeat('a', 101)]))->assertUnprocessable()->assertJsonValidationErrors('q');
        $this->get(route('products', ['category' => 999999]))->assertNotFound();
    }

    public function test_catalog_cards_use_database_gallery_and_single_photo_has_no_slideshow(): void
    {
        $category = Category::create(['name' => 'ARR', 'tipe' => 'produk']);
        $product = Product::create([
            'category_id' => $category->id, 'title' => 'Multi Foto', 'slug' => 'multi-foto', 'image' => 'products/main.jpg',
            'gallery_images' => ['products/second.jpg'], 'is_active' => true,
        ]);
        $response = $this->get(route('products'))->assertOk()
            ->assertSee('data-card-next', false)
            ->assertSee('products/main.jpg')
            ->assertSee('aspect-[4/3]', false);
        $document = new \DOMDocument;
        @$document->loadHTML($response->getContent());
        $card = (new \DOMXPath($document))->query('//*[@data-product-card]')->item(0);
        $this->assertSame($product->gallery_urls, json_decode($card->getAttribute('data-images'), true));
        $product->update(['gallery_images' => []]);
        $this->get(route('products'))->assertOk()->assertDontSee('data-card-next', false)->assertDontSee('data-card-pause', false);
    }

    public function test_product_navigation_opens_catalog_directly_on_desktop_and_mobile(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        $document = new \DOMDocument;
        @$document->loadHTML($html);
        $xpath = new \DOMXPath($document);
        $links = $xpath->query('//a[@data-product-nav]');
        $this->assertCount(2, $links);
        foreach ($links as $link) {
            $this->assertSame(route('products'), $link->getAttribute('href'));
            $this->assertSame(0, $xpath->query('ancestor::details', $link)->length);
        }
    }
}
