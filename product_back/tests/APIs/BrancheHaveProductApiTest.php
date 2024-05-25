<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\BrancheHaveProduct;

class BrancheHaveProductApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_branche_have_product()
    {
        $brancheHaveProduct = BrancheHaveProduct::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/branche_have_products', $brancheHaveProduct
        );

        $this->assertApiResponse($brancheHaveProduct);
    }

    /**
     * @test
     */
    public function test_read_branche_have_product()
    {
        $brancheHaveProduct = BrancheHaveProduct::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/branche_have_products/'.$brancheHaveProduct->id
        );

        $this->assertApiResponse($brancheHaveProduct->toArray());
    }

    /**
     * @test
     */
    public function test_update_branche_have_product()
    {
        $brancheHaveProduct = BrancheHaveProduct::factory()->create();
        $editedBrancheHaveProduct = BrancheHaveProduct::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/branche_have_products/'.$brancheHaveProduct->id,
            $editedBrancheHaveProduct
        );

        $this->assertApiResponse($editedBrancheHaveProduct);
    }

    /**
     * @test
     */
    public function test_delete_branche_have_product()
    {
        $brancheHaveProduct = BrancheHaveProduct::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/branche_have_products/'.$brancheHaveProduct->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/branche_have_products/'.$brancheHaveProduct->id
        );

        $this->response->assertStatus(404);
    }
}
