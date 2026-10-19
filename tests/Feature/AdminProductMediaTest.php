<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Admin\Contracts\ProductRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class AdminProductMediaTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->category = Category::create(['name' => 'Perangkat Telemetri', 'tipe' => 'produk']);
        $this->actingAs(User::create(['name' => 'Admin', 'email' => 'media@example.test', 'password' => 'password']));
    }

    private function payload(array $overrides = []): array
    {
        return array_merge(['category_id' => $this->category->id, 'title' => 'Produk Dinamis', 'is_active' => '1'], $overrides);
    }

    private function product(array $overrides = []): Product
    {
        return Product::create($this->payload(array_merge(['slug' => 'produk-dinamis'], $overrides)));
    }

    public function test_admin_forms_offer_multiple_photos_and_pdf_upload(): void
    {
        $this->get(route('admin.products.create'))->assertOk()
            ->assertSee('name="is_active" value="1"', false)
            ->assertSee('name="gallery_images[]"', false)
            ->assertSee('multiple', false)
            ->assertSee('name="brochure"', false);
        $product = $this->product(['gallery_images' => ['products/photo.jpg'], 'brochure' => 'products/brochures/old.pdf', 'is_active' => false]);
        $this->get(route('admin.products.edit', $product))->assertOk()
            ->assertSee('name="is_active" value="0"', false)
            ->assertSee('products/photo.jpg')
            ->assertSee('Unduh brosur saat ini');
    }

    public function test_admin_can_create_product_with_five_photos_and_pdf(): void
    {
        $this->post(route('admin.products.store'), $this->payload([
            'image' => UploadedFile::fake()->image('main.jpg'),
            'gallery_images' => array_map(fn ($i) => UploadedFile::fake()->image("photo-$i.png"), range(1, 4)),
            'brochure' => UploadedFile::fake()->create('brochure.pdf', 100, 'application/pdf'),
        ]))->assertRedirect(route('admin.products.index'))->assertSessionHasNoErrors();

        $product = Product::firstOrFail();
        $this->assertCount(4, $product->gallery_images);
        $this->assertCount(5, $product->gallery_urls);
        Storage::disk('public')->assertExists([$product->image, ...$product->gallery_images, $product->brochure]);
        $this->get(route('products.show', $product->slug))->assertOk()
            ->assertSee($product->brochure_url, false)->assertSee('Unduh Brosur');
    }

    public function test_uploading_only_gallery_automatically_sets_first_photo_as_main(): void
    {
        $this->post(route('admin.products.store'), $this->payload([
            'gallery_images' => [UploadedFile::fake()->image('first.jpg'), UploadedFile::fake()->image('second.jpg')],
        ]))->assertSessionHasNoErrors();

        $product = Product::firstOrFail();
        $this->assertNotNull($product->image);
        $this->assertCount(1, $product->gallery_images);
        $this->assertCount(2, $product->gallery_urls);
    }

    public function test_editing_text_preserves_existing_media_and_legacy_image(): void
    {
        $product = $this->product(['image' => 'images/products/legacy.png', 'gallery_images' => ['products/extra.jpg'], 'brochure' => 'products/brochures/old.pdf']);
        Storage::disk('public')->put('products/extra.jpg', 'old photo');
        Storage::disk('public')->put('products/brochures/old.pdf', 'old brochure');

        $this->put(route('admin.products.update', $product), $this->payload(['title' => 'Judul Baru']))
            ->assertSessionHasNoErrors();

        $product->refresh();
        $this->assertSame('images/products/legacy.png', $product->image);
        $this->assertSame(['products/extra.jpg'], $product->gallery_images);
        $this->assertSame('products/brochures/old.pdf', $product->brochure);
        $this->assertSame(asset('images/products/legacy.png'), $product->gallery_urls[0]);
        Storage::disk('public')->assertExists(['products/extra.jpg', 'products/brochures/old.pdf']);
    }

    public function test_replacing_media_removes_old_files_and_keeps_retained_photos(): void
    {
        $product = $this->product(['image' => 'products/old.jpg', 'gallery_images' => ['products/remove.jpg', 'products/keep.jpg'], 'brochure' => 'products/brochures/old.pdf']);
        foreach ([$product->image, ...$product->gallery_images, $product->brochure] as $path) {
            Storage::disk('public')->put($path, 'old file');
        }

        $this->put(route('admin.products.update', $product), $this->payload([
            'image' => UploadedFile::fake()->image('new.jpg'),
            'gallery_images' => [UploadedFile::fake()->image('extra.jpg')],
            'remove_gallery_images' => ['products/remove.jpg'],
            'brochure' => UploadedFile::fake()->create('new.pdf', 100, 'application/pdf'),
        ]))->assertSessionHasNoErrors();

        $product->refresh();
        Storage::disk('public')->assertMissing(['products/old.jpg', 'products/remove.jpg', 'products/brochures/old.pdf']);
        Storage::disk('public')->assertExists([$product->image, ...$product->gallery_images, $product->brochure]);
        $this->assertContains('products/keep.jpg', $product->gallery_images);
    }

    public function test_media_can_be_removed_explicitly_and_gallery_photo_becomes_main(): void
    {
        $product = $this->product(['image' => 'products/old.jpg', 'gallery_images' => ['products/next.jpg'], 'brochure' => 'products/brochures/old.pdf']);
        foreach ([$product->image, ...$product->gallery_images, $product->brochure] as $path) {
            Storage::disk('public')->put($path, 'file');
        }
        $this->put(route('admin.products.update', $product), $this->payload(['remove_image' => '1', 'remove_brochure' => '1']))
            ->assertSessionHasNoErrors();
        $product->refresh();
        $this->assertSame('products/next.jpg', $product->image);
        $this->assertSame([], $product->gallery_images);
        $this->assertNull($product->brochure);
        Storage::disk('public')->assertMissing(['products/old.jpg', 'products/brochures/old.pdf']);
        Storage::disk('public')->assertExists('products/next.jpg');
    }

    public function test_photo_limit_includes_retained_photos_and_rejects_before_storing_uploads(): void
    {
        $product = $this->product(['image' => 'products/main.jpg', 'gallery_images' => ['products/1.jpg', 'products/2.jpg', 'products/3.jpg', 'products/4.jpg']]);
        $this->put(route('admin.products.update', $product), $this->payload([
            'gallery_images' => [UploadedFile::fake()->image('sixth.jpg')],
        ]))->assertSessionHasErrors('gallery_images');
        $this->assertSame([], Storage::disk('public')->allFiles());
        $this->assertCount(4, $product->fresh()->gallery_images);
    }

    public function test_upload_sizes_and_pdf_content_are_validated(): void
    {
        $this->post(route('admin.products.store'), $this->payload([
            'image' => UploadedFile::fake()->image('large.jpg')->size(2049),
            'gallery_images' => [UploadedFile::fake()->image('large.png')->size(2049)],
            'brochure' => UploadedFile::fake()->create('large.pdf', 5121, 'application/pdf'),
        ]))->assertSessionHasErrors(['image', 'gallery_images.0', 'brochure']);
        $this->post(route('admin.products.store'), $this->payload([
            'image' => UploadedFile::fake()->image('executable.php'),
            'brochure' => UploadedFile::fake()->create('fake.pdf', 100, 'text/plain'),
        ]))->assertSessionHasErrors(['image', 'brochure']);
        $this->assertSame(0, Product::count());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_replacing_specific_gallery_photo_keeps_its_position(): void
    {
        $product = $this->product(['image' => 'products/main.jpg', 'gallery_images' => ['products/1.jpg', 'products/2.jpg', 'products/3.jpg', 'products/4.jpg']]);
        foreach ([$product->image, ...$product->gallery_images] as $path) {
            Storage::disk('public')->put($path, 'old file');
        }

        $this->put(route('admin.products.update', $product), $this->payload([
            'replace_gallery_images' => [2 => UploadedFile::fake()->image('new-third.jpg')],
            'remove_gallery_images' => ['products/4.jpg'],
            'gallery_images' => [UploadedFile::fake()->image('extra.jpg')],
        ]))->assertSessionHasNoErrors();

        $gallery = $product->fresh()->gallery_images;
        $this->assertCount(4, $gallery);
        $this->assertSame(['products/1.jpg', 'products/2.jpg'], array_slice($gallery, 0, 2));
        $this->assertNotSame('products/3.jpg', $gallery[2]);
        Storage::disk('public')->assertExists($gallery);
        Storage::disk('public')->assertMissing(['products/3.jpg', 'products/4.jpg']);
    }

    public function test_cannot_replace_gallery_photo_outside_current_gallery(): void
    {
        $product = $this->product(['gallery_images' => ['products/own.jpg']]);
        $this->put(route('admin.products.update', $product), $this->payload([
            'replace_gallery_images' => [5 => UploadedFile::fake()->image('ghost.jpg')],
        ]))->assertSessionHasErrors('replace_gallery_images');
        $this->assertSame(['products/own.jpg'], $product->fresh()->gallery_images);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_brochure_downloads_named_after_product_title(): void
    {
        $this->post(route('admin.products.store'), $this->payload([
            'title' => 'Sensor AWLR 2026',
            'brochure' => UploadedFile::fake()->create('random-upload.pdf', 100, 'application/pdf'),
        ]))->assertSessionHasNoErrors();

        $product = Product::firstOrFail();
        $this->get(route('products.show', $product->slug))->assertOk()
            ->assertSee('download="Brosur Sensor AWLR 2026.pdf"', false);

        $product->update(['title' => 'Sensor: AWLR/Pro']);
        $this->assertSame('Brosur Sensor AWLR Pro.pdf', $product->brochure_download_name);
    }

    public function test_cannot_remove_another_products_media(): void
    {
        $product = $this->product(['gallery_images' => ['products/own.jpg']]);
        $this->put(route('admin.products.update', $product), $this->payload([
            'remove_gallery_images' => ['products/another-product.jpg'],
        ]))->assertSessionHasErrors('remove_gallery_images.0');
        $this->assertSame(['products/own.jpg'], $product->fresh()->gallery_images);
    }

    public function test_failed_database_save_cleans_new_uploads(): void
    {
        $repository = Mockery::mock(ProductRepositoryInterface::class);
        $repository->shouldReceive('create')->once()->andThrow(new RuntimeException('Simulated save failure'));
        $this->app->instance(ProductRepositoryInterface::class, $repository);
        $this->withoutExceptionHandling();
        try {
            $this->post(route('admin.products.store'), $this->payload([
                'image' => UploadedFile::fake()->image('new.jpg'),
                'brochure' => UploadedFile::fake()->create('new.pdf', 100, 'application/pdf'),
            ]));
            $this->fail('Expected save failure.');
        } catch (RuntimeException $exception) {
            $this->assertSame('Simulated save failure', $exception->getMessage());
        }
        $this->assertSame([], Storage::disk('public')->allFiles());
        $this->assertSame(0, Product::count());
    }

    public function test_product_delete_cleans_media_but_preserves_shared_uploads(): void
    {
        $product = $this->product(['image' => 'products/shared.jpg', 'gallery_images' => ['products/own.jpg'], 'brochure' => 'products/brochures/own.pdf']);
        $this->product(['slug' => 'other-product', 'image' => 'products/shared.jpg']);
        foreach ([$product->image, ...$product->gallery_images, $product->brochure] as $path) {
            Storage::disk('public')->put($path, 'file');
        }
        $this->delete(route('admin.products.destroy', $product))->assertRedirect(route('admin.products.index'));
        $this->assertModelMissing($product);
        Storage::disk('public')->assertMissing(['products/own.jpg', 'products/brochures/own.pdf']);
        Storage::disk('public')->assertExists('products/shared.jpg');
    }

    public function test_failed_update_preserves_old_media_and_cleans_replacement_uploads(): void
    {
        $product = $this->product(['image' => 'products/old.jpg', 'brochure' => 'products/brochures/old.pdf']);
        Storage::disk('public')->put($product->image, 'old image');
        Storage::disk('public')->put($product->brochure, 'old PDF');
        $repository = Mockery::mock(ProductRepositoryInterface::class);
        $repository->shouldReceive('update')->once()->andThrow(new RuntimeException('Simulated update failure'));
        $this->app->instance(ProductRepositoryInterface::class, $repository);
        $this->withoutExceptionHandling();
        try {
            $this->put(route('admin.products.update', $product), $this->payload([
                'image' => UploadedFile::fake()->image('new.jpg'),
                'brochure' => UploadedFile::fake()->create('new.pdf', 100, 'application/pdf'),
            ]));
            $this->fail('Expected update failure.');
        } catch (RuntimeException $exception) {
            $this->assertSame('Simulated update failure', $exception->getMessage());
        }
        $this->assertSame('products/old.jpg', $product->fresh()->image);
        Storage::disk('public')->assertExists(['products/old.jpg', 'products/brochures/old.pdf']);
        $this->assertCount(2, Storage::disk('public')->allFiles());
    }

    public function test_guest_cannot_upload_product_media(): void
    {
        auth()->logout();
        $this->post(route('admin.products.store'), $this->payload([
            'image' => UploadedFile::fake()->image('main.jpg'),
        ]))->assertRedirect(route('login'));
        $this->assertSame([], Storage::disk('public')->allFiles());
    }
}
