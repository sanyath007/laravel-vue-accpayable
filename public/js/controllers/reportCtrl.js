app.controller('reportCtrl', function($scope, $http, toaster, ModalService, CONFIG) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.debts = []

    $scope.getDebtPerType = function() {
    	console.log($("#debtType").val());
    	console.log($("#debtDate").val());
    	console.log($("#showall").val());

    	var debtType = $("#debtType").val();
    	var debtDate = $("#debtDate").val();
    	var showAll = $("#showall").val();

    	$http.get(CONFIG.BASE_URL + '/debt-debttype/rpt/' +debtType+ '/2018-11-01/2018-11-16/' +showAll)
    	.then(function(res) {
    		console.log(res);
    		$scope.debts = res.data;
    	}, function(err) {
    		console.log(err);
    	})
    }
});