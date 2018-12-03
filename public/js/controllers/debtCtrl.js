app.controller('debtCtrl', function(CONFIG, $scope, $http, toaster, ModalService, StringFormatService, ReportService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.loading = false;
    $scope.cboDebtType = "";

    $scope.debtPager = [];
    $scope.appPager = [];
    $scope.paidPager = [];

    $scope.debts = [];
    $scope.apps = [];
    $scope.paids = [];
    
    $scope.totalDebt = 0.00;

    $scope.debt = {
        debt_id: '',
        debt_date: '',
        debt_doc_recno: '',
        debt_doc_recdate: '',
        debt_doc_no: '',
        debt_doc_date: '',
        debt_type_id: '',
        debt_type_detail: '',
        supplier_id: '',
        supplier_name: '',
        doc_receive: '',
        debt_year: '',
        debt_amount: '',
        debt_vatrate: '',
        debt_vat: '',
        debt_total: '',
        debt_remark: '',
    };

    $scope.barOptions = {};

    $scope.getDebtChart = function () {
        ReportService.getSeriesData('/report/debt-chart/','2018-10')
        .then(function(res) {
            var debtSeries = [];
            var paidSeries = [];

            angular.forEach(res.data, function(value, key) {
                debtSeries.push(value.request);
                paidSeries.push(value.service);
            });

            var categories = ['ยอดหนี้']
            $scope.barOptions = ReportService.initBarChart("barContainer", "", categories, 'จำนวน');
            $scope.barOptions.series.push({
                name: 'หนี้คงเหลือ',
                data: [4945713.15]
            }, {
                name: 'ตัดจ่าย',
                data: [72596483.07]
            });

            var chart = new Highcharts.Chart($scope.barOptions);
        }, function(err) {
            console.log(err);
        });
    };

    $scope.getDebtData = function(URL) {
        $scope.debts = [];
        $scope.loading = true;
        
        var debtDate = ($("#debtDate").val()).split(",");
        var sDate = debtDate[0].trim();
        var eDate = debtDate[1].trim();
        var debtType = $("#debtType").val();
        var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;
		console.log(CONFIG.BASE_URL +URL+ '/' +$scope.cboDebtType+ '/' +sDate+ '/' +eDate+ '/' +showAll);

        $http.get(CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +sDate+ '/' +eDate+ '/' +showAll)
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

    $scope.add = function(event) {
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

    $scope.store = function(event, form) {
        console.log(event);
        event.preventDefault();

        if (form.$invalid) {
            toaster.pop('warning', "", 'กรุณาข้อมูลให้ครบก่อน !!!');
            return;
        } else {
            console.log($scope.debt);
            // $http.post(CONFIG.BASE_URL + '/debt/store', $scope.debt)
            // .then(function(res) {
            //     console.log(res);
            //     toaster.pop('success', "", 'บันทึกข้อมูลเรียบร้อยแล้ว !!!');
            // }, function(err) {
            //     console.log(err);
            //     toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            // });            
        }

        document.getElementById('frmNewDebt').reset();
    }

    $scope.getDebt = function(debtId) {
        $http.get(CONFIG.BASE_URL + '/debt/get-debt/' +debtId)
        .then(function(res) {
            console.log(res);
            $scope.debt = res.data.debt;
            $scope.debt.debt_date = StringFormatService.convFromDbDate($scope.debt.debt_date);
        }, function(err) {
            console.log(err);
        });
    }

    $scope.edit = function(debtId) {
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

    $scope.update = function(event, form, debtId) {
        console.log(debtId);
        event.preventDefault();

        $scope.debt.debt_date = StringFormatService.convToDbDate($scope.debt.debt_date);
        console.log($scope.debt);
        // if(confirm("คุณต้องแก้ไขรายการหนี้เลขที่ " + debtId + " ใช่หรือไม่?")) {
        //     $http.put(CONFIG.BASE_URL + '/debt/update/', $scope.debt)
        //     .then(function(res) {
        //         console.log(res);
        //         toaster.pop('success', "", 'แก้ไขข้อมูลเรียบร้อยแล้ว !!!');
        //     }, function(err) {
        //         console.log(err);
        //         toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
        //     });
        // }
    };

    $scope.delete = function(debtId) {
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

    $scope.setzero = function(debtId) {
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