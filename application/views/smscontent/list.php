<link href="/assets/styles/admin/users.css" rel="stylesheet"/>
<div class="container">

    <div class="row">
        <h3>Note</h3>
        When editing sms content, to send "address", type %addr <br/>
        type %name for First Name <br/>
        type %city for City
        type &lt;br&gt; for line break
    </div>

    <div class="row">
        <h3>Sms template List</h3>
    </div>
  
	<div class="row" id="userarea">
        <input type="hidden" id="current_no" value="-1">
		<table class="table table-striped table-hover"> 
		    <thead>
		      <tr>  
                <th class="col-xs-1 col-sm-1 col-md-1">No</th> 
                <th class="col-xs-8 col-sm-8 col-md-8">Template</th>	
		        <th class="col-xs-3 col-sm-3 col-md-3">Action</th>		        
		      </tr>
		    </thead>
		    <tbody>

		    </tbody>			
		</table>
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
<div class="modal_area" id="editbox">
    <div class="modal_dialog">
        <div class="modal_title">
            <label>Edit Sms Content</label>
            <span class="close btnclose" data-target="editbox">&times;
            </span>
        </div>
        <div class="modal_content">
            <div>
                <input type="hidden" id="lid" />
                <textarea id='lmsg' style="width:350px; height: 150px;"></textarea>
            </div>
        </div>
        <div class="modal_footer">
            <input type="button" class="btn btn-primary btnupdate" value="Update">
        </div>                
    </div>
</div>
<script defer="defer" type="text/javascript" src="/assets/js/smscontent/list.js?3"></script>