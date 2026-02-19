<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Sigma',
            'email' => 'sigma@example.com',
            'password' => bcrypt('Allowme@1'),
        ]);
    }
}
