<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PreorderTest extends TestCase
{
    public function test_get_items(): void
    {
        $response = $this->get('/api/preorder');
        $response->assertStatus(200);
    }

    public function test_post_items(): void
    {
        $fileId = 'foobar';
        $response = $this->post('/api/preorder/items/' . $fileId);
        $response->assertStatus(200);
    }
}
