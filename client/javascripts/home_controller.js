// ---------- Home Page Controller -----------
ZamplerApp.controller('HomeController', [
'$scope',
'$rootScope',
function($scope, $routeParams, $rootScope) {
    $scope.request_school_popup = false;
    $scope.requested_school = '';
    $scope.school_search = 'Search for your school...';

    
    $scope.openCoursesForThisSchool = function(school_id) {
        window.location.href = '#/school/' + school_id;
    };

    $scope.hideRequestSchoolPopup = function() {
        $scope.request_school_popup = false;
    };
    $scope.showRequestSchoolPopup = function() {
        $scope.request_school_popup = true;
    };

    $scope.submitRequestedSchool = function() {
        $.ajax({
            url : "/server/create_requested_school.php",
            type: "POST",
            data : { 
                        name : $scope.requested_school,
                    },
            success: function(data) { 
                $scope.requested_school = '';
                $scope.request_school_popup = false;
                if(!$scope.$$phase)
                    $scope.$digest();
            }
        });
    }
}])