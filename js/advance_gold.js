// Advance Controller
myapp.controller('AdvanceController', function($scope, $http, $window, $timeout) {
    $scope.myVar = false;
    $scope.toggle = function() {
        $scope.myVar = !$scope.myVar;
        $scope.div_all_clients = !$scope.div_all_clients;
        
    };

    // Add Advanve 
    $scope.AddAdvance = function()
	{
		var data = {
			new_client: 	$scope.new_client,
			client_name: 	$scope.client_name,
			shop_name: 		$scope.shop_name,
			phone: 			$scope.phone,
			all_client: 	$scope.all_client,
			advance_gold: 	$scope.advance_gold,
			debit_gold: 	$scope.debit_gold,
			labour_fee_credit: $scope.labour_fee_credit
		}
		$http.post('action.php?action=AddAdvance', data).success(function(response){
			//console.log(response); return false;
			if (response != 0) {
				$("#msgAdvanceGoldSuccess").show();
				//$('#msgAdvanceGoldSuccess').delay(3000).fadeOut('slow');
				$('#AdvanceGoldForm')[0].reset();
				//refresh();
				//alert('adfasd'); return false;
				$window.location.href = 'advance.html';
				//$scope.myForm.$setPristine();
				// Since Angular 1.3, set back to untouched state.
				//$scope.myForm.$setUntouched();
			} else { $("#msgAdvanceGoldSuccess").hide(); }
		}).error(function(error){
			console.log(error);
		});
	}

	// Load all client in advance gold
	$http.get('action.php?action=GetAllClients').success(function(response){
		console.log(response); return false;
		$scope.clients = response;
	}).error(function(error){
		console.log(error);
	});

	function refresh() {
        $timeout(function() {
            $scope.success = false;
            $scope.error = false;
            $scope.message = '';
        }, 5000);
    }

});