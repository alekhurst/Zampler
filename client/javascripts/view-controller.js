angular.module('zamplerApp', ['ngRoute'])


// ---------- Route Management -----------
.config(function($routeProvider, $locationProvider) {
    $routeProvider
        .when('/', {
            templateUrl: '/client/partials/home.php',
            controller: 'HomeController',
        })
        .when('/school/:school_id', {
            templateUrl: '/client/partials/school.php',
            controller: 'SchoolController',
        })
        .when('/course/:course_id', {
            templateUrl: '/client/partials/course.php',
            controller: 'CourseController',
        })
        .when('/zample/:zample_id', {
            templateUrl: '/client/partials/zample.php',
            controller: 'ZampleController',
        })
        .otherwise({
            redirectTo: '/'
        });

})

// ---------- Home Page Controller -----------
.controller('HomeController', [
'$scope',
function($scope, $routeParams) {
    $scope.schools = window.zampler.schools;
    $scope.school_search = 'Search for your school...';
    
    $scope.openCoursesForThisSchool = function(school_id) {
        window.location.href = '#/school/' + school_id;
    }
}])

// ---------- School Page Controller -----------
.controller('SchoolController', [
'$scope',
'$routeParams',
function($scope, $routeParams) {
    $scope.courses = [];
    $scope.current_school = window.zampler.schools[$routeParams.school_id]; 

    $scope.getRelevantCourses = function() {         
        $.ajax({
            url : "/server/get_relevant_courses.php",
            type: "POST",
            data : { school : $routeParams.school_id },
            success: function(data) { 
                if(data) {
                    data = JSON.parse(data);
                    for(var i=0; i<data.length; i++) {
                        $scope.courses[i] = {
                            id        : data[i].id,
                            school_id : data[i].school_id,
                            name      : data[i].name,
                            zample_count : data[i].zample_count,
                            difficulty   : data[i].difficulty,
                            curved       : data[i].curved
                        }
                    }
                } else {
                    $scope.courses[i] = [];
                }

                $scope.$apply();
            }
        });                      
    }

    $scope.openZamplesForThisCourse = function(course_id) {
        window.location.href = '#/course/' + course_id;
    }

    $scope.getRelevantCourses();
}])

// ---------- Course Page Controller -----------
.controller('CourseController', [
'$scope',
'$routeParams',
function($scope, $routeParams) {
    $scope.zamples = [];
    $scope.current_course = window.zampler.courses[$routeParams.course_id]; // REPLACE WITH AJAX

    $scope.getRelevantZamples = function() {                                // REPLACE WITH AJAX
        for(var i=0; i<window.zampler.zamples.length; i++)
            if(window.zampler.zamples[i].course_id == $routeParams.course_id)
                $scope.zamples.push(angular.copy(window.zampler.zamples[i]));
    }

    $scope.openThisZample = function(zample_id) {
        window.location.href = '#/zample/' + zample_id;
    }

    $scope.getRelevantZamples();
}])

// ---------- Zample Page Controller -----------
.controller('ZampleController', [
'$scope',
'$routeParams',
function($scope, $routeParams) {
    $scope.zample = window.zampler.zamples[$routeParams.zample_id]; // REPLACE WITH AJAX
    $scope.zample_image_links = [];
    $scope.selected_zample_image_link = '';

    $scope.parseZampleImageLinks = function() {                                // REPLACE WITH AJAX
        $scope.zample_image_links = $scope.zample.images.split(",")
        $scope.selected_zample_image_link = $scope.zample_image_links[0];
    }

    $scope.setSelectedImage = function(link) {
        $scope.selected_zample_image_link = link;
    }
    $scope.parseZampleImageLinks();
}])

.run( function($rootScope) {
    $rootScope.create_account_popup = false;
    $rootScope.log_in_popup = false;
    $rootScope.create_zample_popup = false;
    $rootScope.create_zample_parameters = {};

    $rootScope.showLogInPopup = function() {
        $rootScope.log_in_popup = true;
    }; $rootScope.showCreateAccountPopup = function() {
        $rootScope.create_account_popup = true;
    }; $rootScope.showCreateZamplePopup = function() {
        $rootScope.create_zample_popup = true;
    }; 

    $rootScope.hideLogInPopup = function() {
        $rootScope.log_in_popup = false;
    }; $rootScope.hideCreateAccountPopup = function() {
        $rootScope.create_account_popup = false;
    }; $rootScope.hideCreateZamplePopup = function() {
        $rootScope.create_zample_popup = false;
    };

    $rootScope.createZampleInDatabase = function() {
        $.ajax({
            url : "/server/create_zample.php",
            type: "POST",
            data : { 
                        school         : $scope.create_zample_parameters.school,
                        course         : $scope.create_zample_parameters.course,
                        title          : $scope.create_zample_parameters.title,
                        professor      : $scope.create_zample_parameters.professor,
                        date_completed : $scope.create_zample_parameters.date_completed,
                        difficulty     : $scope.create_zample_parameters.difficulty,
                        curved         : $scope.create_zample_parameters.curved,
                        images         : ''
                    },
            success: function() { 
                window.top.location.href = 'http://culture.netapp.com/employee-catalyst-commitment/';
            }
        });
    }
})