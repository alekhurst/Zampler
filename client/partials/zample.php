<div id='zample-page'>
    <nav>
        <a href="/#/"><img id='zampler-logo' src='/client/images/full-logo.png'></a>
        <button id='add-a-zample' ng-click="showCreateZamplePopup()">add a zample</button>
        <div id="account-buttons">
            <h3 ng-click="showCreateAccountPopup()">create account</h3>
            <h3 ng-click="showLogInPopup()">log in</h3>
        </div>
    </nav>
    <h1 class='header-text'> {{ zample.name }} </h1>
    <div id="zample-image-thumbnail-container" ng-repeat="link in zample_image_links">
        <img ng-src="/client/images/{{link}}" ng-click="setSelectedImage(link)">
    </div>
    <div id="selected-zample-image-container">
        <img ng-src="/client/images/{{selected_zample_image_link}}">
    </div>
    <h1 id="likes"><span class="glyphicon glyphicon-thumbs-up"></span> 3</h1>
    <button id="report-this-zample">report this zample</button>
</div>