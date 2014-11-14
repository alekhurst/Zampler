// ---------- Zample Page Controller -----------
ZamplerApp.controller('ZampleController', [
'$scope',
'$routeParams',
'$rootScope',
'$window',
function($scope, $routeParams, $rootScope, $window, $sce) {
    $scope.zample = {}; 
    $scope.remove_zample_popup = false;
    $scope.user_owns_this_zample = false;
    $scope.user_liked_this_zample = false;
    $scope.user_reported_this_zample = false;
    $scope.zample_file_links = [];
    $scope.selected_zample_file_link = '';
    
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

    $scope.checkIfUserLikedThisZample = function() {
        if($rootScope.user) {
            if($rootScope.user.id) {
                $.ajax({
                    url : "/server/check_zample_liker.php",
                    type: "POST",
                    data : { 
                                zample_id : $routeParams.zample_id,
                            },
                    success: function(data) { 
                        if(data == 'yes') {
                            $scope.user_liked_this_zample = true;
                            if(!$scope.$$phase)
                                $scope.$digest();
                        }   
                    }
                });
            }
        }
    }

    $scope.checkIfUserReportedThisZample = function() {
        if($rootScope.user) {
            if($rootScope.user.id) {
                $.ajax({
                    url : "/server/check_if_user_reported_this_zample.php",
                    type: "POST",
                    data : { 
                                zample_id : $routeParams.zample_id,
                            },
                    success: function(data) { 
                        if(data == 'yes') {
                            $scope.user_reported_this_zample = true;
                            if(!$scope.$$phase)
                                $scope.$digest();
                        }
                    }
                });
            }
        }
    };

    $scope.getZampleFromId = function() {
        $.ajax({
            url : "/server/get_zample_from_id.php",
            type: "POST",
            data : { 
                        id : $routeParams.zample_id
                    },
            success: function(data) { 
                if(data == 'null' || !data) {
                    window.location.href = '#'; // 404
                } else {
                    $scope.zample = JSON.parse(data)[0];
                    $scope.parseZampleFileLinks();
                    $scope.checkIfUserOwnsThisZample();
                    $scope.checkIfUserLikedThisZample();
                    $scope.checkIfUserReportedThisZample();
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
                    },
            success: function(data) { 
                $rootScope.recalculateCourseStats(data);
                if(data != '' && data != 'null') {
                    window.location.href = '/#/course/' + data;
                }
            }
        });
    };

    $scope.reportThisZample = function() {
        $.ajax({
            url : "/server/report_zample.php",
            type: "POST",
            data : { 
                        zample_id : $routeParams.zample_id,
                    },
            success: function(data) { 
                if(data == 'success') {
                    $scope.user_reported_this_zample = true;
                    if(!$scope.$$phase)
                        $scope.$digest();  
                }
            }   
        });
    };

    $scope.likeThisZample = function() {
        $.ajax({
            url : "/server/like_zample.php",
            type: "POST",
            data : { 
                        zample_id : $routeParams.zample_id,
                    },
            success: function(data) { 
                if(data == 'success') {
                    $scope.user_liked_this_zample = true;
                    $scope.zample.likes++;
                    if(!$scope.$$phase)
                        $scope.$digest();   
                }
            }
        });
    };
    
    $scope.parseZampleFileLinks = function() {                             
        $scope.zample_file_links = $scope.zample.files.split(",");
        $scope.selected_zample_file_link = "../../user_uploads/" + $scope.zample_file_links[0];
    };

    $scope.setSelectedFile = function(link) {
        $scope.selected_zample_file_link = "../../user_uploads/" + link;
    };

    $scope.showRemoveZamplePopup = function() {
        $scope.remove_zample_popup = true;
        $window.scrollTo(0,0);
    }; $scope.hideRemoveZamplePopup = function() {
        $scope.remove_zample_popup = false;
    }

    $scope.getZampleFromId();
}])