<html>
<head>
	<script src="/assets/js/customers.js"></script>
</head>
<body>
<form method ="post" id="customers_form">
<nav class="navbar navbar-default sidebar" role="navigation">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <li class="active"><a onclick="send_sms()">List<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Methods<span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a>
          <ul class="dropdown-menu forAnimate" role="menu">
            <li><a>Delete</a></li>
            <li><a>Edit</a></li>
            <li><a>Add</a></li>
            <li class="divider"></li>
            <li class="divider"></li>
          </ul>
        </li>          
        <li ><a onclick="send_sms()">SendSms<span style="font-size:16px;" class="pull-right hidden-xs showopacity  glyphicon glyphicon-envelope"></span></a></li>        
      </ul>

  </div>
</nav>
	  <div class="container">
	  <h2>CustomersList</h2>
	  <p>.....</p>                                                                                   
	  <div class="table">          
	  <table class="table table-bordered" id="tb_custoerms">
	    <thead>
	      <tr>
	        <th>No</th>
	        <th>Name</th>
	        <th>Address</th>
	        <th>City</th>
	        <th>State</th>
	        <th>Zip</th>	        
	        <th>Type</th>	        
	        <th>PhoneNumber1</th>
	        <th>PhoneNumber2</th>
	        <th>PhoneNumber3</th>
	        <th>PhoneNumber4</th>
	        <th>PhoneNumber5</th>
	        <th>Select</th>
	      </tr>
	    </thead>
	    <tbody>
	    	<?php
	    	    $fields = array("No","Name", "Address","City","State","Zip","Type","Phone1","Phone2","Phone3","Phone4","Phone5");
	    	    $row_index=0;
	    		foreach ($customers as $customer) {
	    			echo("<tr>");
	    			for ($i=0; $i <12 ; $i++) { 
	    				$tr_html = sprintf("<td>%s</td>", $customer[$fields[$i]]);
	    				echo($tr_html);
	    			}
	    			$tr_html = $tr_html = sprintf('<td><input type="radio" id="chk%d" value="%s" name="chk_sel" ><input type="hidden" id="num%d" value="%s"></td>',$row_index, $customer[$fields[0]],$row_index,$customer[$fields[2]]);
	    			echo($tr_html);
	    			$row_index++;
	    		}

	    	?>
	    </tbody>
	  </table>

	  </div>
	  	  	<?php
	    		$str_hidden=sprintf('<input type="hidden" id="count_rows" value="%d" >', $row_index);
	    		echo ($str_hidden);

	  	?>
	  	<input type="hidden" id="customer_no" value="-1" name="customer_no" >
	  	<input type="hidden" id="phonenum" value="-1" name="phonenum" >
	  	<nav aria-label="Page navigation">
		  <ul class="pagination">
		  <?php
		    	$rows = $count_customers;
		    	$allPages = ($rows/10);

		    	$prev_page=0;
		    	$next_page=0;
		    	if($current_page>0){
		    		$prev_page = $current_page -1;
		    	}
		    	if($current_page<($allPages-1))
		    		$next_page = $current_page + 1;
		  ?>
		    <li>
		      <a href="/index.php/customers/index/<?php echo($prev_page); ?>" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>
		    <?php

		    	for($i=0; $i<$allPages; $i++){
					$html_str = sprintf('<li><a href="/index.php/customers/index/%d">%d</a></li>', $i , $i+1);
					echo($html_str);
		    	}

		    	

		    ?>
		    <li>
		      <a href="/index.php/customers/index/<?php echo($next_page); ?>" aria-label="Next">
		        <span aria-hidden="true">&raquo;</span>
		      </a>
		    </li>
		  </ul>
		</nav>  
	</div>
</form>
</body>
</html>