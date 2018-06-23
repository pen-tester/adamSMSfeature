<?php

	include_once(APPPATH."/libraries/plivo/vendor/autoload.php");

	use Plivo\RestAPI;

	function get_plivoconfig(){
		$plivo = array(
		  "id"      => "MAYTA5YJLLYMY3YTVJNG",
		  "token" => "M2EzZjZjM2RlNTVhNzUwMjBkNTM1Zjg5ODQ0Mjg5"
		);
		return $plivo;
	}

	function send_MultipleSms($images, $count, $number)
	{
		$number = "+1".$number;

		$config = get_plivoconfig();
	    $auth_id = $config["id"];
	    $auth_token = $config["token"];

		$allcount = sizeof($images);
		$current_max = ($count>$allcount)? $allcount: $count;
		$rand_keys = array_rand($images, $current_max);

		if($current_max == 1){
			$image= $images[$rand_keys];
				$url="http://dev.probateproject.com/assets/images/gifs/".$image["filename"];

				$p = new RestAPI($auth_id, $auth_token);
				//echo($image["sms"]);
			    $params = array(
				        'src' => '1111111111', // Sender's phone number with country code
				        'dst' => $number, // Receiver's phone number with country code
				        'text' => $url."\n".$image["sms"], // Your SMS text message
				        // To send Unicode text
				        //'text' => 'こんにちは、元気ですか？' # Your SMS Text Message - Japanese
				        //'text' => 'Ce est texte généré aléatoirement' # Your SMS Text Message - French
				        //'url' => 'http://example.com/report/', // The URL to which with the status of the message is sent
				        //'method' => 'POST' // The method used to call the url
				    );
				    // Send message
				$response = $p->send_message($params);
				print_r ($response['response']);

		}else if($current_max>1){
			foreach($rand_keys as $sel_key){

				$image= $images[$sel_key];
				$url="http://dev.probateproject.com/assets/images/gifs/".$image["filename"];

				$p = new RestAPI($auth_id, $auth_token);
				//echo($image["sms"]);
			    $params = array(
				        'src' => '15147092926', // Sender's phone number with country code
				        'dst' => $number, // Receiver's phone number with country code
				        'text' => $url."\n".$image["sms"], // Your SMS text message
				        // To send Unicode text
				        //'text' => 'こんにちは、元気ですか？' # Your SMS Text Message - Japanese
				        //'text' => 'Ce est texte généré aléatoirement' # Your SMS Text Message - French
				        //'url' => 'http://example.com/report/', // The URL to which with the status of the message is sent
				        //'method' => 'POST' // The method used to call the url
				    );
				    // Send message
				$response = $p->send_message($params);
				print_r ($response['response']);

				 /*   // Print the response
				    echo "Response : ";
				    print_r ($response['response']);

				    // Print the Api ID
				    echo "<br> Api ID : {$response['response']['api_id']} <br>";

				    // Print the Message UUID
				    echo "Message UUID : {$response['response']['message_uuid'][0]} <br>";
				    */
			}

		}


	}
?>