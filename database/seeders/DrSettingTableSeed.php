<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrSettingTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dr_settings')->insert([
            [
	            'title' => 'Driving School',
                'mobile_no' => '01641122236',
                'phone_no' => '01641122236, 01641122237',
                'email' => 'info@drivingschool.com',
                'address' => 'Pl, London NW1 The United of Rochester Kingdom',
	            'facebook_link' => '',
	            'instagram_link' => '',
	            'pinterest_link' => '',
	            'linkedin_link' => '',
	            'twitter_link' => '',
	            'youtube_link' => '',
	            'created_at' => now(),
	            'updated_at' => now(),
            ],
        ]);
    }
}
