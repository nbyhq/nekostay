<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cat_id' => Cat::inRandomOrder()->first()?->id ?? Cat::factory(),
            'type' => $this->faker->randomElement(['vaccine', 'deworm', 'sterilization', 'checkup', 'other']),
            'description' => $this->faker->sentence(15),
            'treated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'vet_name' => 'Dr. ' . $this->faker->lastName(),
        ];
    }
}
