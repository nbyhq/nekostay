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
        $visitDate = $this->faker->dateTimeBetween('-6 months', 'now');
        $hasNextVisit = $this->faker->boolean(40);

        return [
            'cat_id' => Cat::inRandomOrder()->first()?->id ?? Cat::factory(),
            'visit_date' => $visitDate,
            'next_visit_date' => $hasNextVisit ? $this->faker->dateTimeBetween('now', '+2 months') : null,
            'next_visit_note' => $hasNextVisit ? $this->faker->randomElement(['Booster vaccine', 'Follow-up checkup', 'Sterilization follow-up']) : null,
            'doctor' => 'Dr. ' . $this->faker->lastName(),
            'diagnosis' => $this->faker->randomElement(['Healthy check-up', 'Mild flu symptoms', 'Skin infection', 'Parasite infestation', 'Post-surgery recovery']),
            'treatment' => $this->faker->randomElement(['Vaccination', 'Deworming', 'Antibiotics', 'Sterilization', 'Wound cleaning']),
            'notes' => $this->faker->sentence(12),
            'weight' => $this->faker->randomFloat(1, 1.5, 6.5),
            'temperature' => $this->faker->randomFloat(1, 37.5, 39.5),
            'status' => $this->faker->randomElement(['Healthy', 'Treatment', 'Recovery']),
        ];
    }
}
