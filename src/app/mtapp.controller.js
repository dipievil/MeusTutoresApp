/* global angular */
var mtAppControllers = angular.module('mtApp.Controllers',[])
.controller("ctrlMainMenu", function ($scope, $http, getKey, $facebook)
{
	$scope.menuModel = '';
	$scope.menuKey = '';
	$scope.menuLogin = false;
    $scope.menuMtId = null;
    $scope.menuMtUserId = '0';

    $http.get('../php/helper.facebook.php', {
        params: {
            getSessionData : true
        }
    })
    .success(function (dataSession) {
        if(dataSession!= null){
            if(dataSession.sessionMtId != undefined && dataSession.sessionMtId.length > 0){
                $scope.menuLogin = true;
                $scope.menuMtUserId = dataSession.mtSessionUserId;
            }
        }

        getKey.getData()
            .success(function(dataKey) {
                $scope.menuKey = dataKey.GeneratedKey;
                if ($scope.menuKey.length > 0){
                    console.log('userid: '+$scope.sessionMtUserId + ' & key: '+ $scope.menuKey);
                    $http.get('../ws/list_menu.php', {
                        params: {
                            key : $scope.menuKey,
                            userid : $scope.menuMtUserId
                        }
                    })
                        .success(function (dataMenu) {
                            $scope.menuModel = dataMenu;
                        })
                        .error(function (dataMenu, statusMenu) {
                            console.log("Falha ao realizar a consulta list_menu :" + statusMenu);
                        });
                }
            });
    })
    .error(function (dataSession, status) {
        console.log("Falha ao realizar a consulta FacebookHelper # :" + status);
    });
})
.controller("mtQuestionController", function ($scope, $http, $window, getKey)
{
    $scope.questionUserid = 0;
    $scope.questionKey = 0;
    $scope.viewerror = false;

    $scope.SendQuestion = function () {
        $http.get('../php/helper.facebook.php', {
            params: {
                getSessionData : true
            }
        })
        .success(function (dataSession) {
            if(dataSession.mtSessionUserId != undefined){
                $scope.questionUserid = dataSession.mtSessionUserId;
                getKey.getData()
                    .success(function(dataKey){
                        $scope.questionKey = dataKey.GeneratedKey;
                        if ($scope.questionKey.length > 0) {
                            var parameters = $.param(
                                {
                                    'key': $scope.questionKey,
                                    'userid': $scope.questionUserid,
                                    'formQuestion': $scope.formQuestion});
                            $http({
                                url: '../ws/send_question.php',
                                method: 'POST',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                data: parameters
                            })
                            .success(function (dataQuestion) {
                                if (dataQuestion.message != '') {
                                    $scope.viewerror = true;
                                    $scope.errorMessage = dataQuestion.message;

                                    if (dataQuestion.id != undefined && dataQuestion.id > 0) {
                                        $scope.alertClass = 'alert-success';
                                    } else {
                                        $scope.alertClass = 'alert-danger';
                                    }

                                }
                            })
                            .error(function (dataQuestion, statusQuestion) {
                                console.log('Falha ao enviar pergunta #' + statusQuestion);
                                var url = '../html/index.html#/pergunta';
                                window.location.href = url;
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
	.success(function(dataKey){
		$scope.genKey = dataKey.GeneratedKey;
					
		//Paineis dinâmicos
		$scope.panelClass={
			0: "panel-danger",
			1: "panel-success"
		};

        $scope.btnResposta = {
            0: "",
            1: "hidden"
        };

		if ($scope.genKey.length > 0){

			serviceData.sendValue('show');
				
			$http.get('../ws/list_question.php', {
					params: {
						key : $scope.genKey
					}
				 })
				 .success(function (dataListQuestion) {
					 if(dataListQuestion.error != undefined)
						 console.log(dataListQuestion.erro);
					$scope.perguntasModel = dataListQuestion;
					
					//Desativa o modal
					serviceData.sendValue('close');
				 })
				 .error(function (dataListQuestion, dataStatus) {
					console.log("Falha ao realizar a consulta list_question # :" + dataStatus);
                    var url = '../html/index.html#/home';
                    document.location.href = url;
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
            var url = '../html/index.html#/home';
            window.location.href = url;
            console.log(url);
        })
        .error(function (data, status) {
            console.log('Falha ao realizar a consulta #'+status);
        });

})
.controller("ctrlLogin", function ($scope, $facebook)
{
    $scope.showModal = 'show';
    $scope.isLoggedIn = false;

    $scope.login = function() {
        $facebook.login().then(function() {
            refresh();
        });
    };

    function refresh() {
        $facebook.api("/me").then(
            function(response) {
                if (response.id != undefined) {
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
    .controller("ctrlPerfil", function($scope){
        console.log($scope.userId);
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

	

