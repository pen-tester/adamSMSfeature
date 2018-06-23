mainApp.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});

mainApp.controller('uploadarchiveController', function($scope, $http, $sce) {
    $scope.renderHtml = function (htmlCode) {
        return $sce.trustAsHtml(htmlCode);
    };

    $scope.currentPage = 0;
    $scope.total_pages=1;
    $scope.pageSize = 30;
    $scope.page_record = [];
    $scope.totalrecordsnumber = 0;

    $scope.numberOfPages=function(){
        return Math.ceil($scope.requests.length/$scope.pageSize);  
    } 

    $scope.filterfunction = function(request){
        return true;
    };    


    $scope.get_record_page = function(){

        $http.get("/api/api_authuser/list_archive_upload_phone_page/"+$scope.currentPage+"/"+$scope.pageSize)
        .then(function(response) {
            //First function handles success
            $scope.page_record =response.data.result;
            console.log($scope.page_record);
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });        
    }

    //Getting all counts
    $scope.get_number_of_all_records=function(){
        $http.get("/api/api_authuser/get_total_number_archive_upload_phones")
        .then(function(response) {
            //First function handles success
            $scope.totalrecordsnumber = response.data.result["total"];
            console.log(response.data.result);
            $scope.total_pages = Math.ceil($scope.totalrecordsnumber/$scope.pageSize);

           // console.log($scope.requests);
        }, function(response) {
            //Second function handles error
            $scope.content = "Something went wrong";
        });
    }
    
    $scope.reloaddata=function(){     
        $scope.get_record_page();
        $scope.get_number_of_all_records();

    }

    $scope.reloaddata();


});
