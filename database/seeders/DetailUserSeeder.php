<?php

namespace Database\Seeders;

use App\Models\DetailUser;
use Illuminate\Database\Seeder;

class DetailUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $detail_users = [
            [
                'user_id' => 1,
                'photo' => '',
                'role' => 'Backend Web Developer',
                'contact_number' => '',
                'biography' => '',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'photo' => '',
                'role' => 'UI Designer',
                'contact_number' => '',
                'biography' => '',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DetailUser::insert($detail_users);
    }
}
