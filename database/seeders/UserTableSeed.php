<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
	            'first_name' => 'sajib',
                'last_name' => 'mridha',
                'email' => 'sajib@gmail.com',
                'is_role' => '1',
                'password' => bcrypt(123456),
	            'created_at' => now(),
	            'updated_at' => now(),
            ],
        ]);
    }
}
