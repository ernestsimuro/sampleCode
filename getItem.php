<?php
    if (! empty($_GET['id'])) {
        $id = $_GET['id'];
    }
    $first=1;
?>
<!DOCTYPE html>
<html >
<style>
    label {
        margin-left: 20px;
        font-weight: bold;
    }
    .paddLeft   {
        margin-left:   20px;
    }
    img     {
        width: 80%;
    }

</style>
<title>Display News Item</title>

<!-- LOAD BOOTSTRAP CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">

<body>

    <div ng-app="myApp" ng-controller="customersCtrl">

        <div class="col-md-6 col-md-offset-3">
            <div>
                <img src="image/header.jpg" />
            </div>

            <div class="page-header">
                <h1><span class="glyphicon glyphicon-tower"></span> Requested News Item</h1>
            </div>

            <!-- SHOW ERROR/SUCCESS MESSAGES -->
             <table>
                <tr>
                    <td><label>Title</label></td>
                    <td><span class="paddLeft"> {{title}} </span></td>
                </tr>
                <tr>
                    <td><label>sub-header</label></td>
                    <td><span class="paddLeft"> {{subTitle}} </span></td>
                </tr>
                <tr>
                    <td><label>Author</label></td>
                    <td><span class="paddLeft"> {{author}} </span></td>
                </tr>
                <tr>
                    <td><label>Date Published</label></td>
                    <td><span class="paddLeft">{{publishDate}} </span></td>
                </tr>
                <tr>
                    <td valign="top"><label>News Item</label></td>
                    <td><p class="paddLeft" ng-text-truncate="article"
                           ng-tt-chars-threshold="40"
                           ng-tt-more-label="Read More"
                           ng-tt-less-label="Read Less">
                        </p>
                    </td>
                </tr>

            </table>

            <div style="margin-left: 50px; margin-top: 20px;">
                <a href="editItem.php?id={{id}}" class="btn btn-success" role="button">Edit News Items</a>
                <button ng-click="check_credentials()" class="btn btn-success" >Delete Item </button>
                <a href="index.php" class="btn btn-success" role="button">Return to News List</a>
            </div>
            <div>
                <span id="message"></span>
            </div>
        </div>

    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-resource.js"></script>
    <script src="ng-text-truncate.js"></script><script></script>
    <script>

        var app = angular.module('myApp', ["ngTextTruncate"]);
        app.controller('customersCtrl', function($scope, $http) {

            <?php   if ($first == 1) {
                        $first = '';
            ?>
            $scope.id = "<?php echo $id ?>";
            $http.get("./process_api.php", {
                params: {
                    action: 'getItem',
                    id:    $scope.id
                }
            })
                .then(function(response) {
                    $scope.title = response.data.records.title;
                    $scope.subTitle = response.data.records.subTitle;
                    $scope.author = response.data.records.author;
                    $scope.publishDate = response.data.records.publishDate;
                    $scope.article = response.data.records.article;
                });

            <?php   } ?>
            $scope.check_credentials = function () {
                document.getElementById("message").textContent = "";
                var request = $http({
                    method: 'DELETE',
                    url: "process_api.php",
                    data: {
                        id: $scope.id
                    }
                });
                /* Check whether the HTTP Request is successful or not. */
                request.success(function (data) {
                    document.getElementById("message").textContent = "Record for '" + $scope.title + "' successfully added ";
                    $scope.title = '';
                    $scope.subTitle = '';
                    $scope.author = '';
                    $scope.publishDate = '';
                    $scope.article = '';
                });
            }
        });
    </script>

</body>
</html>
