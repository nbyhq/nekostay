<?php

namespace Database\Seeders;

use App\Models\Adoption;
use Illuminate\Database\Seeder;

class AdoptionSeeder extends Seeder
{
    public function run(): void
    {
        Adoption::factory(15)->create();
    }
}
