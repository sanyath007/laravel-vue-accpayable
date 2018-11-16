app.controller('reportCtrl', function($scope, $http, toaster, ModalService, CONFIG) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.debts = []

    $scope.getDebtData = function(URL) {
    	var debtDate = ($("#debtDate").val()).split(",");
    	var sDate = debtDate[0].trim();
    	var eDate = debtDate[1].trim();
    	var debtType = $("#debtType").val();
    	var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;
    	console.log(CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +sDate+ '/' +eDate+ '/' +showAll);
    	$http.get(CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +sDate+ '/' +eDate+ '/' +showAll)
    	.then(function(res) {
    		console.log(res);
    		$scope.debts = res.data;
    	}, function(err) {
    		console.log(err);
    	})
    }
});