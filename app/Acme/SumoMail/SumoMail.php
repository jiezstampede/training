<?php 

namespace Acme\SumoMail;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

use App\Email;
use App\Option;
use Mail;
use Carbon;

class SumoMail extends Mail
{	
	public function send($view, array $data, array $params)
	{
		/***** START OF SAMPLE CALL OF SEND METHOD 
        $data=[];
        $params=[];
        $params['from_email'] = "no-reply@domain.com";
        $params['from_name'] = "Company Admin";
        $params['subject'] = "Email Subject";
        $params['to'] = "to@domain.com";

        //not required fields
        $params['cc'] = "cc@domain.com";
        $params['bcc'] = "bcc@domain.com";
        $params['replyTo'] = "reply-to@domain.com";
        //attach requires filepath
        $params['attach'] = "";

        //DEBUG Options are as follows:
        // FALSE - Default
        // TRUE - Shows HTML output upon sending
        // SIMULATE = Does not send email but saves information to the database
        $params['debug'] = true; 
            
        $return= SumoMail::send('emails.basic', $data, $params);
        ***** END OF SAMPLE CALL OF SEND METHOD ******/

        //set email config based from options
      	$driver= Option::where('slug', 'mail-driver')->select('value')->first()['value'];
      	$host= Option::where('slug', 'mail-host')->select('value')->first()['value'];
      	$port= Option::where('slug', 'mail-port')->select('value')->first()['value'];
      	$username= Option::where('slug', 'mail-username')->select('value')->first()['value'];
      	$password= Option::where('slug', 'mail-pass')->select('value')->first()['value'];
      	$encryption= Option::where('slug', 'mail-encryption')->select('value')->first()['value'];
      	$from_name= Option::where('slug', 'sender-name')->select('value')->first()['value'];
      	$from_email = Option::where('slug', 'sender-email')->select('value')->first()['value'];

      	if (!isset($driver)  || !isset($host) || !isset($port) || !isset($username) || !isset($password) || !isset($encryption))
      	{
      		return "ERROR: Mail sending credentials are incomplete.";
      	}

        \Config::set('mail.driver', $driver);
        \Config::set('mail.host', $host);
		\Config::set('mail.port', $port);
		\Config::set('mail.username', $username);
		\Config::set('mail.password', $password);
		\Config::set('mail.encryption', $encryption);


		if ($from_email != "" && $params['from_email'] != "" && $params['to']!="" && $params['subject']!="" )
		{
			$viewSave = View::make($view, $data);

			if (@$params['debug'] == 'TRUE')
			{
				
				echo $viewSave;
				die();
			}

			//saving to DB
			$params['content'] = $viewSave->render();
       		$email = Email::create($params);

       		set_time_limit(60); //60 seconds = 1 minute
			$return = Mail::send($view,$data,function($message) use ($params) {

				if ( isset($params['cc']) || @$params['cc'] != ""){
					// $message->cc($address, $name = null);
	           		$message->cc($params['cc']);
				}

				if (isset($params['bcc']) || @$params['bcc']!= ""){
					// $message->bcc($address, $name = null);
	           		$message->bcc($params['bcc']);
				}

				if (isset($params['attach']) || @$params['attach'] != ""){
					// $message->attach($pathToFile, array $options = []);
	            	$message->attach($params['attachment']);
				}

				if (isset($params['replyTo']) || $params['replyTo'] != ""){
					$params['replyTo']=$params['from_email'];
				}

				if (!isset($params['replyTo']) || @$params['replyTo_name'] == ""){
					$params['replyTo_name']=$params['from_name'];
				}	

				//use the admin set email or use the defaults
				if (isset($params['from_email']) || @$params['from_email'] == ""){
					if (!isset($params['from_name']) || @$params['from_name'] == ""){
		           		$message->from($params['from_email']);
					}else{
		            	$message->from($params['from_email'], $params['from_name']);
					}
				}
				else {
					//uses default in site options
					$message->from($from_email, $from_name);
				}

	            // $message->to($address, $name = null);
	            $message->to($params['to']);
	            // $message->replyTo($address, $name = null);
	            $message->replyTo($params['replyTo'],$params['replyTo_name']);
	            // $message->subject($subject);
	            $message->subject($params['subject']);
			});

            //Updates status of sent and saves sent date
            $email = Email::findOrFail($email->id);
            if ($return == "3") {
            	$params['status'] = 'sent';
            	$date = Carbon::now();       
            	$date->setTimezone('UTC');
            	$params['sent'] = $date;
            }
            else {
            	$params['status'] = 'failed';
            }
            $params['attach'] = $return;
      		$email->update($params);
			return $return;	
			
		}	
		else {
			return "Error: Provide the required information (From, To, Subject)";
		}
     
	}
}