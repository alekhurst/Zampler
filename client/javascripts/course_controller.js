// ---------- Course Page Controller -----------
ZamplerApp.controller('CourseController', [
'$scope',
'$routeParams',
'$rootScope',
function($scope, $routeParams, $rootScope) {
    $scope.zamples = [];
    $scope.current_course = {};

   
    $scope.getCourseFromId = function() {
        $.ajax({
            url : "/server/get_course_from_id.php",
            type: "POST",
            data : { 
                        id : $routeParams.course_id,
                    },
            success: function(data) { 
                if(data == 'null' || !data) {
                    window.location.href = '#'; // 404
                } else {
                    $scope.current_course = JSON.parse(data)[0];
                    if(!$scope.$$phase)
                        $scope.$digest();
                }
            }
        });
    }
    
    $scope.getRelevantZamples = function() {
        $.ajax({
            url : "/server/get_relevant_zamples.php",
            type: "POST",
            data : { 
                        course_id : $routeParams.course_id,
                   },
            success: function(data) { 
                if(data != '') {
                    $scope.zamples = JSON.parse(data);
                    if(!$scope.$$phase)
                        $scope.$digest();
                }
            }
        });
    }

    $scope.openThisZample = function(zample_id) {
        window.location.href = '#/zample/' + zample_id;
    }

    $scope.getCourseFromId();
    $scope.getRelevantZamples();
}])