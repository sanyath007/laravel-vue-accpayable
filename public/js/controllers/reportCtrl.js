app.controller('reportCtrl', function(CONFIG, $scope, $http, toaster, PaginateService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.debts = [];
    $scope.pager = [];
    $scope.pages = [];
    $scope.loading = false;

    $scope.getDebtData = function(URL) {
        $scope.debts = [];
        $scope.pager = [];
        $scope.loading = true;
        
        var debtDate = ($("#debtDate").val()).split(",");
        var sDate = debtDate[0].trim();
        var eDate = debtDate[1].trim();
        var debtType = ($("#debtType").val() != '') ? $("#debtType").val() : 0;
        var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;

        $http.get(CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +sDate+ '/' +eDate+ '/' +showAll)
        .then(function(res) {
            console.log(res);
            $scope.debts = res.data.pager.data;
            $scope.pager = res.data.pager;

            $scope.pages = PaginateService.createPagerNo($scope.pager);

            console.log($scope.pages);
            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        })
    }

    $scope.getDataWithURL = function(URL) {
        console.log(URL);
        $scope.debts = [];
        $scope.pager = [];
        $scope.loading = true;

        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.debts = res.data.pager.data;
            $scope.pager = res.data.pager;

            $scope.pages = PaginateService.createPagerNo($scope.pager);

            console.log($scope.pages);
            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    };

    $scope.debtCreditorToExcel = function(URL) {
        console.log($scope.debts);

        if($scope.debts.length == 0) {
            toaster.pop('warning', "", "ไม่พบข้อมูล !!!");
        } else {
            var debtDate = ($("#debtDate").val()).split(",");
            var sDate = debtDate[0].trim();
            var eDate = debtDate[1].trim();
            var creditor = ($("#debtType").val() == '') ? '0' : $("#debtType").val();
            var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;

            window.location.href = CONFIG.BASE_URL +URL+ '/' +creditor+ '/' +sDate+ '/' +eDate+ '/' + showAll;
        }
    };

    $scope.debttypeToExcel = function(URL) {
        console.log($scope.debts);

        if($scope.debts.length == 0) {
            toaster.pop('warning', "", "ไม่พบข้อมูล !!!");
        } else {
            var debtDate = ($("#debtDate").val()).split(",");
            var sDate = debtDate[0].trim();
            var eDate = debtDate[1].trim();
            var debtType = ($("#debtType").val() == '') ? '0' : $("#debtType").val();
            var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;
            
            window.location.href = CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +sDate+ '/' +eDate+ '/' + showAll;
        }
    };
});