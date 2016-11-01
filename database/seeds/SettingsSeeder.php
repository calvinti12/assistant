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
        DB::table('settings')->insert(['key' => 'words']);
        DB::table('settings')->insert(['key' => 'urls']);
        DB::table('settings')->insert([
            'key' => 'match',
            'value'=>'75'
        ]);
        DB::table('settings')->insert([
            'key' => 'exception',
            'value'=>'yes'
        ]);

        DB::table('settings')->insert([
            'key' => 'spamDefender',
            'value'=>'on'
        ]);
        DB::table('settings')->insert([
            'key' => 'autoDelete',
            'value'=>'on'
        ]);
    }
}
