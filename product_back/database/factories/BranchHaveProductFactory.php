<?php

namespace Database\Factories;

use App\Models\BranchHaveProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchHaveProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BranchHaveProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'branch_id' => $this->faker->word,
        'product_id' => $this->faker->word,
        'pcount' => $this->faker->randomDigitNotNull,
        'reg_type' => $this->faker->word,
        'user_id' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
