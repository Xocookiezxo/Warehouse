<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Branches;

class BranchesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_branches()
    {
        $branches = Branches::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/branches', $branches
        );

        $this->assertApiResponse($branches);
    }

    /**
     * @test
     */
    public function test_read_branches()
    {
        $branches = Branches::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/branches/'.$branches->id
        );

        $this->assertApiResponse($branches->toArray());
    }

    /**
     * @test
     */
    public function test_update_branches()
    {
        $branches = Branches::factory()->create();
        $editedBranches = Branches::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/branches/'.$branches->id,
            $editedBranches
        );

        $this->assertApiResponse($editedBranches);
    }

    /**
     * @test
     */
    public function test_delete_branches()
    {
        $branches = Branches::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/branches/'.$branches->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/branches/'.$branches->id
        );

        $this->response->assertStatus(404);
    }
}
