<?php
class Smsmsg extends CI_Controller {
        public $username;
        public $email;
        public $userid;
        public $userrole;
        public $permissions = array();

        public function __construct()
        {
                parent::__construct();
                $this->load->library('session');
                $this->load->model('smsmsg_model');
                $this->load->helper('url_helper');
                $this->load->helper('form');
                $this->load->helper('twilio');
                if(!$this->session->has_userdata('logged_in')){
                        redirect("users/login");
                }     
                $this->username = $this->session->userdata("username");
                $this->email = $this->session->userdata("email");
                $this->userrole = (int) $this->session->userdata("role");
                $this->userid = (int) $this->session->userdata("userid");
                $this->permissions["editsms"] = (int) $this->session->userdata("editsms");
                $this->permissions["sendsms"] = (int) $this->session->userdata("sendsms");
                $this->permissions["upload"] = (int) $this->session->userdata("upload");                                  
        }

        public function index()
        {

                $data['smsmsg'] = $this->smsmsg_model->get_smsmsg();

                $data['title']="All Sms received";
                $data['menuid']="actions";
                $data['submenuid']=0;               
                //Display the contents.
                $this->load->view('templates/header', $data);
                $this->load->view('smsmsg/index', $data);
                $this->load->view('templates/footer');                


        }

        public function view($newsms = TRUE)
        {
                 $sess_id = $this->session->userdata('logged_in');

                if(empty($sess_id) || $sess_id != TRUE)
                          redirect("/pages/view");

                $data['smsmsg'] = $this->smsmsg_model->get_smsmsg($newsms);

                if (empty($data['smsmsg']))
                {
                        show_404();
                }

                $data['title'] = "New Sms";
                $data['menuid']="actions";
                $data['submenuid']=0; 
                $this->load->view('templates/header', $data);
                $this->load->view('smsmsg/view', $data);
                $this->load->view('templates/footer');

        }


        public function callsendsms(){

                $phonenum = $this->input->post('phonenum');
                $msg = $this->input->post('sms_msg');
                
                //if(substr($phonenum, 0, 1)=="+") $phonenum=substr($phonenum, 1);
                $rep_arr=array("+","(",")","-","_"," ");
                
                $phonenum = str_replace($rep_arr, "", $phonenum);

                $len =strlen($phonenum);
                $data['msg']="";
                $data['menuid']="actions";
                $data['submenuid']=0;                  

                $regex = "/[0-9]+/";
                if ((preg_match($regex, $phonenum) && ($len>9 && $len<14)) && strlen($msg)>0) {
                    // Indeed, the expression "[a-zA-Z]+ \d+" matches the date string
                    //echo "Found a match!";
                        $respond ="success";
                        $phonenum = "+".$phonenum;
                        try{
                            //$sms = send_Sms($phonenum, $msg);
                            $sms = send_Sms($phonenum, $msg);
                            $this->smsmsg_model->insert_sms($phonenum, "+18137500671", $msg,1);                            
                        }catch(Exception $ex){
                            $respond="error";
                        }


                       // print_r($respond);
                        //$respond = "success";
                        if($respond != "success"){
                                $data['msg']=$respond;
                        }
                        else
                                $data['msg']="Sending sms success";
                } else {
                    // If preg_match() returns false, then the regex does not
                    // match the string
                    //echo "The regex pattern does not match. :(";
                        $data['msg']="Phone number is worng or Message body is empty";
                }

                //$data['title']= sprintf("phonenum:%s \n body: %s", $phonenum, $msg);
                $data['title']= "Send sms";
                $data['phonenum']=$phonenum;
                $data['menuid']="actions";
                $data['submenuid']=0; 
                $this->load->view('templates/mheader', $data);
                $this->load->view('templates/authnav', $data);
                $this->load->view('smsmsg/send', $data);
                $this->load->view('templates/mfooter');   

                   
        }

}