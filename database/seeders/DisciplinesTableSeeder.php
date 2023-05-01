<?php

namespace Database\Seeders;

use App\Models\Discipline;
use Illuminate\Database\Seeder;

class DisciplinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $disciplines = [
            'Archery',
            'Acrobatics',
            'Edged Weapons',
            'Martial Art',
            'Pa Kua Chi',
            'Pa Kua Rhythm',
            'Tai Chi',
            'Sintony',
        ];

        foreach ($disciplines as $discipline) {
            Discipline::create(['name' => $discipline]);
        }
    }
}
