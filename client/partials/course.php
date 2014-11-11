<div id='course-page'>
    <nav>
        <a href="/#/"><img id='zampler-logo' src='/client/images/full-logo.png'></a>
        <button id='add-a-zample' ng-click="showCreateZamplePopup()">add a zample</button>
        <div id="account-buttons">
            <h3 ng-click="showCreateAccountPopup()">create account</h3>
            <h3 ng-click="showLogInPopup()">log in</h3>
        </div>
    </nav>
    <h1 class='header-text'> {{ current_course.name }} </h1>
    <input type='text' id='search-zamples' value='Filter zamples...'>
    <table class='table table-hover zample-table'>
        <thead>
            <tr>
                <th class='col-md-5'>Zample</th>
                <th class='col-md-4'>Professor</th>
                <th class='col-md-2'>Date Completed</th>
                <th class='col-md-1'>Likes</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="zample in zamples" ng-click="openThisZample(zample.id)">
                <td class='col-md-5'> {{ zample.title }} </td>
                <td class='col-md-4'> {{ zample.professor }} </td>
                <td class='col-md-2'> {{ zample.date_completed }} </td>
                <td class='col-md-1'> {{ zample.likes }} </td>
            </tr>
        </tbody>
    </table>
</div>