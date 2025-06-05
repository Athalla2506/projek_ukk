<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role Admin jika belum ada
        if (!\Spatie\Permission\Models\Role::where('name', 'super_admin')->exists()) {
            \Spatie\Permission\Models\Role::create(['name' => 'super_admin']);
        }

        // Buat user Admin jika belum ada
        if (!\App\Models\User::where('email')) {
            \App\Models\User::create([
                'name' => 'super_admin',
                'email' => 'super_admin@gmail.com',
                'password' => bcrypt('12345'),
            ])->assignRole('super_admin');
            
    }
}
}