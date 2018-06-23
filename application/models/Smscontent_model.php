<?php
class Smscontent_model extends CI_Model {
    public $keys= array("msg", "userid",  "status",  "created");

    public function __construct()
    {
            $this->load->database();
    }

    public function list_smstemplates(){
        $query = $this->db->get('tb_messages');
        return $query->result_array();
    }
    
    public function get_sms($id){
        $this->db->where("id",$id);
        $query = $this->db->get("tb_messages");
       // $rows = $query->row();
        //return $row;
        $rows=$query->result_array();
        foreach ($rows as $row) {
            return $row;
        }
        return null;
    }

    public function get_sms_template_byid($id){
        $this->db->where("id",$id);
        $query = $this->db->get("tb_messages");
       // $rows = $query->row();
        //return $row;
        $rows=$query->result_array();
        foreach ($rows as $row) {
            return $row;
        }
        return null;        
    }


    public function insert_phone($leads){
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

    public function updatesms($leads){
        $data = array();
        $this->db->where(array('id'=>$leads["id"]));
        $query = $this->db->get("tb_messages");
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }

        $rows = $query->result_array();
        if(count($rows)==0){
            $this->db->insert("tb_messages", $data);
            return 1;
        } 

        $this->db->where(array('id'=>$leads["id"]));
        $this->db->update("tb_messages", $data);
        return $this->db->affected_rows();
    }


}