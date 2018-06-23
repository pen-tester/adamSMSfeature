<?php
class Smsmsg_model extends CI_Model {

    public $pkeys = array("PhoneNum", "FromNum", "RecTime", "Content", "status", "readstatus", "ChatTime", "userid");


    public function __construct()
    {
            $this->load->database();
    }
    
    public function get_smsmsg($all_flag = TRUE)
	{
        $this->db->from('tb_recsms');
        $this->db->where(array("FromNum !="=>"+17273501397"));
        $this->db->or_where("FromNum is null");
        $this->db->order_by("No", "desc");
        $this->db->limit(150, 0);
        $query = $this->db->get();
        return $query->result_array();
        /*
        if ($all_flag === TRUE)
        {
                $this->db->from('tb_recsms');
                $this->db->order_by("No", "desc");
                $this->db->limit(10, 0);
                $query = $this->db->get(); 
                return $query->result_array();
                /*
                $query = $this->db->get('tb_recsms');
                return $query->result_array();
               
        }

        $query = $this->db->get_where('tb_recsms', array('NewSms' => 0));
        return $query->row_array();
        */
	}

    public function list_chat($phone){
        $querytxt= sprintf("select * from tb_recsms where PhoneNum='%s' or FromNum='%s' order by No desc", $phone, $phone);
        $query=$this->db->query($querytxt);
        return $query->result_array();

    }
    public function list_newchat($phone,$id){
        $querytxt= sprintf("select * from tb_recsms where (PhoneNum='%s' or FromNum='%s') and No>%d order by No desc", $phone, $phone, $id);
        $query=$this->db->query($querytxt);
        return $query->result_array();

    }    

    public function insert_sms($phoneNum,$fromNum,$msg_body,$status=0){

       date_default_timezone_set('US/Eastern');
     //  echo date_default_timezone_get();
       $currenttime = date("Y-m-d H:i:s");
      
        //$recTime =  date('m/d/Y h:i:s a', time());
        $recTime =  $currenttime;

        $data = array(
                'PhoneNum' => $phoneNum,
                'FromNum'=>$fromNum,
                'RecTime' => $recTime,
                'Content' => $msg_body,
                'status' =>$status
        );

        $this->db->insert('tb_recsms', $data);
    
    }

    public function add_sms($leads){
        $data = array();
        foreach ($this->pkeys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        $this->db->insert("tb_recsms", $data);
        return $this->db->affected_rows();        
    }
}