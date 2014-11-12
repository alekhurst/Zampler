// ---------- Route Management -----------
ZamplerApp.config(function($routeProvider, $locationProvider) {
    $routeProvider
        .when('/', {
            templateUrl: '/client/partials/home.html',
            controller: 'HomeController',
        })
        .when('/school/:school_id', {
            templateUrl: '/client/partials/school.html',
            controller: 'SchoolController',
        })
        .when('/course/:course_id', {
            templateUrl: '/client/partials/course.html',
            controller: 'CourseController',
        })
        .when('/zample/:zample_id', {
            templateUrl: '/client/partials/zample.html',
            controller: 'ZampleController',
        })
        .otherwise({
            redirectTo: '/'
        });

})