var mtApp = angular.module('mtApp',['ngRoute', 'mtApp.Controllers','ngFacebook']);

mtApp.config( function ($routeProvider,$facebookProvider) {

	$facebookProvider
            .setAppId('1416196658700730')
            .setPermissions("email,public_profile")
            .setVersion("v2.2");

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

mtApp.run(
	function( $rootScope ) {
		// Load the facebook SDK asynchronously
		(function(){
			// If we've already installed the SDK, we're done
			if (document.getElementById('facebook-jssdk')) {return;}

			// Get the first script element, which we'll use to find the parent node
			var firstScriptElement = document.getElementsByTagName('script')[0];

			// Create a new script element and set its id
			var facebookJS = document.createElement('script');
			facebookJS.id = 'facebook-jssdk';

			// Set the new script's source to the source of the Facebook JS SDK
			facebookJS.src = '//connect.facebook.net/pt_BR/all.js';

			// Insert the Facebook JS SDK into the DOM
			firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);
		}());
	});
