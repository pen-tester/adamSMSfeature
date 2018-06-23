 <link href="/assets/styles/reg.css" rel="stylesheet"/>
	<div class="container">
        <div class="row centered-form">
        <div class="col-xs-12 col-sm-4 col-md-4 col-sm-offset-4 col-md-offset-4">
        	<div class="panel panel-default">
        		<div class="panel-heading">
			    		<h3 class="panel-title">Please Change your password</h3>
			 			</div>
			 			<div class="panel-body">
			 			<?php echo validation_errors(); ?>
			    		<form method="post">
			    			<?php
			    				if($error !=""){
			    			?>
			    				<div><?php echo $error; ?></div>
			    			<?php
			    				}
			    			?>
	    					<div class="form-group">
	    						<label>Current Password</label>
	    						<input type="password" name="currentpwd" class="form-control input-sm" required="required">
	    					</div>

	    					<div class="form-group">
	    						<label>New Password</label>
	    						<input type="password" name="newpwd" class="form-control input-sm" required="required">
	    					</div>
	    					<div class="form-group">
	    						<label>Confirm Password</label>
	    						<input type="password" name="confirmpwd" class="form-control input-sm" required="required">
	    					</div>

	    					<input type="submit" value="Change" class="btn btn-info btn-block">
			    		
			    		</form>
			    	</div>
	    		</div>
    		</div>
    	</div>
    </div>