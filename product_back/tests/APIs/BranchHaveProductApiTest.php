<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\BranchHaveProduct;

class BranchHaveProductApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_branch_have_product()
    {
        $branchHaveProduct = BranchHaveProduct::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/branch_have_products', $branchHaveProduct
        );

        $this->assertApiResponse($branchHaveProduct);
    }

    /**
     * @test
     */
    public function test_read_branch_have_product()
    {
        $branchHaveProduct = BranchHaveProduct::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/branch_have_products/'.$branchHaveProduct->id
        );

        $this->assertApiResponse($branchHaveProduct->toArray());
    }

    /**
     * @test
     */
    public function test_update_branch_have_product()
    {
        $branchHaveProduct = BranchHaveProduct::factory()->create();
        $editedBranchHaveProduct = BranchHaveProduct::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/branch_have_products/'.$branchHaveProduct->id,
            $editedBranchHaveProduct
        );

        $this->assertApiResponse($editedBranchHaveProduct);
    }

    /**
     * @test
     */
    public function test_delete_branch_have_product()
    {
        $branchHaveProduct = BranchHaveProduct::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/branch_have_products/'.$branchHaveProduct->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/branch_have_products/'.$branchHaveProduct->id
        );

        $this->response->assertStatus(404);
    }
}
