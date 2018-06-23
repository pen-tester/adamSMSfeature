<?php

class Main extends CI_Controller {
	public $stripe=array();

		public function __construct()
		{
		    // Construct our parent class
		    parent::__construct();
		    $this->load->helper('url');
		    $this->load->helper('stripe');
		    $this->load->helper('twilio');
         	$this->load->library('session');		    
		   // $this->load->library('token');
		}

        public function view($page='home')
        {
			//For interface     	
        	$data['title']="Sms Campaign";
        	$data['menuid']=$page;
        	$data['submenuid']=0;
        	$this->load->view('templates/header', $data);
        	$this->load->view('main/'.$page, $data);
        	$this->load->view('templates/footer', $data);
        }

        public function success()
        {
        	$this->session->set_userdata('message', "Messages are on their way");
        	//$this->session->set_flashdata('message', "Messages are on their way");
        	redirect("/");
      	
		}
		
		public function test(){
			echo (int)false;
		}

        public function charge(){
        	$stripe = getStripeConfig();
			\Stripe\Stripe::setApiKey($stripe['secret_key']);   

        	$custommessage="";
        	$name = $this->input->post("Customer");;
        	$planid = $this->input->post("attackplan");
        	$phonenumber=$this->input->post("recipient");
        	$token ="";
        	if($this->input->post("HasCustomMessage") == true){
        		$custommessage=$this->input->post("CustomMessage");
        	}

        	$images = $this->images_model->get_images();

        	$smstype= $this->smstype_model->get_smstype($planid);

        	$error="";

        	if($smstype == null) redirect("/");

			if(isset($_POST['stripeToken']))
			{
				$token = $this->input->post("stripeToken");
				$description = "Invoice for sending sms";
				$amount_cents =str_replace(".", "",$smstype->price);
				try {

					$charge = \Stripe\Charge::create(array(		 
						  "amount" => $amount_cents,
						  "currency" => "usd",
						  "source" => $token,
						  "description" => $description)			  
					);

					/*if ($charge->card->address_zip_check == "fail") {
						throw new Exception("zip_check_invalid");
					} else if ($charge->card->address_line1_check == "fail") {
						throw new Exception("address_check_invalid");
					} else if ($charge->card->cvc_check == "fail") {
						throw new Exception("cvc_check_invalid");
					}
					*/
					// Payment has succeeded, no exceptions were thrown or otherwise caught				

					$result = "success";

				} catch(Stripe_CardError $e) {			

					$error = $e->getMessage();
					$result = "declined";

				} catch (Stripe_InvalidRequestError $e) {
					$error= $e->getMessage();
					$result = "declined";		  
				} catch (Stripe_AuthenticationError $e) {
					$error= $e->getMessage();
					$result = "declined";
				} catch (Stripe_ApiConnectionError $e) {
					$error= $e->getMessage();
					$result = "declined";
				} catch (Stripe_Error $e) {
					$error= $e->getMessage();
					$result = "declined";
				} catch (Exception $e) {
					$error= $e->getMessage();
					if ($e->getMessage() == "zip_check_invalid") {
						$result = "declined";
					} else if ($e->getMessage() == "address_check_invalid") {
						$result = "declined";
					} else if ($e->getMessage() == "cvc_check_invalid") {
						$result = "declined";
					} else {
						$result = "declined";
					}		  
				}

				if($result=="success"){
					send_twiliomultiplesms($images, $smstype->count, $phonenumber,$name);
					redirect("/main/success");
				}else{
					$this->load->view("errors/error", array('error'=>$error));
				}
			}

        }
}

