<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ShortUrl;

class shorturlTest extends TestCase
{
    use RefreshDatabase;

    public function test_shorten_valid_url()
    {
        $response = $this->postJson('/api/shorten', ['url' => 'https://laravel.com']);
        $response->assertStatus(200)->assertJsonStructure(['short_url']);
    }

    public function test_invalid_url_is_rejected()
    {
        $response = $this->postJson('/api/shorten', ['url' => 'invalid-url']);
        $response->assertStatus(422);
    }

    public function test_redirect_and_hits_increment()
    {
        $short = ShortUrl::create([
            'original_url' => 'https://laravel.com',
            'short_code' => 'lar123',
            'jumlah_akses' => 0
        ]);

        $this->get('/lar123')->assertRedirect('https://laravel.com');
        $this->assertDatabaseHas('short_urls', ['short_code' => 'lar123', 'jumlah_akses' => 1]);
    }
}

