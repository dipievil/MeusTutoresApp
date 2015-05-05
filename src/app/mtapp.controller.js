/* global angular */
angular.module('mtApp.Controllers',[])
	   .controller("ctrlMainMenu", function ($scope, $http, getKey)
{
	$scope.menuModel = '';
	$scope.genKey = '';
	
	getKey.getData()
	.success(function(data){
		$scope.genKey = data.GeneratedKey;
			
		if ($scope.genKey.length > 0){
	
			$http.get('../php/list_menu.php', {
					params: {
						key : $scope.genKey
					}
				 })
				 .success(function (data) {
					$scope.menuModel = data;
				 })
				 .error(function (data, status) {
					console.log("Falha ao realizar a consulta # :" + status);
				 });
		}
	});	
})
	   .controller("mtQuestionController", function ($scope, $http, $window, getKey)
{
	getKey.getData()
	.success(function(data){
		$scope.genKey = data.GeneratedKey;
			
		if ($scope.genKey.length > 0){
			
			$scope.viewerror = false;
			$scope.SendQuestion = function() {
			
				var parameters = $.param({'key': $scope.genKey,'formQuestion': $scope.formQuestion});
				$http({
					url: '../ws/send_question.php',
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
					data: parameters
				})
				.success(function(data) {
					if (data.message != '')
					{
						$scope.viewerror = true;
						$scope.errorMessage = data.message;
						
						if(data.id != undefined && data.id > 0){
							$scope.alertClass = 'alert-success';
							console.log($scope.alertClass);
						} else {
							$scope.alertClass='alert-danger';
						}
							
					}
					
				}).error(function(data, status) { 
					$scope.errorMessage = status;
					console.log(data.error);
					$scope.viewerror = true;
				});
			}
		}
	});
})
	   .controller("mtHomeCtrl", function ($scope, $http, getKey, serviceData)
{
	$scope.genKey = '';	

	
	getKey.getData()
	.success(function(data){
		$scope.genKey = data.GeneratedKey;
					
		//Paineis dinâmicos
		$scope.panelClass={
			0: "panel-danger",
			1: "panel-success"
		}
		if ($scope.genKey.length > 0){

			serviceData.sendValue('show');
				
			$http.get('../php/list_	question.php', {
					params: {
						key : $scope.genKey
					}
				 })
				 .success(function (data) {
					 if(data.error != undefined)
						 console.log(data.erro);
					$scope.perguntasModel = data;
					
					//Desativa o modal
						
					serviceData.sendValue('close');
				 })
				 .error(function (data, status, headers, config) {
					console.log("Falha ao realizar a consulta # :" + status);
				 });	
		}
	});
})
	   .controller("ctrlRegistrar", function ($scope)
{
	$scope.showModal = 'show';
	
})
	   .controller("ctrlModal", function ($scope)
{
	$scope.showModal = 'show';
	
	$scope.$on('receiveValue', function(event, message) {

        if(message = 'close'){
			$scope.showModal = '';	
		} else {
			$scope.showModal = 'show';
		}
    });
});

	

