app.controller('debtCtrl', function($scope, $http, toaster, CONFIG) {
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
        var debtType = $("#debtType").val();
        var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;


    	$http.get(CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +sDate+ '/' +eDate+ '/1')
    	.then(function(res) {
    		console.log(res);
            $scope.debts = res.data.debts.data;
    		$scope.totalDebt = res.data.totalDebt;

            $scope.loading = false;
    	}, function(err) {
    		console.log(err);
            $scope.loading = false;
    	})
    }

    $scope.addNewDebt = function(event) {
        console.log(event);
        event.preventDefault();

        var creditor = $("#debtType").val();
        console.log(creditor);

        if(creditor === '') {
            console.log("You doesn't select creditor !!!");
            toaster.pop('warning', "", "คุณยังไม่ได้เลือกเจ้าหนี้ !!!");
        } else {
            console.log(CONFIG.BASE_URL + '/debt/add/' + creditor);
            window.location.href = CONFIG.BASE_URL + '/debt/add/' + creditor;
        }
    }
});