<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_renders_successfully(): void
    {
        $response = $this->get(route('contact'));
        $response->assertStatus(200);
    }

    public function test_contact_message_can_be_submitted(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Budi Santoso',
            'company' => 'PT Sumber Makmur',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'message' => 'Saya tertarik dengan produk telemetri AWLR.',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
        ]);
    }
}
