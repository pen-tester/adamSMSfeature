<?php
class Uploadphonearchive_model extends CI_Model {
    public $keys= array("sent", "date_added", "date_sent", "address", "city", "state", "firstname", "lastname", "owner_address", "owner_city", "owner_state", "phone0", "phone1", "phone2", "phone3", "phone4", "phone5", "phone6", "phone7", "phone8", "phone9", "leadtype", "userid", "batch_sent_date", "sent_option", "send_userid" );

    public function __construct()
    {
            $this->load->database();
    }
    
    public function insert_phone($leads){
        $data = array();
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        $this->db->insert("tb_upload_phone_archive", $data);
    }

    public function update_userinfo($leads){
         if(array_key_exists("id", $leads)==false)return -1;
        $data = array();
        $this->db->where(array('id'=>$leads["id"]));
        $query = $this->db->get("tb_upload_phone_archive");
        $rows = $query->result_array();
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        if(count($rows)==0) $this->db->insert("tb_upload_phone_archive", $data);
        $this->db->where(array('id'=>$leads["id"]));
        $this->db->update("tb_upload_phone_archive", $data);
        return $this->db->affected_rows();
    }

    public function get_userinfo($id){
        $this->db->where("id",$id);
        $query = $this->db->get("tb_upload_phone_archive");
       // $rows = $query->row();
        //return $row;
        $rows=$query->result_array();
        foreach ($rows as $row) {
            return $row;
        }
        return null;
    }

    public function get_total_phone_numbers($userid=0, $all=0){
        $querytxt = sprintf("select count(*) as total from tb_upload_phone_archive where userid='%s' or 1=%d", $userid, $all );
        $query = $this->db->query($querytxt);
        return (array)$query->row();
    }

    public function get_phones_page($userid=0,$page=0, $entry=100, $all=0){
        $querytxt = sprintf("select tua.*, tu.Name  from (select * from tb_upload_phone_archive where send_userid='%s' or 1=%d ) tua left join tb_user tu on tua.send_userid=tu.No  order by tua.batch_sent_date desc limit %d offset %d", $userid, $all, $entry, $page * $entry );
        $query = $this->db->query($querytxt);
        return $query->result_array();
    }    
}