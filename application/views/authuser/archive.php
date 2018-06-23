<link href="/assets/styles/authuser/uploads.css?1" rel="stylesheet"/>
<link href="/assets/styles/admin/users.css" rel="stylesheet"/>
<script type="text/javascript" src="/assets/js/libs/angular/angular.min.js"></script>
<script type="text/javascript" src="/assets/js/libs/angular/angular-route.min.js"></script>
<script type="text/javascript" src="/assets/js/libs/angular/angapp.js"></script>
<script type="text/javascript" src="/assets/js/authuser/uploadarchiveController.js?3"></script>
<script defer type="text/javascript" src="/assets/js/authuser/archiveupload.js?5"></script> 
<div ng-app="mainApp" ng-controller="uploadarchiveController" id="uploadarchiveController">
    <div class="container" >

        <div class="row">
            <h3>Archive</h3>
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


    <div class="container">
        <div class="row table_area">
            <table id="list_leads" class="">
                <thead>
                    <th>Batch sms sent time</th>
                    <th>User</th>
                    <th>sent</th>
                    <th>sent_option</th>
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
                    <tr ng-repeat="phone in page_record">
                        <td>{{phone.batch_sent_date}}</td>
                        <td>{{phone.Name}}</td>
                        <td>{{phone.sent}}</td>
                        <td>{{phone.sent_option}}</td>
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
                    <button ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1;get_record_page()">
                        Previous
                    </button>
                    {{currentPage+1}}/{{total_pages}}
                    <button ng-disabled="currentPage >= total_pages - 1" ng-click="currentPage=currentPage+1;get_record_page() ">
                        Next
                    </button>                  
            </div>     
        </div>  
    </div> 
</div>