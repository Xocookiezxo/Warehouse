<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Gender;

class GenderApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_gender()
    {
        $gender = Gender::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/genders', $gender
        );

        $this->assertApiResponse($gender);
    }

    /**
     * @test
     */
    public function test_read_gender()
    {
        $gender = Gender::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/genders/'.$gender->id
        );

        $this->assertApiResponse($gender->toArray());
    }

    /**
     * @test
     */
    public function test_update_gender()
    {
        $gender = Gender::factory()->create();
        $editedGender = Gender::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/genders/'.$gender->id,
            $editedGender
        );

        $this->assertApiResponse($editedGender);
    }

    /**
     * @test
     */
    public function test_delete_gender()
    {
        $gender = Gender::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/genders/'.$gender->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/genders/'.$gender->id
        );

        $this->response->assertStatus(404);
    }
}
