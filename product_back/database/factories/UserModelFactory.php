<?php

namespace Database\Factories;

use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'register' => $this->faker->word,
        'ovog' => $this->faker->word,
        'name' => $this->faker->word,
        'branch_id' => $this->faker->word,
        'phone' => $this->faker->word,
        'username' => $this->faker->word,
        'password' => $this->faker->word,
        'roles' => $this->faker->word,
        'remember_token' => $this->faker->word,
        'push_token' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
