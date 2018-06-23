<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../application/libraries/twilio/vendor/autoload.php";

use Twilio\Jwt\ClientToken;

// put your Twilio API credentials here
$accountSid = 'AC883ace0e82efe5dd5c08c6550adae88e';
$authToken  = '30b23223a8b969970a556645514f9ecf';

// put your TwiML Application Sid here
$appSid = 'AP96cd5d8dfd74953fd304f851564feb5f';

$clientName="andrew";
// get the Twilio Client name from the page request parameters, if given
if (isset($_REQUEST['client'])) {
    $clientName = $_REQUEST['client'];
}


$capability = new ClientToken($accountSid, $authToken);
$capability->allowClientOutgoing($appSid);
$capability->allowClientIncoming($clientName);
$token = $capability->generateToken();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Hello Client Monkey 5</title>
    <script type="text/javascript"
      src="//media.twiliocdn.com/sdk/js/client/v1.3/twilio.min.js"></script>
    <script type="text/javascript"
      src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <link href="//static0.twilio.com/resources/quickstart/client.css"
      type="text/css" rel="stylesheet" />
    <script type="text/javascript">

      Twilio.Device.setup("<?php echo $token; ?>");

      Twilio.Device.ready(function (device) {
        $("#log").text("Client '<?php echo $clientName ?>' is ready");
      });

      Twilio.Device.error(function (error) {
        $("#log").text("Error: " + error.message);
      });

      Twilio.Device.connect(function (conn) {
        $("#log").text("Successfully established call");
      });

      Twilio.Device.disconnect(function (conn) {
        $("#log").text("Call ended");
      });

      Twilio.Device.incoming(function (conn) {
        $("#log").text("Incoming connection from " + conn.parameters.From);
        // accept the incoming connection and start two-way audio
        conn.accept();
      });

      function call() {
        // get the phone number to connect the call to
        params = {"To": $("#number").val()};
        Twilio.Device.connect(params);
      }

      function hangup() {
        Twilio.Device.disconnectAll();
      }
    </script>
  </head>
  <body>
    <button class="call" onclick="call();">
      Call
    </button>

    <button class="hangup" onclick="hangup();">
      Hangup
    </button>
        
    <input type="text" id="number" name="number"
      placeholder="Enter a phone number or client to call"/>

    <div id="log">Loading pigeons...</div>
  </body>
</html>

