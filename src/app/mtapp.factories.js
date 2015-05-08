
angular.module('mtApp')
    .factory('getKey', function($http) {
        return {
            getData: function(data) {

                return $http({
                    url: '../lib/keygen.php',
                    method: "POST",
                    headers: {'Content-Type': 'application/json'}
                }).success(function (data) {
                    return data;
                })
                    .error(function (data, status, headers, config) {
                        console.log('Erro : ' + status + ' ' + headers);
                    });
            }
        }
    })
    .factory('serviceData', function($rootScope) {
        return {
            sendValue: function(msg) {
                $rootScope.$broadcast('receiveValue', msg);
            }
        };
    });
