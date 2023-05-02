<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instructor;

class InstructorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = [
            'Julio C. Hugentobler',
            'Colin Peacock',
            'Emmanuel Guerrero',
            'Jessie Alexanderson',
            'Morgane Lashkari',
            'Stacey Duffield'
        ];

        foreach ($instructors as $instructor) {
            Instructor::create(['name' => $instructor]);
        }
    }
}
