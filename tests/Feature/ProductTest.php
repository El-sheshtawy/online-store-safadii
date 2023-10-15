<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_homepage_contains_non_empty_products(): void
    {
        $response = $this->get('/admin/dashboard/products');

        $response->assertDontSee('No products to show');
    }
}
