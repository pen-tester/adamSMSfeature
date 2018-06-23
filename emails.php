<?php
    /*
     * Enable error reporting
     */


    ini_set( 'display_errors', 0 );
   // error_reporting( E_ALL );
 
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    $_from="Test";
    //$_to=$_POST["To"];
    $_body= "Test body";
    //$_body= $_POST["Body"];

    /*
     * Setup email addresses and change it to your own
     */
    $from = 'webmaster@probateproject.com';
    $to = 'andrew.lidev@yandex.com';
    $subject = 'Sms Received from '.$_from;
    $message = $_body;
    $headers = 'From:' . $from;
 
    /*
     * Test php mail function to see if it returns 'true' or 'false'
     * Remember that if mail returns true does not guarantee
     * that you will also receive the email
     */
    mail($to,$subject,$message, $headers);

  /*  if(mail($to,$subject,$message, $headers))
    {
        echo 'Test email send.';
    } 
    else 
    {
        echo 'Failed to send.';
    }*/
?>
<Response>

</Response>