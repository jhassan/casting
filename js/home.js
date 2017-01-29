var HomeApp = angular.module('HomeApp', ['ui.bootstrap']);

    HomeApp.filter('startFrom', function () {
        return function (input, start) {
            if (input) {
                start = +start;
                return input.slice(start);
            }
            return [];
        };
    });
    HomeApp.controller('HomeController', ['$scope', '$http', 'filterFilter' ,'$location', '$window', function (scope, http, filterFilter, location, window){
        
        if(localStorage['token'] === undefined)
        {
            window.location.href = '/';
        }

        // Logout
        var token = JSON.parse(localStorage['token']);
        scope.logOutUser = function()
        {
            var data = {
                token: token
            }
            http.post('action.php?action=Logout', data).success(function(response){
                //console.log(response); return false;
                localStorage.clear();
                 window.location.href = '/';
                //$location.path('/gold_casting2/login.html');
            }).error(function(error){
                console.log(error);
            });
        }

        scope.search = '';

        scope.resetFilters = function () {
            // needs to be a function or it won't trigger a $watch
            scope.search = {};
        };
        http.get("action.php?action=GetAllDebitCreditClients")
            .then(function (response) {
                //console.log(response); return false;
                scope.clients = response.data.records;
                // pagination controls
                scope.currentPage = 1;
                scope.totalItems = scope.clients.length;
                scope.entryLimit = 10; // items per page
                scope.noOfPages = Math.ceil(scope.totalItems / scope.entryLimit);

                // $watch search to update pagination
                scope.$watch('search', function (newVal, oldVal) {
                    scope.filtered = filterFilter(scope.clients, newVal);
                    scope.totalItems = scope.filtered.length;
                    scope.noOfPages = Math.ceil(scope.totalItems / scope.entryLimit);
                    scope.currentPage = 1;
                }, true);
            });
            scope.set_color = function (main_value, total) {
                  if (main_value == 'F' && (total != "0.000" || total != "0")) {
                    return { 'backgroundColor': "#d9534f", 'color': '#fff', 'font-weight': 'bold',
                                'font-size': '16px' } // red
                  }
                  else if(main_value == 'T' && (total != "0.000"  || total != "0"))
                  {
                    return { 'backgroundColor': "#5cb85c", 'color': '#fff', 'font-weight': 'bold',
                                'font-size': '16px' } // green
                  }
                };
      }]);