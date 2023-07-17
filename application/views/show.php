<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-route.min.js"></script>

</head>

<body ng-app="crudApp" ng-controller="crudController">

    <h1 align="center">Crud Using AngularJS and Codeigniter3</h1>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add Data</button>

    <!-- Add Modal -->
    <div id="addModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form ng-submit="createRecord()">
                        <div class="form-group">
                            <input type="hidden" id="id" ng-model="id">
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" ng-model="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" ng-model="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <h2>Submitted Data</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="record in submittedData">
                <td>{{ record.id }}</td>
                <td>{{ record.name }}</td>
                <td>{{ record.email }}</td>
                <td>
                    <button ng-click="openEditModal(record)">Edit</button>
                    <button ng-click="deleteRecord(record)">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>

<!-- 
    <div id="" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button> -->

<div id="editModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form ng-submit="updateRecord()">
                        <div class="form-group">
                            <input type="hidden" id="id" ng-model="id">
                        </div>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" ng-model="editedName" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" ng-model="editedEmail" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

    <script>
        var app = angular.module('crudApp', []);

        var $config = {
            'base_url': '<?php echo $this->config->item("base_url") ?>'
        }

        app.controller('crudController', ['$scope', '$http', function($scope, $http) {

            $scope.submittedData = [];
            $scope.editedName = '';
            $scope.editedEmail = '';
            $scope.editIndex = -1;

            $scope.createRecord = function() {
                var data = $.param({
                    'name': $scope.name,
                    'email': $scope.email,
                });

                $http({
                    method: 'POST',
                    url: $config.base_url + 'Register/create',
                    data: data,
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                    }
                }).then(function(response) {
                    alert('Data submitted');
                    $scope.name = '';
                    $scope.email = '';
                    $scope.getSubmittedData(); // Retrieve updated data
                    $('#addModal').modal('hide'); // Hide the modal after data submission
                }).catch(function(error) {
                    console.log('Error:', error);
                });
            };

            $scope.getSubmittedData = function() {
                $http({
                    method: 'GET',
                    url: $config.base_url + 'Register/getData',
                }).then(function(response) {
                    $scope.submittedData = response.data;
                }).catch(function(error) {
                    console.log('Error:', error);
                });
            }

            $scope.openEditModal = function(record) {
                $scope.editIndex = $scope.submittedData.indexOf(record);
                $scope.id = record.id;
                $scope.editedName = record.name;
                $scope.editedEmail = record.email;
                $('#editModal').modal('show');
            }

            $scope.updateRecord = function() {
                var editedData = {
                    'id': $scope.id,
                    'name': $scope.editedName,
                    'email': $scope.editedEmail
                };
                var data = $.param(editedData);
                $http({
                    method: 'POST',
                    url: $config.base_url + 'Register/update',
                    data: data,
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                    }
                }).then(function(response) {
                    alert('Record updated');
                    $scope.editedName = '';
                    $scope.editedEmail = '';
                    $scope.editIndex = -1;
                    $('#editModal').modal('hide');
                    $scope.getSubmittedData(); // Retrieve updated data
                }).catch(function(error) {
                    console.log('Error:', error);
                });
            }

            $scope.deleteRecord = function(record) {
                var confirmation = confirm('Are you sure you want to delete this record?');
                if (confirmation) {
                    var data = $.param({
                        'id': record.id
                        // 'name': record.name,
                        // 'email': record.email
                    });
                    $http({
                        method: 'POST',
                        url: $config.base_url + 'Register/delete',
                        data: data,
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                        }
                    }).then(function(response) {
                        alert('Record deleted');
                        $scope.getSubmittedData(); // Retrieve updated data
                    }).catch(function(error) {
                        console.log('Error:', error);
                    });
                }
            }

            // Call the function to retrieve the submitted data on page load
            $scope.getSubmittedData();

        }]);
    </script>

</body>

</html>