<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat admin manual
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mocha.com',
            'phone' => '0000000000',
            'address' => 'System',
            'password' => bcrypt('admin123'),
            'role' => 'admin'
        ]);

        // Buat 10 customer pakai factory
        User::factory(10)->create();
    }
}
