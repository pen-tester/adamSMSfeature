mainApp.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});

mainApp.controller('userController', function($scope, $http) {
    $scope.currentPage = 0;
    $scope.pageSize = 30;
    $scope.requests = [];
    $scope.allrequests = [];
    $scope.totalrecords = 0;

    $scope.numberOfPages=function(){
        return Math.ceil($scope.requests.length/$scope.pageSize);  
    } 
    
    //Get "Yes", "No" from 1,0
    $scope.dropfor_yesno = [{"name":"No", "value":"0"},{"name":"Yes", "value":"1"}];
    $scope.dropfor_active = [{"name":"Inactive", "value":"0"},{"name":"Active", "value":"1"}];

    $scope.filterfunction = function(request){
        return true;
    };    
 

    $scope.get_record_page = function(page){

        $http.get("/adminhelper/list_users_page/"+page+"/"+$scope.pageSize)
        .then(function(response) {
            //First function handles success
            $scope.allrequests =$scope.allrequests.concat(response.data.result);
            $scope.select_user =JSON.parse(JSON.stringify($scope.allrequests[0]));
            console.log($scope.allrequests);
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
        $scope.allrequests = [];        
        $scope.get_number_of_all_records();

    }

    $scope.reloaddata();


    //Update the user
    $scope.select_user = null;
    $scope.update_user = function(userinfo){
        var data = userinfo;
        $http.post("/adminhelper/update_user", data).then(
            function(resp){
                console.log(resp);
            },
            function(resp){
                console.log(resp);
            }
        );
    }
    //When changing the user in userlist, reload userdata phone number
    $scope.refresh_user_phone = function(user){
       // $scope.select_user=user;
       $scope.select_user = JSON.parse( JSON.stringify(user));
        console.log($scope.select_user);
    }
  

    //When clicking list purchased twilio numbers
    $scope.purhcased_twilio_numbers = [];
    $scope.avail_twilio_numbers = [];
    $scope.list_purchased_twilio_numbers = function(){
        $http.get("/adminhelper/list_system_numbers").then(
            function(resp){
                $scope.purhcased_twilio_numbers =[];
                $scope.purhcased_twilio_numbers =$scope.purhcased_twilio_numbers.concat(resp.data.result);
                console.log($scope.purhcased_twilio_numbers);
            },
            function(resp){
                console.log(resp);
            }
        );
    }

    $scope.area_code = 0;

    $scope.list_available_twilio_numbers = function(){
        $http.get("/adminhelper/list_twilio_numbers/"+$scope.area_code).then(
            function(resp){
                $scope.avail_twilio_numbers = [];
                $scope.avail_twilio_numbers = $scope.avail_twilio_numbers.concat(resp.data.result);
                console.log( $scope.avail_twilio_numbers);
            },
            function(resp){
                console.log(resp);
            }
        );    
        $scope.area_code = 1-$scope.area_code;    
    }

    $scope.update_user_incomingnumber=function(user){
        var data=user;

        $http.post("/adminhelper/update_user", data).then(
            function(resp){
                console.log(resp);
                $scope.reloaddata();
            },
            function(resp){
                console.log(resp);
            }
        );
    }

    $scope.update_user_outgoingnumber=function(user){
        var data=user;

        $http.post("/adminhelper/update_user", data).then(
            function(resp){
                console.log(resp);
                $scope.reloaddata();                
            },
            function(resp){
                console.log(resp);
            }
        );        
    }    
});
