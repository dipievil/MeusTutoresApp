var mtApp = angular.module('mtApp',['ngRoute',
									'mtApp.Controllers']);

//angular.module ('mtApp.Controllers', []);
//angular.module ('mtApp.Repositories', []);

mtApp.config( function ($routeProvider) {
	$routeProvider.
		when('/home', {
			title: 'home',
			templateUrl: '../html/home.html'
		})
		.when('/pergunta', {
			title: 'newquestion',
			templateUrl: '../html/question.html',
			controller: 'mtQuestionController'
		})
		.when('/resposta', {
			title: 'answer',
			templateUrl: '../html/answer.html',
			controller: 'mtQuestionController'
		})
		.when('/perfil', {
			title: 'perfil',
			templateUrl: '../html/perfil.html',
			controller: 'mtQuestionController'
		})
		.when('/sair', {
			title: 'sair',
			templateUrl: '../html/sair.html',
			controller: 'sairController'
		})
		.when('/login', {
			title: 'entrar',
			templateUrl: '../html/login.html',
			controller: 'entrarController'
		})		
		.otherwise({
			redirectTo: '/home'
		});
});

angular.module('mtApp').factory('getKey', function($http) {
    return {
        getData: function(data) {
			var key='';
			return $http({
				url: '../php/key_gen.php',
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
});
