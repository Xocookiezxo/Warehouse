<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SupplyProduct;

class SupplyProductApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_supply_product()
    {
        $supplyProduct = SupplyProduct::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/supply_products', $supplyProduct
        );

        $this->assertApiResponse($supplyProduct);
    }

    /**
     * @test
     */
    public function test_read_supply_product()
    {
        $supplyProduct = SupplyProduct::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/supply_products/'.$supplyProduct->id
        );

        $this->assertApiResponse($supplyProduct->toArray());
    }

    /**
     * @test
     */
    public function test_update_supply_product()
    {
        $supplyProduct = SupplyProduct::factory()->create();
        $editedSupplyProduct = SupplyProduct::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/supply_products/'.$supplyProduct->id,
            $editedSupplyProduct
        );

        $this->assertApiResponse($editedSupplyProduct);
    }

    /**
     * @test
     */
    public function test_delete_supply_product()
    {
        $supplyProduct = SupplyProduct::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/supply_products/'.$supplyProduct->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/supply_products/'.$supplyProduct->id
        );

        $this->response->assertStatus(404);
    }
}
