<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Belt;


class BeltsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $belts = [
            'White',
            'Yellow',
            'Orange',
            'Green',
            'Grey',
            'Blue',
            'Red'
        ];

        foreach ($belts as $belt) {
            Belt::create(['name' => $belt]);
        }
    }
}
