app.controller('paymentCtrl', function($scope, $http, toaster, CONFIG, ModalService, StringFormatService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.supplierDebtData = [];
    $scope.supplierDebtToRemoveData = [];

    $scope.debttypes = [];
    $scope.debts = [];
    $scope.debtPager = [];

    $scope.loading = false;
    $scope.pager = [];
    $scope.payments = [];
    $scope.payment = {};

    $scope.initData = function() {
        $scope.payment = {
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
            net_amt_str: ' ตัวอักษร ',
            net_total: '0.00',
            net_total_str: ' ตัวอักษร ',
            cheque: '0.00',
            cheque_str: ' ตัวอักษร ',
            cr_user: '',
            chg_user: '',
            debts: [],
        };

        $scope.supplierDebtData = [];
        $scope.supplierDebtToRemoveData = [];

        $scope.debts = [];
        $scope.debtPager = [];
    }

    $scope.getData = function(event) {
        console.log(event);
        $scope.payments = [];
        $scope.loading = true;
        
        var searchKey = ($("#searchKey").val() == '') ? 0 : $("#searchKey").val();

        $http.get(CONFIG.BASE_URL+ '/payment/search/' +searchKey)
        .then(function(res) {
            console.log(res);
            $scope.payments = res.data.payments.data;
            $scope.pager = res.data.payments;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getDataWithURL = function(URL) {
        console.log(URL);
        $scope.payments = [];
        $scope.loading = true;

    	$http.get(URL)
    	.then(function(res) {
    		console.log(res);
            $scope.payments = res.data.payments.data;
            $scope.pager = res.data.payments;

            $scope.loading = false;
    	}, function(err) {
    		console.log(err);
            $scope.loading = false;
    	});
    }

    $scope.store = function(event, form) {
        event.preventDefault();

        if (form.$invalid) {
            console.log(form.$error);
            toaster.pop('warning', "", 'กรุณาข้อมูลให้ครบก่อน !!!');
            return;
        } else {
            /** Convert thai date to db date. */
            $scope.payment.app_date = StringFormatService.convToDbDate($scope.payment.app_date);
            $scope.payment.app_recdoc_date = StringFormatService.convToDbDate($scope.payment.app_recdoc_date);
            /** Get user id */
            $scope.payment.cr_user = $("#user").val();
            $scope.payment.chg_user = $("#user").val();
            /** Add debt to paymentment */
            $scope.payment.debts =  $scope.supplierDebtData;
            console.log($scope.payment);

            $http.post(CONFIG.BASE_URL + '/payment/store', $scope.payment)
                .then(function(res) {
                    console.log(res);
                    toaster.pop('success', "", 'บันทึกข้อมูลเรียบร้อยแล้ว !!!');
                }, function(err) {
                    console.log(err);
                    toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
                });            
        }

        /** Clear control value and model data */
        document.getElementById('frmNewPayment').reset();
        $scope.initData();
    }

    $scope.getCreditor = function(creditorId) {
        $http.get(CONFIG.BASE_URL + '/payment/get-payment/' +paymentId)
        .then(function(res) {
            console.log(res);
            $scope.payment = res.data.payment;
        }, function(err) {
            console.log(err);
        });
    }

    $scope.edit = function(creditorId) {
        console.log(creditorId);

        window.location.href = CONFIG.BASE_URL+ '/payment/edit/' +paymentId;
    };

    $scope.update = function(event, form, creditorId) {
        console.log(creditorId);
        event.preventDefault();

        if(confirm("คุณต้องแก้ไขเจ้าหนี้เลขที่ " + creditorId + " ใช่หรือไม่?")) {
            $http.put(CONFIG.BASE_URL + '/payment/update/', $scope.payment)
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
            $http.delete(CONFIG.BASE_URL + '/payment/delete/' +creditorId)
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

    $scope.popupApproveSelection = function(event) {
        // let creditor = $("#creditor_id").val();

        // if (!creditor) {
        //     toaster.pop('error', "", 'กรุณาเลือกเจ้าหนี้ก่อน !!!');
        //     return;
        // }

        // $http.get(baseUrl + '/payment/'+ creditor +'/list')
        //     .then(function (res) {
        //         console.log(res);
        //         $scope.getSupplierDebtData(res.data.debts.data, res.data.debts);

                $('#dlgApproveSelection').modal('show');
            // });
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

        /** Set supplier name to approve.pay_to */
        $scope.approve.pay_to = $("#creditor_id option:selected").text().trim();
    };

    $scope.popupApproveDebtList = function(appid) {
        console.log(appid);
        $http.get(baseUrl + '/payment/detail/'+ appid)
            .then(function (res) {
                console.log(res);
                $scope.debts = res.data.appdetails;
                $scope.debttypes = res.data.debttypes;

                $('#dlgPaymentDebtList').modal('show');
            });
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

        $scope.approve.amount = currencyFormat(netVal); // ฐานภาษี
        $scope.approve.net_val = currencyFormat(netVal); // ฐานภาษี
        $scope.approve.vatamt = currencyFormat(vatAmt); // ภาษีมูลค่าเพิ่ม
        $scope.approve.tax_val = currencyFormat(taxVal); // ภาษีหัก ณ ที่จ่าย
        $scope.approve.net_amt = currencyFormat(taxVal); // ภาษีหัก ณ ที่จ่าย
        $scope.approve.net_total = currencyFormat(netTotal); // ยอดสุทธิ
        $scope.approve.cheque = currencyFormat(cheque); // ยอดจ่ายเช็ค

        $scope.approve.net_amt_str = ArabicNumberToText(taxVal.toFixed(2)); // ภาษีหัก ณ ที่จ่าย
        $scope.approve.net_total_str = ArabicNumberToText(netTotal.toFixed(2)); // ยอดสุทธิ
        $scope.approve.cheque_str = ArabicNumberToText(cheque.toFixed(2)); // ยอดจ่ายเช็ค
        console.log($scope.approve);
    }

    function currencyFormat(num) {
        return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
});