var TodaySaleApp = angular.module('TodaySaleApp', ['ui.bootstrap']);

    TodaySaleApp.filter('startFrom', function () {
        return function (input, start) {
            if (input) {
                start = +start;
                return input.slice(start);
            }
            return [];
        };
    });
    TodaySaleApp.controller('TodaySaleController', ['$scope', '$http', 'filterFilter' ,'$location', '$window', function (scope, http, filterFilter, location, window){
        if(localStorage['token'] === undefined)
        {
            window.location.href = '/login.html';
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
                 window.location.href = '/login.html';
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
        http.get("action.php?action=TodayReport")
            .then(function (response) {
                //console.log(response); return false;
                scope.today_sale = response.data.records;
                // pagination controls
                scope.currentPage = 1;
                scope.totalItems = scope.today_sale.length;
                scope.entryLimit = 10; // items per page
                scope.noOfPages = Math.ceil(scope.totalItems / scope.entryLimit);

                // $watch search to update pagination
                scope.$watch('search', function (newVal, oldVal) {
                    scope.filtered = filterFilter(scope.today_sale, newVal);
                    scope.totalItems = scope.filtered.length;
                    scope.noOfPages = Math.ceil(scope.totalItems / scope.entryLimit);
                    scope.currentPage = 1;
                }, true);
            });
      }]);