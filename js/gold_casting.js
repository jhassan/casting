myapp.controller('GoldCastingController', function($scope, $http, $window) {
	// Load all client in advance gold
	$http.get('action.php?action=GetAllClients').success(function(response){
		//console.log(response); return false;
		$scope.clients = response;
	}).error(function(error){
		console.log(error);
	});

	// Get Advance Gold 
	$scope.countryName = '';
	$scope.GetAdvanceGold = function() {
	  $scope.client_id = $("#all_client option:selected").val();
	  var data = {
			client_id: 	$scope.client_id
		}
		$http.post('action.php?action=GetAdvanceGold', data).success(function(response){
			//$scope.td_advance_gold = response; 
			$("#client_full_name").html($("#all_client option:selected").html());
			//$("#td_advance_gold").html(response); 
			$scope.td_advance_gold = response;
			console.log(response); return false;
			
		}).error(function(error){
			console.log(error);
		});
	};

	// Get Caret
	$scope.GoldCaret = function(id){
		var data = {
			casting_gold_weight: 	$scope.casting_gold,
			caret_type: 			id,
			all_client: 			$scope.all_client,
			caret_cb: 				$scope.caret_cb,
			katpay: 				$scope.katpay,
			mb_entry: 				$scope.mb_entry	
		}
		$http.post('action.php?action=CalculateGoldCastig', data).success(function(response){
			 //console.log(response['total_gold']); return false;
			//console.log(response['total_gold']); return false;
			$scope.td_total_gold = response['total_gold'];
			/*if(response['total_gold'].indexOf("-") >= 0)
			{
				//console.log('found');
				//console.log(response['total_gold']);
				//$("#td_total_gold").css({'backgroundColor': '#d9534f', 'color': '#000', 'font-weight': 'bold'});
				$scope.td_total_gold = response['total_gold'];//.replace("","-");
				$scope.total_gold_css = {
				    'backgroundColor': "#d9534f",
				    'color': '#000', 
				    'font-weight': 'bold'
				};
			}
			else
			{
				console.log('no found');
				$scope.td_total_gold = response['total_gold'];//.replace("","-");
				$scope.total_gold_css = {
				    'backgroundColor': "#5cb85c",
				    'color': '#000', 
				    'font-weight': 'bold'
				};
				//$("#td_total_gold").css({'backgroundColor': '#5cb85c', 'color': '#000', 'font-weight': 'bold'});
			}*/
			$scope.entityId = response;
			$scope.all_data = response;
			
		}).error(function(error){
			console.log(error);
		});
	};
	// Add Gold Casting 
    $scope.AddGoldCasting = function()
	{
		var data = {
			all_client: 	$scope.all_client,
			entityId: 		$scope.entityId,
			get_pure_gold: 	$scope.get_pure_gold,
			pay_or_gold: 	$scope.pay_or_gold,
			current_gold_rate: $scope.current_gold_rate,
			labour_fee_credit: $scope.labour_fee_credit
		}
		$http.post('action.php?action=AddGoldCasting', data).success(function(response){
			//console.log(response); return false;
			$window.location.href = 'gold_casting.html';
			//console.log(response); return false;
			
		}).error(function(error){
			console.log(error);
		});
	}

	// Calculate Gold
	$scope.CalculateGold = function(){
		//console.log($scope.total_gold);
		if($scope.total_gold < 0)
			$scope.remaining_gold = parseFloat($scope.get_pure_gold) + parseFloat($scope.total_gold);
		else
			$scope.remaining_gold = parseFloat($scope.get_pure_gold) - parseFloat($scope.total_gold);
			$scope.remaining_gold = (isNaN($scope.remaining_gold)) ? '' : $scope.remaining_gold.toFixed( 3 );
			
		if($scope.get_pure_gold != null && $scope.get_pure_gold > $scope.total_gold)
		{
			var get_remaining_gold = $("#get_remaining_gold").html();	
			if(get_remaining_gold.indexOf("-") >= 0)
			{
				$scope.total_gold_css = {
				    'backgroundColor': "#d9534f", // red
				    'color': '#000', 
				    'font-weight': 'bold'
				};
			}
			else
			{
				$scope.total_gold_css = {
				    'backgroundColor': "#5cb85c", // green
				    'color': '#000', 
				    'font-weight': 'bold'
				};
				//console.log(get_remaining_gold);
				//$scope.total_gold = $scope.remaining_gold;
			}
		}
		else if($scope.get_pure_gold == null || $scope.get_pure_gold < $scope.total_gold) 
		{
			$scope.total_gold_css = {
				    'backgroundColor': "#d9534f", // red
				    'color': '#000', 
				    'font-weight': 'bold'
				};
			//$scope.total_gold = $scope.total_gold;
		}
	}
	// Pay Laboure fee or gold
	$scope.PayOrGold = function(str){
		$scope.current_gold_rate = $scope.current_gold_rate;
		$scope.pay_or_gold = false;
		var labour_gold = "";
		var labour_fee = $("#td_labore_fee").html();
		if (str == "G") {
			$scope.pay_or_gold = true;
			var data = {
			current_gold_rate: 	$scope.current_gold_rate,
			labour_fee: 		labour_fee
			}
			$http.post('action.php?action=CalculateLabourGold', data).success(function(response){
				var td_total_gold = $("#td_total_gold").html();
				td_total_gold = td_total_gold.replace("-", "");
				td_total_gold = td_total_gold.replace(",", "");
				//console.log(td_total_gold+"*****"+response);
				if(td_total_gold != "" && td_total_gold != null)
				{
					$scope.grand_total_gold = (parseFloat(response) + parseFloat(td_total_gold)).toFixed(3);
					$scope.total_laboure_fee_gold = response;	
				}
				//console.log(response); return false;
			}).error(function(error){
				console.log(error);
			});
		}
		else
		{
			$scope.pay_or_gold = false;
		}
		//console.log(labour_gold.toFixed(3));
	}

});	// End gold casting