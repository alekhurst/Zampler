// ---------- Course Page Controller -----------
ZamplerApp.controller('CourseController', [
'$scope',
'$routeParams',
function($scope, $routeParams) {
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
                $scope.current_course = JSON.parse(data)[0];
                $scope.$apply();
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
                $scope.zamples = JSON.parse(data);
                $scope.$apply();
            }
        });
    }

    $scope.openThisZample = function(zample_id) {
        window.location.href = '#/zample/' + zample_id;
    }

    $scope.getCourseFromId();
    $scope.getRelevantZamples();
}])