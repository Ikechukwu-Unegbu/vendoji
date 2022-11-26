<?php

namespace Database\Factories\V1\extras;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\extras\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'answer'=>$this->faker->sentences(5, true),
            'question'=>$this->faker->sentence(6)
        ];
    }
}
