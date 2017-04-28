<?php
    if (! empty($_GET['id'])) {
        $id = $_GET['id'];
        $first = 1;
    }
?>
<!DOCTYPE html>
<html>
<style>
    label {
        margin-left: 20px;
        font-weight: bold;
    }
    .paddLeft   {
        margin-left:   20px;
    }
    img     {
        width: 100%;
    }
    .mytextbox {
        height: auto !important;
        padding: 0  !important;
    }

</style>
<title>Display News Item</title>

<!-- LOAD BOOTSTRAP CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">

<body>

<div id="container">
    <div class="col-md-6 col-md-offset-3">
        <div>
            <img src="image/header.jpg" />
        </div>
        <div class="page-header">
            <h2><span class="glyphicon glyphicon-tower"></span> &nbsp; Edit News Item</h2>
        </div>

        <div ng-app="myApp" ng-controller="customersCtrl">
            <table>
                <tr>
                    <td><label>Title</label></td>
                    <td><input type="text" name="title" ng-model="title" required ng-minlength="2" ng-maxlength="20" ng-pattern="/^[A-Za-z ]+$/"/><br />
                        <span style="color:red" ng-show="myForm.title.$dirty && myForm.title.$invalid">
                        <span ng-show="myForm.title.$error.required">Title is required.</span>
                        <span ng-show="myForm.title.$error.minlength">Title must be at least 2 characters.</span>
                        <span ng-show="myForm.title.$error.maxlength">Title  must be 20 characters or less.</span>
                        <span ng-show="myForm.title.$error.pattern">Title  must be alphebitic.</span>
                    </span></td>
                </tr>
                <tr>
                    <td><label>Sub-Title</label></td>
                    <td><input type="text" name="subTitle" ng-model="subTitle" required ng-minlength="2" ng-maxlength="20"/>
                        <span style="color:red" ng-show="myForm.subTitle.$dirty && myForm.subTitle.$invalid">
                        <span ng-show="myForm.subTitle.$error.required">subTitle is required.</span>
                        <span ng-show="myForm.subTitle.$error.minlength">subTitle must be at least characters.</span>
                        <span ng-show="myForm.subTitle.$error.maxlength">subTitle  must be 2o characters or less.</span></span>
                    </td>
                </tr>
                <tr>
                    <td><label>Author</label></td>
                    <td><input type="text" name="author" ng-model="author" required />
                        <span style="color:red" ng-show="myForm.author.$dirty && myForm.author.$invalid">
                        <span ng-show="myForm.author.$error.required">Author is required.</span></span>
                    </td>
                </tr>
                <tr>
                    <td><label>Date Published</label></td>
                    <td><input type="text" name="publishDate" ng-model="publishDate"
                               placeholder="yyyy-MM-dd"  required />
                        <span style="color:red" ng-show="myForm.publishDate.$dirty && myForm.publishDate.$invalid">
                        <span ng-show="myForm.publishDate.$error.required">Author is required.</span></span></td>
                </tr>
                <tr>
                    <td valign="top"><label>News Item</label></td>
                    <td><textarea class="col-xs-10 mytextbox" rows="5" name="article" ng-model="article">
                        Enter text here...</textarea>
                        <span style="color:red" ng-show="myForm.article.$dirty && myForm.article.$invalid">
                        <span ng-show="myForm.article.$error.required">The news Item is required </span>
                        </span>
                    </td>
                </tr>

            </table>

            <div style="margin-left: 50px; margin-top: 20px;">
                <button ng-click="check_credentials()" class="btn btn-success" >Submit </button>
                <a href="index.php" class="btn btn-success paddLeft" role="button">Return to News List</a>
            </div>
            <div>
                <span id="message"></span>
            </div>
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
                    method: 'PUT',
                    url: "process_api.php",
                    data: {
                        id: $scope.id,
                        title: $scope.title,
                        subTitle: $scope.subTitle,
                        author: $scope.author,
                        publishDate: $scope.publishDate,
                        article: $scope.article
                    }
                });
            /* Check whether the HTTP Request is successful or not. */
            request.success(function (data) {
                document.getElementById("message").textContent = "Record for '" + $scope.title + "' successfully updated ";
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