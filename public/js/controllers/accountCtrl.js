app.controller('accountCtrl', function(CONFIG, $scope, $http, toaster, ModalService, StringFormatService, PaginateService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.creditors = [];
    $scope.payments = [];
    $scope.pager = [];
    $scope.pages = [];
    $scope.totalDebt = 0.00;
    $scope.loading = false;

    $scope.getArrearData = function(URL) {
        $scope.debts = [];
        $scope.pager = [];
        
        if($("#showall:checked").val() != 'on' && ($("#debtType").val() == '' && $("#creditor").val() == '')) {
            toaster.pop('warning', "", "กรุณาเลือกเจ้าหนี้หรือประเภทหนี้ก่อน !!!");
        } else {
            $scope.loading = true;

            var debtDate = ($("#debtDate").val()).split(",");
            var sDate = debtDate[0].trim();
            var eDate = debtDate[1].trim();
            var debtType = ($("#debtType").val() == '') ? '0' : $("#debtType").val();
            var creditor = ($("#creditor").val() == '') ? '0' : $("#creditor").val();
            var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;
            
            $http.get(CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +creditor+ '/' +sDate+ '/' +eDate+ '/' + showAll)
            .then(function(res) {
                console.log(res);
                $scope.debts = res.data.debts.data;
                $scope.pager = res.data.debts;
                $scope.totalDebt = res.data.totalDebt;

                $scope.pages = PaginateService.createPagerNo($scope.pager);

                console.log($scope.pages);
                $scope.loading = false;
            }, function(err) {
                console.log(err);
                $scope.loading = false;
            });
        }
    };

    $scope.getArrearWithURL = function(URL) {
        $scope.debts = [];
        $scope.pager = [];
        $scope.loading = true;
            
        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.debts = res.data.debts.data;
            $scope.pager = res.data.debts;
            $scope.totalDebt = res.data.totalDebt;

            $scope.pages = PaginateService.createPagerNo($scope.pager);

            console.log($scope.pages);
            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    };

    $scope.arrearToExcel = function(URL) {
        console.log($scope.debts);

        if($scope.debts.length == 0) {
            toaster.pop('warning', "", "ไม่พบข้อมูล !!!");
        } else {
            var debtDate = ($("#debtDate").val()).split(",");
            var sDate = debtDate[0].trim();
            var eDate = debtDate[1].trim();
            var debtType = ($("#debtType").val() == '') ? '0' : $("#debtType").val();
            var creditor = ($("#creditor").val() == '') ? '0' : $("#creditor").val();
            var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;

            window.location.href = CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +creditor+ '/' +sDate+ '/' +eDate+ '/' + showAll;
        }
    };

    $scope.getCreditorPaidData = function(URL) {
        $scope.payments = [];
        $scope.pager = [];
        
        if($("#showall:checked").val() != 'on' && $("#creditor").val() == '') {
            toaster.pop('warning', "", "กรุณาเลือกเจ้าหนี้ก่อน !!!");
        } else {
            $scope.loading = true;

            var debtDate = ($("#debtDate").val()).split(",");
            var sDate = debtDate[0].trim();
            var eDate = debtDate[1].trim();
            var creditor = ($("#creditor").val() == '') ? '0' : $("#creditor").val();
            var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;
            
            $http.get(CONFIG.BASE_URL +URL+ '/' +creditor+ '/' +sDate+ '/' +eDate+ '/' + showAll)
            .then(function(res) {
                console.log(res);
                $scope.payments = res.data.payments.data;
                $scope.pager = res.data.payments;
                $scope.totalDebt = res.data.totalDebt;

                $scope.pages = PaginateService.createPagerNo($scope.pager);

                console.log($scope.pages);
                $scope.loading = false;
            }, function(err) {
                console.log(err);
                $scope.loading = false;
            });
        }
    };

    $scope.getCreditorPaidWithURL = function(URL) {
        $scope.payments = [];
        $scope.pager = [];

        $scope.loading = true;
            
        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.payments = res.data.payments.data;
            $scope.pager = res.data.payments;
            $scope.totalDebt = res.data.totalDebt;

            $scope.pages = PaginateService.createPagerNo($scope.pager);

            console.log($scope.pages);
            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    };

    $scope.creditorPaidToExcel = function(URL) {
        console.log($scope.payments);

        if($scope.payments.length == 0) {
            toaster.pop('warning', "", "ไม่พบข้อมูล !!!");
        } else {
            var debtDate = ($("#debtDate").val()).split(",");
            var sDate = debtDate[0].trim();
            var eDate = debtDate[1].trim();
            var creditor = ($("#creditor").val() == '') ? '0' : $("#creditor").val();
            var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;

            window.location.href = CONFIG.BASE_URL +URL+ '/' +creditor+ '/' +sDate+ '/' +eDate+ '/' + showAll;
        }
    };

    $scope.getLedgerData = function(event, URL) {
        event.preventDefault();        
        $scope.loading = true;

        var sDate = StringFormatService.convToDbDate($("#sdate").val());
        var eDate = StringFormatService.convToDbDate($("#edate").val());
        var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;
        
        $scope.loading = false;
        console.log(URL);
        $("#frmSearch").attr('action', CONFIG.BASE_URL +URL+ '/' +sDate+ '/' +eDate+ '/' + showAll);
        $("#frmSearch").submit();
    };

    $scope.ledgerToExcel = function(URL) {
        var sDate = StringFormatService.convToDbDate($("#sdate").val());
        var eDate = StringFormatService.convToDbDate($("#edate").val());
        var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;

        window.location.href = CONFIG.BASE_URL +URL+ '/' +sDate+ '/' +eDate+ '/' + showAll;
    };
});