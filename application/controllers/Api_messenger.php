<?php
class Api_messenger extends CI_Controller {
  public $username;
  public $userid;
  public $email;
  public $userrole;
  public $permissions=array();
        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('phone_model');
            $this->load->model('smsmsg_model');
            $this->load->model('messenger_model');
            $this->load->database();
            $this->load->helper('twilio');
            $this->load->helper('predefined');
            $this->load->helper('result');
            $this->load->library('session');

           // $this->load->library('token');
           $this->username = $this->session->userdata("username");
           $this->email = $this->session->userdata("email");
           $this->userrole = (int) $this->session->userdata("role");
           $this->userid = (int) $this->session->userdata("userid");
           $this->permissions["editsms"] = (int) $this->session->userdata("editsms");
           $this->permissions["sendsms"] = (int) $this->session->userdata("sendsms");
           $this->permissions["upload"] = (int) $this->session->userdata("upload");     

            if(!$this->session->has_userdata('logged_in')){
                   header("Content-Type: application/json; charset=UTF-8");
                   $result = new MessageResult();
                   $result->code=0;
                   $result->status="error";
                   $result->errors=array("Not logged_in");
                   echo json_encode($result);
                   die;
            }  
           // $this->load->library('token');
           // header("Access-Control-Allow-Origin: *");
           // header("Access-Control-Allow-Methods: POST, GET");
           // header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
            header("Content-Type: application/json; charset=UTF-8");
        }

        public function send_singlesms(){
          $phone = $this->input->post("phone");
          $msg= $this->input->post("content");
                 $result=array();

                 if($msg=="" || $phone==""){
                  $result["status"] = "error";
                  $result["msg"] = "parameters are required.";
                  $result["code"]="101";
                  echo json_encode($result);
                  return;
                 }
                 try{
                    $sms = send_Sms($phone, $msg);  
                     $this->smsmsg_model->insert_sms($phone, "+17273501397", $msg);
                 }
                 catch(Exception $ex){
                    $status="failed";
                    $sms=$ex->getMessage();
                    $result["status"] = "error";
                    $result["msg"] = $sms;
                    $result["code"]="101";
                    echo json_encode($result);
                    return;                    
                 }       
                    $result["status"] = "ok";
                    $result["msg"] = "successfully sent";
                    $result["code"]="1";
                    $result["result"] = $sms;
                    echo json_encode($result);
                    return;                       
        }

        public function get_numbers_newsms(){
           $result = new MessageResult();

           $all = ($this->userrole==1000)?1:0;
           $count = $this->messenger_model->get_total_newsms($this->userid, $all);
           $result->result=array("total"=>$count);
           echo (json_encode($result));         
        }

        public function get_numbers_users(){
           $result = new MessageResult();
           $count = $this->messenger_model->get_numbers_users();
           $result->result=array("total"=>$count);
           echo (json_encode($result));           
        }

        public function get_recent_chatusers($page=0, $entry=5){
           $page = (int)$page;
           $result = new MessageResult();
           $users = $this->messenger_model->get_recent_chatuser($page);
           $result->result=$users;
           echo (json_encode($result));          
        }


        public function get_list_newsms($page='0',$entries='10'){
          $search = $this->input->post("search");
          $grades = $this->input->post("grades");
          $star = $this->input->post("star");
          $userid = (int)$this->input->post("userid");
          $leadtype = $this->input->post("leadtype");

          $userid = ($this->userrole == 1000)? $userid:$this->userid;

          $this->load->model("recentsmsarchive_model");
          $this->load->model("messenger_model");

          if($search==null) $search="";
          if($grades == null) $grades=array();
          if($star == null) $star="-1";
          $page = (int)$page;
          $entries = (int)$entries;
          $result = new MessageResult();
          $search = preg_replace( "/[^0-9 A-Za-z\.\+]/", '', $search);
          $all=0;
          if($userid == -1)$all = ($this->userrole==1000)?1:0;
          $sms_list = $this->recentsmsarchive_model->get_list_newsms_bypage($userid,$page,$search, $grades,$star, $entries, $all, $leadtype);
         //$sms_list = $this->messenger_model->get_list_newsms_bypage($userid,$page,$search, $grades,$star, $entries, $all, $leadtype);
          $result->result=$sms_list;
          echo (json_encode($result));

        }
        public function get_list_recentnewsms(){
          $page = (int)$this->input->post("page");
          $entries = (int)$this->input->post("entry");;
          $curno= (int)$this->input->post("curno");;
          $result = new MessageResult();
          $all = ($this->userrole==1000)?1:0;
          $sms_list = $this->messenger_model->get_list_recentnewsms($this->userid, $curno,$page,$entries, $all);
          $result->result=$sms_list;
          echo (json_encode($result));
        }
        public function remove_message(){

          $id = (int)$this->input->post("id");
          $result = new MessageResult();
          $sms_list = $this->messenger_model->remove_message($id);
          $result->result=$sms_list;
          echo (json_encode($result));
        }
        public function update_message_readstatus(){
          $id = (int)$this->input->post("id");
          $phone = $this->input->post("phone");
          $result = new MessageResult();
          $data["id"]=$id;
          $data["phone"] = $phone;
          $data["readstatus"]=1;
          $sms_list = $this->messenger_model->update_message_readstatus($data);
          $result->result=$sms_list;

          $this->load->model("recentsmsarchive_model");
          $this->recentsmsarchive_model->update_data($data);
          echo (json_encode($result));          
        }

        public function get_var(){
          $varname = $this->input->post("varname");
          $result = new MessageResult();
          $this->load->model("variable_model");
          $val = $this->variable_model->get_var($varname);
          $result->result=$val["valreplace"];
          echo (json_encode($result));          
        }

        public function insert_var(){
          $varname = $this->input->post("varname");
          $varval = $this->input->post("varval");
          $result = new MessageResult();
          $this->load->model("variable_model");
          $data["search"] = $varname;
          $data["valreplace"] = $varval;
          $val = $this->variable_model->insert_var($data);
          $result->result=$val;
          echo (json_encode($result));          
        }      

        public function get_member_info(){
          $phone = $this->input->post("phone");
          $result = new MessageResult();
          $this->load->model("archive_model");
          $res = $this->archive_model->get_userinfo($phone);
          $result->result=$res;
          echo (json_encode($result)); 
        }  

        public function update_member_info(){
          $target = $this->input->post("phone");
          $field = $this->input->post("field");
          $value=$this->input->post("value");
          $leads["phone"] = $target;
          $leads[$field] = $value;
          $result = new MessageResult();
          $this->load->model("archive_model");
          $this->load->model("recentsmsarchive_model");
          $res = $this->archive_model->update_userinfo($leads);
          $this->recentsmsarchive_model->update_data($leads);
          $result->result=$res;
          echo (json_encode($result));           
        }

        public function add_archive(){
          $leads=$this->input->post("leads");

          $result = new MessageResult();
          $this->load->model("archive_model");
          $this->load->model("recentsmsarchive_model");
          if(!array_key_exists("phone", $leads)){
            $result->result=$leads;
            $result->status="error";
            echo (json_encode($result));             
            return;
          }
          $prev = $this->archive_model->get_userinfo($leads["phone"]);
          if($prev!=null){
            $result->result=$leads;
            $result->status="error";
            $result->message="Existed phone number";
            echo (json_encode($result));             
            return;           
          }
          $leads["userid"]  = $this->userid;
          $leads["sms_sent_time"] = date("Y-m-d H:i:s");
          $res = $this->archive_model->insert_phone($leads);
          $leads["send_username"] = $this->username;
          $res = $this->recentsmsarchive_model->update_data($leads);

          $result->result=$res;
          $result->additional_info=$leads;
          echo (json_encode($result));              
        }

        public function update_member(){
          $leads = $this->input->post("leads");
          $result = new MessageResult();
          $this->load->model("archive_model");
          $res = $this->archive_model->update_userinfo($leads);
          $this->load->model("recentsmsarchive_model");
          $this->recentsmsarchive_model->update_data($leads);          
          $result->result=$res;
          echo (json_encode($result));           
        }


        public function load_message(){
          $phone = $this->input->post("phone");
          $cur_id = (int)$this->input->post("id");
          $result = new MessageResult();
          $this->load->model("messenger_model");
          $res = $this->messenger_model->load_message($phone,$cur_id);
          $result->result=array('phone'=>$phone, 'msg'=>$res);
          echo (json_encode($result));            
        }


  /*
     For the zillow and google map displaying.
  */
  public function get_zillow_propertyurl(){
    $addr = $this->input->post("addr");
    $zip = $this->input->post("zip");

    $result = new MessageResult();

    //Get the zillow property url to display
    $this->load->helper("zillow");
    $content = Zillow_Wrapper::get_allresult($addr,$zip);

    $result->result=$content;
    echo (json_encode($result));     
  }
  public function get_zillow_detailresult(){
    $zpid = $this->input->post("zpid");

    $result = new MessageResult();

    //Get the zillow property url to display
    $this->load->helper("zillow");
    $content = Zillow_Wrapper::get_detailed_info($zpid);

    $result->result=$content;
    echo (json_encode($result));     
  }   

  /*
    Upload Podio
  */
  public function upload_podio(){
    $leads = $this->input->post("leads");
    $result = new MessageResult();

    $allkeys = array("bedrooms","bathrooms", "zestimate-2","ac-notes", "roof", "type-of-property-3", "garage-2", "pool-notes", "last-sold-date", "repairs",  "size-of-the-house-sf", "year-built", "lot-size","asking-price","last-sold-amount","tax-assesment-value","zestimate-2","rent","our-offer","mortgage-amount-2",
    "vacant2", "rent", "notes-2");
    
    foreach (array_keys($leads) as $key) {
      
      if($leads[$key] == null || $leads[$key]==""){
        $leads[$key]="  ";
      }
      if(!array_key_exists($key , $allkeys)){
        unset($leads[$key]);
      }
    }

    
    $int_keys = array("bedrooms","bathrooms", "size-of-the-house-sf", "year-built", "lot-size");

    //Currency fields 
    $currency_keys = array("asking-price","last-sold-amount","tax-assesment-value","zestimate-2","rent","our-offer","mortgage-amount-2");

    foreach($currency_keys as $cur_key){
      if(!array_key_exists($cur_key, $leads)) $leads[$cur_key]="";
      $leads[$cur_key] =(int)preg_replace('/[^0-9]/', "", $leads[$cur_key] );
    }

    //Get the zillow property url to display
    $this->load->helper("podio");

    if(array_key_exists("bathrooms", $leads)){
      $bath = (int)((float)$leads["bathrooms"]/0.5);
      $leads["bathrooms"] = ($bath>0) ?$bath-1: 0;
    }

    if(array_key_exists("vacant2", $leads))$leads["vacant2"] =(int)($leads["vacant2"]) + 1;
    if(array_key_exists("mortgage-amount-2", $leads))$leads["mortgage-amount-2"] = array("value"=>(int)$leads["mortgage-amount-2"], "currency"=>"USD");
    if(array_key_exists("our-offer", $leads))$leads["our-offer"] = array("value"=>(int)$leads["our-offer"], "currency"=>"USD");
    if(array_key_exists("rent", $leads))$leads["rent"] = array("value"=>(int)$leads["rent"], "currency"=>"USD");
    if(array_key_exists("zestimate-2", $leads))$leads["zestimate-2"] = array("value"=>(int)$leads["zestimate-2"], "currency"=>"USD");
    if(array_key_exists("tax-assesment-value", $leads))$leads["tax-assesment-value"] = array("value"=>(int)$leads["tax-assesment-value"], "currency"=>"USD");
    if(array_key_exists("last-sold-amount", $leads))$leads["last-sold-amount"] = array("value"=>(int)$leads["last-sold-amount"], "currency"=>"USD");
    if(array_key_exists("asking-price", $leads))$leads["asking-price"] = array("value"=>(int)$leads["asking-price"], "currency"=>"USD");
    	


    foreach($int_keys as $number_key){
      if(!array_key_exists($number_key, $leads)) continue;
      $leads[$number_key] = (int) $leads[$number_key];
      if($leads[$number_key] == 0 )unset($leads[$number_key]);
    }

    if(init_podio()){
      $item = add_item_to_podio($leads);
    }

    $result->result=array("item_id" => $item->item_id);
    $result->addtional_info=$leads;
    echo (json_encode($result));     
  }

  public function upload_seller_podio(){
    $leads = $this->input->post("leads");
    $result = new MessageResult();

    $int_keys = array("property");
    //Get the zillow property url to display
    $this->load->helper("podio");
    
    foreach (array_keys($leads) as $key) {
      if($leads[$key] == null || $leads[$key]==""){
        $leads[$key]="  ";
      }
    }

    foreach($int_keys as $number_key){
      $leads[$number_key] = (int) $leads[$number_key];
      if($leads[$number_key] == 0 )unset($leads[$number_key]);
    }

    if(init_podio_seller()){
      $item = add_seller_to_podio($leads);
    }

    $result->result=array("item_id" => $item->item_id);
    $result->addtional_info=$leads;
    echo (json_encode($result));     
  } 

  public function update_seller_podio(){
    $leads = $this->input->post("leads");
    $result = new MessageResult();

    $int_keys = array("next-action");
    //Get the zillow property url to display
    $this->load->helper("podio");
    
    foreach (array_keys($leads) as $key) {
      if($leads[$key] == null || $leads[$key]==""){
        $leads[$key]="  ";
      }
    }

    foreach($int_keys as $number_key){
      $leads[$number_key] = (int) $leads[$number_key];
    }

    if(init_podio_seller()){
      $item = update_seller_to_podio($leads);
    }


      //$result->status='error';
      $params= (array)$item;
      if(array_key_exists("revision", $params))
        $result->result=array("item_id"=>$params["revision"]);
      else
        {
          $result->status='error';
          $result->result = $params;
        }
    
    $result->addtional_info=$leads;
    echo (json_encode($result));     
  }

  public function upload_cashbuyer_podio(){
    $leads = $this->input->post("leads");
    $result = new MessageResult();

    $int_keys = array("status2");
    //Get the zillow property url to display
    $this->load->helper("podio");
    
    foreach (array_keys($leads) as $key) {
      if($leads[$key] == null || $leads[$key]==""){
        $leads[$key]="  ";
      }
    }

    foreach($int_keys as $number_key){
      $leads[$number_key] = (int) $leads[$number_key];
    }

    if(init_podio_cashbuyer()){
      $item = upload_cashbuyer_podio($leads);
    }

    $result->result=array("item_id" => $item->item_id);
    $result->addtional_info=$leads;
    echo (json_encode($result));     
  }    

  /**
   * List lead type
   */

   public function list_leadtypes(){
      $result = new MessageResult();

      //Get the zillow property url to display
      $this->load->model("archive_model");
      $leadtypes = $this->archive_model->list_leadtypes();

      $result->result=$leadtypes;
      echo (json_encode($result)); 
   }
   
}



