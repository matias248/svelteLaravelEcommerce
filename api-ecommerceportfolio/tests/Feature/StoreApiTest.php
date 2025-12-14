<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\StoreModel;


class StoreApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        StoreModel::factory()->create([
            'id' => 1,
            'name' => 'Simple Store',
            'street_number' => '0',
            'street_name' => 'Street Name',
            'city' => 'Simple City D.C',
            'state' => 'Simple Country',
            'zip_code' => '31000',
            'latitude' => 1,
            'longitude' => 2,
            'contact_phone' => '+33 123456',
            'image_url' => '/store1.jpeg',
        ]);

        StoreModel::factory()->create([
            'id' => 2,
            'name' => 'Another Store',
            'street_number' => '0',
            'street_name' => 'Street Name',
            'city' => 'another City D.C',
            'state' => 'Another Country',
            'zip_code' => '31000',
            'latitude' => 1,
            'longitude' => 2,
            'contact_phone' => '+33 123456',
            'image_url' => '/store1.jpeg',
        ]);
    }

    /** -------------------------
     * GET /stores
     * ------------------------ */
    public function test_get_stores_returns_200()
    {
        $response = $this->getJson('/api/stores');

        $response
            ->assertStatus(200)
            ->assertJsonCount(2);
    }
      public function test_get_stores_with_textfilter()
    {
        $response = $this->getJson('/api/stores?textfilter=Simple');

        $response
            ->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'name' => 'Simple Store',
            ]);
    }
      /** -------------------------
     * GET /stores/{id}
     * ------------------------ */
    public function test_get_store_by_id_returns_200()
    {
        $response = $this->getJson('/api/stores/2');

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => 2,
            ]);
    }

    public function test_get_store_by_id_returns_404()
    {
        $response = $this->getJson('/api/stores/999');

        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'Store not found',
            ]);
    }

     /** -------------------------
     * POST /stores
     * ------------------------ */
    public function test_can_create_store()
    {
        $payload = [
            'name' => 'Black Watch',
            'imageUrl' => 'black-watch.jpg',
            'address' => [
                'streetNumber' => '1',
                'streetName' => 'Street Name',
                'city' => 'City',
                'state' => 'State',
                'zipCode' => '31000',
            ],
            'location' => [
                'longitude' => 1,
                'latitude' => 1,
            ],
            'contactPhone' => '+33 90',
        ];

        $response = $this->postJson('/api/stores', $payload);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Black Watch',
            ]);

        $this->assertDatabaseHas('stores', [
            'name' => 'Black Watch',
        ]);
    }

       /** -------------------------
     * PATCH /stores/{id}
     * ------------------------ */
    public function test_can_update_store()
    {
        $response = $this->patchJson('/api/stores/1', [
            'name' => '2009',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => 1,
                'name' => '2009',
                'address' => [
                    'streetNumber' => '0',
                    'streetName' => 'Street Name',
                    'city' => 'Simple City D.C',
                    'state' => 'Simple Country',
                    'zipCode' => '31000',
                ],
                'location' => [
                    'latitude' => 1,
                    'longitude' => 2,
                ],
                'contactPhone' => '+33 123456',
                'imageUrl' => '/store1.jpeg',
            ]);
    }

    public function test_update_store_returns_404()
    {
        $response = $this->patchJson('/api/stores/999', [
            'name' => '2009',
        ]);

        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'Store not found',
            ]);
    }

      /** -------------------------
     * DELETE /stores/{id}
     * ------------------------ */
    public function test_can_delete_store()
    {
        $response = $this->deleteJson('/api/stores/2');

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'store deleted',
            ]);
    }

    public function test_delete_store_returns_404()
    {
        $response = $this->deleteJson('/api/stores/999');

        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'Store not found',
            ]);
    }
}
