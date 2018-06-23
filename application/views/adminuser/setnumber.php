<link href="/assets/styles/admin/users.css" rel="stylesheet"/>
<div class="container">
    <div class="row">
        <label>Update the call back number</label>
    </div>
    <div class="row">
        <input type="text" class="fromnumber" />
        <button type="button" class="update_number btn btn-primary">Update</button>
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
<script defer="defer" type="text/javascript" src="/assets/js/admin/setcallback.js?3"></script>