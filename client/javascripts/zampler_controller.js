// ---------- Zample Page Controller -----------
ZamplerApp.controller('ZampleController', [
'$scope',
'$routeParams',
function($scope, $routeParams) {
    $scope.zample = {}; // REPLACE WITH AJAX
    $scope.zample_image_links = [];
    $scope.selected_zample_image_link = '';

    $scope.getZampleFromId = function() {
        $.ajax({
            url : "/server/get_zample_from_id.php",
            type: "POST",
            data : { 
                        id : $routeParams.zample_id,
                    },
            success: function(data) { 
                $scope.zample = JSON.parse(data)[0];
                $scope.$apply();
            }
        });
    }

    $scope.parseZampleImageLinks = function() {                                // REPLACE WITH AJAX
        $scope.zample_image_links = $scope.zample.images.split(",")
        $scope.selected_zample_image_link = $scope.zample_image_links[0];
    }

    $scope.setSelectedImage = function(link) {
        $scope.selected_zample_image_link = link;
    }

    //$scope.parseZampleImageLinks();
    $scope.getZampleFromId();
}])