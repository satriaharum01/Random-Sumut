<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('settings')->insert([
                [
                    'id' => 1, 
                    'key' => 'site_name',
                    'value' => 'My Website'
                ],
                [
                    'id' => 2,
                    'key' => 'site_email', 
                    'value' => 'admin@example.com'
                ],
                [
                    'id' => 3,
                    'key' => 'site_phone',
                    'value' => '+62 812-3456-7890'
                ],
                [
                    'id' => 4,
                    'key' => 'site_address',
                    'value' => 'Jl. Contoh No. 123'
                ],
                [
                    'id' => 5,
                    'key' => 'site_description',
                    'value' => 'Website Description'
                ],
                [
                    'id' => 6,
                    'key' => 'facebook_url',
                    'value' => 'https://facebook.com'
                ],
                [
                    'id' => 7,
                    'key' => 'twitter_url',
                    'value' => 'https://twitter.com'
                ],
                [
                    'id' => 8,
                    'key' => 'instagram_url',
                    'value' => 'https://instagram.com'
                ],
        ]);
    }
}
