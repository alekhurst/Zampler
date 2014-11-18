// ---------- Root Scope Funcitonality -----------
ZamplerApp.run([
"$rootScope", 
"$location",
"$route", 
"$window",
function($rootScope, $location, $route, $window) {

    $rootScope.user = undefined;
    $rootScope.log_in_credentials = {};
    $rootScope.schools = window.zampler.schools;

    $rootScope.create_account_popup = false;
    $rootScope.log_in_popup = false;
    $rootScope.create_zample_popup = false;
    $rootScope.what_is_zampler_popup = false;

    $rootScope.showLogInPopup = function() {
        $rootScope.log_in_popup = true;
        $rootScope.hideCreateAccountPopup();
        $window.scrollTo(0,0);
    }; $rootScope.showCreateAccountPopup = function() {
        $rootScope.create_account_popup = true;
        $rootScope.hideLogInPopup();
    }; $rootScope.showCreateZamplePopup = function() {
        $rootScope.create_zample_popup = true;
    }; $rootScope.showWhatIsZamplerPopup = function() {
        $rootScope.what_is_zampler_popup = true;
    }; 

    $rootScope.hideLogInPopup = function() {
        $rootScope.log_in_popup = false;
        if($rootScope.log_in_credentials)
            $rootScope.log_in_credentials.error = false;
    }; $rootScope.hideCreateAccountPopup = function() {
        if($rootScope.create_account_parameters)
            $rootScope.create_account_parameters.errors = [];
        $rootScope.create_account_popup = false;
    }; $rootScope.hideCreateZamplePopup = function() {
        $rootScope.create_zample_popup = false;
    }; $rootScope.hideWhatIsZamplerPopup = function() {
        $rootScope.what_is_zampler_popup = false;
        $.cookie('has_seen_ethics_statement', 'true');
    }; $rootScope.takeToChegg = function() {
        $.cookie('has_seen_ethics_statement', 'false');
        window.location = "http://www.chegg.com/homework-help/textbook-solutions";
    }

    /**
     * at every reload, check if user is logged in
     */
    $rootScope.checkIfLoggedIn = function() {
        $.ajax({
            url : "/server/check_if_logged_in.php",
            type: "POST",
            success: function(data) {
                if(data != 'not_logged_in') {
                    data = JSON.parse(data);
                    $rootScope.user = {
                        id       : data[0],
                        username : data[1],
                        email    : data[2]
                    }
                } else {
                    $rootScope.user = undefined;
                }
                $route.reload();
                if(!$rootScope.$$phase)
                    $rootScope.$apply();
            }
        });
    }
    $rootScope.checkIfLoggedIn();

    $rootScope.logOut = function() {
        $.ajax({
            url : "/server/log_out.php",
            type: "POST",
            data : {},
            success: function(data) {
                $rootScope.checkIfLoggedIn();
            }
        });
    }
    $rootScope.logIn = function() {
        if($rootScope.log_in_credentials.email && $rootScope.log_in_credentials.password) {
            $.ajax({
                url : "/server/log_in.php",
                type: "POST",
                data : {
                    email    : $rootScope.log_in_credentials.email,
                    password : $rootScope.log_in_credentials.password
                },
                success: function(data) {
                    if(data != 'null' && data != 'invalid' && data) {
                        data = JSON.parse(data);
                        $rootScope.user = {
                            id       : data[0],
                            username : data[1],
                            email    : data[2]
                        }

                        $rootScope.log_in_credentials = undefined;
                        $rootScope.hideLogInPopup();
                        $route.reload();
                        if(!$rootScope.$$phase)
                            $rootScope.$apply();

                    } else {
                        $rootScope.log_in_credentials.error = true;
                    }    
                }
            });
        } else {
            $rootScope.log_in_credentials.error = true;
        }
    }


    /* ----------------- BEGIN ACCOUNT CREATION STUFF --------------------------- */
    /**
     * Create an account - Parameters used throughout creating
     */

    $rootScope.create_account_parameters = {
        email : undefined,
        username : undefined,
        password1 : undefined,
        password2 : undefined,
        errors : [],
        erros_exist : undefined
    }

    $rootScope.checkCreateAccountInput = function() {
        var email_regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        $rootScope.create_account_parameters.errors_exist = false;

        if(email_regex.test($rootScope.create_account_parameters.email) != true)
            $rootScope.create_account_parameters.errors[0] = true;
        else
            $rootScope.create_account_parameters.errors[0] = false;
        
        if($rootScope.create_account_parameters.username === '' || $rootScope.create_account_parameters.username == undefined)
            $rootScope.create_account_parameters.errors[1] = true;
        else
            $rootScope.create_account_parameters.errors[1] = false
        
        if($rootScope.create_account_parameters.password1 == undefined || $rootScope.create_account_parameters.password1.length < 5)
            $rootScope.create_account_parameters.errors[2] = true;
        else
            $rootScope.create_account_parameters.errors[2] = false;
        
        if($rootScope.create_account_parameters.password1 != $rootScope.create_account_parameters.password2)
            $rootScope.create_account_parameters.errors[3] = true;
        else
            $rootScope.create_account_parameters.errors[3] = false;

        for(var i = 0; i<4; i++) {
            if($rootScope.create_account_parameters.errors[i] == true) {
                $rootScope.create_account_parameters.errors_exist = true;
                break;
            }
        }
    }

    $rootScope.tryToCreateAccount = function() {
        $rootScope.checkCreateAccountInput();
        if($rootScope.create_account_parameters.errors_exist)
            return;
        else {
            $.ajax({
                url : "/server/check_for_duplicate_account.php",
                type: "POST",
                data : { 
                            email : $rootScope.create_account_parameters.email,
                            username : $rootScope.create_account_parameters.username
                       },
                success: function(data) { 
                    if(data == 'duplicate') {
                        $rootScope.create_account_parameters.errors_exist = true;
                        $rootScope.create_account_parameters.errors[4] = true;
                        if(!$rootScope.$$phase)
                            $rootScope.$apply();
                        return;
                    } else if(data == 'ok') {
                        $rootScope.create_account_parameters.errors[4] = false;
                        if(!$rootScope.$$phase)
                            $rootScope.$apply();
                        $rootScope.createAccountInDatabase();
                    }
                }
            });
        }
    }

    $rootScope.createAccountInDatabase = function() {
        $.ajax({
            url : "/server/create_account.php",
            type: "POST",
            data : { 
                        email : $rootScope.create_account_parameters.email,
                        username : $rootScope.create_account_parameters.username,
                        password : $rootScope.create_account_parameters.password1
                   },
            success: function() { 
                clearCreateAccountParams();
                $rootScope.create_account_popup = false;
                $rootScope.checkIfLoggedIn();
                if(!$rootScope.$$phase)
                    $rootScope.$apply();
            }
        });

        function clearCreateAccountParams() {
            $rootScope.create_account_parameters = {
                email : undefined,
                username : undefined,
                password1 : undefined,
                password2 : undefined,
                errors : [],
                erros_exist : undefined
            }
        }
    }



    /* ----------------- BEGIN ZAMPLE CREATION STUFF --------------------------- */
    /*              PREPARE YOURSELF! HERE COMES THE STORMMMMMMMMMMMM            */
                            
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
                    $rootScope.create_zample_parameters.course_options = [{name: '', id: ''}];
                }
                $rootScope.create_zample_parameters.flag_to_change_course = true; // user cannot submit this form until they change the course
                if(!$rootScope.$$phase)
                    $rootScope.$digest();
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
        $rootScope.create_zample_parameters.flag_to_change_course = false; 
    }; 

    /**
     * Create a Zample - Called when user clicks 'create' after filling out the create a zample form
     */
    $rootScope.validateZampleCreationForm = function() {

        // check to see if they created a new course. If they didn't, don't 
        // try to create a course and run normally. 
        if($rootScope.create_zample_parameters.creating_new_course) {
            checkUserInput();
            if($rootScope.create_zample_parameters.errors_exist == true) {
                return;
            } else { // no errors, create the new course
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
                                uploadFiles();
                            }
                        }
                        if(!$rootScope.$$phase)
                            $rootScope.$apply();
                    }
                });
            }
        } else { // user not creating new course
            checkUserInput();
            if($rootScope.create_zample_parameters.errors_exist == true)
                return;
            else
                uploadFiles();
        }

        function uploadFiles() {
            if($rootScope.create_zample_parameters.there_are_files) {
                $('#file-upload').uploadifive('upload');
                $rootScope.create_zample_parameters.error[8] = false;
            } else 
                $rootScope.create_zample_parameters.error[8] = true;
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
            if($rootScope.create_zample_parameters.flag_to_change_course === true) {
                $rootScope.create_zample_parameters.error[9] = true;
            } else {
                $rootScope.create_zample_parameters.error[9] = false;
            }

            for(var i = 0; i<$rootScope.create_zample_parameters.error.length; i++) {
                if($rootScope.create_zample_parameters.error[i] == true) {
                    $rootScope.create_zample_parameters.errors_exist = true;
                    break;
                }
            }
        }
    };

    /**
     * create the new zample after all errors have been checked
     */
    $rootScope.createZample = function() {
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
                        user_id        : $rootScope.user.id,
                        school_id      : $rootScope.create_zample_parameters.school_id,
                        course_id      : cid,
                        zample_name    : $rootScope.create_zample_parameters.zample_name,
                        professor      : $rootScope.create_zample_parameters.professor,
                        date_completed : $rootScope.create_zample_parameters.date_completed,
                        difficulty     : $rootScope.create_zample_parameters.difficulty,
                        curved         : curve,
                        files          : $rootScope.create_zample_parameters.files
                    },
            success: function(data) { 
                $rootScope.clearCreateZampleParams();
                $rootScope.create_zample_popup = false;
                $rootScope.recalculateCourseStats(cid);
                window.location.href = '#/zample/' + data;
            }
        });
    }

    $rootScope.clearCreateZampleParams = function() {
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
            files : undefined,
            there_are_files : undefined,
            error : [],
            errors_exist : undefined
        };
    }
    $rootScope.clearCreateZampleParams(); // clear on load

    /**
     * Called when a zample is added or removed
     */
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
}]);