<?php
class Batch_model extends CI_Model {
    public $keys= array("sent_time","userid","sent_option","sent_entry");

    public function __construct()
    {
            $this->load->database();
    }
    
    public function insert_item($leads){
        $data = array();

        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        $this->db->insert("tb_batch_send_sms", $data);
    }

    public function get_total_sms_sent($conditions=array()){
        $ranges_con = "1";
        if(array_key_exists("start" ,$conditions) && $conditions["start"]!=""){
             $ranges_con = sprintf("( ta.sent_time > '%s' )", $conditions["start"]);
         }         
 
         $rangee_con = "1";
         if(array_key_exists("end" ,$conditions) && $conditions["end"]!=""){
              $rangee_con = sprintf("( ta.sent_time < '%s' )", $conditions["end"]);
          }   

          $cretaria = sprintf("%s and %s", $rangee_con , $ranges_con);
     //     $cretaria = 1;

        $querytxt = sprintf("select count(*) as batch_total, sum(sent_entry) as total from tb_batch_send_sms ta where %s", $cretaria);
        $query = $this->db->query($querytxt);
        return (array) $query->row();
    }    

    public function update_userinfo($leads){
         if(array_key_exists("phone", $leads)==false)return -1;
        $data = array();
        $this->db->where(array('phone'=>$leads["phone"]));
        $query = $this->db->get("tb_batch_send_sms");
        $rows = $query->result_array();
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        if(count($rows)==0) $this->db->insert("tb_batch_send_sms", $data);
        $this->db->where(array('phone'=>$leads["phone"]));
        $this->db->update("tb_batch_send_sms", $data);
        return $this->db->affected_rows();
    }

    public function get_userinfo($phone){
        $this->db->where("phone",$phone);
        $query = $this->db->get("tb_batch_send_sms");
       // $rows = $query->row();
        //return $row;
        $rows=$query->result_array();
        foreach ($rows as $row) {
            return $row;
        }
        return null;
    }

    public function list_leadtypes(){
        $querytxt = "select distinct(leadtype) from tb_batch_send_sms";
        $query = $this->db->query($querytxt);
        return $query->result_array(); 
    }

}