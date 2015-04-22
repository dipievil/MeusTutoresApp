angular.module('mtApp.Controllers',[])
	   .controller("mtHomeCtrl", function ($scope, $http)
{
	
	//Paineis dinâmicos
	$scope.panelClass={
		0: "panel-danger",
		1: "panel-success"
	}
	
	$http.get('../php/list_question.php')
	     .success(function (data) {
			$scope.perguntasModel = data;
			$scope.size = $scope.perguntasModel.length;

			/*
			if ($scope.perguntasModel.length > 0) {
				
				// Load the list of Orders, and their Products, that this Customer has ever made.
				$scope.loadOrders();
			}
			*/
		 })
		 .error(function (data, status, headers, config) {
			$scope.errorMessage = "Falha ao realizar a consulta # " + status;
		 });
	
	console.log = $scope.errorMessage;
});	



