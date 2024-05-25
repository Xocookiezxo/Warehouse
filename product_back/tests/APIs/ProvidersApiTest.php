<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Providers;

class ProvidersApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_providers()
    {
        $providers = Providers::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/providers', $providers
        );

        $this->assertApiResponse($providers);
    }

    /**
     * @test
     */
    public function test_read_providers()
    {
        $providers = Providers::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/providers/'.$providers->id
        );

        $this->assertApiResponse($providers->toArray());
    }

    /**
     * @test
     */
    public function test_update_providers()
    {
        $providers = Providers::factory()->create();
        $editedProviders = Providers::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/providers/'.$providers->id,
            $editedProviders
        );

        $this->assertApiResponse($editedProviders);
    }

    /**
     * @test
     */
    public function test_delete_providers()
    {
        $providers = Providers::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/providers/'.$providers->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/providers/'.$providers->id
        );

        $this->response->assertStatus(404);
    }
}
