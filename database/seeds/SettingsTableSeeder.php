<?php

use Illuminate\Database\Seeder;
use App\Settings;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
			'app_name'  		 =>	'QMS',
			'user_registration'  => 1,
		]);
    }
}
