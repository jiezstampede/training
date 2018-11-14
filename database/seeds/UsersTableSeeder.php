<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
        	[
	            'name' => 'Shredder Developer',
	            'email' => 'dev@helloshredder.com',
	            'password' => bcrypt('qweasd'),
	            'cms' => '1',
	            'verified' => '1',
	            'status' => 'active',
	            'type' => 'super'
        	]
        );
    }
}
