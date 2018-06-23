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
	        		echo form_open('customers/addrecord');
	        	?>
            <h4><?php echo($title); ?></h4>
             </br>
             <div class="form-group">
              <label for="cus_name">Name</label>
             <input type="text" id="cus_name" class="form-control input-sm chat-input" placeholder="name" name="cus_name"> 
            </div>
             <div class="form-group">
              <label for="cus_num">PhoneNumber</label>
             <input type="text" id="cus_num" class="form-control input-sm chat-input" placeholder="phonenumber" name="cus_num"> 
            </div>
             <div class="form-group">
              <label for="cus_note">Note</label>
             <input type="text" id="cus_note" class="form-control input-sm chat-input" placeholder="Note" name="cus_note"> 
            </div>
             <div class="form-group">
              <label for="cus_addr">Address</label>
             <input type="text" id="cus_addr" class="form-control input-sm chat-input" placeholder="Address" name="cus_addr"> 
            </div>
            <div class="form-group">
              <label for="cus_city">City</label>
             <input type="text" id="cus_city" class="form-control input-sm chat-input" placeholder="City" name="cus_city"> 
            </div>
             <div class="form-group">
              <label for="cus_state">State</label>
             <input type="text" id="cus_state" class="form-control input-sm chat-input" placeholder="State" name="cus_state"> 
            </div>            
             <div class="form-group">
              <label for="cus_zip">Zip</label>
             <input type="text" id="cus_zip" class="form-control input-sm chat-input" placeholder="Zip" name="cus_zip"> 
            </div> 
            </br>
            <div class="wrapper">
            <span class="group-btn">     
                <button type="submit" class="btn btn-primary btn-md">send <i class="fa fa-sign-in"></i></a>
            </span>
            </div>
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

