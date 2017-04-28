<?php
if (! empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = 0;
}
?>

<!DOCTYPE html>
<html >
<style>
    .headerLine {
        margin: 0;
    }
    .dataLine   {
        width: 100px;
        padding-left: 15px;
        float: left;
    }
    label {
        margin-left: 20px;
        font-weight: bold;
    }
    img{
        width:80%;
    }

</style>
<title>Display News Item</title>

<!-- LOAD BOOTSTRAP CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">

<body>

    <div ng-app="myApp" ng-controller="newsListCtrl">
        <div class="col-md-6 col-md-offset-3">
            <div>
                <img src="image/header.jpg" />
            </div>
            <div class="page-header">
                <h1><span class="glyphicon glyphicon-tower"></span> News Items List</h1>
            </div>

            <!-- SHOW ERROR/SUCCESS MESSAGES -->
            <div id="messages"></div>
            <div>
                <p>list of items in the news item file</p>
                <ul>
                    <li ng-repeat="x in records">
                        <p class="headerLine"><a href="getItem.php?id={{x.id}}">{{ x.title }}</a></p>
                        <p class="dataLine"> {{ x.author }} </p>
                        <p  > {{  x.publishDate }} </p>
                    </li>
                </ul>
            </div>
            <div ng-if="id != -1">
                <a href="index.php?id={{id}}" class="btn btn-success" role="button">Get Next News Items</a>
                <a href="additem.php" class="btn btn-success" role="button">Add New News Item</a>
            </div>
                <div ng-if="id == -1">
                <a href="index.php" class="btn btn-success" role="button">Start News Items Again</a>
                <a href="additem.php" class="btn btn-success" role="button">Add New News Item</a>
            </div>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script src="ng-text-truncate.js"></script>

<script>
    var app = angular.module('myApp', ["ngTextTruncate"]);
    app.controller('newsListCtrl', function($scope, $http) {
        $scope.id =  "<?php echo $id ?>";
        $scope.ariticle = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla semper augue vel scelerisque egestas. Praesent odio lacus, porta vitae nisl a, semper tempor elit. Etiam fringilla ut nisl non dictum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus quis eros euismod, elementum tortor ut, sagittis felis. Nulla lectus ante, eleifend non felis pharetra, porta aliquet urna. Curabitur nec elit sit amet tortor accumsan volutpat sed vitae ante. Cras semper consequat nunc, in tincidunt dolor scelerisque eget. Morbi volutpat quis est bibendum aliquet. Sed euismod neque nisl, congue fermentum eros sagittis sit amet. Nulla at tincidunt nibh.";
        $http.get("./process_api.php", {
            params: {
                    action: 'getList',
                    id:    $scope.id
            }
        })
        .then(function(response) {
            $scope.records = response.data.records;
            $scope.id  = response.data.next;
        });
    });

</script>

</body>
</html>