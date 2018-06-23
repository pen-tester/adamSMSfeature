<?php
class Users extends CI_Controller {
    public $username;
    public $userid;
    public $userrole;
    public $editsms;    
        public function __construct()
        {
            // Construct our parent class
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('url_helper');
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('users_model');
            $this->load->database();
            $this->load->library('session');
           // $this->load->library('token');
           // $this->load->library('token');
            $this->username = $this->session->userdata("username");
            $this->userid = $this->session->userdata("email");
            $this->userrole = (int) $this->session->userdata("role");
            $this->editsms = (int) $this->session->userdata("editsms");            
        }

        public function login($redirect='')
        {
            $redirect = $this->input->get_post("redirect", TRUE);            
                if($this->session->has_userdata('logged_in') && $this->session->userdata("logged_in")==true){
                        redirect("main/view");
                }
                else{
                    $this->form_validation->set_rules('email', 'User Email', 'required|valid_email');
                   // $this->form_validation->set_rules('email', 'User Email', 'required|valid_email|callback_useremail_check');
                    $this->form_validation->set_rules('password', 'Password', 'required');
                        $data['title']='Login';
                        $data['menuid']="home";
                        $data['submenuid']=0; 
                    if ($this->form_validation->run() === FALSE)
                    {
                        $this->load->view('templates/header', $data);
                        $this->load->view('users/login', $data);
                        $this->load->view('templates/footer', $data);       
                    }               
                    else{
                        $row=$this->users_model->get_user($this->input->post("email"),$this->input->post("password"));
                        if($row == null){
                                $data['error']="User email or password incorrect";
                                 $this->load->view('templates/header', $data);
                                $this->load->view('users/login', $data);
                                $this->load->view('templates/footer', $data);  
                        }
                        else{
                            if((int)$row["active"]==1 || (int)$row["role"]==1000){
                                $newdata = array(
                                        'userid'=>$row["No"],
                                        'username'  => $row["Name"],
                                        'email'     => $row["UsrId"],
                                        'role' =>$row["role"],
                                        'editsms'=>$row['editsms'],
                                        'sendsms'=>$row["sendsms"],
                                        'upload'=>$row["upload"],
                                        'logged_in' => TRUE
                                );

                                $this->session->set_userdata($newdata);
                                if($redirect!=""){
                                    redirect($redirect);
                                }
                                else redirect("messenger/index");                                
                            }
                            else{
                                 $data['error']="User is not activated";
                                 $this->load->view('templates/header', $data);
                                $this->load->view('users/login', $data);
                                $this->load->view('templates/footer', $data);                                 
                            }
                        }
                    }
                }

        }

        public function logout(){
                $array_items = array('username', 'email', 'logged_in','role');
                $this->session->unset_userdata($array_items);
                redirect("/main/view");
        }

        public function register()
        {
        	$data['title']='Register user';
                $data['menuid']="home";
                $data['submenuid']=0;             

                    $this->form_validation->set_rules('name', 'Last Name', 'required|max_length[30]');
                    $this->form_validation->set_rules('email', 'User Email', 'required|valid_email|is_unique[tb_user.UsrId]');
                   // $this->form_validation->set_rules('email', 'User Email', 'required|valid_email|callback_useremail_check');
                    $this->form_validation->set_rules('password', 'Password', 'required');
                    $this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'required|matches[password]');

                    if ($this->form_validation->run() === FALSE)
                    {
                        $this->load->view('templates/mheader', $data);
                        $this->load->view('templates/authnav', $data);
                        $this->load->view('users/register', $data);
                        $this->load->view('templates/footer', $data);

                    }
                    else
                    {
                        $this->users_model->add_user();
                        redirect("/users/success");
                    }                
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

        public function dashboard()
        {
                if(!$this->session->has_userdata('logged_in')){
                        redirect("users/login");
                }
                else{
                        $data['title']='dashboard';
                        $data['menuid']="home";
                        $data['submenuid']=0;                         
                        $this->load->view('templates/mainheader', $data);
                        $this->load->view('templates/sidebar', $data);
                        $this->load->view('users/dashboard', $data);
                        $this->load->view('templates/footer', $data);

                }
        }   
        
}

