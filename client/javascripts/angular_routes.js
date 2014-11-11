// ---------- Route Management -----------
ZamplerApp.config(function($routeProvider, $locationProvider) {
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