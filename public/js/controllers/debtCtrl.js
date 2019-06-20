app.controller('debtCtrl', function(CONFIG, $scope, $http, toaster, ModalService, StringFormatService, ReportService, PaginateService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.loading = false;
    $scope.cboDebtType = "";
    $scope.searchKeyword = "";
    $scope.searchTmp = [];

    $scope.debts = [];
    $scope.apps = [];
    $scope.paids = [];
    $scope.setzeros = [];

    $scope.debtPager = [];
    $scope.appPager = [];
    $scope.paidPager = [];
    $scope.setzeroPager = [];

    $scope.debtPages = [];
    $scope.appPages = [];
    $scope.paidPages = [];
    $scope.setzeroPages = [];

    $scope.totalDebt = 0.00;

    $scope.debt = {
        debt_date: '',
        debt_doc_recno: '',
        debt_doc_recdate: '',
        deliver_no: '',
        deliver_date: '',
        debt_doc_no: '',
        debt_doc_date: '',
        debt_type_id: '',
        debt_type_detail: '',
        debt_month: '',
        debt_year: '',
        supplier_id: '',
        supplier_name: '',
        doc_receive: '',
        debt_amount: '',
        debt_vatrate: '',
        debt_vat: '',
        debt_total: '',
        debt_remark: '',
        debt_creby: '',
        debt_userid: ''
    };

    $scope.barOptions = {};

    $scope.clearDebtObj = function() {
        $scope.debt = {
            debt_date: '',
            debt_doc_recno: '',
            debt_doc_recdate: '',
            deliver_no: '',
            deliver_date: '',
            debt_doc_no: '',
            debt_doc_date: '',
            debt_type_id: '',
            debt_type_detail: '',
            debt_month: '',
            debt_year: '',
            supplier_id: '',
            supplier_name: '',
            doc_receive: '',
            debt_amount: '',
            debt_vatrate: '',
            debt_vat: '',
            debt_total: '',
            debt_remark: '',
            debt_creby: '',
            debt_userid: ''
        };
    };

    $scope.getDebtChart = function (creditorId) {
        ReportService.getSeriesData('/report/debt-chart/', creditorId)
        .then(function(res) {
            console.log(res);

            var debtSeries = [];
            var paidSeries = [];
            var setzeroSeries = [];

            angular.forEach(res.data, function(value, key) {
                let debt = (value.debt) ? parseFloat(value.debt.toFixed(2)) : 0;
                let paid = (value.paid) ? parseFloat(value.paid.toFixed(2)) : 0;
                let setzero = (value.setzero) ? parseFloat(value.setzero.toFixed(2)) : 0;
                
                debtSeries.push(debt);
                paidSeries.push(paid);
                setzeroSeries.push(setzero);
            });

            var categories = ['ยอดหนี้']
            $scope.barOptions = ReportService.initBarChart("barContainer", "", categories, 'จำนวน');
            $scope.barOptions.series.push({
                name: 'หนี้คงเหลือ',
                data: debtSeries
            }, {
                name: 'ตัดจ่ายแล้ว',
                data: paidSeries
            }, {
                name: 'ลดหนี้ศูนย์',
                data: setzeroSeries
            });

            var chart = new Highcharts.Chart($scope.barOptions);
        }, function(err) {
            console.log(err);
        });
    };

    $scope.getDebtData = function(URL) {
        $scope.debts = [];
        $scope.apps = [];
        $scope.paids = [];
        $scope.setzeros = [];

        $scope.debtPager = [];
        $scope.appPager = [];
        $scope.paidPager = [];
        $scope.setzeroPager = [];

        $scope.debtPages = [];
        $scope.appPages = [];
        $scope.paidPages = [];
        $scope.setzeroPages = [];

        $scope.loading = true;
        
        var debtDate = ($("#debtDate").val()).split(",");
        var sDate = debtDate[0].trim();
        var eDate = debtDate[1].trim();
        var debtType = ($("#debtType").val() != '') ? $("#debtType").val() : 0;
        var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;

        $http.get(CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +sDate+ '/' +eDate+ '/' +showAll)
        .then(function(res) {
            console.log(res);
            $scope.debts = res.data.debts.data;
            $scope.debtPager = res.data.debts;
            $scope.debtPages = PaginateService.createPagerNo($scope.debtPager);

            $scope.apps = res.data.apps.data;
            $scope.appPager = res.data.apps;
            $scope.appPages = PaginateService.createPagerNo($scope.appPager);

            $scope.paids = res.data.paids.data;
            $scope.paidPager = res.data.paids;
            $scope.paidPages = PaginateService.createPagerNo($scope.paidPager);

            $scope.setzeros = res.data.setzeros.data;
            $scope.setzeroPager = res.data.setzeros;
            $scope.setzeroPages = PaginateService.createPagerNo($scope.setzeroPager);

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
        $scope.debtPager = [];
        $scope.debtPages = [];

        $scope.loading = true;

        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.debts = res.data.debts.data;
            $scope.debtPager = res.data.debts;
            $scope.debtPages = PaginateService.createPagerNo($scope.debtPager);

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getAppWithURL = function(URL) {
        console.log(URL);
        $scope.apps = [];
        $scope.appPager = [];
        $scope.appPages = [];

        $scope.loading = true;

        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.apps = res.data.apps.data;
            $scope.appPager = res.data.apps;
            $scope.appPages = PaginateService.createPagerNo($scope.appPager);

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getPaidWithURL = function(URL) {
        console.log(URL);
        $scope.paids = [];
        $scope.paidPager = [];
        $scope.paidPages = [];

        $scope.loading = true;

        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.paids = res.data.paids.data;
            $scope.paidPager = res.data.paids;
            $scope.paidPages = PaginateService.createPagerNo($scope.paidPager);

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getSetzeroWithURL = function(URL) {
        console.log(URL);
        $scope.setzeros = [];
        $scope.setzeroPager = [];
        $scope.setzeroPages = [];
        
        $scope.loading = true;

        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.setzeros = res.data.setzeros.data;
            $scope.setzeroPager = res.data.setzeros;
            $scope.setzeroPages = PaginateService.createPagerNo($scope.setzeroPager);
            
            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.calculateVat = function(amount, vatRate) {
        $scope.debt.debt_vat = ((amount * vatRate) / 100).toFixed(2);
        $scope.debt.debt_total = (parseFloat(amount) + parseFloat($scope.debt.debt_vat)).toFixed(2);
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
            window.location.href = CONFIG.BASE_URL + '/debt/add/' + creditor;
        }
    }

    $scope.store = function(event, form) {
        console.log(event);
        event.preventDefault();

        if (form.$invalid) {
            console.log(form.$error);
            toaster.pop('warning', "", 'กรุณาข้อมูลให้ครบก่อน !!!');
            return;
        } else {
            /** Convert thai date to db date. */
            $scope.debt.debt_date = StringFormatService.convToDbDate($scope.debt.debt_date);
            $scope.debt.debt_doc_recdate = StringFormatService.convToDbDate($scope.debt.debt_doc_recdate);
            $scope.debt.deliver_date = StringFormatService.convToDbDate($scope.debt.deliver_date);
            $scope.debt.debt_doc_date = ($scope.debt.debt_doc_date) ? StringFormatService.convToDbDate($scope.debt.debt_doc_date) : '';
            $scope.debt.doc_receive = StringFormatService.convToDbDate($scope.debt.doc_receive);
            /** Get supplier data */
            $scope.debt.supplier_id = $("#supplier_id").val();
            $scope.debt.supplier_name = $("#supplier_name").val();
            /** Get user id */
            $scope.debt.debt_creby = $("#user").val();
            $scope.debt.debt_userid = $("#user").val();
            console.log($scope.debt);

            $http.post(CONFIG.BASE_URL + '/debt/store', $scope.debt)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'บันทึกข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });            
        }

        /** Clear control value and model data */
        document.getElementById('frmNewDebt').reset();
        $scope.clearDebtObj();
    }

    $scope.getDebt = function(debtId) {
        $http.get(CONFIG.BASE_URL + '/debt/get-debt/' +debtId)
        .then(function(res) {
            console.log(res);
            $scope.debt = res.data.debt;

            /** Convert db date to thai date. */
            $scope.debt.debt_date = StringFormatService.convFromDbDate($scope.debt.debt_date);
            $scope.debt.debt_doc_recdate = StringFormatService.convFromDbDate($scope.debt.debt_doc_recdate);
            $scope.debt.deliver_date = StringFormatService.convFromDbDate($scope.debt.deliver_date);
            $scope.debt.debt_doc_date = ($scope.debt.debt_doc_date) ? StringFormatService.convFromDbDate($scope.debt.debt_doc_date) : '';
            $scope.debt.doc_receive = StringFormatService.convFromDbDate($scope.debt.doc_receive);
        }, function(err) {
            console.log(err);
        });
    }

    $scope.edit = function(debtId) {
        console.log(debtId);

        /** Show edit form modal dialog */
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

        if (form.$invalid) {
            toaster.pop('warning', "", 'กรุณาข้อมูลให้ครบก่อน !!!');
            return;
        } else {
            /** Convert thai date to db date. */
            $scope.debt.debt_date = StringFormatService.convToDbDate($scope.debt.debt_date);
            $scope.debt.debt_doc_recdate = StringFormatService.convToDbDate($scope.debt.debt_doc_recdate);
            $scope.debt.deliver_date = StringFormatService.convToDbDate($scope.debt.deliver_date);
            $scope.debt.debt_doc_date = ($scope.debt.debt_doc_date) ? StringFormatService.convToDbDate($scope.debt.debt_doc_date) : '';
            $scope.debt.doc_receive = StringFormatService.convToDbDate($scope.debt.doc_receive);
            /** Get supplier data */
            $scope.debt.supplier_id = $("#supplier_id").val();
            $scope.debt.supplier_name = $("#supplier_name").val();
            /** Get user id */
            $scope.debt.debt_creby = $("#user").val();
            $scope.debt.debt_userid = $("#user").val();
            console.log($scope.debt);

            if(confirm("คุณต้องแก้ไขรายการหนี้เลขที่ " + debtId + " ใช่หรือไม่?")) {
                $http.put(CONFIG.BASE_URL + '/debt/update/', $scope.debt)
                .then(function(res) {
                    console.log(res);
                }, function(err) {
                    console.log(err);
                });
            }

            /** Redirect to debt list */
            window.location.href = CONFIG.BASE_URL + '/debt/list';
        }
    };

    $scope.delete = function(debtId) {
        console.log(debtId);

        if(confirm("คุณต้องลบรายการหนี้เลขที่ " + debtId + " ใช่หรือไม่?")) {
            $http.delete(CONFIG.BASE_URL + '/debt/delete/' +debtId)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'ลบข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }

        /** Get debt list and re-render chart */
        $scope.getDebtData('/debt/rpt'); 
        $scope.getDebtChart($scope.cboDebtType);
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

        /** Get debt list and re-render chart */
        $scope.getDebtData('/debt/rpt'); 
        $scope.getDebtChart($scope.cboDebtType);
    };
});