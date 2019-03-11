<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert(
        	[
	            'name' => 'Meta Title',
	            'slug' => 'meta-title',
                'type' => 'text',
	            'permanent' => 1,
	            'value' => 'Meta Title',
                'asset' => '',
	            'category' => 'general',
        	]
        );

        DB::table('options')->insert(
        	[
	            'name' => 'Meta Description',
	            'slug' => 'meta-description',
	            'type' => 'text',
                'permanent' => 1,
	            'value' => 'Meta Description',
	            'asset' => '',
	            'category' => 'general',
        	]
        );

        DB::table('options')->insert(
        	[
	            'name' => 'Meta Image',
	            'slug' => 'meta-image',
	            'type' => 'asset',
                'permanent' => 0,
	            'value' => '',
	            'asset' => '',
	            'category' => 'general',
        	]
        );

        DB::table('options')->insert(
            [
                'name' => 'Contact Number',
                'slug' => 'contact-number',
                'type' => 'text',
                'permanent' => 1,
                'value' => '',
                'asset' => '',
	            'category' => 'general',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Contact Email',
                'slug' => 'contact-email',
                'type' => 'text',
                'permanent' => 1,
                'value' => 'no-reply@sumofy.me',
                'asset' => '',
	            'category' => 'general',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Facebook Page',
                'slug' => 'facebook-page',
                'type' => 'text',
                'permanent' => 0,
                'value' => '',
                'asset' => '',
	            'category' => 'general',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Twitter Page',
                'slug' => 'twitter-page',
                'type' => 'text',
                'permanent' => 0,
                'value' => '',
                'asset' => '',
	            'category' => 'general',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Google Page',
                'slug' => 'google-page',
                'type' => 'text',
                'permanent' => 0,
                'value' => '',
                'asset' => '',
	            'category' => 'general',
            ]
        );

        // DB::table('options')->insert(
        //     [
        //         'name' => 'Terms Link',
        //         'slug' => 'terms-link',
        //         'type' => 'text',
        //         'permanent' => 0,
        //         'value' => '',
        //         'asset' => '',
	    //         'category' => 'general',
        //     ]
        // );

        // DB::table('options')->insert(
        //     [
        //         'name' => 'Privacy Link',
        //         'slug' => 'privacy-link',
        //         'type' => 'text',
        //         'permanent' => 0,
        //         'value' => '',
        //         'asset' => '',
	    //         'category' => 'general',
        //     ]
        // );

        // DB::table('options')->insert(
        //     [
        //         'name' => 'Unsubscribe Link',
        //         'slug' => 'unsubscribe-link',
        //         'type' => 'text',
        //         'permanent' => 0,
        //         'value' => '',
        //         'asset' => '',
	    //         'category' => 'general',
        //     ]
        // );

        DB::table('options')->insert(
            [
                'name' => 'Analytics Script',
                'slug' => 'analytics-script',
                'type' => 'text',
                'permanent' => 0,
                'value' => '',
                'asset' => '',
                'category' => 'general',
                'help' => 'The GA Code (ex: UA-xxxxxx)'
            ]
        );

        
        // DB::table('options')->insert(
        //     [
        //         'name' => 'Instagram Feed Token',
        //         'slug' => 'instagram-feed-token',
        //         'type' => 'text',
        //         'permanent' => 0,
        //         'value' => '',
        //         'asset' => '',
        //         'category' => 'general',  
        //         'help' => 'The IG token that will be used for IG feed extraction <br/><a href="https://public.3.basecamp.com/p/qmRMy9T4mjNyTrDQGXQ7UbhU">Click here for more info</a>'
        //     ]
        // );

         DB::table('options')->insert(
            [
                'name' => 'Email Driver',
                'slug' => 'mail-driver',
                'type' => 'text',
                'permanent' => 1,
                'value' => 'smtp',
                'asset' => '',
                'category' => 'email',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Email Host',
                'slug' => 'mail-host',
                'type' => 'text',
                'permanent' => 1,
                'value' => 'email-smtp.us-west-2.amazonaws.com',
                'asset' => '',
                'category' => 'email',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Email Port',
                'slug' => 'mail-port',
                'type' => 'text',
                'permanent' => 1,
                'value' => '587',
                'asset' => '',
                'category' => 'email',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Email Username',
                'slug' => 'mail-username',
                'type' => 'text',
                'permanent' => 1,
                'value' => 'AKIAJOT4XWHN6CZ4ERRA',
                'asset' => '',
                'category' => 'email',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Email Password',
                'slug' => 'mail-pass',
                'type' => 'text',
                'permanent' => 1,
                'value' => 'Ak6ckxl/Ypond/pmIqOkBJ0THsI3x9iLiF6XT13Ftiby',
                'asset' => '',
                'category' => 'email',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Email Encryption',
                'slug' => 'mail-encryption',
                'type' => 'text',
                'permanent' => 1,
                'value' => 'tls',
                'asset' => '',
                'category' => 'email',
            ]
        );

         DB::table('options')->insert(
            [
                'name' => 'Email Image',
                'slug' => 'email-image',
                'type' => 'asset',
                'permanent' => 1,
                'value' => '',
                'asset' => '1',
                'category' => 'email',
            ]
        );

        DB::table('assets')->insert(
            [
                'id' => 1,
                'path' => 'upload/assets/3niaaMVCzUY6QfWvuV6ZbbVhjnFIXAUPqpcCGTBRHvdbTxacek.jpg',
                'name' => '',
                'caption' => 'text',
                'alt' => '',
                'created_at' => '2017-04-08 15:14:06',
            ]
        );

         DB::table('options')->insert(
            [
                'name' => 'Sender Name',
                'slug' => 'sender-name',
                'type' => 'text',
                'permanent' => 1,
                'value' => 'System Admin',
                'asset' => '',
                'category' => 'email',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Sender Email',
                'slug' => 'sender-email',
                'type' => 'text',
                'permanent' => 1,
                'value' => 'no-reply@sumofy.me',
                'asset' => '',
                'category' => 'email',
                'help' => 'The email that users will see when receiving emails from notifications',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Receiver Emails (comma-separated)',
                'slug' => 'receiver-emails',
                'type' => 'text',
                'permanent' => 1,
                'value' => 'contact@sumofy.me',
                'asset' => '',
                'category' => 'email',  
                'help' => 'The email addresses that will receive inquiries in contact-us.'
            ]
        );



    }
}