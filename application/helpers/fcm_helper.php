<?php

 function send_message(){
	#API access key from Google API's Console
	    define( 'API_ACCESS_KEY', 'AAAAAq00v4o:APA91bFAgu4DMajgkG7msxi4-q-TpPdUxMIbIJvZn1TT-Sio7ENvOgksi-1DLI8qBpRd5C7umDqQ-vHcu6VQ4DPXq71tyJ4zGsDTxtEwKj_n2k_v-Kqt5ImiECQL4ZnWflp-MmSNWl3u' );
	    $registrationIds = $_GET['id'];
	#prep the bundle
	     $msg = array
	          (
			'body' 	=> 'Body  Of Notification',
			'title'	=> 'Title Of Notification',
	             	'icon'	=> 'myicon',/*Default Icon*/
	              	'sound' => 'mySound'/*Default sound*/
	          );
		$fields = array
				(
					'to'		=> $registrationIds,
					'notification'	=> $msg
				);
		
		
		$headers = array
				(
					'Authorization: key=' . API_ACCESS_KEY,
					'Content-Type: application/json'
				);
	#Send Reponse To FireBase Server	
			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
			$result = curl_exec($ch );
			curl_close( $ch );
	#Echo Result Of FireBase Server
	return $result; 	
 }

?>