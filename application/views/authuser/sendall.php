<link href="/assets/styles/authuser/uploads.css?1" rel="stylesheet"/>
<link href="/assets/styles/admin/users.css" rel="stylesheet"/>
<script type="text/javascript" src="/assets/js/libs/angular/angular.min.js"></script>
<script type="text/javascript" src="/assets/js/libs/angular/angular-route.min.js"></script>
<script type="text/javascript" src="/assets/js/libs/angular/angapp.js"></script>
<script type="text/javascript" src="/assets/js/authuser/sendallController.js?7"></script>
<script defer="defer" type="text/javascript" src="/assets/js/authuser/sendall.js?7"></script> 
<div ng-app="mainApp" ng-controller="sendallController" id="sendallController">
    <div class="container" >

        <div class="row">
            <h3>Send Setup</h3>
                The string started with % such as, %name , %addr is the placeholder string.
                It will be replaced to the real value when sending sms.
        </div>

        <div class="row">
            <h3>Sms template List</h3>
            <div class="col-md-2">
                    <label>How many phones are you going to send?</label>
                    <a class="btn btn-default btn-select filter_star">
                        <input type="hidden" class="btn-select-input"  id="entry" value="selected_entrypoint.value" />
                        <span class="btn-select-value">{{selected_entrypoint.name}}</span>
                        <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                        <ul>
                            <li data-value="{{item.value}}" ng-repeat="item in entrypoints" ng-click="select_entrypoint(item)">{{item.name}}</li>
                        </ul>
                    </a>              
            </div>   
            <?php 
                if($this->userrole == 1000){
            ?>
                <div class="col-md-2">
                        <label>User Name</label>
                        <a class="btn btn-default btn-select filter_star">
                            <input type="hidden" class="btn-select-input"  id="entry" value="select_user.No" />
                            <span class="btn-select-value">{{select_user.Name}}</span>
                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                            <ul>
                                <li data-value="{{item.No}}" ng-repeat="item in allusers" ng-click="select_user_from_list(item)">{{item.Name}}</li>
                            </ul>
                        </a>                
                </div>          
            <?php 
                }
            ?>              
        </div>
    
        <div class="row" id="userarea">
            <input type="hidden" id="current_no" value="-1">
            <table class="table table-striped table-hover"> 
                <thead>
                <tr>  
                    <th class="col-xs-1 col-sm-1 col-md-1">No</th> 
                    <th class="col-xs-8 col-sm-8 col-md-8">Template</th>	
                    <th class="col-xs-3 col-sm-3 col-md-3">Action</th>		
                    <?php 
                            if($this->userrole != 1000){
                        ?>                        
                    <th>Master Action List</th>
                    <?php 
                    }
                    ?>                            
                </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in allsms_templates" >
                        <td>{{item.id}}</td>
                        <td ng-bind-html="renderHtml(item.msg)"></td>
                        <td><span class='btn_sendall btnpadding' ng-click="send_batch_sms(item.id)"><i class="fa fa-paper-plane" aria-hidden="true"></i></span></td>
                        <?php 
                            if($this->userrole != 1000){
                        ?>                        
                        <td><span class='btn_sendall btnpadding' ng-click="send_batch_sms_master(item.id)"><i class="fa fa-paper-plane" aria-hidden="true"></i></span></td>
                        <?php 
                        }
                        ?>
                    </tr>
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


    <?php 
        if($this->permissions["upload"]==1 || $this->userrole == 1000){
    ?>
    <div class="container">
        <div class="row text-center">
            <button type="button" class="btn btn-success btn_archive">Archive</button>
        </div>
        <form id="frm_upcsv" enctype='multipart/form-data' method="POST">
            <div class="row">
                <label>Upload CSV file to the system</label>
                <input type="file" id="csvfile" name="csv" accept=".csv"/>
                <input type="hidden" name="userid" value="{{select_user.No}}"/>
                <button type="button" class="btn btn-primary btnupload" ng-show="select_user!=null && select_user.No!='0'">Upload</button>
            </div>

        </form>
        <div class="row">
            <button class="btn btn-primary btndeleteall">Delete All</button>
        </div>
        <div class="row table_area">
            <table id="list_leads" class="">
                <thead>
                    <th>sent</th>
                    <th>date_added</th>
                    <th>date_sent</th>
                    <th>address</th>
                    <th>city</th>
                    <th>state</th>
                    <th>firstname</th>
                    <th>lastname</th>
                    <th>owner_address</th>
                    <th>owner_city</th>
                    <th>owner_state</th>
                    <th>phone0</th>
                    <th>phone1</th>
                    <th>phone2</th>
                    <th>phone3</th>
                    <th>phone4</th>
                    <th>phone5</th>
                    <th>phone6</th>
                    <th>phone7</th>
                    <th>phone8</th>
                    <th>phone9</th>
                    <th>leadtype</th>
                </thead>
                <tbody>
                    <tr ng-repeat="phone in phone_items_page">
                        <td>{{phone.sent}}</td>
                        <td>{{phone.date_added}}</td>
                        <td>{{phone.date_sent}}</td>
                        <td>{{phone.address}}</td>
                        <td>{{phone.city}}</td>
                        <td>{{phone.state}}</td>
                        <td>{{phone.firstname}}</td>
                        <td>{{phone.lastname}}</td>
                        <td>{{phone.owner_address}}</td>
                        <td>{{phone.owner_city}}</td>
                        <td>{{phone.owner_state}}</td>
                        <td>{{phone.phone0}}</td>
                        <td>{{phone.phone1}}</td>
                        <td>{{phone.phone2}}</td>
                        <td>{{phone.phone3}}</td>
                        <td>{{phone.phone4}}</td>
                        <td>{{phone.phone5}}</td>
                        <td>{{phone.phone6}}</td>
                        <td>{{phone.phone7}}</td>
                        <td>{{phone.phone8}}</td>
                        <td>{{phone.phone9}}</td>
                        <td>{{phone.leadtype}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
            <div class="row">
                    <button ng-disabled="phone_current_page == 0" ng-click="phone_current_page=phone_current_page-1;get_up_phones_page()">
                        Previous
                    </button>
                    {{phone_current_page+1}}/{{total_up_phone_pages}}
                    <button ng-disabled="phone_current_page >= total_up_phone_pages - 1" ng-click="phone_current_page=phone_current_page+1;get_up_phones_page() ">
                        Next
                    </button>                  
            </div>     
        </div>  
    </div> 
    <?php 
        }
    ?> 
</div>
