<?php
class Log_model extends CI_Model {
    public $keys = array('create', 'opt', 'userid');

    public function __construct()
    {
            $this->load->database();
    }
    
    public function get_alllogs($opt = 0)
	{
        $this->db->from('tb_sendlog');
        $query = $this->db->get(); 
        return $query->result_array();
    }
    
    public function get_recent_count($opt =0 ,$userid=0){
        $now =  date('Y-m-d H:i:s');
        $querytxt = sprintf("select count(*) as count from tb_sendlog where created > subdate('%s', interval 15 minute) and opt=%d and userid='%s'", $now, $opt, $userid);
        $query = $this->db->query($querytxt);
        $row = $query->row();
        return (int)$row->count;
    }

    public function insert_log($opt =0, $userid=0){
        $data['opt'] = $opt;
        $data['userid'] = $userid;
        $data['created'] =  date('Y-m-d H:i:s');
        $this->db->insert('tb_sendlog', $data);
        return $this->db->affected_rows();
    }
}