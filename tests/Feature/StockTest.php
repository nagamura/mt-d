<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockTest extends TestCase
{
    public function test_post_items(): void
    {
        $response = $this->post('/api/stock/items');
        $response->assertStatus(200);
    }

    public function test_patch_items(): void
    {
        $response = $this->patch('/api/stock/items');
        $response->assertStatus(200);
    }

    public function test_post_posts(): void
    {
        $response = $this->post('/api/stock/posts');
        $response->assertStatus(200);
    }

    public function test_post_notify(): void
    {
        $response = $this->post('/api/stock/notify');
        $response->assertStatus(200);
    }
}
