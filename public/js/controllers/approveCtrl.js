app.controller('approveCtrl', function($scope, $http, toaster, CONFIG, ModalService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.supplierDebtData = [];
    $scope.supplierDebtToRemoveData = [];

    $scope.debts = [];
    $scope.debtPager = [];

    $scope.loading = false;
    $scope.pager = [];
    $scope.approvements = [];

    $scope.thbaht = '';

    $scope.approve = {
        creditor_id: '',
        app_doc_no: '',
        app_date: '',
        app_recdoc_no: '',
        app_recdoc_date: '',
        pay_to: '',
        budget_id: '',
        amount: '0.00',
        tax_val: '0.00',
        discount: '0.00',
        fine: '0.00',
        vatrate: '1',
        vatamt: '0.00',
        net_val: '0.00',
        net_amt: '0.00',
        net_amt_str: '',
        net_total: '0.00',
        net_total_str: '',
        cheque: '0.00',
        cheque_str: '',
    };

    $scope.getData = function(event) {
        console.log(event);
        $scope.approvements = [];
        $scope.loading = true;
        
        var searchKey = ($("#searchKey").val() == '') ? 0 : $("#searchKey").val();
        console.log(CONFIG.BASE_URL+ '/approve/search/' +searchKey);

        $http.get(CONFIG.BASE_URL+ '/approve/search/' +searchKey)
        .then(function(res) {
            console.log(res);
            $scope.approvements = res.data.approvements.data;
            $scope.pager = res.data.approvements;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getDataWithURL = function(URL) {
        console.log(URL);
        $scope.approvements = [];
        $scope.loading = true;

    	$http.get(URL)
    	.then(function(res) {
    		console.log(res);
            $scope.approvements = res.data.approvements.data;
            $scope.pager = res.data.approvements;

            $scope.loading = false;
    	}, function(err) {
    		console.log(err);
            $scope.loading = false;
    	});
    }

    $scope.add = function(event, form) {
        console.log(event);
        event.preventDefault();

        if (form.$invalid) {
            toaster.pop('warning', "", 'กรุณาข้อมูลให้ครบก่อน !!!');
            return;
        } else {
            $http.post(CONFIG.BASE_URL + '/creditor/store', $scope.creditor)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'บันทึกข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });            
        }

        document.getElementById('frmNewCreditor').reset();
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

    $scope.getCreditor = function(creditorId) {
        $http.get(CONFIG.BASE_URL + '/creditor/get-creditor/' +creditorId)
        .then(function(res) {
            console.log(res);
            $scope.creditor = res.data.creditor;
        }, function(err) {
            console.log(err);
        });
    }

    $scope.edit = function(creditorId) {
        console.log(creditorId);

        window.location.href = CONFIG.BASE_URL + '/creditor/edit/' + creditorId;
    };

    $scope.update = function(event, form, creditorId) {
        console.log(creditorId);
        event.preventDefault();

        if(confirm("คุณต้องแก้ไขเจ้าหนี้เลขที่ " + creditorId + " ใช่หรือไม่?")) {
            $http.put(CONFIG.BASE_URL + '/creditor/update/', $scope.creditor)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'แก้ไขข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }
    };

    $scope.delete = function(creditorId) {
        console.log(creditorId);

        if(confirm("คุณต้องลบเจ้าหนี้เลขที่ " + creditorId + " ใช่หรือไม่?")) {
            $http.delete(CONFIG.BASE_URL + '/creditor/delete/' +creditorId)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'ลบข้อมูลเรียบร้อยแล้ว !!!');
                $scope.getData();
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }
    };

    $scope.showSupplierDebtList = function(event) {
        let creditor = $("#creditor_id").val();

        if (!creditor) {
            toaster.pop('error', "", 'กรุณาเลือกเจ้าหนี้ก่อน !!!');
            return;
        }

        $http.get(baseUrl + '/debt/'+ creditor +'/list')
            .then(function (res) {
                console.log(res);
                $scope.getSupplierDebtData(res.data.debts.data, res.data.debts);

                $('#dlgSupplierDebtList').modal('show');
            });
    };

    $scope.getSupplierDebtData = function(data, pager) {
        let resData = data;
        $scope.debtPager = pager;

        if ($scope.supplierDebtData.length > 0) {
            $scope.debts = resData.filter(function(d) {
                let tmp = [];
                angular.forEach($scope.supplierDebtData, function(sd) {
                    tmp.push(sd.debt_id);
                });

                return tmp.indexOf(d.debt_id) === -1;
            });
        } else {
            $scope.debts = resData;
        }
    }

    $scope.getSupplierDebtDataWithURL = function(URL) {
        console.log(URL);

        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.getSupplierDebtData(res.data.debts.data, res.data.debts)

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.addSupplierDebtData = function(event, supplierDebt) {
        if ($(event.target).is(':checked')) {            
            $scope.supplierDebtData.push(supplierDebt);
        } else {
            let removeIndex = $scope.supplierDebtData.findIndex(function(debt) {
                return debt.debt_id === supplierDebt.debt_id;
            });

            $scope.supplierDebtData.splice(removeIndex, 1);
        }

        calculateSupplierDebt();
    };

    $scope.addSupplierDebtToRemove = function(event, debt) {
        console.log($scope.supplierDebtData);
        let tmp = [];

        if ($(event.target).is(':checked')) {            
            $scope.supplierDebtToRemoveData.push(debt.debt_id);
            console.log($scope.supplierDebtToRemoveData);
        } else {
            $scope.supplierDebtToRemoveData.splice(debt.debt_id, 1)
        }
    }

    $scope.removeSupplierDebt = function() {
        if ($scope.supplierDebtToRemoveData.length < 1) {
            toaster.pop('error', "", 'ไม่พบรายการที่คุณต้องการลบ กรุณาเลือกรายการก่อน !!!');
            return;
        }

        tmp = $scope.supplierDebtData.filter(function(d) {
            return $scope.supplierDebtToRemoveData.indexOf(d.debt_id);
        });
        
        $scope.supplierDebtData = tmp;
        calculateSupplierDebt();

        $scope.supplierDebtToRemoveData = [];
    };

    $scope.clearSupplierDebtData = function() {
        if ($scope.supplierDebtData.length > 0) {
            $scope.supplierDebtData = [];
        }
    };

    function calculateSupplierDebt() {
        let vatAmt  = 0.0;
        let taxVal  = 0.0;
        let netVal  = 0.0;
        let netTotal = 0.0;
        let cheque = 0.0;
        let vatRate = $("#vatrate").val();

        angular.forEach($scope.supplierDebtData, function(debt) {
            vatAmt += debt.debt_vat;
            netVal += debt.debt_amount;
        });

        taxVal = (netVal * 1) / 100;
        netTotal = netVal + vatAmt;
        cheque = netTotal - taxVal;

        $("#net_val").val(currencyFormat(netVal));
        $("#vatamt").val(currencyFormat(vatAmt));
        $("#tax_val").val(currencyFormat(taxVal));
        $("#net_total").val(currencyFormat(netTotal));
        $("#cheque").val(currencyFormat(cheque));

        $scope.thbaht = THBText(cheque.toFixed(2))
        console.log(THBText(1000))
    }

    function currencyFormat(num) {
        return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
});