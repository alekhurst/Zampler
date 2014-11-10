<div id='school-page'>
    <nav>
        <a href="/#/"><img id='zampler-logo' src='/client/images/full-logo.png'></a>
        <button id='add-a-zample' ng-click="showCreateZamplePopup()">add a zample</button>
        <div id="account-buttons">
            <h3 ng-click="showCreateAccountPopup()">create account</h3>
            <h3 ng-click="showLogInPopup()">log in</h3>
        </div>
    </nav>
    <h1 class='header-text'> {{ current_school.name }} </h1>
    <input type='text' id='search-courses' placeholder='Filter courses...' ng-model="search.$">
    <table class='table table-hover course-table'>
        <thead>
            <tr>
                <th class='col-md-3'>Course Name</th>
                <th class='col-md-3'>Zamples</th>
                <th class='col-md-3'>Curve</th>
                <th class='col-md-4'>Difficulty</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="course in courses | filter:search" ng-click="openZamplesForThisCourse(course.id)">
                <td class='col-md-3'> {{ course.name }} </td>
                <td class='col-md-3'> {{ course.zample_count }} </td>
                <td class='col-md-3'> {{ course.curved }} </td>
                <td class='col-md-3'> <img ng-src="/client/images/difficulty-10-indicator.png"> </td>
            </tr>
        </tbody>
    </table>
</div>