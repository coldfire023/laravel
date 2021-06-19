<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        User::create([
            'name'=>'admin Bahadur',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('admin123')
        ]);

        User::create([
            'name'=>'shyam Bahadur',
            'email'=>'shyam@gmail.com',
            'password'=>Hash::make('shyam123')
        ]);


    }
}
