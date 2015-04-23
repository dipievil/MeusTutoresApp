angular.module('mtApp.Controllers',[])
	   .controller("mtHomeCtrl", function ($scope, $http, getKey)
{
	$scope.genKey = '';	
	
	//Paineis dinâmicos
	$scope.panelClass={
		0: "panel-danger",
		1: "panel-success"
	}
	
	getKey.getData()
	.success(function(data){
		$scope.genKey = data.GeneratedKey;
			
		if ($scope.genKey.length > 0){
				
			$http.get('../php/list_	question.php', {
					params: {
						key : $scope.genKey
					}
				 })
				 .success(function (data) {
					$scope.perguntasModel = data;
					$scope.size = $scope.perguntasModel.length;
				 })
				 .error(function (data, status, headers, config) {
					console.log("Falha ao realizar a consulta # :" + status);
				 });	
		}
	});

});	



