<?php

namespace Database\Factories\V1\extras;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\extras\Inquiry>
 */
class InquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name(),
            'ticket'=>$this->faker->randomNumber(9),
            'phone'=>$this->faker->phoneNumber(),
            'email'=>$this->faker->email(),
            'body'=>$this->faker->sentences(5, true),
            'solved'=>1,
        ];
    }
}
