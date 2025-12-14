<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ProductModel;
use App\Models\StoreModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear store base
        StoreModel::factory()->create([
            'id' => 1,
            'name' => 'Simple Store',
        ]);

        // Crear productos base
        ProductModel::factory()->create([
            'id' => 1,
            'store_id' => 1,
            'name' => 'Another Product',
            'category' => 'Accessories',
            'inventory_status' => 'OUTOFSTOCK',
        ]);

        ProductModel::factory()->create([
            'id' => 2,
            'store_id' => 1,
            'name' => 'Simple Shirt',
            'description' => 'Discover effortless style with the Simple Shirt...',
            'price' => 72,
            'category' => 'Accessories',
            'inventory_status' => 'INSTOCK',
            'currency' => '€',
        ]);
    }

    public function test_get_public_products()
    {
        $response = $this->getJson('/api/products/public');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'products')
            ->assertJsonFragment([
                'inventoryStatus' => 'INSTOCK'
            ]);
    }


    public function test_get_public_products_with_textfilter()
    {
        $response = $this->getJson('/api/products/public?textfilter=Simple');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'products')
            ->assertJsonFragment([
                'name' => 'Simple Shirt'
            ]);
    }

    public function test_get_public_products_by_store()
    {
        $response = $this->getJson('/api/products/public?storeid=1');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'products');
    }

    public function test_get_public_products_with_pagination()
    {
        $response = $this->getJson('/api/products/public?page=1&pagelength=2');

        $response->assertStatus(200)
            ->assertJson([
                'totalPages' => 1
            ]);
    }

    public function test_get_public_products_by_category()
    {
        $response = $this->getJson('/api/products/public?categories=Accessories');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'products')
            ->assertJsonFragment([
                'category' => 'Accessories'
            ]);
    }
    public function test_get_products_by_store()
    {
        $response = $this->getJson('/api/stores/1/products');

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    public function test_get_products_with_store_data()
    {
        $response = $this->getJson('/api/stores/1/products?storedata=true');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'store',
                'products'
            ]);
    }

    public function test_get_product_not_found()
    {
        $response = $this->getJson('/api/stores/1/products/999');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Product or store not found'
            ]);
    }

    public function test_create_product()
    {
        $response = $this->postJson('/api/stores/1/products', [
            'name' => 'Black Watch',
            'description' => 'Product Description',
            'imageUrl' => 'black-watch.jpg',
            'price' => 72,
            'category' => 'Accessories',
            'inventoryStatus' => 'INSTOCK',
            'currency' => '€',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Black Watch'
            ]);
    }

    public function test_post_product_invalid_category_should_return_400()
    {
        $payload = [
            'name' => 'Black Watch',
            'description' => 'Product Description',
            'image_url' => 'black-watch.jpg',
            'price' => 72,
            'category' => 'error', 
            'inventory_status' => 'INSTOCK',
            'currency' => '€',
        ];

        $response = $this->postJson('/api/stores/1/products', $payload);

        $response->assertStatus(405);
    }

    public function test_post_product_invalid_inventory_status_should_return_400()
    {
        $payload = [
            'name' => 'Black Watch',
            'description' => 'Product Description',
            'image_url' => 'black-watch.jpg',
            'price' => 72,
            'category' => 'Accessories',
            'inventory_status' => 'error', 
            'currency' => '€',
        ];

        $response = $this->postJson('/api/stores/1/products', $payload);

        $response->assertStatus(405);
    }

    public function test_create_product_invalid_currency()
    {
        $response = $this->postJson('/api/stores/1/products', [
            'currency' => 'error'
        ]);

        $response->assertStatus(405);
    }

    public function test_update_product()
    {
        $response = $this->patchJson('/api/stores/1/products/2', [
            'name' => '2009'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => '2009'
            ]);
    }

    public function test_update_product_not_found()
    {

        $payload = [
            'year' => 2009
        ];

        $response = $this->patchJson('/api/stores/1/products/65b6c351179df29507b30db9', $payload);

        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'Product not found',
            ]);
    }


    public function test_delete_product()
    {
        $response = $this->deleteJson('/api/stores/1/products/2');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'deleted'
            ]);
    }
    public function test_delete_product_not_found()
{

    $response = $this->deleteJson('/api/stores/1/products/65b6c351179df29507b30db9');

    $response
        ->assertStatus(404)
        ->assertJson([
            'message' => 'Product not found',
        ]);
}

    







    
}