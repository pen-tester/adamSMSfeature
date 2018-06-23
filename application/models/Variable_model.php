<?php
class Variable_model extends CI_Model {
    public $keys= array("search", "valreplace");

    public function __construct()
    {
            $this->load->database();
    }
    
    public function insert_var($leads)
	{
        if(!array_key_exists("search",$leads)) return -1;
        $this->db->where(array("search"=>$leads["search"]));
        $this->db->delete("tb_variables");
        $udata = array();
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads))
                $udata[$key] = $leads[$key];
        }        
        $query= $this->db->insert("tb_variables", $udata);
        
        //return $this->db->affected_rows();
        return $udata;
	}

    public function get_var($search){
        $this->db->where(array("search"=>$search));
        $query= $this->db->get("tb_variables");
        $rows=$query->result_array();
        foreach($rows as $row){
            return $row;
        }
        return null;
    }
}