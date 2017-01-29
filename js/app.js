var myapp = angular.module('GoldCastingApp',['ngRoute']); // ,'ui.bootstrap'

myapp.config(function($routeProvider){
	$routeProvider
		.when('/',{
			templateUrl: 'login.html'
		})
		.when('/home',{
			templateUrl: 'home.html'
		})
		.otherwise({
			redirectTo: 'login.html'
		});
});

myapp.controller('MainController', function($scope, $http, $location, $window){
	if(localStorage['token'] === undefined)
	{
		$window.location.href = 'index.html';
	}

	// Logout
	var token = JSON.parse(localStorage['token']);
	$scope.logOutUser = function()
	{
		var data = {
			token: token
		}
		$http.post('action.php?action=Logout', data).success(function(response){
			//console.log(response); return false;
			localStorage.clear();
			 $window.location.href = 'index.html';
			//$location.path('/gold_casting2/login.html');
		}).error(function(error){
			console.log(error);
		});
	}

});

// User controller
myapp.controller('UserController', function($scope, $http, $location, $window){
	$scope.AddUser = function()
	{
		var data = {
			username: $scope.username,
			password: $scope.password,
			user_type: $scope.user_type
		}
		$http.post('action.php?action=AddUser', data).success(function(response){
			//console.log(response); return false;
			if(response != "already")
			{
				$("#msgUserSuccess").show();
				$('#msgUserSuccess').delay(1000).fadeOut('slow');
			}
			else
			{
				$("#msgUserExists").show();
				$('#msgUserExists').delay(1000).fadeOut('slow');
			}
			
		}).error(function(error){
			console.log(error);
		});
	}
});
	

 

