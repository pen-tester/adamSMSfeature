<html>
<head>
  <title>
    
    
  </title>
</head>
<body>
 <div class="container">
    <div class="row">
        <h2>

        </h2>
        <div class="col-md-offset-1 col-md-10">
	        	<?php
	        		echo form_open('customers/editrecord');
	        	?>
            <h4><?php echo($title); ?></h4>
             </br>
             <div class="form-group">
              <label for="cus_name">Name</label>
             <input type="text" id="cus_name" class="form-control input-sm chat-input" placeholder="name" name="cus_name" value="<?php echo($customer['Name']); ?>"> 
            </div>
             <div class="form-group">
              <label for="cus_num">PhoneNumber</label>
             <input type="text" id="cus_num" class="form-control input-sm chat-input" placeholder="phonenumber" name="cus_num" value="<?php echo($customer['PhoneNum']); ?>"> 
            </div>
             <div class="form-group">
              <label for="cus_note">Note</label>
             <input type="text" id="cus_note" class="form-control input-sm chat-input" placeholder="Note" name="cus_note" value="<?php echo($customer['Note']); ?>"> 
            </div>
             <div class="form-group">
              <label for="cus_addr">Address</label>
             <input type="text" id="cus_addr" class="form-control input-sm chat-input" placeholder="Address" name="cus_addr" value="<?php echo($customer['Address']); ?>"> 
            </div>
            <div class="form-group">
              <label for="cus_city">City</label>
             <input type="text" id="cus_city" class="form-control input-sm chat-input" placeholder="City" name="cus_city" value="<?php echo($customer['City']); ?>"> 
            </div>
             <div class="form-group">
              <label for="cus_state">State</label>
             <input type="text" id="cus_state" class="form-control input-sm chat-input" placeholder="State" name="cus_state" value="<?php echo($customer['State']); ?>"> 
            </div>            
             <div class="form-group">
              <label for="cus_zip">Zip</label>
             <input type="text" id="cus_zip" class="form-control input-sm chat-input" placeholder="Zip" name="cus_zip" value="<?php echo($customer['Zip']); ?>"> 
            </div> 
            </br>
            <div class="wrapper">
            <span class="group-btn">     
                <button type="submit" class="btn btn-primary btn-md">send <i class="fa fa-sign-in"></i></a>
            </span>
            </div>
            <input type="hidden" id="cus_no" name="cus_no" value="<?php echo($customer['No']); ?>">
	        	<?php
	        		echo form_close();
	        	?>
        
        </div>
    </div>
</div>
<script>

</script>
</body>
</html>

