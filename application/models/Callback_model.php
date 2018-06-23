<?php
class Callback_model extends CI_Model {
    public $keys= array("phone", "type");

    public function __construct()
    {
            $this->load->database();
    }

    public function get_phone($type=0){
        $this->db->where("type",$type);
        $query = $this->db->get("tb_twilio_function");
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
        $this->db->delete("tb_twilio_function");
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        $this->db->insert("tb_twilio_function", $data);
    }

    public function update_phone($leads){
        $data = array();
        $this->db->where(array('phone'=>$leads["phone"]));
        $query = $this->db->get("tb_twilio_function");
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }

        $rows = $query->result_array();
        if(count($rows)==0){
            $this->db->insert("tb_twilio_function", $data);
            return 1;
        } 

        $this->db->where(array('phone'=>$leads["phone"]));
        $this->db->update("tb_twilio_function", $data);
        return $this->db->affected_rows();
    }


}