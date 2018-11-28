app.controller('debtCtrl', function($scope, $http, toaster, CONFIG, ModalService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.loading = false;

    $scope.debtPager = [];
    $scope.appPager = [];
    $scope.paidPager = [];

    $scope.debts = [];
    $scope.apps = [];
    $scope.paids = [];
    
    $scope.totalDebt = 0.00;

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
            $scope.debtPager = res.data.debts;

            $scope.apps = res.data.apps.data;
            $scope.appPager = res.data.apps;

            $scope.paids = res.data.paids.data;
            $scope.paidPager = res.data.paids;

    		$scope.totalDebt = res.data.totalDebt;

            $scope.loading = false;
    	}, function(err) {
    		console.log(err);
            $scope.loading = false;
    	});
    }

    $scope.getDebtWithURL = function(URL) {
        console.log(URL);
        $scope.debts = [];
        $scope.loading = true;

        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.debts = res.data.debts.data;
            $scope.debtPager = res.data.debts;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getAppWithURL = function(URL) {
        console.log(URL);
        $scope.apps = [];
        $scope.loading = true;

        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.apps = res.data.apps.data;
            $scope.appPager = res.data.apps;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getPaidWithURL = function(URL) {
        console.log(URL);
        $scope.paids = [];
        $scope.loading = true;

        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.paids = res.data.paids.data;
            $scope.paidPager = res.data.paids;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
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

    $scope.editDebt = function(debtId) {
        console.log(debtId);
        // $('#dlgEditForm').modal('show');

        var creditor = $("#debtType").val();

        if(creditor === '') {
            console.log("You doesn't select creditor !!!");
            toaster.pop('warning', "", "คุณยังไม่ได้เลือกเจ้าหนี้ !!!");
        } else {
            window.location.href = CONFIG.BASE_URL + '/debt/edit/' + creditor + '/' + debtId;
        }
    };

    $scope.deleteDebt = function(debtId) {
        console.log(debtId);

        if(confirm("คุณต้องลบรายการหนี้เลขที่ " + debtId + " ใช่หรือไม่?")) {
            // $http.delete()
            // .then(function(res) {
                // console.log(res);
            // }, function(err) {
                // console.log(err);
            // });
        }
    };

    $scope.zeroDebt = function(debtId) {
        console.log(debtId);

        if(confirm("คุณต้องลดหนี้เป็นศูนย์รายการหนี้เลขที่ " + debtId + " ใช่หรือไม่?")) {
            $http.post(CONFIG.BASE_URL + '/debt/setzero', { debt_id: debtId })
            .then(function(res) {
                console.log(res);
                if(res.data.status == 'success') {
                    toaster.pop('success', "ระบบทำการงลดหนี้เป็นศูนย์สำเร็จแล้ว", "");
                } else { 
                    toaster.pop('error', "พบข้อผิดพลาดในระหว่างการดำเนินการ !!!", "");
                }
            }, function(err) {
                console.log(err);

                toaster.pop('error', "พบข้อผิดพลาดในระหว่างการดำเนินการ !!!", "");
            });
        }
    };
});