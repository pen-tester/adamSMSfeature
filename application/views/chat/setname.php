<link href="/assets/styles/chat.css" rel="stylesheet"/>
<div class="container">
    <div class="chatwindow">
		<div class="row">
			<div class="col-sm-8 col-md-8">
				<input  id="valreplace" placeholder="Name Here"></textarea>
			</div>
			<div class="col-sm-4 col-md-4">
				<button type="button" id="btnset" class="btn">
				   <i class="fa fa-cog" aria-hidden="true"></i> Set
				</button>
			</div>		
		</div>
		<div class="row" id="msgcontent">				
		</div>
	</div>
</div>
<div class="modal_area" id="msgbox">
    <div class="modal_dialog">
        <div class="modal_title">
            <label>Message</label>
            <span class="close btnclose" data-target="msgbox">&times;
            </span>
        </div>
        <div class="modal_content">
        </div>
        <div class="modal_footer">
            <input type="button" class="btn btn-primary btnclose"  data-target="msgbox" value="Close">
        </div>                
    </div>
</div>
<script defer type="text/javascript" src="/assets/js/chat/setname.js"></script> 
