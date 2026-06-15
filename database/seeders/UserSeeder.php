<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superadminRole = Role::create(['name' => 'superadmin', 'guard_name' => 'web']);
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $editorRole = Role::create(['name' => 'editor', 'guard_name' => 'web']);

        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@smkn2pekanbaru.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
            'is_active' => true,
        ]);
        $superadmin->assignRole($superadminRole);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin2@smkn2pekanbaru.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);
        $admin->assignRole($adminRole);

        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@smkn2pekanbaru.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'is_active' => true,
        ]);
        $editor->assignRole($editorRole);
    }
}
