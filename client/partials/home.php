<div id='home-page'>
    <img id='zampler-logo' src='/client/images/full-logo.png'>
    <h1 class='header-text'>Work less, learn more</h1>
    <input class='search-schools' type='text' placeholder='Search for your school...' ng-model="search.$">
    <ul class='search-results' >
      <li ng-repeat='school in schools | filter:search' ng-click="openCoursesForThisSchool(school.id)">{{ school.name }}</li>
    </ul>
    <h3 class='add-school'>don't see your school?</h3>
</div>
