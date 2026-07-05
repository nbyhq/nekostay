<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\Adoption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Adoption>
 */
class AdoptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cat_id' => Cat::inRandomOrder()->first()?->id ?? Cat::factory(),
            'adopter_name' => $this->faker->name(),
            'adopter_phone' => $this->faker->numerify('(###) ###-####'),
            'adopter_address' => $this->faker->address(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'notes' => $this->faker->optional()->sentence(10),
        ];
    }
}
