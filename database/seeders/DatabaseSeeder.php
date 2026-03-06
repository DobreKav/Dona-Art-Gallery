<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Македонка Димова',
            'email' => 'admin@donaart.mk',
            'password' => \Illuminate\Support\Facades\Hash::make('dona2026'),
        ]);
    }
}
