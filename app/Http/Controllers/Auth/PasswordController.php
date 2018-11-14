<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Option;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = '/admin';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $driver= Option::where('slug', 'mail-driver')->select('value')->first()['value'];
        $host= Option::where('slug', 'mail-host')->select('value')->first()['value'];
        $port= Option::where('slug', 'mail-port')->select('value')->first()['value'];
        $username= Option::where('slug', 'mail-username')->select('value')->first()['value'];
        $password= Option::where('slug', 'mail-pass')->select('value')->first()['value'];
        $encryption= Option::where('slug', 'mail-encryption')->select('value')->first()['value'];
        $from_name= Option::where('slug', 'sender-name')->select('value')->first()['value'];
        $from_email = Option::where('slug', 'sender-email')->select('value')->first()['value'];
        $from = ['address' =>$from_email, 'name' => $from_name];

        // if (!isset($driver)  || !isset($host) || !isset($port) || !isset($username) || !isset($password) || !isset($encryption))
        // {
        //     return "ERROR: Mail sending credentials are incomplete.";
        // }

        \Config::set('mail.from', $from);
        \Config::set('mail.driver', $driver);
        \Config::set('mail.host', $host);
        \Config::set('mail.port', $port);
        \Config::set('mail.username', $username);
        \Config::set('mail.password', $password);
        \Config::set('mail.encryption', $encryption);

        $this->middleware('guest');
    }
}
