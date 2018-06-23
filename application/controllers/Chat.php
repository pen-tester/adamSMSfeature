<?php

class Chat extends CI_Controller {
    public $username;
    public $userid;
    public $userrole;

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
            $this->username = $this->session->userdata("username");
            $this->userid = $this->session->userdata("email");
            $this->userrole = (int) $this->session->userdata("role");                
           // $this->load->library('token');
        }

        public function index(){
                $data['title']="Chat with customer";
                $data['menuid']="chat";
                $data['submenuid']=1;                 
                
           
                //Display the contents.
                $this->load->view('templates/mheader', $data);
                $this->load->view('templates/authnav', $data);
                $this->load->view('chat/index', $data);
                $this->load->view('templates/mfooter');   
        }
 
        public function setname(){
                $data['title']="Set Name";
                $data['menuid']="actions";
                $data['submenuid']=2;                 
                
           
                //Display the contents.
                $this->load->view('templates/mheader', $data);
                $this->load->view('templates/authnav', $data);
                $this->load->view('chat/setname', $data);
                $this->load->view('templates/mfooter');               
        }
        
}

