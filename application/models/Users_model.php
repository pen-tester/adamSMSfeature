<?php
class Users_model extends CI_Model {

    public $keys= array("Name", "UsrId","Pwd", "twiliophone", "backwardnumber", "twilionumbersid", "editsms", "sendsms", "upload", "role", "active", "created");

        public function __construct()
        {
                $this->load->database();
        }
        public function add_user()
        {
        	$data = array(
			        'Name' => $this->input->post('name'),
			        'UsrId'=>$this->input->post('email'),
			        'Pwd'=>hash ( "sha256", $this->input->post('password'))
			);
			$this->db->insert('tb_user', $data);
        }

        public function get_current_smsnumbers(){
            $this->db->select("twiliophone");
            $query= $this->db->get("tb_user");
            return $query->result_array();
        }

        public function get_userbyid($id=0){
            $this->db->where("No", $id);
            $query= $this->db->get("tb_user");
            return $query->row();
        }

        public function get_user($user, $password){
        	$pwd=hash("sha256", $password);
        	$query = $this->db->get_where('tb_user', array('UsrId'=>$user, 'Pwd'=>$pwd));
        	foreach ($query->result_array() as $row)
			{
				return $row;
			}
			return null;
        }

        public function get_users_page($page= 0, $entry=30){
            $querytxt = "select No, Name,UsrId, twiliophone,backwardnumber,twilionumbersid,created, editsms,sendsms, upload, role ,active   from tb_user order by role desc";
            $query = $this->db->query($querytxt);    
            return $query->result_array();       
        }

        public function get_number_of_all_users(){
            $querytxt = "select count(*) as total from tb_user";
            $query = $this->db->query($querytxt);
            $row = $query->row();
            return $row;
        }

        public function delete_user($user){
            $this->db->where("UsrId", $user);
            $this->db->delete('tb_user');
            return $this->db->affected_rows();
        }

        public function listusers(){
            $this->db->select("No,Name, UsrId, editsms, active,created");
            $this->db->where("role", 1);
            $query=$this->db->get('tb_user');
            return $query->result_array();
        }

        public function list_all_users(){
            $this->db->select("No,Name, UsrId, editsms, active,created");
            $query=$this->db->get('tb_user');
            return $query->result_array();
        }        

    public function update_userinfo($leads){
        $data = array();
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        if(array_key_exists("Pwd", $leads) == true){
            $data["Pwd"] = hash("sha256", $leads["Pwd"]);
        }

        $this->db->where(array('UsrId'=>$leads["UsrId"]));
        $this->db->update("tb_user", $data);
        return $this->db->affected_rows();
    }

    public function update_userinfobyid($leads){
        $data = array();
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        if(array_key_exists("Pwd", $leads) == true){
            $data["Pwd"] = hash("sha256", $leads["Pwd"]);
        }

        $this->db->where(array('No'=>$leads["No"]));
        $this->db->update("tb_user", $data);
        return $this->db->affected_rows();
    }    

    public function insert_user($leads){
        $data = array();
        $this->db->where(array('phone'=>$leads["phone"]));
        $this->db->delete("tb_archive");
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        $this->db->insert("tb_archive", $data);
    }

    public function get_current_phonenumber($id=0){
        $this->db->where("No", $id);
        $this->db->select("twiliophone as phone, twilionumbersid as sid");
        $query = $this->db->get("tb_user");
        return $query->row();
    }

    public function get_current_callnumber($id=0){
        $this->db->where("No", $id);
        $this->db->select("backwardnumber as phone");
        $query = $this->db->get("tb_user");
        return $query->row();
    }    

}
