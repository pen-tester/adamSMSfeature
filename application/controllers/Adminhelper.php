<?php

class Adminhelper extends CI_Controller {
    public $username;
    public $email;
    public $userid;
    public $userrole;
    public $permissions = array();

        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->database();
            $this->load->helper('result');
            $this->load->helper('twilio');

           // $this->load->library('token');
           $this->username = $this->session->userdata("username");
           $this->email = $this->session->userdata("email");
           $this->userrole = (int) $this->session->userdata("role");
           $this->userid = (int) $this->session->userdata("userid");
           $this->permissions["editsms"] = (int) $this->session->userdata("editsms");
           $this->permissions["sendsms"] = (int) $this->session->userdata("sendsms");
           $this->permissions["upload"] = (int) $this->session->userdata("upload");     

            header("Content-Type: application/json; charset=UTF-8");

            if(!$this->session->has_userdata('logged_in') || $this->userrole != 1000){
                    $result = new MessageResult();
                    $result->status="error";
                    $result->code=0; //Not logged in
                    $result->errors=array("Not Logged in");
                    echo (json_encode($result)); 
                    die;
            }                


        }

        public function listusers(){
            
            $this->load->model("users_model");
            $result = new MessageResult();
            $result->result = $this->users_model->listusers();

            echo (json_encode($result));   
        }

        public function list_all_users(){
            
            $this->load->model("users_model");
            $result = new MessageResult();
            $result->result = $this->users_model->list_all_users();

            echo (json_encode($result));   
        }

        public function update_member_info(){
          $leads = $this->input->post("leads");
          $result = new MessageResult();
          $this->load->model("users_model");
          $res = $this->users_model->update_userinfo($leads);
          $result->result=$res;
          echo (json_encode($result));           
        }        
        /***
         * For reporting api ...
         */
        public function get_total_archive_number(){
            $searchcondition =  json_decode(file_get_contents('php://input'), true);
            $result = new MessageResult();
            $this->load->model("archive_model");
            $res = $this->archive_model->get_total_archive_number($searchcondition);
            $result->result=$res;
            $result->additional_info= $searchcondition;
            echo (json_encode($result)); 
        }

        public function get_archive_records_page(){
            $params =  json_decode(file_get_contents('php://input'), true);
            $searchcondition = $params["condition"];
            $page = (int) $params["page"];
            $entry = (int) $params["entry"];
            $result = new MessageResult();
            $this->load->model("archive_model");
            $res = $this->archive_model->get_record_archive_page($searchcondition, $page, $entry);
            $result->result=$res;
            $result->additional_info= $searchcondition;
            echo (json_encode($result)); 
        }

        public function get_total_sms_sent(){
            $searchcondition =  json_decode(file_get_contents('php://input'), true);
            $result = new MessageResult();
            $this->load->model("batch_model");
            $res = $this->batch_model->get_total_sms_sent($searchcondition);
            $result->result=$res;
            $result->additional_info= $searchcondition;
            echo (json_encode($result));             
        }
        
        public function get_total_sms_called(){
            $searchcondition =  json_decode(file_get_contents('php://input'), true);
            $result = new MessageResult();
            $this->load->model("archive_model");
            $res = $this->archive_model->get_total_number_called($searchcondition);
            $result->result=$res;
            $result->additional_info= $searchcondition;
            echo (json_encode($result));             
        }    

        public function get_total_sms_by_attr($attr='grade'){
            $searchcondition =  json_decode(file_get_contents('php://input'), true);
            $result = new MessageResult();
            $this->load->model("archive_model");
            $res = $this->archive_model->get_total_number_by_attr($searchcondition,$attr);
            $result->result=$res;
            $result->additional_info= $searchcondition;
            echo (json_encode($result));             
        }    
        
        public function get_total_number_by_attr_group($attr='grade'){
            $searchcondition =  json_decode(file_get_contents('php://input'), true);
            $result = new MessageResult();
            $this->load->model("archive_model");
            $res = $this->archive_model->get_total_number_by_attr_group($searchcondition,$attr);
            $result->result=$res;
            $result->additional_info= $searchcondition;
            echo (json_encode($result));             
        }          
        /**
         * Reporting
         */
        public function deleteuser(){
            $this->load->model("users_model");
            $userid = $this->input->post("userid");
            $result = new MessageResult();
            $result->result = $this->users_model->delete_user($userid);     
            echo (json_encode($result));       
        }

        public function list_smstemplates(){
            $this->load->model("smscontent_model");
            $result = new MessageResult();
            $result->result = $this->smscontent_model->list_smstemplates();

            echo (json_encode($result));              
        }

        public function get_sms_info(){
            $id = $this->input->post("id");
             $this->load->model("smscontent_model");
            $result = new MessageResult();
            $result->result = $this->smscontent_model->get_sms($id);

            echo (json_encode($result));            
        }

        public function updatesms(){
            $leads = $this->input->post("leads");
             $this->load->model("smscontent_model");
            $result = new MessageResult();
            $result->result = $this->smscontent_model->updatesms($leads);

            echo (json_encode($result));              
        }


    /*
        Get and Update the call back number used when the user calling the twilio number
    */
        //Get the callback number used when the some calling the twilio number
        public function get_callback_number(){
            $this->load->model("callback_model");
            $phone = $this->callback_model->get_phone(0);
            $result = new MessageResult();
            $result->result = $phone;

            echo (json_encode($result));             
        }
        //update callback
        public function update_callback_number(){
            $leads= $this->input->post("leads");
            $this->load->model("callback_model");
            $res = $this->callback_model->update_phone($leads);
            $result = new MessageResult();
            $result->result = $res;

            echo (json_encode($result));             
        }


    /*
        Podio relation api
    */
        public function podio_test(){
            $this->load->helper("podio");
            if(init_podio()){
               $item = add_item_to_podio();
               print_r($item);
            }
        }

    /*
        Zillow api 
    */
      public function get_zillow_result(){
        $addr = "606 NEW YORK AVE";
        $zip = "DUNEDIN, FL";

        $result = new MessageResult();

        //Get the zillow property url to display
        $this->load->helper("zillow");
        $zillow_wrapper = new Zillow_Wrapper;
        $content = $zillow_wrapper->get_allresult($addr,$zip);

        $result->result=$content;
        echo (json_encode($result));     
      }

      public function get_zillow_detailresult(){
        $zpid = "45068499";

        $result = new MessageResult();

        //Get the zillow property url to display
        $this->load->helper("zillow");
        $content = Zillow_Wrapper::get_detailed_info($zpid);

        $result->result=$content;
        echo (json_encode($result));     
      }   
    
    public function get_number_of_all_users(){
        $this->load->model("users_model");
        $result = new MessageResult();

        $res = $this->users_model->get_number_of_all_users();

        $result->result = $res;

        echo (json_encode($result));          
    }

    public function list_users_page($page=0, $entry=30){
        $page = (int)$page;
        $entry = (int) $entry;
        $result = new MessageResult();

        $this->load->model("users_model");
        $users = $this->users_model->get_users_page($page, $entry);
 
        $result->result = $users;

        echo (json_encode($result));          
    }

    public function update_user(){
        $leads = json_decode(file_get_contents('php://input'), true);
        $result = new MessageResult();
        if(!array_key_exists("No", $leads)){
            $result->status='error';
            $result->errors='Wrong action';
            echo (json_encode($result));  
        }
        
        unset($leads["UsrId"]);

        $sid = update_twilio_phonenumber($leads["twiliophone"], $leads["twilionumbersid"],$leads["No"]);

        if($sid==""){
            $leads["twiliophone"]=""; $leads["twilionumbersid"] ="";
        }
    

        $this->load->model("users_model");
        $users = $this->users_model->update_userinfobyid($leads);
 
        $result->result = $users;

        echo (json_encode($result));         
    }



    public function list_system_numbers(){
        $result = new MessageResult();
        $this->load->model("users_model");
        $rows = $this->users_model->get_current_smsnumbers();
         array_push( $rows, array( "twiliophone"=>"+12402211454"));
         array_push( $rows,array("twiliophone"=> "+19172439029"));

         $current_numbers = list_twilio_numbers();
         $res = array();
         foreach($current_numbers as $number){
             if(!in_array(array("twiliophone"=>$number->phoneNumber), $rows)) array_push($res, array("phone"=>$number->phoneNumber,"sid"=>$number->sid));
         }

        $result->result=$res;
        $result->additional_info=$rows;
        echo (json_encode($result));           
     }

     public function list_twilio_numbers($option=0){
         $result = new MessageResult();

         $option=(int)$option;

         $area_codes = array("813", "407");

         if($option>1) $option =0;

          $current_numbers = list_twilio_available_numbers($area_codes[$option]);
          $res = array();
          foreach($current_numbers as $number){
             array_push($res, array("phone"=>$number->phoneNumber));
          }

         $result->result=$res;
         echo (json_encode($result));           
      }        
    

}

