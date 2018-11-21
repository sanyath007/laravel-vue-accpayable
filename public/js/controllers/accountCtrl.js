app.controller('accountCtrl', function($scope, $http, toaster, CONFIG, ModalService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.debts = [];
    $scope.totalDebt = 0.00;
    $scope.loading = false;

    $scope.getDebtData = function(URL) {
        $scope.debts = [];
        $scope.loading = true;
        
        var debtDate = ($("#debtDate").val()).split(",");
        var sDate = debtDate[0].trim();
        var eDate = debtDate[1].trim();
        var debtType = ($("#debtType").val() == '') ? '0' : $("#debtType").val();
        var creditor = ($("#creditor").val() == '') ? '0' : $("#creditor").val();
        var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;
        console.log(CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +creditor+ '/' +sDate+ '/' +eDate+ '/' + showAll);
        
    	$http.get(CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +creditor+ '/' +sDate+ '/' +eDate+ '/' + showAll)
    	.then(function(res) {
    		console.log(res);
            $scope.debts = res.data.debts.data;
    		$scope.totalDebt = res.data.totalDebt;

            $scope.loading = false;
    	}, function(err) {
    		console.log(err);
            $scope.loading = false;
    	});
    }
});