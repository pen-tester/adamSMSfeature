<div class="container">
	<div class="row">
		<div class="col-sm-4 col-md-4">
			Phone Number
		</div>
		<div class="col-sm-4 col-md-4">
			<input type="text" id="phone">
		</div>
		<div class="col-sm-4 col-md-4">
			<input type="button" class="btn" id="btnchat" value="chat">
		</div>
	</div>
	<div class="row chatarea">		
		Chat with <label id="current_phone"></label>
	</div>
	<input type="hidden" id="topid" value="0"/>
	<div class="row">
		<div class="col-sm-8 col-md-8">
			<textarea class="sms_content" id="sms"></textarea>
		</div>
		<div class="col-sm-4 col-md-4">
			<input type="button" id="btnsendsms" class="btn" value="Send Sms">
		</div>		
	</div>
	<div class="row" id="msgcontent">				
	</div>
</div>
        <div class="modal" id="errorbox">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel">Errors</h3>
                    </div>
                    <div class="modal-body" id="errorcontent"> 
                    	The Phone Number is incorrect.
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default btnclose">Close</button>
                      </div>
                </div>
            </div>
        </div>
<!--<script defer src="https://www.gstatic.com/firebasejs/4.5.2/firebase.js"></script> -->
<script defer type="text/javascript" src="/assets/js/chat.js"></script> 

