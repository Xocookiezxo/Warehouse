<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ProductCategories;

class ProductCategoriesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_product_categories()
    {
        $productCategories = ProductCategories::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/product_categories', $productCategories
        );

        $this->assertApiResponse($productCategories);
    }

    /**
     * @test
     */
    public function test_read_product_categories()
    {
        $productCategories = ProductCategories::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/product_categories/'.$productCategories->id
        );

        $this->assertApiResponse($productCategories->toArray());
    }

    /**
     * @test
     */
    public function test_update_product_categories()
    {
        $productCategories = ProductCategories::factory()->create();
        $editedProductCategories = ProductCategories::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/product_categories/'.$productCategories->id,
            $editedProductCategories
        );

        $this->assertApiResponse($editedProductCategories);
    }

    /**
     * @test
     */
    public function test_delete_product_categories()
    {
        $productCategories = ProductCategories::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/product_categories/'.$productCategories->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/product_categories/'.$productCategories->id
        );

        $this->response->assertStatus(404);
    }
}
