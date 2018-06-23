<?php
class Messenger_model extends CI_Model {
    public $keys= array("FromNum", "PhoneNum", "Content", "RecTime", "status","readstatus");

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

    public function get_total_newsms($userid=0, $all=0){
       // $querytxt = "select count(*) as total from tb_recsms where status=0";
        $querytxt=sprintf("select count(*) as total from (select max(No) as No, FromNum,max(ChatTime) as ChatTime from tb_recsms where status=0 group by FromNum ) ts join tb_archive ta on ta.phone=ts.FromNum and (ta.send_userid='%s' or 1=%d)", $userid, $all);
        $query = $this->db->query($querytxt);
        $row = $query->row();
        return $row->total;
    }

    public function get_numbers_users(){
        $querytxt = "select count(*) as total from (select max(No) as No, FromNum,max(ChatTime) as ChatTime from tb_recsms where readstatus=1 and status=0 group by FromNum) tso left join tb_archive ta on ta.phone=tso.FromNum";
        $query = $this->db->query($querytxt);
        $row = $query->row();
        return $row->total;       
    }

    public function get_list_newsms_bypage($userid, $page=0,$search="", $grades=array(),$star="-1",$entries=10, $all=0, $leadtype=''){
       /* $querytxt =sprintf("select tr.*,ta.firstname, ta.lastname,ta.address,ta.state,ta.city, ta.zip, ta.leadtype from tb_recsms tr left join tb_archive ta on tr.FromNum=ta.phone where status=0 order by No desc limit %d offset %d", $entries, $page*$entries);*/
       if(count($grades)==0) return null;
       $search_cretaria ="1";
       $rate_cretaria="1";
       $condition_grade="1";
       $leadtype_cretaria="1";
       $cretaria ="";
       if($search!=""){
            $search_cretaria ="(ta.leadtype like '%%s%' or ta.phone like '%%s%' or tsms.Content like '%%s%' or concat(ta.firstname,' ', ta.lastname) like '%%s%' or concat(ta.address,',', ta.city,', ', ta.state, ', ', ta.zip) like '%%s%' or ta.grade like '%%s%')";
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

       $querytxt=sprintf("select tt.*, tb_user.Name as username from (select tso.*,ta.*, tsms.Content,tsms.RecTime,tsms.readstatus from (select max(No) as No, FromNum,max(ChatTime) as ChatTime from tb_recsms where status=0 group by FromNum) tso left join tb_archive ta on ta.phone=tso.FromNum  join tb_recsms tsms on tsms.No=tso.No %s) tt left join tb_user on tt.send_userid=tb_user.No order by tt.No desc limit %d offset %d","where ".$cretaria,  $entries, $page*$entries );
        $query = $this->db->query($querytxt);
        return $query->result_array();   
    }

    public function get_list_recentnewsms($userid=0, $cur_no=0, $page=0,$entries=10, $all=0){
        $querytxt =sprintf("select tr.*,ta.firstname, ta.lastname,ta.address,ta.state,ta.city, ta.zip, ta.leadtype from tb_recsms tr left join tb_archive ta on tr.FromNum=ta.phone and (ta.send_userid='%s' or 1=%d) where status=0 and No>%d order by No desc limit %d offset %d",$userid, $all, $cur_no, $entries, $page*$entries);
        $query = $this->db->query($querytxt);
        return $query->result_array();   
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

    public function insert_sms($phoneNum,$fromNum,$msg_body){

       date_default_timezone_set('US/Eastern');
     //  echo date_default_timezone_get();
       $currenttime = date("Y-m-d H:i:s");
      
        //$recTime =  date('m/d/Y h:i:s a', time());
        $recTime =  $currenttime;

        $data = array(
                'PhoneNum' => $phoneNum,
                'FromNum'=>$fromNum,
                'RecTime' => $recTime,
                'Content' => $msg_body
        );

        $this->db->insert('tb_recsms', $data);
        //send_Sms("+17274872339", $msg);
        //send_Sms("+8615714254213", $msg);
        //send_Sms("+8618242423147", $msg);
        // Create connection
    
    }

    public function remove_message($id){
        $this->db->where(array("No"=>$id));
        $this->db->delete("tb_recsms");
        return $this->db->affected_rows();
    }

    public function update_message($data){
        $udata= array();
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $data))
                $udata[$key] = $data[$key];
        }
        $this->db->where(array("No"=>$data["id"]));
        $this->db->update("tb_recsms", $udata);
        return $this->db->affected_rows();
    }

    public function update_message_readstatus($data){
        $now = date('Y-m-d H:i:s');
        $this->db->where(array("No"=>$data["id"]));
        $this->db->update("tb_recsms", array('ChatTime'=>$now));
        $udata= array();
        $udata["readstatus"] = $data["readstatus"];
        $this->db->where(array("FromNum"=>$data["phone"]));
        $this->db->update("tb_recsms", $udata);
        return $this->db->affected_rows();
    }   

    public function get_recent_chatuser($page=0 ,$entry=5){
        $querytxt =sprintf("select tso.*,ta.*, tsms.Content from (select max(No) as No, FromNum,max(ChatTime) as ChatTime from tb_recsms where readstatus=1 and status=0 group by FromNum  order by ChatTime desc limit 5 offset %d) tso left join tb_archive ta on ta.phone=tso.FromNum join tb_recsms tsms on tsms.No=tso.No order by ChatTime desc", $page*$entry);
        $query=$this->db->query($querytxt);
        return $query->result_array();
    } 

    public function load_message($phone, $cur_id){
        $querytxt= sprintf("select * from tb_recsms where (FromNum='%s') order by No desc  limit 10 offset 1", $phone, $cur_id);
        $query=$this->db->query($querytxt);
        return $query->result_array();       
    }
}