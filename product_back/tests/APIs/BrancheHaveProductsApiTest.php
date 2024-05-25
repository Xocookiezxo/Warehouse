<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\BrancheHaveProducts;

class BrancheHaveProductsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_branche_have_products()
    {
        $brancheHaveProducts = BrancheHaveProducts::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/branche_have_products', $brancheHaveProducts
        );

        $this->assertApiResponse($brancheHaveProducts);
    }

    /**
     * @test
     */
    public function test_read_branche_have_products()
    {
        $brancheHaveProducts = BrancheHaveProducts::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/branche_have_products/'.$brancheHaveProducts->id
        );

        $this->assertApiResponse($brancheHaveProducts->toArray());
    }

    /**
     * @test
     */
    public function test_update_branche_have_products()
    {
        $brancheHaveProducts = BrancheHaveProducts::factory()->create();
        $editedBrancheHaveProducts = BrancheHaveProducts::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/branche_have_products/'.$brancheHaveProducts->id,
            $editedBrancheHaveProducts
        );

        $this->assertApiResponse($editedBrancheHaveProducts);
    }

    /**
     * @test
     */
    public function test_delete_branche_have_products()
    {
        $brancheHaveProducts = BrancheHaveProducts::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/branche_have_products/'.$brancheHaveProducts->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/branche_have_products/'.$brancheHaveProducts->id
        );

        $this->response->assertStatus(404);
    }
}
