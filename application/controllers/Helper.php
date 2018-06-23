<?php

class Helper extends CI_Controller {

        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('smsmsg_model');
            $this->load->model('users_model');
            $this->load->model("recentsmsarchive_model");
            $this->load->database();
            $this->load->helper('twilio');
           // $this->load->library('token');
        }

        public function recsms(){
          /*$phoneNum = $this->input->get("From");
          $receiveNum = $this->input->get("To");
          $msg_body = $this->input->get("Body");  */   
          $phoneNum = $this->input->post("From");
          $receiveNum = $this->input->post("To");
          $msg_body = $this->input->post("Body");             
          $this->smsmsg_model->insert_sms($receiveNum, $phoneNum, $msg_body);
          $msg=sprintf("From %s\n Msg\n %s", $phoneNum, $msg_body);        
          send_Sms("+18137487471", $msg);
          send_Sms("+18135464847‬", $msg);
          send_Sms("+18136000015‬", $msg);//(813) 546-4847‬From:Aaron Pimpis‭+1 (813) 600-0015‬
        }

        public function receivesms($userid=0){
          /*$phoneNum = $this->input->get("From");
          $receiveNum = $this->input->get("To");
          $msg_body = $this->input->get("Body");  */ 
          $userid = (int)$userid;  
          $phoneNum = $this->input->post("From");
          $receiveNum = $this->input->post("To");
          $msg_body = $this->input->post("Body");             
          $leads["userid"] = $userid;
          $leads["PhoneNum"] = $receiveNum;
          $leads["FromNum"] = $phoneNum;
          $leads["Content"] = $msg_body; 
          $leads["RecTime"] = date("Y-m-d H:i:s");

          $this->smsmsg_model->add_sms($leads);
          $msg=sprintf("From %s\n Msg\n %s", $phoneNum, $msg_body);        
          send_Sms("+18137487471", $msg,"+18137500671");
          send_Sms("+18135464847‬", $msg,"+18137500671");
          send_Sms("+18136000015‬", $msg,"+18137500671");//(813) 546-4847‬From:Aaron Pimpis‭+1 (813) 600-0015‬

          unset($leads["userid"]);
          $leads["phone"] = $leads["FromNum"];
          //$user = $this->users_model->get_userbyid($userid);
          $this->recentsmsarchive_model->update_data($leads);

        }

        public function voice(){
          $response = new Twilio\Twiml();

          $callerid="+12402211454";
          // get the phone number from the page request parameters, if given
         // if (isset($_REQUEST['To']) && strlen($_REQUEST['To']) > 0) {
           if (strlen($this->input->get_post("To"))>0) {
              $number = htmlspecialchars($this->input->get_post("To"));
              
              // wrap the phone number or client name in the appropriate TwiML verb
              // by checking if the number given has only digits and format symbols
              if (preg_match("/^[\d\+\-\(\) ]+$/", $number) && $number!=$callerid) {
                  $dial = $response->dial(array("callerId"=>$callerid));
                  $dial->number($number);
              }
              else{
                 $dial = $response->dial(array("callerId"=>$this->input->get("From")));
                  $dial->client("andrew");
              }
            } else {
              $response->say("Thanks for calling!");
            }

          header('Content-Type: text/xml');
          echo $response;          
        }


        public function redirect(){
          $response = new Twilio\Twiml();
          $dial = $response->dial();
          $this->load->model("callback_model");
          $row = $this->callback_model->get_phone(0);
          if($row == null){
            $dial->number("+‭18135464847");
          }
          else $dial->number($row["phone"]);
          header('Content-Type: text/xml');
          echo $response;
        }
        

        public function redirectphone($userid=0){
          $response = new Twilio\Twiml();
          $dial = $response->dial();
          $this->load->model("users_model");
          $user = $this->users_model->get_userbyid($userid);
          if($user == null){
            $dial->number("+‭18135464847");
          }
          else $dial->number($user->backwardnumber);
          header('Content-Type: text/xml');
          echo $response;
        }     

        public function emailsms(){

          $_from=$_POST["From"];
          $_to=$_POST["To"];
          $_body= $_POST["Body"];


          /*
           * Setup email addresses and change it to your own
           */
          $from = 'webmaster@sms.probateproject.com';
          $to = 'andrew.lidev@yandex.com';
          $subject = 'Sms Received from '.$_from;
          $message = $_body;
          $headers = 'From:' . $from;
       
          /*
           * Test php mail function to see if it returns 'true' or 'false'
           * Remember that if mail returns true does not guarantee
           * that you will also receive the email
           */
          if(mail($to,$subject,$message, $headers)!=false){

            header("content-type: text/xml");
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";          
            echo("<Response></Response>");
          }
        }

        
}

