<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // HOME
        DB::table('pages')->insert([
			'slug' => 'home',
			'name' => 'Home',
        ]);
        DB::table('pages')->insert([
			'slug' => 'home-banner',
			'name' => 'Banner',
        ]);
        DB::table('pages')->insert([
			'slug' => 'home-about',
			'name' => 'About',
        ]);
        DB::table('pages')->insert([
			'slug' => 'home-team',
			'name' => 'Team',
        ]);
        DB::table('pages')->insert([
			'slug' => 'home-inquiry',
			'name' => 'inquiry ',
        ]);
        

        // ABOUT
        DB::table('pages')->insert([
			'slug' => 'about',
			'name' => 'About',
        ]);
        DB::table('pages')->insert([
			'slug' => 'about-heading',
			'name' => 'Heading',
        ]);
        DB::table('pages')->insert([
			'slug' => 'about-content',
			'name' => 'Content',
        ]);
        DB::table('pages')->insert([
			'slug' => 'about-team',
			'name' => 'Team',
        ]);
        DB::table('pages')->insert([
			'slug' => 'about-contact',
			'name' => 'Contact',
        ]);
        

        // ARTICLES
        DB::table('pages')->insert([
			'slug' => 'articles',
			'name' => 'Articles',
        ]);
        DB::table('pages')->insert([
			'slug' => 'articles-heading',
			'name' => 'Heading',
        ]);
        
        // CONTACT US
        DB::table('pages')->insert([
			'slug' => 'contact',
			'name' => 'Contact Us',
        ]);
        DB::table('pages')->insert([
			'slug' => 'contact-heading',
			'name' => 'Heading',
        ]);
        DB::table('pages')->insert([
			'slug' => 'contact-content',
			'name' => 'Content',
        ]);
        DB::table('pages')->insert([
			'slug' => 'contact-address',
			'name' => 'Address',
        ]);
        DB::table('pages')->insert([
			'slug' => 'contact-phone',
			'name' => 'Phone',
        ]);
        
        
        // ABOUT ITEMS
		DB::table('page_items')->insert([
			'slug' => 'about',
            'title' => 'Free Chat',
            'description' => '<p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough. </p>',
            'image' => null
        ]);
		DB::table('page_items')->insert([
			'slug' => 'about',
            'title' => 'Verified Users',
            'description' => '<p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough. </p>',
            'image' => null
        ]);
		DB::table('page_items')->insert([
			'slug' => 'about',
            'title' => 'Fingerprint',
            'description' => '<p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough. </p>',
            'image' => null
        ]);
    }
}
