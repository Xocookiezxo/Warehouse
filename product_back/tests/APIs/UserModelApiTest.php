<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserModel;

class UserModelApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_model()
    {
        $userModel = UserModel::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/user_models', $userModel
        );

        $this->assertApiResponse($userModel);
    }

    /**
     * @test
     */
    public function test_read_user_model()
    {
        $userModel = UserModel::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/user_models/'.$userModel->id
        );

        $this->assertApiResponse($userModel->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_model()
    {
        $userModel = UserModel::factory()->create();
        $editedUserModel = UserModel::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/user_models/'.$userModel->id,
            $editedUserModel
        );

        $this->assertApiResponse($editedUserModel);
    }

    /**
     * @test
     */
    public function test_delete_user_model()
    {
        $userModel = UserModel::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/user_models/'.$userModel->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/user_models/'.$userModel->id
        );

        $this->response->assertStatus(404);
    }
}
