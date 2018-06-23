<?php

class Adminuser extends CI_Controller {
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
            $this->load->model('smsmsg_model');
            $this->load->database();
            $this->load->helper('twilio');

            if(!$this->session->has_userdata('logged_in')){
                    redirect("users/login?redirect=".$this->input->server('REQUEST_URI'));
            }                
           // $this->load->library('token');
           // $this->load->library('token');
           $this->username = $this->session->userdata("username");
           $this->email = $this->session->userdata("email");
           $this->userrole = (int) $this->session->userdata("role");
           $this->userid = (int) $this->session->userdata("userid");
           $this->permissions["editsms"] = (int) $this->session->userdata("editsms");
           $this->permissions["sendsms"] = (int) $this->session->userdata("sendsms");
           $this->permissions["upload"] = (int) $this->session->userdata("upload");   

            if($this->userrole != 1000){
            	redirect("/messenger/index");
            }
        }

        public function users(){
                $data['title']="Users";
                $data['menuid']="messenger";
                $data['submenuid']=2;                 
                
                //Display the contents.
                $this->load->view('templates/mheader', $data);
                $this->load->view('templates/authnav', $data);
                $this->load->view('adminuser/users', $data);
                $this->load->view('templates/mfooter');   
        }

        public function set_number(){
                $data['title']="Set the Callback number";
                $data['menuid']="actions";
                $data['submenuid']=2;                 
                
                //Display the contents.
                $this->load->view('templates/mheader', $data);
                $this->load->view('templates/authnav', $data);
                $this->load->view('adminuser/setnumber', $data);
                $this->load->view('templates/mfooter');   
        }      
        public function reporting(){
                $data['title']="Reporting";
                $data['menuid']="reporting";
                $data['submenuid']=2;                 
                
                //Display the contents.
                $this->load->view('templates/mheader', $data);
                $this->load->view('templates/authnav', $data);
                $this->load->view('adminuser/reporting', $data);
                $this->load->view('templates/mfooter');   
        }        
          
}

