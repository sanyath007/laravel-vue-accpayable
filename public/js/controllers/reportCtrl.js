app.controller('reportCtrl', function($scope, $http, toaster, CONFIG) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.debts = [];
    $scope.loading = false;

    $scope.getDebtData = function(URL) {
        $scope.debts = [];
        $scope.loading = true;
        
        var debtDate = ($("#debtDate").val()).split(",");
        var sDate = debtDate[0].trim();
        var eDate = debtDate[1].trim();
        var debtType = $("#debtType").val();
        var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;


    	$http.get(CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +sDate+ '/' +eDate+ '/' +showAll)
    	.then(function(res) {
    		console.log(res);
    		$scope.debts = res.data;
            $scope.loading = false;
    	}, function(err) {
    		console.log(err);
            $scope.loading = false;
    	})
    }
});