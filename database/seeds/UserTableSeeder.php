<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		User::create([
			'name' 		=>	'Admin',
			'username'	=>	'admin',
			'email'		=>	'admin@gmail.com',
            'status'    =>  'ACTIVE',
			'password'	=>	Hash::make('123456'),
			'is_admin'	=>	1
		]);        
    }
}
