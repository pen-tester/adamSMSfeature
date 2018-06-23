mainApp.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});

mainApp.controller('reportingController', function($scope, $http, $sce) {
    $scope.renderHtml = function (htmlCode) {
        return $sce.trustAsHtml(htmlCode);
    };

    $scope.currentPage = 0;
    $scope.pageSize = 30;
    $scope.totalrecords = 0;
    $scope.totalpages=1;
    $scope.archive_items_page =[];


    $scope.allusers = [];
    $scope.allleadtyps=[];

    
    $scope.entrypoints = [{name:"All",value:0},{name:"50",value:50},{name:"100",value:100},{name:"150",value:150}];
    $scope.selected_entrypoint = $scope.entrypoints[1];

    $scope.drop_yesno = [{"name":"All", "value":-1},{"name":"Yes", "value":1},{"name":"No", "value":0}];

    $scope.podio_con = {"name":"All", "value":-1};
    $scope.select_podio_con=function(item){
        $scope.podio_con = item;
        $scope.search_conditions.podio = item.value;
    }

    $scope.star_con = {"name":"All", "value":-1};
    $scope.select_star_con=function(item){
        $scope.star_con = item;
        $scope.search_conditions.star = item.value;
    }

    $scope.user_con = {"Name":"All", "No":-1};
    $scope.select_user_con=function(item){
        $scope.user_con = item;
        $scope.search_conditions.user = item.No;
    }
    
    $scope.leadtype_con = {"leadtype":"All", "value":-1};
    $scope.select_leadtype_con=function(item){
        $scope.leadtype_con = item;
        $scope.search_conditions.leadtype = item.leadtype;
    }    
    //Search variables
    $scope.search_conditions={podio:-1, star:-1, user:-1, leadtype:'All', cashbuyer:false, realtor:false, grades:["Low","Medium", "High","Nurture"], start:"2018-01-20", end:"2018-01-26", keyword:""};
   // $scope.search_conditions={podio:-1, star:-1, user:-1, leadtype:'All', cashbuyer:true, realtor:true, grades:["Low","Medium", "High","Nurture"], start:"", end:"", keyword:""};


    $scope.setting_daterange = function(start, end){
        $scope.search_conditions.start = start;
        $scope.search_conditions.end= end;
        $scope.load_result_data();        

    }

    $scope.setting_grades = function(grades){
        $scope.search_conditions.grades=grades;
    }

    $scope.filterfunction = function(request){
        return true;
    };    

    $scope.select_entrypoint = function(item){
        $scope.selected_entrypoint = item;
    }
 

    $scope.get_record_page = function(){
        var data={
            page:$scope.currentPage,
            entry:$scope.pageSize,
            condition:$scope.search_conditions
        }

        $http.post("/adminhelper/get_archive_records_page", data)
        .then(function(response) {
            //First function handles success
            //$scope.allusers =$scope.allusers.concat(response.data.result);
            $scope.archive_items_page = response.data.result;
            console.log(response.data.result);
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });        
    }

    //Getting all counts
    $scope.get_number_of_all_records=function(){
        var data=$scope.search_conditions;
        $http.post("/adminhelper/get_total_archive_number",data)
        .then(function(response) {
            //First function handles success
            $scope.totalrecords = response.data.result["total"];
            $scope.totalpages = Math.ceil((+$scope.totalrecords) /$scope.pageSize);

           // console.log($scope.requests);
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });
    }

    $scope.get_users_list = function(){
        $http.get("/adminhelper/list_all_users")
        .then(function(response) {
            //First function handles success
            $scope.allusers =[ {"name":"All", "No":-1}];
            $scope.allusers =$scope.allusers.concat(response.data.result);            
            console.log("users",$scope.allusers);
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });        
    }        
    
    $scope.get_leadtypes_list = function(){
        $http.get("/api/api_messenger/list_leadtypes")
        .then(function(response) {
            //First function handles success
            $scope.allleadtyps=[ {"leadtype":"All"}];
            $scope.allleadtyps =$scope.allleadtyps.concat(response.data.result);
            console.log("allleadtyps",$scope.allleadtyps);
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });        
    }    

    $scope.result={total:0, batch_total:0, grade:[], occupancy:[], called:0,realtor:0, podiocashbuyerid:0};
    $scope.drop_occupancy=["No","Yes - Primary", "Yes - 2nd Home", "Rented"];
    $scope.get_total_sms_sent = function(){
        var data=$scope.search_conditions;
        $http.post("/adminhelper/get_total_sms_sent",data)
        .then(function(response) {
            //First function handles success
            $scope.result.total = response.data.result.total;     
            $scope.result.batch_total = response.data.result.batch_total;
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        }); 
    }
    
    $scope.initdata=function(){
        $scope.get_users_list();
        $scope.get_leadtypes_list();
    }

    $scope.initdata();

    $scope.get_total_called_number = function(){
        var data=$scope.search_conditions;
        $http.post("/adminhelper/get_total_sms_called",data)
        .then(function(response) {
            //First function handles success
            $scope.result.called = response.data.result.total;     
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });        
    }

    $scope.get_total_number_by_attr = function(attr){
        var data=$scope.search_conditions;
        $http.post("/adminhelper/get_total_sms_by_attr/"+attr,data)
        .then(function(response) {
            //First function handles success
            $scope.result[attr] = response.data.result.total;     
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });                
    };

    $scope.get_total_number_by_attr_group = function(attr){
        var data=$scope.search_conditions;
        $http.post("/adminhelper/get_total_number_by_attr_group/"+attr,data)
        .then(function(response) {
            //First function handles success
            $scope.result[attr] = response.data.result;     
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });         
    }

    $scope.load_result_data = function(){
        $scope.get_record_page();
        $scope.get_number_of_all_records();
        $scope.get_total_sms_sent();
        $scope.get_total_called_number();
        $scope.get_total_number_by_attr_group('grade');
        $scope.get_total_number_by_attr_group('occupancy'); 
        $scope.get_total_number_by_attr('realtor');     
        $scope.get_total_number_by_attr('podiocashbuyerid');
    }


    $scope.load_result_data();

});
