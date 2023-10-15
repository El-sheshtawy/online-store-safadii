<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->truncate();
        User::create([
            'name'=>'Mohamed Mostafa',
            'email'=>'ramyalfe22@gmail.com',
            'password'=>Hash::make('password'),
            'phone_number'=>'0102526',
        ]);

        DB::table('users')->insert([
            'name'=>'Elsheshtawy',
            'email'=>'ramyalfe@gmail.com',
            'password'=>Hash::make('password'),
            'phone_number'=>'01025267',
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
    }
}
