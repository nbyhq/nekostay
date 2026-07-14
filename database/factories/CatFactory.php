<?php
namespace Database\Factories;
use App\Models\Cat;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends Factory<Cat>
 */
class CatFactory extends Factory
{
    public function definition(): array
    {
        $names = ['Miso', 'Luna', 'Midnight', 'Cloud', 'Peaches', 'Mochi', 'Simba', 'Cali', 'Oliver', 'Patches', 'Miko', 'Nala', 'Ginger', 'Shadow', 'Snowy'];
        $breeds = ['Domestic Shorthair', 'Ginger Tabby', 'British Shorthair', 'Bombay', 'Persian', 'Calico', 'Siamese', 'Scottish Fold', 'Calico Mix'];
        $colors = ['Orange', 'White', 'Black', 'Gray', 'Cream', 'Brown Tabby'];

        $photoIndex = $this->faker->numberBetween(1, 15);

        return [
            'name' => $this->faker->randomElement($names),
            'breed' => $this->faker->randomElement($breeds),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'age_estimate' => $this->faker->randomElement(['2 months', '6 months', '1 year', '2 years', '4 years']),
            'color' => $this->faker->randomElement($colors),
            'status' => $this->faker->randomElement(['rescued', 'in_treatment', 'ready_for_adoption', 'adopted']),
            'rescue_location' => $this->faker->streetName(),
            'photo' => 'images/seed-cats/cat-' . $photoIndex . '.jpg',
            'description' => $this->faker->sentence(12),
        ];
    }
}
