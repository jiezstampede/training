<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('user_roles')->insert(
            [
				'id'=>1,
				'name'=>'Super Admin',
				'description'=>'Access to all',
				'deleted_at'=>NULL,
				'created_at'=>NULL,
				'updated_at'=>NULL
            ]
        );
    }
}
