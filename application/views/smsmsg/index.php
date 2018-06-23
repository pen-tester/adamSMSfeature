<form method="post" id="sms_form" action="/smsmsg/sendsms">
	  <div class="container">
	  <h2>Recent Received Msg</h2>
	  <p>.....</p>                                                                                      
	  <div class="table-responsive">          
	  <table class="table table-bordered" id="tb_custoerms">
	    <thead>
	      <tr>
	        <th>No</th>
	        <th>PhoneNumber</th>
	        <th>When</th>
	        <th>Body</th>
	        <th>Select</th>
	      </tr>
	    </thead>
	    <tbody>
	    	<?php
	    	    $fields = array("No","PhoneNum", "RecTime","Content");
	    	    $row_index=0;
	    		foreach ($smsmsg as $sms) {
	    			echo("<tr>");
	    			for ($i=0; $i <4 ; $i++) { 
	    				$tr_html = sprintf("<td>%s</td>", $sms[$fields[$i]]);
	    				echo($tr_html);
	    			}
	    			$tr_html = sprintf('<td><input type="radio" id="chk%d" value="%s" name="phonenum" ></td>',$row_index, $sms[$fields[1]]);
	    			echo($tr_html);
	    			$row_index++;
	    			echo("</tr>");

	    		}

	    	?>
	    </tbody>
	  </table>
	  </div>
	    <div class="wrapper">
            <span class="group-btn">     
                <button type="submit" class="btn btn-primary btn-md">send <i class="fa fa-sign-in"></i></a>
            </span>
            </div>
	</div>
		  	  	<?php
	    		$str_hidden=sprintf('<input type="hidden" id="count_rows" value="%d" >', $row_index);
	    		echo ($str_hidden);

	  	?>
	</form>





