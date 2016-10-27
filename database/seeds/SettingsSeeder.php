<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert(['key' => 'fbAppId']);
        DB::table('settings')->insert(['key' => 'fbAppToken']);
        DB::table('settings')->insert(['key' => 'fbAppSec']);
    }
}
