<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array {
        $name = $this->faker->text(50);
        return [
            'name' => $name,
            'short_description' => $this->faker->realText(),
            'long_description' => $this->faker->realText(500),
            'product_image' => $this
                ->faker
                ->image('storage/app/public/products', 640, 480, null, false, true, $this->faker->word),
        ];
    }
}
