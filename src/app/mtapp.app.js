angular.module ('mtApp.Controllers', []);
angular.module ('mtApp.Repositories', []);

var mtApp = angular.module('mtApp', ['ngRoute', 
								    'mtApp.Controllers',
								    'mtApp.Repositories']);

desculpizatorApp.config( function ($routeProvider) {
	$routeProvider
	.when('/home', {
		title: 'home',
		templateUrl: '../html/home.html',
		controller: 'mtHomeController'
	})		
	.when('/newquestion', {
		title: 'newquestion',
		templateUrl: '../html/question.html',
		controller: 'mtQuestionController'
	})
	.when('/pergunta', {
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
	})
});

	





  



