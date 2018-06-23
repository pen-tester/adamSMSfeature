<?php

class Authuser extends CI_Controller {
    public $username;
    public $userid;
    public $email;
    public $userrole;
    public $permissions=array();

        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('users_model');
            $this->load->database();
            $this->load->helper('twilio');

           // $this->load->library('token');
           $this->username = $this->session->userdata("username");
           $this->email = $this->session->userdata("email");
           $this->userrole = (int) $this->session->userdata("role");
           $this->userid = (int) $this->session->userdata("userid");
           $this->permissions["editsms"] = (int) $this->session->userdata("editsms");
           $this->permissions["sendsms"] = (int) $this->session->userdata("sendsms");
           $this->permissions["upload"] = (int) $this->session->userdata("upload"); 

            if(!$this->session->has_userdata('logged_in')){
                    redirect("users/login?redirect=".$this->input->server('REQUEST_URI'));
            }                
           // $this->load->library('token');

        }

        public function password(){
                $data['title']="Change your password";
                $data['menuid']="action";
                $data['submenuid']=3;
                $data["error"] = "";
          
                    $this->form_validation->set_rules('currentpwd', 'Current Password', 'required');
                    $this->form_validation->set_rules('newpwd', 'New Password', 'required');
                    $this->form_validation->set_rules('confirmpwd', 'Confirm Password', 'required');

                    if ($this->form_validation->run() === FALSE)
                    {
                        //Display the contents.
                        $this->load->view('templates/mheader', $data);
                        $this->load->view('templates/authnav', $data);
                        $this->load->view('authuser/password', $data);
                        $this->load->view('templates/mfooter');  

                    }
                    else
                    {
                        $currentpwd = $this->input->post("currentpwd");
                        $newpwd = $this->input->post("newpwd");
                        $confirmpwd = $this->input->post("confirmpwd");
                        if($confirmpwd != $newpwd ){
                            $data["error"]="Confirm does not match";
                             //Display the contents.
                            $this->load->view('templates/mheader', $data);
                            $this->load->view('templates/authnav', $data);
                            $this->load->view('authuser/password', $data);
                            $this->load->view('templates/mfooter');                             
                        }else{
                            $row = $this->users_model->get_user($this->userid, $currentpwd);
                            if($row == null){
                                 $data["error"]="Current Password is incorrect";
                                 //Display the contents.
                                $this->load->view('templates/mheader', $data);
                                $this->load->view('templates/authnav', $data);
                                $this->load->view('authuser/password', $data);
                                $this->load->view('templates/mfooter');                                
                            }    
                            else{

                                $leads["UsrId"] = $this->userid;
                                $leads["Pwd"] = $newpwd;
                                $this->users_model->update_userinfo($leads);
                                redirect("/authuser/success");                               
                            }
                        }

                    }  


        }

        public function sendsms(){

                $data['title']="Send Sms";
                $data['msg']="";
                $data['phonenum'] = $this->input->post("phonenum");
                $data['menuid']="actions";
                $data['submenuid']=0; 
                $this->load->view('templates/mheader', $data);
                $this->load->view('templates/authnav', $data);
                $this->load->view('smsmsg/send', $data);
                $this->load->view('templates/mfooter');   
        }

        public function settings(){
            $data['title']="Settings";
            $data['msg']="";
            $data['menuid']="settings";
            $data['submenuid']=0; 
            $this->load->view('templates/mheader', $data);
            $this->load->view('templates/authnav', $data);
            $this->load->view('authuser/settings', $data);
            $this->load->view('templates/mfooter');               
        }

        public function success(){
                $data['title']='Success Register user';
                $data['menuid']="home";
                $data['submenuid']=0; 
                //Display the contents.
                $this->load->view('templates/mheader', $data);
                $this->load->view('templates/authnav', $data);
                $this->load->view('users/success', $data);
                $this->load->view('templates/mfooter');              
        }        

        public function sendall(){
            if($this->permissions["sendsms"] == 0 && $this->userrole != 1000) {
                echo "you don't have the permission";
                return;
            }
                $data['title']='Send sms all option';
                $data['menuid']="sendsetup";
                $data['submenuid']=0; 
                //Display the contents.
                $this->load->view('templates/mheader', $data);
                $this->load->view('templates/authnav', $data);
                $this->load->view('authuser/sendall', $data);
                $this->load->view('templates/mfooter');               
        }

        public function uploads(){
            $data['title']='Send sms all option';
            $data['menuid']="uploads";
            $data['submenuid']=0; 
            //Display the contents.
            $this->load->view('templates/mheader', $data);
            $this->load->view('templates/authnav', $data);
            $this->load->view('authuser/uploads', $data);
            $this->load->view('templates/mfooter');                
        }

        public function archive(){
            $data['title']='Archive';
            $data['menuid']="archive";
            $data['submenuid']=0; 
            //Display the contents.
            $this->load->view('templates/mheader', $data);
            $this->load->view('templates/authnav', $data);
            $this->load->view('authuser/archive', $data);
            $this->load->view('templates/mfooter');              
        }
}

