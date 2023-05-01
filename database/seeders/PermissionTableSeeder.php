<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'itinerancy-list',
            'itinerancy-create',
            'itinerancy-edit',
            'itinerancy-delete',
            'evaluation-list',
            'evaluation-create',
            'evaluation-edit',
            'evaluation-delete',
            'student-list',
            'student-create',
            'student-edit',
            'student-delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
