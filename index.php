<!DOCTYPE html>
<html>
  <head>
    <title>zampler</title>
    <base href="/">
    <link rel="stylesheet/less" href="/client/stylesheets/style.less" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/lib/uploadifive/uploadifive.css" />
    <link rel="shortcut icon" href="http://54.67.2.106/favicon.ico" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/jquery.cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-route.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.0.0/less.min.js"></script>
    <script src="/client/javascripts/angular_app.js"></script>
    <script src="/client/javascripts/angular_routes.js"></script>
    <script src="/client/javascripts/index_controller.js"></script>
    <script src="/client/javascripts/home_controller.js"></script>
    <script src="/client/javascripts/school_controller.js"></script>
    <script src="/client/javascripts/course_controller.js"></script>
    <script src="/client/javascripts/zample_controller.js"></script>
    <script src="/client/javascripts/objects.js"></script>
    <script src="/lib/uploadifive/jquery.uploadifive.min.js"></script>

    <script>
      /* Everything Involving File Upload Is Here */
      <?php $timestamp = time();?>
      $(function() {
          if($.cookie('has_seen_ethics_statement') != 'true' ) {
              var $body = angular.element(document.body); 
              var $rootScope = $body.scope().$root; 
              $rootScope.$apply(function () {  
                $rootScope.what_is_zampler_popup = true;
              });  
          };

          $('#custom-file-upload-button').click( function() {
              $('#uploadifive-file-upload input:last').click();
          });

          $('#file-upload').uploadifive({
              'auto'             : false,
              'fileType'         : ["image/jpg","application/pdf", "image/jpeg", "image/png", "text/plain"],
              'fileSizeLimit'    : 3000,
              'checkScript'      : '/lib/uploadifive/check-exists.php',
              'formData'         : {
                                       'timestamp' : '<?php echo $timestamp;?>',
                                       'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
                                   },
              'queueID'          : 'file-upload-queue',
              'queueSizeLimit'   : 6,
              'uploadScript'     : '/lib/uploadifive/uploadifive.php',
              'removeCompleted'  : 'true',
              'onError'          : function(errorType) {
                                      var $body = angular.element(document.body); 
                                      var $rootScope = $body.scope().$root; 
                                      $rootScope.$apply(function () {  
                                        $rootScope.create_zample_parameters.error[10] = true;
                                      });                                      
                                   },
              'onAddQueueItem'   : function() {
                                      var $body = angular.element(document.body); 
                                      var $rootScope = $body.scope().$root;       
                                      $rootScope.$apply(function () {  
                                          $rootScope.create_zample_parameters.error[10] = false;
                                          $rootScope.create_zample_parameters.there_are_files = true;
                                          $rootScope.create_zample_parameters.error[8] = false;
                                      });
                                   },
              'onUploadComplete' : function(file, data) { 
                                      if(data && data != '') {
                                          var $body = angular.element(document.body); 
                                          var $rootScope = $body.scope().$root;       
                                          $rootScope.$apply(function () { 
                                              $rootScope.create_zample_parameters.error[10] = false; 
                                              if(!$rootScope.create_zample_parameters.files)
                                                  $rootScope.create_zample_parameters.files = data;
                                              else        
                                                  $rootScope.create_zample_parameters.files += ',' + data;
                                          });
                                      }
                                   },
              'onQueueComplete'  : function(uploads) {
                                      var $body = angular.element(document.body); 
                                      var $rootScope = $body.scope().$root; 
                                      if($rootScope.create_zample_parameters.error[10] != true) 
                                        $rootScope.createZample();
                                   }
          });
      });
    </script>

  </head>
  <body ng-app="zamplerApp">
    <!-- What is zampler popup -->
    <div id="what-is-zampler-popup" ng-show="what_is_zampler_popup" ng-cloak>
      <h1>What is zampler?</h1>
      <h3>Zampler is a place for college students to post <span>completed</span> and <span>returned</span> coursework for others to <span>learn</span> from.</h3>
      <h1>We are not a tool for cheating.</h1>
      <h3>After hearing about zampler, your first thought was probably "isn't that cheating?" or "that sounds illegal!". This is exactly the opposite of what we are here for, and you will in fact fail out of school if you use Zampler to cheat. Zampler is a tool to help you maximize your learning efficiency via the most efficient process to date: learning by example.</h3>
      <h1>Why we are not a tool for cheating.</h1>
      <h3>1) The number one rule of zampler: <span>it is strictly forbidden to upload any coursework until a) the course has been completed</span>, <span>b) the quarter/semester is complete</span> and <span>c) it is your own work</span>. <span>If any of these statements are not true, you may not post the coursework to zampler.</span>This rule is enforced to abide by academic integrity and disallow anyone from using somebody else's work as their own.</h3>
      <h3>2) You're stuck on something, let's say, a calculus problem. At this point, your first approach to solving the problem might consist of looking at the textbook, searching google, or watching a tutorial video. While looking, you don't search for algebra or trigonomotry problems, but for calculus problems, more specifically, problems similar to the one you're stuck on. The end goal is to find a problem and procedure similar to the problem you're stuck on so that you can apply the same process and come to a solution. Or in other words, to <span>learn</span>. Zampler was created to supplement these google searches, textbook examples, and video tutorials by providing you with similar examples to learn from.</h3>
      <h3>3) Professors have every right not to hand back their coursework, and nobody has the right to get their hands on said coursework and upload it to Zampler. On the other hand, professors who do hand back coursework hopefully change their tests every quarter/semester. If tests are handed back to students and not changed for the next course, it provides an unfair advantage to the students who have access to the exact copy of the test they are about to take. Either way, Zampler is available to everybody and provides equal opportunity for all students to learn from.</h3>
      <h3>4) As with any other example from any other source, it's your choice: <span>if you copy, you are cheating.</span> Copying will greatly increase the chances of failing the test, and anyone who does is subject to punishment from the university. </h3>
      <button id="agree-not-to-cheat" ng-click="hideWhatIsZamplerPopup()">I agree to use zampler to learn & not to cheat</button>
      <button id="dont-agree-not-to-cheat" ng-click="takeToChegg()">I do not agree</button>
    </div>

    <!-- Create Account Popup -->
    <div id="create-account-popup" ng-cloak="create_account_popup" ng-show="create_account_popup">
      <button id="close-create-account-popup" ng-click="hideCreateAccountPopup()">
        <span class="glyphicon glyphicon-remove"></span>
      </button>
      <h1>Create an Account</h1>
      <p>You will remain anonymous after creating an account, except for comments, which will be associated with your username.</p>
      <div id="create-account-input-labels">
        <h2>email:</h2>
        <h2>username:</h2>
        <h2>password:</h2>
        <h2>verify password:</h2>
      </div>
      <div id="create-account-input-fields">
        <input id="create-account-email" type="text" ng-model="create_account_parameters.email">
        <input id="create-account-username" type="text" ng-model="create_account_parameters.username">
        <input id="create-account-password" type="password" ng-model="create_account_parameters.password1">
        <input id="create-account-verify-password" type="password" ng-model="create_account_parameters.password2">
      </div>
      <div id="create-account-errors" ng-show="create_account_parameters.errors_exist">
        <h3 ng-show="create_account_parameters.errors[0]"> Invalid email. </h3>
        <h3 ng-show="create_account_parameters.errors[1]"> Username blank. </h3>
        <h3 ng-show="create_account_parameters.errors[2]"> Password not long enough. </h3>
        <h3 ng-show="create_account_parameters.errors[3]"> Passwords do not match. </h3>
        <h3 ng-show="create_account_parameters.errors[4]"> Username or email already in use. </h3>
      </div>
      <button id="submit-create-account" ng-click="tryToCreateAccount()">create</button>
    </div>
    
    <!-- Log In Popup -->
    <div id="log-in-popup" ng-cloak="log_in_popup" ng-show="log_in_popup">
      <button id="close-log-in-popup" ng-click="hideLogInPopup()">
        <span class="glyphicon glyphicon-remove"></span>
      </button>
      <div id="log-in-input-labels">
        <h2>email:</h2>
        <h2>password:</h2>
      </div>
      <div id="log-in-input-fields">
        <input id="log-in-account-email" type="text" ng-model="log_in_credentials.email">
        <input id="log-in-account-password" type="password" ng-model="log_in_credentials.password">
      </div>
      <h1 id="log-in-err" ng-show="log_in_credentials.error">Invalid Login Info</h1>
      <button id="create-account-button" ng-click="showCreateAccountPopup();">create account</button>
      <button id="log-in-button" ng-click="logIn()">log in</button>   
    </div>

    <!-- Add a Zample Popup -->
    <div id="create-zample-popup" ng-cloak="create_zample_popup" ng-show="create_zample_popup">
      <button id="close-create-zample-popup" ng-click="hideCreateZamplePopup()">
        <span class="glyphicon glyphicon-remove"></span>
      </button>
      <h1>Create a Zample!</h1>
      <div id="create-zample-input-labels">
        <h2>school:</h2>
        <h2>course:</h2>
        <h2 ng-show="create_zample_parameters.creating_new_course">create course:</h2>
        <h2>zample name:</h2>
        <h2>professor:</h2>
        <h2>date completed:</h2>
        <h2>difficulty:</h2>
        <h2>was it curved?:</h2>
        <h2>files:</h2>
      </div>
      <div id="create-zample-input-fields">
        <select id="create-zample-school" ng-change="updateCreateZampleCourseOptions(create_zample_parameters.school_id)" ng-options="a_school.id as a_school.name for a_school in schools | orderBy:'name'" ng-model="create_zample_parameters.school_id">
          <option value=''>Select School</option>
        </select>
        <select id="create-zample-course" ng-disabled="!create_zample_parameters.course_options" ng-model="create_zample_parameters.course_id" ng-change="checkIfCreatingNewCourse(create_zample_parameters.course_id)">
          <option ng-repeat="a_course in create_zample_parameters.course_options | orderBy:'name'" ng-value="a_course.id">{{ a_course.name }}</option>
          <option value='new'>-- Create New Course --</option>
        </select> 
        <input id="create-zample-create-new-course" placeholder="MATH 11 - Intro to Calculus" type="text" ng-model="create_zample_parameters.new_course_title" ng-show="create_zample_parameters.creating_new_course">
        <input id="create-zample-title" type="text" placeholder="Assignment 1 - Derivatives" ng-model="create_zample_parameters.zample_name">
        <input id="create-zample-professor" type="text" placeholder="Smith, John" ng-model="create_zample_parameters.professor">
        <select id="create-zample-date-completed" ng-model="create_zample_parameters.date_completed">
          <option value="2010">2010</option>
          <option value="2011">2011</option>
          <option value="2012">2012</option>
          <option value="2013">2013</option>
          <option value="2014">2014</option>
          <option value="2015">2015</option>
        </select>
        <select id="create-zample-difficulty" ng-model="create_zample_parameters.difficulty">
          <option value='0' >0</option>
          <option value='1' >1</option>
          <option value='2' >2</option>
          <option value='3' >3</option>
          <option value='4' >4</option>
          <option value='5' >5</option>
          <option value='6' >6</option>
          <option value='7' >7</option>
          <option value='8' >8</option>
          <option value='9' >9</option>
          <option value='10'>10</option>
        </select>
        <select id="create-zample-curved" ng-model="create_zample_parameters.curved">
          <option value="0">No</option>
          <option value="10">Yes</option>
          <option value="na">N/A</option>
        </select>
        <button id="custom-file-upload-button">Select Files</button><h2><span>*REMOVE YOUR NAME FROM FILE</span></h2>
        <input type="file" name="file_upload" id="file-upload" multiple="true">
      </div>
      <div id="file-upload-queue"></div>
      <div id="create-zample-errors">
        <h3 ng-show="create_zample_parameters.error[0]"> Attempted course creation name already exists at this university. </h3>
        <h3 ng-show="create_zample_parameters.error[1]"> No school chosen. </h3>
        <h3 ng-show="create_zample_parameters.error[2]"> Course name blank. </h3>
        <h3 ng-show="create_zample_parameters.error[3]"> Zample name blank.</h3>
        <h3 ng-show="create_zample_parameters.error[4]"> Professor blank. </h3>
        <h3 ng-show="create_zample_parameters.error[5]"> Date completed blank. </h3>
        <h3 ng-show="create_zample_parameters.error[6]"> Difficulty blank. </h3>
        <h3 ng-show="create_zample_parameters.error[7]"> Curved blank. </h3>
        <h3 ng-show="create_zample_parameters.error[8]"> No files uploaded. </h3>
        <h3 ng-show="create_zample_parameters.error[9]"> SORRY, this is a weird bug -- but please change your course to a different one, and then re-select the desired course. </h3>
        <h3 ng-show="create_zample_parameters.error[10]"> Invalid file type. </h3>
      </div>
      <button id="create-zample-button" ng-click="validateZampleCreationForm()">create</button>
    </div>
    
    <!-- This is where views are injected -->
  	<div id='application-wrapper'>
  		<div ng-view></div>
	  </div>
  </body>
</html>
