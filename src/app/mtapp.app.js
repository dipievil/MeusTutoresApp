var mtApp = angular.module('mtApp',['ngRoute', 'mtApp.Controllers']);

//angular.module ('mtApp.Controllers', []);
//angular.module ('mtApp.Repositories', []);

mtApp.config( function ($routeProvider) {
	$routeProvider.
		when('/home', {
			title: 'home',
			templateUrl: '../html/home.html'
		})
		.when('/pergunta', {
			title: 'pergunta',
			templateUrl: '../html/question.html'
		})
		.when('/resposta', {
			title: 'answer',
			templateUrl: '../html/answer.html'
		})
		.when('/perfil', {
			title: 'perfil',
			templateUrl: '../html/perfil.html'
		})
		.when('/sair', {
			title: 'sair',
			templateUrl: '../html/sair.html'
		})
		.when('/login', {
			title: 'entrar',
			templateUrl: '../html/login.html'
		})	
		.when('/signup', {
			title: 'registrar',
			templateUrl: '../html/signup.html'
		})	
		.otherwise({
			redirectTo: '/home'
		});
});

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
