<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::query()->create([
            'role_id' => 1,
            'email' => 'admin123@gmail.com',
            'status' => 1,
            'password' => Hash::make('admin123!'),
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
    }
}
