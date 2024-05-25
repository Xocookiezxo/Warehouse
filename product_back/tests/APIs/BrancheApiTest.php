<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Branche;

class BrancheApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_branche()
    {
        $branche = Branche::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/branches', $branche
        );

        $this->assertApiResponse($branche);
    }

    /**
     * @test
     */
    public function test_read_branche()
    {
        $branche = Branche::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/branches/'.$branche->id
        );

        $this->assertApiResponse($branche->toArray());
    }

    /**
     * @test
     */
    public function test_update_branche()
    {
        $branche = Branche::factory()->create();
        $editedBranche = Branche::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/branches/'.$branche->id,
            $editedBranche
        );

        $this->assertApiResponse($editedBranche);
    }

    /**
     * @test
     */
    public function test_delete_branche()
    {
        $branche = Branche::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/branches/'.$branche->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/branches/'.$branche->id
        );

        $this->response->assertStatus(404);
    }
}
