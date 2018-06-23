<?php
class Phone_model extends CI_Model {

        public $keys=array("sent", "date_added",  "date_sent", "address", "city", "state", "firstname", "lastname", "owner_address", "owner_city", "owner_state", "phone0", "phone1", "phone2", "phone3", "phone4", "phone5", "phone6", "phone7", "phone8", "phone9", "leadtype", "userid");

        public function __construct()
        {
                $this->load->database();
        }
    
        public function get_allphones($option='0', $userid=0, $all=0, $entry=0)
	{
                $querytxt="";
                if($entry!=0) $querytxt= sprintf("select * from tb_phone where (userid='%s' or 1=%d) and sent NOT LIKE '%%%s%%' order by id limit %d",$userid, $all, $option, $entry);
                else $querytxt= sprintf("select * from tb_phone where (userid='%s' or 1=%d) and  sent NOT LIKE '%%%s%%' order by id",$userid, $all, $option);
                $query =$this->db->query($querytxt);
                return $query->result_array(); 
        }

        public function update_phone($leads){
                if(!isset($leads["id"]))return -1;
                $data = array();
                foreach ($this->keys as $key) {
                        if(array_key_exists($key, $leads)==true){
                        $data[$key] = $leads[$key];
                        }
                }
                $this->db->where("id", $leads["id"]);
                $this->db->update("tb_phone", $data);   
                return $this->db->affected_rows();              
        }

        public function insert_phone($leads){
                $data = array();
                foreach ($this->keys as $key) {
                        if(array_key_exists($key, $leads)==true){
                        $data[$key] = $leads[$key];
                        }
                }
                $this->db->insert("tb_phone", $data);
        }    

        public function list_phones($userid=0, $page=0, $limit=50, $all=0)
	{
                $querytxt = sprintf("select * from tb_phone where userid='%s' or 1=%d order by id limit %d offset %d",$userid, $all, $limit, $page*$limit);
                $query =$this->db->query($querytxt);
                return $query->result_array();               
        }

        public function get_total_number_of_phones($userid, $all=0){
                $querytxt = sprintf("select count(*) as total from tb_phone where userid='%s' or 1=%d",$userid, $all);
                $query =$this->db->query($querytxt);
                return $query->row();                
        }

        public function delete_allphones($userid=0, $all=0){
                $querytxt = sprintf("delete from tb_phone where userid='%s' or 1=%d",$userid, $all);
                $query =$this->db->query($querytxt);
                return $this->db->affected_rows();                
        }

}