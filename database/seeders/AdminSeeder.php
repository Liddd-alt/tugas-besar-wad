<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@lostfound.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '0xxxxx',
            'nim' => '0xxxxx',
            'address' => 'Telkom University',
        ]);
    }
}