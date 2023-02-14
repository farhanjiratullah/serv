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
        $users = [
            [
                'name' => 'Farhan Jiratullah',
                'email' => 'farhanjiratullah794@gmail.com',
                'password' => Hash::make('googleplaystore'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Alrelianos Inoky Raisyad',
                'email' => 'inoky@gmail.com',
                'password' => Hash::make('googleplaystore'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        User::insert($users);
    }
}
