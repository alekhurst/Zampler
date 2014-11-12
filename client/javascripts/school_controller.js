// ---------- School Page Controller -----------
ZamplerApp.controller('SchoolController', [
'$scope',
'$routeParams',
'$rootScope',
function($scope, $routeParams, $rootScope) {
    $scope.courses = [];
    $scope.current_school = window.zampler.schools[$routeParams.school_id]; 

    $scope.getRelevantCourses = function() {         
        $.ajax({
            url : "/server/get_relevant_courses.php",
            type: "POST",
            data : { school : $routeParams.school_id },
            success: function(data) { 
                if(data) {
                    parseSuccessData(data);
                } else {
                    $scope.courses[i] = [];
                }
                $scope.$digest();
            }
        });

        function parseSuccessData(data) {
            var rounded_curve;
            var curve_string;
            var difficulty_img_link;
            var rounded_difficulty;

            if(data != 'null') {
                data = JSON.parse(data);
                for(var i=0; i<data.length; i++) {
                    rounded_curve = Math.round(data[i].curve_frequency);
                    rounded_difficulty = Math.round(data[i].difficulty);

                    if(rounded_curve < 0)
                        curve_string = window.zampler.curve_frequency_to_english_mapping[3].title;
                    else if(rounded_curve >= 0 && rounded_curve < 3)
                        curve_string = window.zampler.curve_frequency_to_english_mapping[0].title;
                    else if(rounded_curve >= 3 && rounded_curve < 7)
                        curve_string = window.zampler.curve_frequency_to_english_mapping[1].title;
                    else if(rounded_curve >= 7 )
                        curve_string = window.zampler.curve_frequency_to_english_mapping[2].title;

                    if(rounded_difficulty <= 1)
                        difficulty_img_link = window.zampler.difficulty_image_links[0].link;
                    else if(rounded_difficulty > 1 && rounded_difficulty <=2 )
                        difficulty_img_link = window.zampler.difficulty_image_links[1].link;
                    else if(rounded_difficulty > 2 && rounded_difficulty <=3 )
                        difficulty_img_link = window.zampler.difficulty_image_links[2].link;
                    else if(rounded_difficulty > 3 && rounded_difficulty <=4 )
                        difficulty_img_link = window.zampler.difficulty_image_links[3].link;
                    else if(rounded_difficulty > 4 && rounded_difficulty <=5 )
                        difficulty_img_link = window.zampler.difficulty_image_links[4].link;
                    else if(rounded_difficulty > 5 && rounded_difficulty <=6 )
                        difficulty_img_link = window.zampler.difficulty_image_links[5].link;
                    else if(rounded_difficulty > 6 && rounded_difficulty <=7 )
                        difficulty_img_link = window.zampler.difficulty_image_links[6].link;
                    else if(rounded_difficulty > 7 && rounded_difficulty <=8 )
                        difficulty_img_link = window.zampler.difficulty_image_links[7].link;
                    else if(rounded_difficulty > 8 && rounded_difficulty <=9 )
                        difficulty_img_link = window.zampler.difficulty_image_links[8].link;
                    else if(rounded_difficulty > 9 && rounded_difficulty <=10 )
                        difficulty_img_link = window.zampler.difficulty_image_links[9].link;

                    $scope.courses[i] = {
                        id        : data[i].id,
                        school_id : data[i].school_id,
                        name      : data[i].name,
                        zample_count : data[i].zample_count,
                        difficulty   : difficulty_img_link,
                        curve       : curve_string
                    }
                }
            }
        }                     
    }

    $scope.openZamplesForThisCourse = function(course_id) {
        window.location.href = '#/course/' + course_id;
    }

    $scope.getRelevantCourses();
}])