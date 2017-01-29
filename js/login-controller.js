myapp.controller('LoginController', function($scope, $http, $location, $window){
	// Variables
	$scope.SignUpInfo = {
		username: undefined,
		password: undefined
	}

	// $scope.LoginInfo = {
	// 	username: undefined,
	// 	password: undefined
	// } 

	// Function for SignUp User
	$scope.UserSignUp = function(){
		var data = {
			email: $scope.SignUpInfo.email,
			password: $scope.SignUpInfo.password
		}

		// Insert data into table
		$http.post('action.php?action=SignUpUser', data).success(function(response){
			console.log(response);
			localStorage.setItem("user", JSON.stringify({user: response}));
		}).error(function(error){
			console.error(error);
		});
	}

	// Function for Login User
	$scope.UserLogin = function(){
		var data = {
			username: $scope.username,
			password: $scope.password
		}

		// Insert data into table
		$http.post('action.php?action=LoginUser', data).success(function(response){
			//console.log(response); return false;
			if(response != 'Error')
				$window.location.href = 'gold_casting.html';
			else
				$("#errorLogin").show();
			// if(response == 1)
			// 	$window.location.href = '/gold_casting2/home.html';	
			// else
			// 	$window.location.href = '/gold_casting2/login.html';
			localStorage.setItem("token", JSON.stringify(response));				
		}).error(function(error){
			console.error(error);
		});
	}

});