<?php

namespace Database\Seeders;

use App\Models\AdminSekolah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        AdminSekolah::create([
            'nama'     => 'Admin PPDB',
            'no_hp'    => '081234567890',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
    }
}
