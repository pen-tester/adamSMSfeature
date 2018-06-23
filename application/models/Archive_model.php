<?php
class Archive_model extends CI_Model {
    public $keys= array("date_added", "date_sent", "firstname", "lastname", "phone", "contact", "email", "leadtype", "grade", "address", "city", "state", "zip", "owner_address", "owner_city", "owner_state", "called", "propertytype", "tax_assessment", "lastsolddate", "lastsoldprice",  "bed", "bath", "zillow_estimate", "year_built", "owe", "offer", "sqft", "lot_size", "central_ac", "ac_note", "asking-price", "roof", "garage", "pool", "repairs", "occupancy", "rent", "zillow_link", "note", "rate","podioitemid", "podiosellerid", "podiocashbuyerid", "realtor", "userid","sms_sent_time","send_userid");

    public function __construct()
    {
            $this->load->database();
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

    public function update_userinfo($leads){
         if(array_key_exists("phone", $leads)==false)return -1;
        $data = array();
        $this->db->where(array('phone'=>$leads["phone"]));
        $query = $this->db->get("tb_archive");
        $rows = $query->result_array();
        foreach ($this->keys as $key) {
            if(array_key_exists($key, $leads)==true){
                $data[$key] = $leads[$key];
            }
        }
        if(count($rows)==0) $this->db->insert("tb_archive", $data);
        $this->db->where(array('phone'=>$leads["phone"]));
        $this->db->update("tb_archive", $data);
        return $this->db->affected_rows();
    }

    public function get_userinfo($phone){
        $this->db->where("phone",$phone);
        $query = $this->db->get("tb_archive");
       // $rows = $query->row();
        //return $row;
        $rows=$query->result_array();
        foreach ($rows as $row) {
            return $row;
        }
        return null;
    }

    public function list_leadtypes(){
        $querytxt = "select distinct(leadtype) from tb_archive";
        $query = $this->db->query($querytxt);
        return $query->result_array(); 
    }

    public function get_total_archive_number($conditions){
        $podio_con = "1"; 
        $conditions["podio"] =(int)$conditions["podio"];
        if(array_key_exists("podio" ,$conditions)){
            if($conditions["podio"] != -1){
                $podio_con = ($conditions["podio"] == 1)? "ta.podioitemid!=''":"ta.podioitemid=''";
            }
            
        }

        $realtor_con = "1"; 
        if(array_key_exists("realtor" ,$conditions)){
            $conditions["realtor"] =(int)$conditions["realtor"];            
            $realtor_con = ($conditions["realtor"] == 1)? "ta.realtor!=''":"1";
        }     
        else $conditions["realtor"]=0;
        $cashbuyer_con = "1"; 
        if(array_key_exists("cashbuyer" ,$conditions)){
            $conditions["cashbuyer"] =(int)$conditions["cashbuyer"];
            $cashbuyer_con = ($conditions["cashbuyer"] == 1)? "ta.podiocashbuyerid!=''":"1";
        }
        else $conditions["cashbuyer"] =0;
        
        $realtor_cash_con = sprintf("((%s and 1=%d) or (%s and 1=%d) or ((0=%d) and (0=%d)) )", $realtor_con ,$conditions["realtor"], $cashbuyer_con,$conditions["cashbuyer"],$conditions["realtor"],$conditions["cashbuyer"]);
                   

        $keyword_con = "1"; 
        if(array_key_exists("keyword" ,$conditions)){
            if($conditions["keyword"]!=""){
                $keyword_con ="(ta.leadtype like '%%s%' or ta.phone like '%%s%'  or concat(ta.firstname,' ', ta.lastname) like '%%s%' or concat(ta.address,',', ta.city,', ', ta.state, ', ', ta.zip) like '%%s%' or ta.grade like '%%s%')";
                $keyword_con =str_replace("%s", $conditions["keyword"], $keyword_con);
            }
        }  

        $star_con = "1"; 
        $conditions["star"] =(int)$conditions["star"];
        if(array_key_exists("star" ,$conditions)){
            if($conditions["star"] != -1){
                $star_con = ($conditions["star"] == 1)? "ta.rate=1":"ta.rate=0";
            }
        }   
        
        $user_con = "1"; 
        $conditions["user"] =(int)$conditions["user"];
        if(array_key_exists("user" ,$conditions)){
            $user_con = sprintf("( ta.userid='%s' or -1=%d)", $conditions["user"],$conditions["user"]);
        }   

        $lead_con = "1"; 
        if(array_key_exists("leadtype" ,$conditions)){
            $lead_con = sprintf("( ta.leadtype='%s' or 'All'='%s')", $conditions["leadtype"],$conditions["leadtype"]);
        }         

        $grades_con = "1";
        if(array_key_exists("grades" ,$conditions) && count($conditions["grades"])>0){
            $grades=$conditions["grades"];
            $grades_con="";
            foreach($grades as $grade){
                $grades_con = $grades_con." or ta.grade='".$grade."'";
            }
            $grades_con ="( ". substr($grades_con, 3).")";          
       }

       $ranges_con = "1";
       if(array_key_exists("start" ,$conditions) && $conditions["start"]!=""){
            $ranges_con = sprintf("( ta.sms_sent_time > '%s' )", $conditions["start"]);
        }         

        $rangee_con = "1";
        if(array_key_exists("end" ,$conditions) && $conditions["end"]!=""){
             $rangee_con = sprintf("( ta.sms_sent_time < '%s' )", $conditions["end"]);
         }         

       $cretaria = sprintf("( %s and %s and %s and %s and %s and %s and %s and %s and %s)",$podio_con, $user_con, $keyword_con, $grades_con, $star_con, $lead_con,
        $realtor_cash_con, $ranges_con, $rangee_con);

        $querytxt = "select count(*) as total from tb_archive ta where ".$cretaria;
        $query = $this->db->query($querytxt);
        return (array)$query->row();        
        //return $querytxt;
    }
    public function get_record_archive_page($conditions ,$page=0, $entry=30){
        $podio_con = "1"; 
        $conditions["podio"] =(int)$conditions["podio"];
        if(array_key_exists("podio" ,$conditions)){
            if($conditions["podio"] != -1){
                $podio_con = ($conditions["podio"] == 1)? "ta.podioitemid!=''":"ta.podioitemid=''";
            }
            
        }

        $realtor_con = "1"; 
        if(array_key_exists("realtor" ,$conditions)){
            $conditions["realtor"] =(int)$conditions["realtor"];            
            $realtor_con = ($conditions["realtor"] == 1)? "ta.realtor!=''":"1";
        }     
        else $conditions["realtor"]=0;
        $cashbuyer_con = "1"; 
        if(array_key_exists("cashbuyer" ,$conditions)){
            $conditions["cashbuyer"] =(int)$conditions["cashbuyer"];
            $cashbuyer_con = ($conditions["cashbuyer"] == 1)? "ta.podiocashbuyerid!=''":"1";
        }
        else $conditions["cashbuyer"] =0;
        
        $realtor_cash_con = sprintf("((%s and 1=%d) or (%s and 1=%d) or ((0=%d) and (0=%d)) )", $realtor_con ,$conditions["realtor"], $cashbuyer_con,$conditions["cashbuyer"],$conditions["realtor"],$conditions["cashbuyer"]);
           
           

        $keyword_con = "1"; 
        if(array_key_exists("keyword" ,$conditions)){
            if($conditions["keyword"]!=""){
                $keyword_con ="(ta.leadtype like '%%s%' or ta.phone like '%%s%' or concat(ta.firstname,' ', ta.lastname) like '%%s%' or concat(ta.address,',', ta.city,', ', ta.state, ', ', ta.zip) like '%%s%' or ta.grade like '%%s%')";
                $keyword_con =str_replace("%s", $conditions["keyword"], $keyword_con);
            }
        }  

        $star_con = "1"; 
        $conditions["star"] =(int)$conditions["star"];
        if(array_key_exists("star" ,$conditions)){
            if($conditions["star"] != -1){
                $star_con = ($conditions["star"] == 1)? "ta.rate=1":"ta.rate=0";
            }
        }   
        
        $user_con = "1"; 
        $conditions["user"] =(int)$conditions["user"];
        if(array_key_exists("user" ,$conditions)){
            $user_con = sprintf("( ta.userid='%s' or -1=%d)", $conditions["user"],$conditions["user"]);
        }   

        $lead_con = "1"; 
        if(array_key_exists("leadtype" ,$conditions)){
            $lead_con = sprintf("( ta.leadtype='%s' or 'All'='%s')", $conditions["leadtype"],$conditions["leadtype"]);
        }         

        $grades_con = "1";
        if(array_key_exists("grades" ,$conditions) && count($conditions["grades"])>0){
            $grades=$conditions["grades"];
            $grades_con="";
            foreach($grades as $grade){
                $grades_con = $grades_con." or ta.grade='".$grade."'";
            }
            $grades_con ="( ". substr($grades_con, 3).")";          
       }

       $ranges_con = "1";
       if(array_key_exists("start" ,$conditions) && $conditions["start"]!=""){
            $ranges_con = sprintf("( ta.sms_sent_time > '%s' )", $conditions["start"]);
        }         

        $rangee_con = "1";
        if(array_key_exists("end" ,$conditions) && $conditions["end"]!=""){
             $rangee_con = sprintf("( ta.sms_sent_time < '%s' )", $conditions["end"]);
         }         

       $cretaria = sprintf("( %s and %s and %s and %s and %s and %s and %s and %s and %s)",$podio_con, $user_con, $keyword_con, $grades_con, $star_con, $lead_con,
        $realtor_cash_con, $ranges_con, $rangee_con);

        $querytxt =sprintf( "select * from tb_archive ta where %s order by ta.id desc limit %d offset %d", $cretaria, $entry, $page*$entry);
        $query = $this->db->query($querytxt);
        return $query->result_array();        
    }

    public function get_total_number_called($conditions){
        $ranges_con = "1";
        if(array_key_exists("start" ,$conditions) && $conditions["start"]!=""){
             $ranges_con = sprintf("( ta.sms_sent_time > '%s' )", $conditions["start"]);
         }         
 
         $rangee_con = "1";
         if(array_key_exists("end" ,$conditions) && $conditions["end"]!=""){
              $rangee_con = sprintf("( ta.sms_sent_time < '%s' )", $conditions["end"]);
          }   

          $cretaria = sprintf("%s and %s and ta.called=1", $rangee_con , $ranges_con);
          //$cretaria = 1;

        $querytxt = sprintf("select count(*) as total from tb_archive ta where %s", $cretaria);
        $query = $this->db->query($querytxt);
        return (array) $query->row();        
    }

    public function get_total_number_by_attr($conditions, $attr = 'called'){
        $ranges_con = "1";
        if(array_key_exists("start" ,$conditions) && $conditions["start"]!=""){
             $ranges_con = sprintf("( ta.sms_sent_time > '%s' )", $conditions["start"]);
         }         
 
         $rangee_con = "1";
         if(array_key_exists("end" ,$conditions) && $conditions["end"]!=""){
              $rangee_con = sprintf("( ta.sms_sent_time < '%s' )", $conditions["end"]);
          }   


         // $ranges_con = "1";$rangee_con = "1";
          $cretaria = sprintf("%s and %s and ta.%s !=''", $rangee_con , $ranges_con, $attr);

        $querytxt = sprintf("select count(*) as total from tb_archive ta where %s", $cretaria);
        $query = $this->db->query($querytxt);
        return (array) $query->row();        
    }


    public function get_total_number_by_attr_group($conditions ,$attr='grade'){
        $ranges_con = "1";
        if(array_key_exists("start" ,$conditions) && $conditions["start"]!=""){
             $ranges_con = sprintf("( ta.sms_sent_time > '%s' )", $conditions["start"]);
         }         
 
         $rangee_con = "1";
         if(array_key_exists("end" ,$conditions) && $conditions["end"]!=""){
              $rangee_con = sprintf("( ta.sms_sent_time < '%s' )", $conditions["end"]);
          }   

          $cretaria = sprintf("%s and %s", $rangee_con , $ranges_con);
          //$cretaria = 1;

        $querytxt = sprintf("select %s as name, count(*) as total from tb_archive ta where %s group by %s",$attr, $cretaria ,$attr);
        $query = $this->db->query($querytxt);
        return $query->result_array();        
    }    

}