<?php
class Recentsmsarchive_model extends CI_Model {
    public $keys= array(
        "PhoneNum", "FromNum", "RecTime", "Content", "status", "readstatus", "ChatTime", "date_added", "date_sent", "firstname", "lastname", "phone", "contact", "email", "leadtype", "grade", "address", "city", "state", "zip", "owner_address", "owner_city", "owner_state", "called", "propertytype", "tax_assessment", "lastsolddate", "lastsoldprice", "bed", "bath", "zillow_estimate", "year_built", "owe", "offer", "sqft", "lot_size", "central_ac", "ac_note", "asking-price", "roof", "garage", "pool", "repairs", "occupancy", "rent", "zillow_link", "note", "rate", "podioitemid", "podiosellerid", "podiocashbuyerid", "realtor", "userid", "send_userid", "sms_sent_time", "send_username"
    );

    public function __construct()
    {
            $this->load->database();
    }
    
    public function insert_data($leads){
        $data = array();
        $this->db->where(array('phone'=>$leads["phone"]));
        $this->db->delete("tb_recentsmsarchive");
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        $this->db->insert("tb_recentsmsarchive", $data);
    }

    public function update_data($leads){
        if(array_key_exists("phone", $leads)==false)return -1;
        $data = array();
        $this->db->where(array('phone'=>$leads["phone"]));
        $query = $this->db->get("tb_recentsmsarchive");
        $rows = $query->result_array();
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        if(count($rows)==0) $this->db->insert("tb_recentsmsarchive", $data);
        else{
            $this->db->where(array('phone'=>$leads["phone"]));
            $this->db->update("tb_recentsmsarchive", $data);
        }

        return $this->db->affected_rows();
    }

    public function get_list_newsms_bypage($userid, $page=0,$search="", $grades=array(),$star="-1",$entries=10, $all=0, $leadtype=''){
        if(count($grades)==0) return null;
        $search_cretaria ="1";
        $rate_cretaria="1";
        $condition_grade="1";
        $leadtype_cretaria="1";
        $cretaria ="";
        if($search!=""){
             $search_cretaria ="(ta.leadtype like '%%s%' or ta.phone like '%%s%' or ta.Content like '%%s%' or concat(ta.firstname,' ', ta.lastname) like '%%s%' or concat(ta.address,',', ta.city,', ', ta.state, ', ', ta.zip) like '%%s%' or ta.grade like '%%s%')";
             $search_cretaria =str_replace("%s", $search, $search_cretaria);
        }
        if(count($grades)>0){
             $condition_grade="";
             foreach($grades as $grade){
                 $condition_grade = $condition_grade." or ta.grade='".$grade."'";
             }
             $condition_grade ="( ". substr($condition_grade, 3)." or ta.id is null)";          
        }
 
        if($star != "-1") $rate_cretaria=sprintf("ta.rate=%s", $star);
        if($leadtype !="-1") {
            $leadtype_cretaria = sprintf("ta.leadtype='%s'", $leadtype);
        }
 
        $cretaria = sprintf("%s and %s and %s and %s and (ta.send_userid='%s' or 1=%d)" , $search_cretaria ,$condition_grade, $rate_cretaria,$leadtype_cretaria,$userid,$all);
 
        $querytxt=sprintf("select * from tb_recentsmsarchive ta %s order by ta.RecTime desc limit %d offset %d","where ".$cretaria,  $entries, $page*$entries );
         $query = $this->db->query($querytxt);
         return $query->result_array();   
     }    
}