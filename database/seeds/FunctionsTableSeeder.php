<?php

use Illuminate\Database\Seeder;

class FunctionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_permissions')->insert( [
			'id'=>1,
			'name'=>'Dashboard',
			'slug'=>'dashboard-1',
			'description'=>'Dashboard access',
			'parent'=>0,
			'master'=>1,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>2,
			'name'=>'Articles',
			'slug'=>'articles-2',
			'description'=>'Articles Admin Access',
			'parent'=>0,
			'master'=>2,
			'order'=>2,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>3,
			'name'=>'Create',
			'slug'=>'create-3',
			'description'=>'Create Articles Access',
			'parent'=>2,
			'master'=>2,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>4,
			'name'=>'Update',
			'slug'=>'update-4',
			'description'=>'Update Articles Access',
			'parent'=>2,
			'master'=>2,
			'order'=>2,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>5,
			'name'=>'Delete',
			'slug'=>'delete-5',
			'description'=>'Delete Articles Access',
			'parent'=>2,
			'master'=>2,
			'order'=>3,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>6,
			'name'=>'Publish',
			'slug'=>'publish-6',
			'description'=>'Publish Articles Access',
			'parent'=>2,
			'master'=>2,
			'order'=>4,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>7,
			'name'=>'Banners',
			'slug'=>'banners-7',
			'description'=>'Banners Access',
			'parent'=>0,
			'master'=>7,
			'order'=>3,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>8,
			'name'=>'Page Categories',
			'slug'=>'page-categories-8',
			'description'=>'Page Categories Access',
			'parent'=>0,
			'master'=>8,
			'order'=>4,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>9,
			'name'=>'Create',
			'slug'=>'create-9',
			'description'=>'Create Page Category Access',
			'parent'=>9,
			'master'=>8,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>10,
			'name'=>'Create',
			'slug'=>'create-10',
			'description'=>'Create Page Category Access',
			'parent'=>8,
			'master'=>8,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>11,
			'name'=>'Update',
			'slug'=>'update-11',
			'description'=>'Update Page Category Access',
			'parent'=>8,
			'master'=>8,
			'order'=>2,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>12,
			'name'=>'Delete',
			'slug'=>'delete-12',
			'description'=>'Delete Page Category Access',
			'parent'=>8,
			'master'=>8,
			'order'=>3,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>13,
			'name'=>'Pages',
			'slug'=>'pages-13',
			'description'=>'Page Access',
			'parent'=>0,
			'master'=>13,
			'order'=>5,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>14,
			'name'=>'Create',
			'slug'=>'create-14',
			'description'=>'Create Page Access',
			'parent'=>13,
			'master'=>13,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>15,
			'name'=>'Update',
			'slug'=>'update-15',
			'description'=>'Update Page Access',
			'parent'=>13,
			'master'=>13,
			'order'=>2,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>16,
			'name'=>'Delete',
			'slug'=>'delete-16',
			'description'=>'Delete Page Access',
			'parent'=>13,
			'master'=>13,
			'order'=>3,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>17,
			'name'=>'Publish',
			'slug'=>'publish-17',
			'description'=>'Publish Page Access',
			'parent'=>13,
			'master'=>13,
			'order'=>4,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>18,
			'name'=>'Users',
			'slug'=>'users-18',
			'description'=>'User Access',
			'parent'=>0,
			'master'=>18,
			'order'=>6,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>19,
			'name'=>'User Roles',
			'slug'=>'create-19',
			'description'=>'User Roles Access',
			'parent'=>19,
			'master'=>19,
			'order'=>7,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>20,
			'name'=>'Create',
			'slug'=>'create-20',
			'description'=>'Create User Access',
			'parent'=>18,
			'master'=>18,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>21,
			'name'=>'Update',
			'slug'=>'update-21',
			'description'=>'Update User Access',
			'parent'=>18,
			'master'=>18,
			'order'=>2,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>22,
			'name'=>'Delete',
			'slug'=>'delete-22',
			'description'=>'Delete User Access',
			'parent'=>18,
			'master'=>18,
			'order'=>3,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>23,
			'name'=>'User Roles',
			'slug'=>'user-roles-23',
			'description'=>'User Roles Access',
			'parent'=>0,
			'master'=>23,
			'order'=>7,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>24,
			'name'=>'Create',
			'slug'=>'create-24',
			'description'=>'Create User Roles Access',
			'parent'=>23,
			'master'=>23,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>25,
			'name'=>'Update',
			'slug'=>'update-25',
			'description'=>'Update User Roles Access',
			'parent'=>23,
			'master'=>23,
			'order'=>2,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>26,
			'name'=>'Delete',
			'slug'=>'delete-26',
			'description'=>'Delete Create User Roles Access',
			'parent'=>23,
			'master'=>23,
			'order'=>3,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>27,
			'name'=>'Functions',
			'slug'=>'functions-27',
			'description'=>'Functions Access',
			'parent'=>0,
			'master'=>27,
			'order'=>8,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>28,
			'name'=>'Create',
			'slug'=>'create-28',
			'description'=>'Create Functions Access',
			'parent'=>27,
			'master'=>27,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>29,
			'name'=>'Update',
			'slug'=>'update-29',
			'description'=>'Update Functions Access',
			'parent'=>27,
			'master'=>27,
			'order'=>2,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>30,
			'name'=>'Delete',
			'slug'=>'delete-30',
			'description'=>'Delete Functions Access',
			'parent'=>27,
			'master'=>27,
			'order'=>3,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>31,
			'name'=>'Email Logs',
			'slug'=>'email-logs-31',
			'description'=>'Email Logs Access',
			'parent'=>0,
			'master'=>31,
			'order'=>9,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>32,
			'name'=>'View',
			'slug'=>'view-32',
			'description'=>'View Email Logs',
			'parent'=>31,
			'master'=>31,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>33,
			'name'=>'Options',
			'slug'=>'options-33',
			'description'=>'Options Access',
			'parent'=>0,
			'master'=>33,
			'order'=>10,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>34,
			'name'=>'Create',
			'slug'=>'create-34',
			'description'=>'Create Options Access',
			'parent'=>34,
			'master'=>33,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>35,
			'name'=>'Create',
			'slug'=>'create-35',
			'description'=>'Create Options Access',
			'parent'=>33,
			'master'=>33,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>36,
			'name'=>'Update',
			'slug'=>'update-36',
			'description'=>'Update Options Access',
			'parent'=>36,
			'master'=>33,
			'order'=>2,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>37,
			'name'=>'Update',
			'slug'=>'update-37',
			'description'=>'Update Options Access',
			'parent'=>33,
			'master'=>33,
			'order'=>2,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>38,
			'name'=>'Delete',
			'slug'=>'delete-38',
			'description'=>'Delete Options Access',
			'parent'=>33,
			'master'=>33,
			'order'=>3,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );

		DB::table('user_permissions')->insert( [
			'id'=>39,
			'name'=>'Create',
			'slug'=>'create-39',
			'description'=>'Create Banners Access',
			'parent'=>7,
			'master'=>7,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>40,
			'name'=>'Edit',
			'slug'=>'edit-40',
			'description'=>'Edit Banners Access',
			'parent'=>7,
			'master'=>7,
			'order'=>2,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
			
		DB::table('user_permissions')->insert( [
			'id'=>41,
			'name'=>'Delete',
			'slug'=>'delete-41',
			'description'=>'Delete Banner Access',
			'parent'=>7,
			'master'=>7,
			'order'=>3,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
					
		DB::table('user_permissions')->insert( [
			'id'=>42,
			'name'=>'View',
			'slug'=>'view-42',
			'description'=>'View Dashboard',
			'parent'=>1,
			'master'=>1,
			'order'=>1,
			'deleted_at'=>NULL,
			'created_at'=>NULL,
			'updated_at'=>NULL
		] );
		
    }
} 
