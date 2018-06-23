<?php
class Customers_model extends CI_Model {

    public function __construct()
    {
            $this->load->database();
    }

    public function get_rows_customer(){
        return $this->db->count_all_results('tb_phone'); 
    }

    public function get_customers($page)
    {
        $this->db->from('tb_phone');
       // $this->db->order_by("No", "desc");
        $this->db->limit(10, $page*10);
        $query = $this->db->get(); 
        return $query->result_array();

    }

    public function get_condition_customer($no){
        $sql="SELECT * from tb_phone WHERE No=".$no;
        $query =$this->db->query($sql);
        return $query->result_array();
    }

    public function insert_customer($name, $phone, $note, $address, $city, $state, $zip){
        $sql = sprintf('INSERT INTO tb_phone (Name, PhoneNum, Note,Address,City,State, Zip) VALUES ("%s", "%s", "%s","%s" ,"%s","%s","%s")',$name, $phone, $note, $address, $city, $state, $zip);
        if ($this->db->simple_query($sql))
        {
                return true;
        }
        else
        {
                return false;
        }  

    }

    public function update_customer($no, $name, $phone, $note, $address, $city, $state, $zip){
        $sql = sprintf('UPDATE tb_phone
SET Name="%s", PhoneNum="%s", Note="%s",Address="%s",City="%s",State="%s", Zip="%s" WHERE No=%s', $name, $phone, $note, $address, $city, $state, $zip, $no);
        if ($this->db->simple_query($sql))
        {
                return true;
        }
        else
        {
                return false;
        }  

    }

    public function delete_customer($no){
         $sql = sprintf("Delete from tb_phone where No=%s", $no);
        if ($this->db->simple_query($sql))
        {
                return true;
        }
        else
        {
                return false;
        }    
    }
}