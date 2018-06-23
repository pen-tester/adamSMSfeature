<?php
	use Twilio\Rest\Client;

	include_once(APPPATH."libraries/twilio/vendor/autoload.php");

	function get_TwilioConfig(){
		$stripe = array(
		  "id"      => "xxx",
		  "token" => "xxx"
		);
		return $stripe;
	}

	function send_Smsnew($number,$msg){
		
		$config = get_TwilioConfig();
	    $auth_id = $config["id"];
	    $auth_token = $config["token"];

	    //813-642-6592
		$fromnumber="+18137500671";
		//$fromnumber="+1 727-350-1397 ";
	  		$client = new Client($auth_id, $auth_token);

				// Use the client to do fun stuff like send text messages!
			        $sms = $client->account->messages->create(

			            // the number we are sending to - Any phone number
			            $number,

			            array(
			                // Step 6: Change the 'From' number below to be a valid Twilio number 
			                // that you've purchased
			                'from' => $fromnumber, 

			                // the sms body
			                'body' => $msg
			                
			                // Step 7: Add url(s) to the image media you want to send
			                //'mediaUrl' => array($url)
			            )
			        );
		return $sms;

	}

	function send_Sms($number,$msg, $fromnumber=""){
		
		$config = get_TwilioConfig();
	    $auth_id = $config["id"];
	    $auth_token = $config["token"];

	    //813-642-6592  Admin  +18137500671
		//$fromnumber="+18136000015";
		//$fromnumber="+1 727-350-1397 ";
	  		$client = new Client($auth_id, $auth_token);

				// Use the client to do fun stuff like send text messages!
			        $sms = $client->account->messages->create(

			            // the number we are sending to - Any phone number
			            $number,

			            array(
			                // Step 6: Change the 'From' number below to be a valid Twilio number 
			                // that you've purchased
			                'from' => $fromnumber, 

			                // the sms body
			                'body' => $msg
			                
			                // Step 7: Add url(s) to the image media you want to send
			                //'mediaUrl' => array($url)
			            )
			        );
		return $sms;

	}

	function list_twilio_numbers(){
		$config = get_TwilioConfig();
	    $auth_id = $config["id"];
	    $auth_token = $config["token"];

		  $client = new Client($auth_id, $auth_token);
		  return $client->incomingPhoneNumbers->read();
	}

	function list_twilio_available_numbers($areacode="813"){
		$config = get_TwilioConfig();
	    $auth_id = $config["id"];
		$auth_token = $config["token"];
		$client = new Client($auth_id, $auth_token);

		$numbers = $client->availablePhoneNumbers('US')->local->read(
			array("areaCode" => $areacode, "Voice"=>true, "SMS"=>true)
		);
		
		return $numbers;
	}	

	function update_twilio_phonenumber($phone ,$sid, $userid){
		$config = get_TwilioConfig();
	    $auth_id = $config["id"];
		$auth_token = $config["token"];
		$client = new Client($auth_id, $auth_token);
		
		if($phone == null || $phone == "")return "";

	//	try{
			if($sid == "" || $sid==null){
				// Purchase the first number on the list.
				$number = $client->incomingPhoneNumbers
					->create(
						array(
							"phoneNumber" => $phone,
							"voiceUrl" => "https://home.probateproject.com/helper/redirectphone/".$userid,
							"smsUrl" => "https://home.probateproject.com/helper/receivesms/".$userid				
						)
					);

				return $number->sid;			
			}else{
				$number = $client
				->incomingPhoneNumbers($sid)
				->update(
					array(
						"voiceUrl" => "https://home.probateproject.com/helper/redirectphone/".$userid,
						"smsUrl" => "https://home.probateproject.com/helper/receivesms/".$userid,
						"voiceApplicationSid"=>"",
						"smsApplicationSid"=>""
					)
				);
			
				return $number->sid;	
			}
	//	}catch(Exception $ex){
	//		return "";
	//	}

	}
?>
