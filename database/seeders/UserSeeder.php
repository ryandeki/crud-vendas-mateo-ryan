<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'mateo@gmail.com',
            'senha' => bcrypt('15012009')
        ]);

    }
}