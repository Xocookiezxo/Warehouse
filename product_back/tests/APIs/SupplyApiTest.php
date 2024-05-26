<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Supply;

class SupplyApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_supply()
    {
        $supply = Supply::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/supplies', $supply
        );

        $this->assertApiResponse($supply);
    }

    /**
     * @test
     */
    public function test_read_supply()
    {
        $supply = Supply::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/supplies/'.$supply->id
        );

        $this->assertApiResponse($supply->toArray());
    }

    /**
     * @test
     */
    public function test_update_supply()
    {
        $supply = Supply::factory()->create();
        $editedSupply = Supply::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/supplies/'.$supply->id,
            $editedSupply
        );

        $this->assertApiResponse($editedSupply);
    }

    /**
     * @test
     */
    public function test_delete_supply()
    {
        $supply = Supply::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/supplies/'.$supply->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/supplies/'.$supply->id
        );

        $this->response->assertStatus(404);
    }
}
