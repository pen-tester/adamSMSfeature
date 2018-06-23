mainApp.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});

mainApp.controller('sendallController', function($scope, $http, $sce) {
    $scope.renderHtml = function (htmlCode) {
        return $sce.trustAsHtml(htmlCode);
    };

    $scope.currentPage = 0;
    $scope.pageSize = 30;
    $scope.allusers = [{"No":0, "Name":"All"}];
    $scope.totalrecords = 0;

    $scope.numberOfPages=function(){
        return Math.ceil($scope.requests.length/$scope.pageSize);  
    } 
    
    $scope.entrypoints = [{name:"All",value:0},{name:"10",value:10},{name:"15",value:15},{name:"25",value:25},{name:"50",value:50},{name:"100",value:100},{name:"150",value:150}];
    $scope.selected_entrypoint = $scope.entrypoints[4];

    $scope.filterfunction = function(request){
        return true;
    };    

    $scope.select_entrypoint = function(item){
        $scope.selected_entrypoint = item;
    }
 

    $scope.get_record_page = function(page){

        $http.get("/adminhelper/list_users_page/"+page+"/"+$scope.pageSize)
        .then(function(response) {
            //First function handles success
            console.log("tst");
            
            try{
                $scope.allusers =$scope.allusers.concat(response.data.result);
                $scope.select_user_from_list($scope.allusers[1]);
            }catch(ex){
                $scope.select_user_from_list({"No":-1, "Name":"Own User"});
            }
            
            console.log($scope.allusers);
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });        
    }

    //Getting all counts
    $scope.get_number_of_all_records=function(){
        $http.get("/adminhelper/get_number_of_all_users")
        .then(function(response) {
            //First function handles success
            $scope.totalrecords = response.data.result["total"];
            console.log(response.data.result);

            var counts = Math.ceil((+$scope.totalrecords) /$scope.pageSize);

            //Loading all records
            for(var i=0;i <counts ;i++){
                $scope.get_record_page(i);
            }
           // console.log($scope.requests);
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });
    }
    
    $scope.reloaddata=function(){
        $scope.allusers = [{"No":0, "Name":"All"}];        
        $scope.get_number_of_all_records();

    }

    $scope.reloaddata();


    //Update the user
    $scope.select_user = {"No":-100, "Name":"Own User"};

    $scope.select_user_from_list = function(user){
        $scope.select_user = user;
        $scope.reload_uploaded_phone();
    }

    //List sms list
    $scope.allsms_templates = [];

    $scope.get_sms_templates = function(){
        $http.get("/smscontenthelper/list_smstemplates")
        .then(function(response) {
            //First function handles success
            $scope.allsms_templates =$scope.allsms_templates.concat(response.data.result);
            console.log($scope.allsms_templates);
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });        
    }
    $scope.get_sms_templates();


    //For uploaded phones list
    $scope.total_up_phone_numbers = 0;
    $scope.total_up_phone_pages = 1;
    $scope.phone_page_entry=50;
    $scope.phone_current_page= 0;
    $scope.phone_items_page=[];

    $scope.get_up_phones_page=function(){
        $http.get("/api/api_authuser/list_phones/"+$scope.select_user.No +"/"+$scope.phone_current_page+"/"+$scope.phone_page_entry)
        .then(function(response) {
            //First function handles success
            $scope.phone_items_page=[];
            $scope.phone_items_page =$scope.phone_items_page.concat(response.data.result);
            console.log($scope.phone_items_page);
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });
    }


    $scope.reload_uploaded_phone = function(){
        $http.get("/api/api_authuser/get_total_number_of_phones/"+$scope.select_user.No)
        .then(function(response) {
            //First function handles success
            $scope.total_up_phone_numbers =response.data.result["total"];
            $scope.total_up_phone_pages = Math.ceil($scope.total_up_phone_numbers/$scope.phone_page_entry);
            $scope.get_up_phones_page();
            console.log($scope.allsms_templates);
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });  
    }

    $scope.send_batch_sms = function(option){
       
        $http.get( "/api/sendsms/"+option+"/"+$scope.selected_entrypoint.value+"/"+$scope.select_user.No+"/adam")
        .then(function(response) {
            //First function handles success
            console.log(response.data);
            $scope.get_up_phones_page();


            //Display the modal dialog
            if(response.data.status=='ok'){
                $("#msgbox .modal_content").text("Successfully sent");
                $("#msgbox").fadeIn();
            }
            else{
                $("#msgbox .modal_content").text(response.data.errors);
                $("#msgbox").fadeIn();                
            }
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });         
    }

    $scope.send_batch_sms_master = function(option){
        $http.get( "/api/sendsms/"+option+"/"+$scope.selected_entrypoint.value+"/-1"+"/adam")
        .then(function(response) {
            //First function handles success
            console.log(response.data);
            //Display the modal dialog
            if(response.data.status=='ok'){
                $("#msgbox .modal_content").text("Successfully sent");
                $("#msgbox").fadeIn();
            }
            else{
                $("#msgbox .modal_content").text(response.data.errors);
                $("#msgbox").fadeIn();                
            }
            
            $scope.get_up_phones_page();
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });        
    }
    $scope.reload_uploaded_phone();
});
