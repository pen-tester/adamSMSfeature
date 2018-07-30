 <div class="container">
    <div class="row">
        <h2>
        <?php
            echo ($title);
        ?>
        </h2>
        <?php
          if($msg !=""){
            echo( '<div class="alert alert-info">
          <strong>Warning!</strong> '.$msg.'
        </div>');

          }

        ?>

        <div class="col-md-offset-1 col-md-10">
          <form method="POST" action="/smsmsg/callsendsms">
            <h4>Sms Reply.</h4>
            <input type="text" id="phonenumber" class="form-control input-sm chat-input" placeholder="phonenumber" name="phonenum" value="<?php echo($phonenum); ?>"> 
            </br>
             <div class="form-group">
              <label for="comment">Message:</label>
              <textarea class="form-control" rows="5" id="comment" name="sms_msg" placeholder="message" ></textarea>
            </div>

            </br>
            <div class="wrapper">
            <span class="group-btn">     
                <button type="submit" class="btn btn-primary btn-md">send <i class="fa fa-sign-in"></i></a>
            </span>
            </div>
          </form>
        
        </div>
    </div>
</div>
<script defer type="text/javascript" src="/assets/js/authuser/sendsms.js?30"></script> 
