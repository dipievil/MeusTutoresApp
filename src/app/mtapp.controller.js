/* global angular */
var mtAppControllers = angular.module('mtApp.Controllers',[])
.controller("ctrlMainMenu", function ($scope, $http, getKey, $facebook)
{
	$scope.menuModel = '';
	$scope.genKey = '';
	$scope.mtLogin = false;
    $scope.sessionMtId = null;
    $scope.sessionMtUserId = '0';

    $http.get('../php/helper.facebook.php', {
        params: {
            getSessionData : true
        }
    })
    .success(function (data) {
        if(data!= null){
            console.log(data);
            if(data.sessionMtId != undefined && data.sessionMtId.length > 0){
                $scope.mtLogin = true;
                $scope.sessionMtUserId = data.mtSessionUserId;
            }
        }

        getKey.getData()
            .success(function(data) {
                $scope.genKey = data.GeneratedKey;
                if ($scope.genKey.length > 0){
                    console.log($scope.genKey);
                    console.log($scope.sessionMtId);
                    $http.get('../ws/list_menu.php', {
                        params: {
                            key : $scope.genKey,
                            userid : $scope.sessionMtUserId
                        }
                    })
                        .success(function (data) {
                            $scope.menuModel = data;
                        })
                        .error(function (data, status) {
                            console.log("Falha ao realizar a consulta list_menu :" + status);
                        });
                }
            });
    })
    .error(function (data, status) {
        console.log("Falha ao realizar a consulta FacebookHelper # :" + status);
    });
})
.controller("mtQuestionController", function ($scope, $http, $window, getKey)
{
    $scope.userid = 0;
    $scope.viewerror = false;

    $scope.SendQuestion = function () {
        $http.get('../php/helper.facebook.php', {
            params: {
                getSessionData : true
            }
        })
        .success(function (data) {
            if(data.mtSessionUserId != undefined){
                $scope.userid = data.mtSessionUserId;
                getKey.getData()
                    .success(function(data){
                        $scope.genKey = data.GeneratedKey;
                        if ($scope.genKey.length > 0) {
                            var parameters = $.param(
                                {
                                    'key': $scope.genKey,
                                    'userid': $scope.userid,
                                    'formQuestion': $scope.formQuestion});
                            $http({
                                url: '../ws/send_question.php',
                                method: 'POST',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                data: parameters
                            })
                            .success(function (data) {
                                if (data.message != '') {
                                    $scope.viewerror = true;
                                    $scope.errorMessage = data.message;

                                    if (data.id != undefined && data.id > 0) {
                                        $scope.alertClass = 'alert-success';
                                    } else {
                                        $scope.alertClass = 'alert-danger';
                                    }

                                }
                            })
                            .error(function (data, status) {
                                console.log('Falha ao enviar pergunta #'+status);
                            });
                        }
                    });
            }

        });

    };


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
		};

		if ($scope.genKey.length > 0){

			serviceData.sendValue('show');
				
			$http.get('../ws/list_question.php', {
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
				 .error(function (data, status) {
					console.log("Falha ao realizar a consulta list_question # :" + status);
				 });	
		}
	});
})
.controller("ctrlRegistrar", function ($scope)
{
	$scope.showModal = 'show';
	
})
.controller("ctrlSair", function ($scope)
{
    $http.get('../php/helper.facebook.php', {
        params: {
            logout : 'true'
        }
    })
        .success( function(data){
            $scope.errorMessage = data.message;
        })
        .error(function (data, status) {
            console.log('Falha ao realizar a consulta #'+status);
        });
    window.location.href = url;
})
.controller("ctrlLogin", function ($scope, $facebook)
{
    $scope.showModal = 'show';
    $scope.isLoggedIn = false;
    console.log('go');

    $scope.login = function() {
        $facebook.login().then(function() {
            refresh();
        });
    };

    function refresh() {
        $facebook.api("/me").then(
            function(response) {
                if (response.id != undefined) {
                    console.log(response.id);
                    var faceId = response.id;
                    var faceName = encodeURIComponent(response.name);
                    var faceMail = response.email;
                    var url = '../php/helper.facebook.php?redirect=true&facebookId='+faceId+'&faceName='+faceName+'&faceEmail='+faceMail;

                    window.location.href = url;
                } else {
                    console.log('Not logged');
                }
            },
            function(err) {
                console.log('Not logged');
            });
    };

    refresh();
})
.controller("ctrlModal", function ($scope)
{
	$scope.showModal = 'show';
	
	$scope.$on('receiveValue', function(event, message) {

        var msgSent = null;
        msgSent == message;

        if(msgSent == 'close'){
			$scope.showModal = '';	
		} else {
			$scope.showModal = 'show';
		}
    });
});

	

