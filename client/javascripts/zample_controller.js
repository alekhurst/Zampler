// ---------- Zample Page Controller -----------
ZamplerApp.controller('ZampleController', [
'$scope',
'$routeParams',
'$rootScope',
'$window',
function($scope, $routeParams, $rootScope, $window) {
    $scope.zample = {}; 
    $scope.remove_zample_popup = false;
    $scope.user_owns_this_zample = false;
    $scope.zample_image_links = [];
    $scope.selected_zample_image_link = '';
    
    $scope.checkIfUserOwnsThisZample = function() {
        if($rootScope.user) {
            if($rootScope.user.id) {
                $.ajax({
                    url : "/server/check_zample_creator.php",
                    type: "POST",
                    data : { 
                                zample_id : $routeParams.zample_id,
                                user_id   : $rootScope.user.id
                            },
                    success: function(data) { 
                        if(data === 'yes') {
                            $scope.user_owns_this_zample = true;
                            if(!$scope.$$phase)
                                $scope.$digest();
                        }
                    }
                });
            }
        }
    }

    $scope.getZampleFromId = function() {
        $.ajax({
            url : "/server/get_zample_from_id.php",
            type: "POST",
            data : { 
                        id : $routeParams.zample_id
                    },
            success: function(data) { 
                if(data != '' && data != 'null') {
                    $scope.zample = JSON.parse(data)[0];
                    $scope.parseZampleImageLinks();
                    $scope.checkIfUserOwnsThisZample();
                    if(!$scope.$$phase)
                        $scope.$digest();
                }
            }
        });
    };

    $scope.deleteThisZample = function() {
        $.ajax({
            url : "/server/delete_zample.php",
            type: "POST",
            data : { 
                        zample_id : $routeParams.zample_id,
                        user_id : $rootScope.user.id
                    },
            success: function(data) { 
                $rootScope.recalculateCourseStats(data);
                if(data != '' && data != 'null') {
                    window.location.href = '/#/course/' + data;
                }
            }
        });
    };

    $scope.parseZampleImageLinks = function() {                             
        $scope.zample_image_links = $scope.zample.images.split(",")
        $scope.selected_zample_image_link = $scope.zample_image_links[0];
    };

    $scope.setSelectedImage = function(link) {
        $scope.selected_zample_image_link = link;
    };

    $scope.showRemoveZamplePopup = function() {
        $scope.remove_zample_popup = true;
        $window.scrollTo(0,0);
    }; $scope.hideRemoveZamplePopup = function() {
        $scope.remove_zample_popup = false;
    }

    $scope.getZampleFromId();
}])