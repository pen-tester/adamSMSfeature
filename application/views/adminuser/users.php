<link href="/assets/styles/admin/users.css" rel="stylesheet"/>
<link href="/assets/styles/authuser/settings.css?1" rel="stylesheet"/>
<script type="text/javascript" src="/assets/js/libs/angular/angular.min.js"></script>
<script type="text/javascript" src="/assets/js/libs/angular/angular-route.min.js"></script>
<script type="text/javascript" src="/assets/js/libs/angular/angapp.js"></script>
<script type="text/javascript" src="/assets/js/admin/userController.js?3"></script>
<script defer type="text/javascript" src="/assets/js/admin/users.js?5"></script> 
<div class="container" ng-app="mainApp" ng-controller="userController">

    <div class="row">
        <h3>Users List</h3>
    </div>
  
	<div class="row" id="userarea">
        <input type="hidden" id="current_no" value="-1">
		<table class="table table-striped table-hover"> 
		    <thead>
		      <tr>  
                <th >Date / Time</th> 
                <th >User Name</th>	
                <th>Email</th>	
                <th>Outgoing #</th>	
                <th>Incoming #</th>	
                <th>Upload</th>	
                <th>SendSms</th>	                                                                            	        
		        <th>SMS Edit</th>
                <th>Status</th>
                <th>Action</th>
		      </tr>
		    </thead>
		    <tbody>
                <tr ng-repeat="request in requests=(allrequests|filter:filterfunction) | startFrom:currentPage*pageSize | limitTo:pageSize">
                    <td>{{request.created}}</td> 
                    <td>{{request.Name}}</td>	
                    <td>{{request.UsrId}}</td>	
                    <td>{{request.twiliophone}}</td>	
                    <td>{{request.backwardnumber}}</td>	
                    <td>
                        <a class='btn btn-default btn-select'>
                            <input type='hidden' class='btn-select-input' value='{{request.upload}}' />
                            <span class='btn-select-value'>{{dropfor_yesno[request.upload]["name"]}}</span>
                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                            <ul class='' data-target='{{request.No}}'>
                                <li ng-repeat="item in dropfor_yesno" data-value='item.value' ng-click="request.upload=item.value; update_user(request)">{{item.name}}</li>
                            </ul>
                        </a>                        
                    </td>	
                    <td>
                        <a class='btn btn-default btn-select'>
                            <input type='hidden' class='btn-select-input' name='' value='{{request.sendsms}}' />
                            <span class='btn-select-value'>{{dropfor_yesno[request.sendsms]["name"]}}</span>
                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                            <ul class='' data-target='{{request.No}}'>
                                <li ng-repeat="item in dropfor_yesno" data-value='item.value' ng-click="request.sendsms=item.value; update_user(request)">{{item.name}}</li>
                            </ul>
                        </a>                        
                    </td>	                                                                                	        
                    <td>
                        <a class='btn btn-default btn-select'>
                            <input type='hidden' class='btn-select-input' name='' value='{{request.editsms}}' />
                            <span class='btn-select-value'>{{dropfor_yesno[request.editsms]["name"]}}</span>
                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                            <ul class='' data-target='{{request.No}}'>
                             <li ng-repeat="item in dropfor_yesno" data-value='item.value'  ng-click="request.editsms=item.value; update_user(request)">{{item.name}}</li>
                            </ul>
                        </a>
                    </td>
                    <td>
                        <a class='btn btn-default btn-select'>
                            <input type='hidden' class='btn-select-input' name='' value='{{request.active}}' />
                            <span class='btn-select-value'>{{dropfor_active[request.active]["name"]}}</span>
                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                            <ul class='' data-target='{{request.No}}'>
                              <li ng-repeat="item in dropfor_active" data-value='item.value'  ng-click="request.active=item.value; update_user(request)">{{item.name}}</li>
                            </ul>
                        </a>
                    </td>
                    <td> <a class='delete btnpadding' data-target='{{request.UsrId}}'><i class="fa fa-trash" aria-hidden="true"></i></a></td>                    
                </tr>
		    </tbody>			
		</table>
    </div>
    <div class="row">
                <button ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">
                    Previous
                </button>
                {{currentPage+1}}/{{numberOfPages()}}
                <button ng-disabled="currentPage >= requests.length/pageSize - 1" ng-click="currentPage=currentPage+1">
                    Next
                </button>                  
    </div>  
    <div class="row">
        <div class="col-md-3">
            <label>Users</label>
            <a class="btn btn-default btn-select mediumwidth dropusers">
                <input type="hidden" class="btn-select-input" id="dropusers" value="{{select_user.No}}" />
                <span class="btn-select-value">{{select_user.Name}}</span>
                <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                <ul>
                    <li data-value="{{user.No}}" ng-repeat="user in allrequests" ng-click="refresh_user_phone(user)">
                        {{user.Name}}
                    </li>
                </ul>
            </a>                
        </div>
    </div>    
	<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <h4>Setting the backward phone number that receives calling</h4>
                <input type="text" id="callnumber" ng-model="select_user.backwardnumber" />
                <button class="btn btn-primary btn_update_callnumber" ng-click="update_user_incomingnumber(select_user)">Update</button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <h4>Setting the phone number that sends sms</h4>
                <input type="text" readonly="readonly" id="phonenumber" ng-model="select_user.twiliophone" />
                <button class="btn btn-primary " ng-click="update_user_outgoingnumber(select_user)">Update</button>
            </div>
        </div>
    </div>
	<div class="row">
		<div class="col-md-6 col-lg-6">
			<label> List the phones in twilio </label>
			<ul id="twilio_numbers" class="number_list">
                <li ng-repeat="sys_number in avail_twilio_numbers" ng-click="select_user.twiliophone=sys_number.phone;select_user.twilionumbersid=''">
                    {{sys_number.phone}}
                </li>
			</ul>
			<button class="btn btn-primary"  ng-click="list_available_twilio_numbers()">List the Twilio Number</button>
		</div>	
	</div>      
</div>
<br/>
<br/>
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

