<?php

namespace Database\Factories;

use App\Models\Extra;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExtraValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->city
        ];
    }
}
