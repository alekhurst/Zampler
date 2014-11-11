// ---------- Root Scope Funcitonality -----------
ZamplerApp.run([
"$rootScope", 
"$location",
"$route", 
function($rootScope, $location, $route) {
    $rootScope.schools = window.zampler.schools;

    $rootScope.create_account_popup = false;
    $rootScope.log_in_popup = false;
    $rootScope.create_zample_popup = false;

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

    $rootScope.recalculateCourseStats = function(course_id) {
        $.ajax({
            url : "/server/recalculate_course_stats.php",
            type: "POST",
            data : { 
                        course : course_id,
                   },
            success: function() { 

            }
        });
    };

    /**
     * Create a Zample - Parameters used throughout creating
     */
    $rootScope.create_zample_parameters = {
        user_id : undefined,
        school_id : undefined,
        course_id : undefined,
        course_options : undefined,
        creating_new_course : undefined,
        new_course_title : undefined,
        new_course_id : undefined,
        zample_name : undefined,
        professor : undefined,
        date_completed : undefined,
        difficulty : undefined,
        curved : undefined,
        images : undefined,
        error : [],
        errors_exist : undefined
    };

    /* PREPARE YOURSELF! HERE COMES THE STORMMMMMMMMMMMM 
                    (creating a zample)                  */

    /**
     * Create a Zample - Updates course dropdown when a school is selected
     */
    $rootScope.updateCreateZampleCourseOptions = function(school_id) {
        $.ajax({
            url : "/server/get_relevant_courses.php",
            type: "POST",
            data : { 
                        school : $rootScope.create_zample_parameters.school_id,
                   },
            success: function(data) { 
                if(data != 'null' && data) {
                    $rootScope.create_zample_parameters.course_options = JSON.parse(data);
                } else {
                    $rootScope.create_zample_parameters.course_options = [{name: ' ', id: ' '}];
                }
                $rootScope.$apply();
            }
        });
    }; 

    /**
     * Create a Zample - Called on change of course dropdown while creating a zample, assigns variable accordingly
     */
    $rootScope.checkIfCreatingNewCourse = function(value) {
        if(value === 'new')
            $rootScope.create_zample_parameters.creating_new_course = true;
        else
            $rootScope.create_zample_parameters.creating_new_course = false;
    }; 

    /**
     * Create a Zample - Called when user clicks 'create' after filling out the create a zample form
     */
    $rootScope.createZampleInDatabase = function() {

        // check to see if they created a new course. If they didn't, don't 
        // try to create a course and run normally. 
        if($rootScope.create_zample_parameters.creating_new_course) {
            checkUserInput();
            if($rootScope.create_zample_parameters.errors_exist == true) {
                return;
            } else {
                $.ajax({
                    url : "/server/create_course.php",
                    type: "POST",
                    data : { 
                                name       : $rootScope.create_zample_parameters.new_course_title,
                                school_id  : $rootScope.create_zample_parameters.school_id,
                                curve      : $rootScope.create_zample_parameters.curved,
                                difficulty : $rootScope.create_zample_parameters.difficulty
                            },
                    success: function(data) { 
                        if(data == 'duplicate') {
                            $rootScope.create_zample_parameters.error[0] = true;
                        } else {
                            var x =  JSON.parse(data)
                            $rootScope.create_zample_parameters.course_id = x[0].id;
                            $rootScope.create_zample_parameters.error[0] = false;

                            checkUserInput();
                            if($rootScope.create_zample_parameters.errors_exist == true) {
                                return;
                            } else {
                                createZample();
                            }
                        }
                        $rootScope.$apply();
                    }
                });
            }
        } else {
            checkUserInput();
            if($rootScope.create_zample_parameters.errors_exist == true)
                return;
            else
                createZample();
        }

        // create the new zample
        function createZample() {
            var cid;
            if($rootScope.create_zample_parameters.new_course_id)
                cid = $rootScope.create_zample_parameters.new_course_id;
            else
                cid = $rootScope.create_zample_parameters.course_id;
            if($rootScope.create_zample_parameters.curved == 'na')
                curve = -1;
            else
                curve = $rootScope.create_zample_parameters.curved;

            $.ajax({
                url : "/server/create_zample.php",
                type: "POST",
                data : { 
                            user_id        : 0,
                            school_id      : $rootScope.create_zample_parameters.school_id,
                            course_id      : cid,
                            zample_name    : $rootScope.create_zample_parameters.zample_name,
                            professor      : $rootScope.create_zample_parameters.professor,
                            date_completed : $rootScope.create_zample_parameters.date_completed,
                            difficulty     : $rootScope.create_zample_parameters.difficulty,
                            curved         : curve,
                            images         : ''
                        },
                success: function() { 
                    clearCreateZampleParams();
                    $rootScope.create_zample_popup = false;
                    $rootScope.recalculateCourseStats(cid);
                    $route.reload();
                    $rootScope.$apply();
                }
            });
        }

        // checks if any of create-a-zample fields are blank and alerts the user to change before form submission
        function checkUserInput() {
            $rootScope.create_zample_parameters.errors_exist = false;

            $rootScope.create_zample_parameters.error[0] = false; // remove duplicate new class error

            if($rootScope.create_zample_parameters.school_id === '' || $rootScope.create_zample_parameters.school_id == undefined) {
                $rootScope.create_zample_parameters.error[1] = true;
            } else {
                $rootScope.create_zample_parameters.error[1] = false;
            } 
            if($rootScope.create_zample_parameters.course_id === '' || $rootScope.create_zample_parameters.course_id == undefined 
                || ($rootScope.create_zample_parameters.creating_new_course  && ($rootScope.create_zample_parameters.new_course_title === '' || $rootScope.create_zample_parameters.new_course_title == undefined))) {
                $rootScope.create_zample_parameters.error[2] = true;
            } else {
                $rootScope.create_zample_parameters.error[2] = false;
            } 
            if($rootScope.create_zample_parameters.zample_name === '' || $rootScope.create_zample_parameters.zample_name == undefined) {
                $rootScope.create_zample_parameters.error[3] = true;
            } else {
                $rootScope.create_zample_parameters.error[3] = false;
            } 
            if($rootScope.create_zample_parameters.professor === '' || $rootScope.create_zample_parameters.professor == undefined) {
                $rootScope.create_zample_parameters.error[4] = true;
            } else {
                $rootScope.create_zample_parameters.error[4] = false;
            } 
            if($rootScope.create_zample_parameters.date_completed === '' || $rootScope.create_zample_parameters.date_completed == undefined) {
                $rootScope.create_zample_parameters.error[5] = true;
            } else {
                $rootScope.create_zample_parameters.error[5] = false;
            } 
            if($rootScope.create_zample_parameters.difficulty === '' || $rootScope.create_zample_parameters.difficulty == undefined) {
                $rootScope.create_zample_parameters.error[6] = true;
            } else {
                $rootScope.create_zample_parameters.error[6] = false;
            } 
            if($rootScope.create_zample_parameters.curved === '' || $rootScope.create_zample_parameters.curved == undefined) {
                $rootScope.create_zample_parameters.error[7] = true;
            } else {
                $rootScope.create_zample_parameters.error[7] = false;
            } 
            if($rootScope.create_zample_parameters.images) {
                // $rootScope.create_zample_parameters.error[8];
                // $rootScope.create_zample_parameters.errors_exist = true;
            } 

            for(var i = 0; i<$rootScope.create_zample_parameters.error.length; i++) {
                if($rootScope.create_zample_parameters.error[i] == true) {
                    $rootScope.create_zample_parameters.errors_exist = true;
                    break;
                }
            }
        }

        function clearCreateZampleParams() {
            $rootScope.create_zample_parameters = {
                user_id : undefined,
                school_id : undefined,
                course_id : undefined,
                course_options : undefined,
                creating_new_course : undefined,
                new_course_title : undefined,
                new_course_id : undefined,
                zample_name : undefined,
                professor : undefined,
                date_completed : undefined,
                difficulty : undefined,
                curved : undefined,
                images : undefined,
                error : [],
                errors_exist : undefined
            };
        }
    };
}]);