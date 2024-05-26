<?php

namespace Database\Factories;

use App\Models\SupplyProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplyProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SupplyProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'supply_id' => $this->faker->word,
        'product_id' => $this->faker->word,
        'expected_count' => $this->faker->randomDigitNotNull,
        'pcount' => $this->faker->randomDigitNotNull,
        'description' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
