<!DOCTYPE html>
<html>
  <head>
    <title>zampler</title>
    <base href="/">
    <link rel="stylesheet/less" href="/client/stylesheets/style.less" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-route.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.0.0/less.min.js"></script>
    <script src="/client/javascripts/view-controller.js"></script>
    <script src="/client/javascripts/objects.js"></script>
  </head>
  <body ng-app="zamplerApp">
    
    <!-- Create Account Popup -->
    <div id="create-account-popup" ng-cloak="create_account_popup" ng-show="create_account_popup">
      <button id="close-create-account-popup" ng-click="hideCreateAccountPopup()">
        <span class="glyphicon glyphicon-remove"></span>
      </button>
      <h1>Create an Account</h1>
      <p>You will remain anonymous after creating an account. To change this, uncheck "keep me anonymous" while creating a zample and your username will be shown. Comments will be associated with your username.</p>
      <div id="create-account-input-labels">
        <h2>email:</h2>
        <h3>invalid email</h3>
        <h2>username:</h2>
        <h3>invalid username</h3>
        <h2>password:</h2>
        <h3>passwords do not match</h3>
        <h2>verify password:</h2>
      </div>
      <div id="create-account-input-fields">
        <input id="create-account-email" type="text">
        <input id="create-account-username" type="text">
        <input id="create-account-password" type="text">
        <input id="create-account-verify-password" type="text">
      </div>
      <button id="submit-create-account">create</button>
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
        <input id="log-in-account-email" type="text">
        <input id="log-in-account-password" type="text">
      </div>
      <button id="log-in-button">log in</button>
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
        <h2>title:</h2>
        <h2>professor:</h2>
        <h2>date completed:</h2>
        <h2>difficulty:</h2>
        <h2>curved?:</h2>
        <h2>images:</h2>
      </div>
      <div id="create-zample-input-fields">
        <select id="create-zample-school" ng-model="create_zample_parameters.school">
          <option value="0">Santa Clara University</option>
          <option value="1">San Jose State University</option>
        </select>
        <input id="create-zample-course" type="text" placeholder="ex. MATH11" ng-model="create_zample_parameters.course">
        <input id="create-zample-title" type="text" placeholder="ex. First Midterm" ng-model="create_zample_parameters.title">
        <input id="create-zample-professor" type="text" placeholder="ex. Lastname, Firstname" ng-model="create_zample_parameters.professor">
        <select id="create-zample-date-completed" ng-model="create_zample_parameters.date_completed">
          <option value="2010">2010</option>
          <option value="2011">2011</option>
          <option value="2012">2012</option>
          <option value="2013">2013</option>
          <option value="2014">2014</option>
          <option value="2015">2015</option>
        </select>
        <select id="create-zample-difficulty" ng-model="create_zample_parameters.difficulty">
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
          <option value="5">N/A</option>
        </select>
        <button id="create-zample-button" ng-click="createZampleInDatabase()">create</button>
      </div>
    </div>

    <!-- This is where views are injected -->
  	<div id='application-wrapper'>
  		<div ng-view></div>
	  </div>
  </body>
</html>